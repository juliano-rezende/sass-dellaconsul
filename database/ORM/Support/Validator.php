<?php

namespace Database\ORM\Support;

use Database\Connection;

/**
 * Sistema de Validação
 */
class Validator
{
    protected array $data;
    protected array $rules;
    protected array $errors = [];
    protected array $messages = [
        'required' => 'O campo :field é obrigatório',
        'email' => 'O campo :field deve ser um e-mail válido',
        'min' => 'O campo :field deve ter no mínimo :min caracteres',
        'max' => 'O campo :field deve ter no máximo :max caracteres',
        'unique' => 'O valor do campo :field já está em uso',
        'confirmed' => 'A confirmação do campo :field não confere',
        'in' => 'O valor do campo :field é inválido',
        'numeric' => 'O campo :field deve ser numérico',
        'integer' => 'O campo :field deve ser um número inteiro',
        'url' => 'O campo :field deve ser uma URL válida',
        'date' => 'O campo :field deve ser uma data válida',
    ];
    
    /**
     * Constructor
     */
    public function __construct(array $data, array $rules)
    {
        $this->data = $data;
        $this->rules = $rules;
    }
    
    /**
     * Validate data
     */
    public function validate(): bool
    {
        $this->errors = [];
        
        foreach ($this->rules as $field => $rules) {
            $rulesArray = is_string($rules) ? explode('|', $rules) : $rules;
            
            foreach ($rulesArray as $rule) {
                $this->validateRule($field, $rule);
            }
        }
        
        return empty($this->errors);
    }
    
    /**
     * Validate single rule
     */
    protected function validateRule(string $field, string $rule): void
    {
        // Parse rule and parameters
        $parts = explode(':', $rule);
        $ruleName = $parts[0];
        $parameters = isset($parts[1]) ? explode(',', $parts[1]) : [];
        
        $value = $this->data[$field] ?? null;
        
        // Call validation method
        $method = 'validate' . ucfirst($ruleName);
        
        if (method_exists($this, $method)) {
            $passes = $this->$method($field, $value, $parameters);
            
            if (!$passes) {
                $this->addError($field, $ruleName, $parameters);
            }
        }
    }
    
    /**
     * Add error message
     */
    protected function addError(string $field, string $rule, array $parameters = []): void
    {
        $message = $this->messages[$rule] ?? "O campo :field é inválido";
        
        // Replace placeholders
        $message = str_replace(':field', $field, $message);
        
        foreach ($parameters as $index => $param) {
            $message = str_replace(":{$index}", $param, $message);
            
            // Common parameter names
            if ($index === 0) {
                $message = str_replace(':min', $param, $message);
                $message = str_replace(':max', $param, $message);
            }
        }
        
        $this->errors[$field][] = $message;
    }
    
    /**
     * Get errors
     */
    public function errors(): array
    {
        return $this->errors;
    }
    
    /**
     * Validate required
     */
    protected function validateRequired(string $field, $value, array $parameters): bool
    {
        if (is_null($value)) {
            return false;
        }
        
        if (is_string($value) && trim($value) === '') {
            return false;
        }
        
        return true;
    }
    
    /**
     * Validate email
     */
    protected function validateEmail(string $field, $value, array $parameters): bool
    {
        if (is_null($value) || $value === '') {
            return true; // Use 'required' rule for mandatory fields
        }
        
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }
    
    /**
     * Validate min length
     */
    protected function validateMin(string $field, $value, array $parameters): bool
    {
        if (is_null($value) || $value === '') {
            return true;
        }
        
        $min = (int) $parameters[0];
        
        if (is_numeric($value)) {
            return $value >= $min;
        }
        
        return mb_strlen($value) >= $min;
    }
    
    /**
     * Validate max length
     */
    protected function validateMax(string $field, $value, array $parameters): bool
    {
        if (is_null($value) || $value === '') {
            return true;
        }
        
        $max = (int) $parameters[0];
        
        if (is_numeric($value)) {
            return $value <= $max;
        }
        
        return mb_strlen($value) <= $max;
    }
    
    /**
     * Validate unique in database
     */
    protected function validateUnique(string $field, $value, array $parameters): bool
    {
        if (is_null($value) || $value === '') {
            return true;
        }
        
        $table = $parameters[0];
        $column = $parameters[1] ?? $field;
        $ignoreId = $parameters[2] ?? null;
        
        try {
            $conn = Connection::getDbalConnection();
            $qb = $conn->createQueryBuilder();
            
            $qb->select('COUNT(*) as total')
               ->from($table)
               ->where("{$column} = :value")
               ->setParameter('value', $value);
            
            // Ignore specific ID (for updates)
            if ($ignoreId) {
                $qb->andWhere('id != :id')
                   ->setParameter('id', $ignoreId);
            }
            
            $count = (int) $qb->executeQuery()->fetchOne();
            
            return $count === 0;
        } catch (\Exception $e) {
            return false;
        }
    }
    
    /**
     * Validate confirmed field
     */
    protected function validateConfirmed(string $field, $value, array $parameters): bool
    {
        $confirmField = $field . '_confirmation';
        $confirmValue = $this->data[$confirmField] ?? null;
        
        return $value === $confirmValue;
    }
    
    /**
     * Validate value is in list
     */
    protected function validateIn(string $field, $value, array $parameters): bool
    {
        if (is_null($value) || $value === '') {
            return true;
        }
        
        return in_array($value, $parameters);
    }
    
    /**
     * Validate numeric
     */
    protected function validateNumeric(string $field, $value, array $parameters): bool
    {
        if (is_null($value) || $value === '') {
            return true;
        }
        
        return is_numeric($value);
    }
    
    /**
     * Validate integer
     */
    protected function validateInteger(string $field, $value, array $parameters): bool
    {
        if (is_null($value) || $value === '') {
            return true;
        }
        
        return filter_var($value, FILTER_VALIDATE_INT) !== false;
    }
    
    /**
     * Validate URL
     */
    protected function validateUrl(string $field, $value, array $parameters): bool
    {
        if (is_null($value) || $value === '') {
            return true;
        }
        
        return filter_var($value, FILTER_VALIDATE_URL) !== false;
    }
    
    /**
     * Validate date
     */
    protected function validateDate(string $field, $value, array $parameters): bool
    {
        if (is_null($value) || $value === '') {
            return true;
        }
        
        if ($value instanceof \DateTime) {
            return true;
        }
        
        return strtotime($value) !== false;
    }
    
    /**
     * Set custom error messages
     */
    public function setMessages(array $messages): self
    {
        $this->messages = array_merge($this->messages, $messages);
        return $this;
    }
}
