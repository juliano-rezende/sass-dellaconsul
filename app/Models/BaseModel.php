<?php

namespace App\Models;

use Database\Connection;
use Doctrine\DBAL\Connection as DbalConnection;
use App\Support\Validator;

/**
 * BaseModel - Active Record Pattern
 * Classe base abstrata para todos os models
 */
abstract class BaseModel
{
    protected DbalConnection $connection;
    
    // Configurações da tabela
    protected string $table;
    protected string $primaryKey = 'id';
    
    // Mass assignment
    protected array $fillable = [];
    protected array $guarded = ['id'];
    protected array $hidden = [];
    
    // Conversão de tipos
    protected array $casts = [];
    
    // Validação
    protected array $rules = [];
    protected array $errors = [];
    
    // Timestamps
    protected bool $timestamps = true;
    protected string $createdAtColumn = 'created_at';
    protected string $updatedAtColumn = 'updated_at';
    
    // Atributos do model
    protected array $attributes = [];
    protected array $original = [];
    protected bool $exists = false;
    
    // Query builder state
    protected array $wheres = [];
    protected array $bindings = [];
    protected ?string $orderByColumn = null;
    protected ?string $orderByDirection = null;
    protected ?int $limitValue = null;
    protected ?int $offsetValue = null;
    protected array $selectColumns = ['*'];
    
    /**
     * Constructor
     */
    public function __construct(array $attributes = [])
    {
        $this->connection = Connection::getDbalConnection();
        
        if (!empty($attributes)) {
            $this->fill($attributes);
        }
    }
    
    /**
     * Fill model with data
     */
    public function fill(array $attributes): self
    {
        foreach ($attributes as $key => $value) {
            if ($this->isFillable($key)) {
                $this->setAttribute($key, $value);
            }
        }
        
        return $this;
    }
    
    /**
     * Check if attribute is fillable
     */
    protected function isFillable(string $key): bool
    {
        if (in_array($key, $this->guarded)) {
            return false;
        }
        
        if (empty($this->fillable)) {
            return true;
        }
        
        return in_array($key, $this->fillable);
    }
    
    /**
     * Set attribute value
     */
    public function setAttribute(string $key, $value): void
    {
        $this->attributes[$key] = $value;
    }
    
    /**
     * Get attribute value
     */
    public function getAttribute(string $key)
    {
        if (!array_key_exists($key, $this->attributes)) {
            return null;
        }
        
        $value = $this->attributes[$key];
        
        // Apply casts
        if (isset($this->casts[$key])) {
            $value = $this->castAttribute($key, $value);
        }
        
        return $value;
    }
    
    /**
     * Cast attribute to specified type
     */
    protected function castAttribute(string $key, $value)
    {
        $castType = $this->casts[$key];
        
        if (is_null($value)) {
            return null;
        }
        
        switch ($castType) {
            case 'int':
            case 'integer':
                return (int) $value;
            case 'float':
            case 'double':
                return (float) $value;
            case 'string':
                return (string) $value;
            case 'bool':
            case 'boolean':
                return (bool) $value;
            case 'array':
            case 'json':
                return is_string($value) ? json_decode($value, true) : $value;
            case 'datetime':
                return $value instanceof \DateTime ? $value : new \DateTime($value);
            default:
                return $value;
        }
    }
    
    /**
     * Magic getter
     */
    public function __get(string $key)
    {
        return $this->getAttribute($key);
    }
    
    /**
     * Magic setter
     */
    public function __set(string $key, $value): void
    {
        $this->setAttribute($key, $value);
    }
    
    /**
     * Magic isset
     */
    public function __isset(string $key): bool
    {
        return isset($this->attributes[$key]);
    }
    
    /**
     * Convert model to array
     */
    public function toArray(): array
    {
        $attributes = $this->attributes;
        
        // Remove hidden attributes
        foreach ($this->hidden as $hidden) {
            unset($attributes[$hidden]);
        }
        
        // Apply casts
        foreach ($attributes as $key => $value) {
            if (isset($this->casts[$key])) {
                $attributes[$key] = $this->castAttribute($key, $value);
            }
        }
        
        return $attributes;
    }
    
    /**
     * Convert model to JSON
     */
    public function toJson(): string
    {
        return json_encode($this->toArray());
    }
    
    /**
     * Save model (insert or update)
     */
    public function save(): bool
    {
        // Validate
        if (!$this->validate()) {
            return false;
        }
        
        // Fire before save event
        $this->fireEvent('beforeSave');
        
        if ($this->exists) {
            $result = $this->performUpdate();
            $this->fireEvent('afterSave');
            return $result;
        } else {
            $this->fireEvent('beforeCreate');
            $result = $this->performInsert();
            $this->fireEvent('afterCreate');
            $this->fireEvent('afterSave');
            return $result;
        }
    }
    
    /**
     * Perform insert
     */
    protected function performInsert(): bool
    {
        $data = $this->attributes;
        
        // Add timestamps
        if ($this->timestamps) {
            $now = date('Y-m-d H:i:s');
            $data[$this->createdAtColumn] = $now;
            $data[$this->updatedAtColumn] = $now;
            $this->attributes[$this->createdAtColumn] = $now;
            $this->attributes[$this->updatedAtColumn] = $now;
        }
        
        try {
            $this->connection->insert($this->table, $data);
            
            // Set primary key
            $id = $this->connection->lastInsertId();
            $this->setAttribute($this->primaryKey, $id);
            
            $this->exists = true;
            $this->original = $this->attributes;
            
            return true;
        } catch (\Exception $e) {
            $this->errors[] = $e->getMessage();
            return false;
        }
    }
    
    /**
     * Perform update
     */
    protected function performUpdate(): bool
    {
        $data = $this->attributes;
        
        // Update timestamp
        if ($this->timestamps) {
            $now = date('Y-m-d H:i:s');
            $data[$this->updatedAtColumn] = $now;
            $this->attributes[$this->updatedAtColumn] = $now;
        }
        
        // Remove primary key from data
        $id = $data[$this->primaryKey];
        unset($data[$this->primaryKey]);
        
        try {
            $this->connection->update(
                $this->table,
                $data,
                [$this->primaryKey => $id]
            );
            
            $this->original = $this->attributes;
            
            return true;
        } catch (\Exception $e) {
            $this->errors[] = $e->getMessage();
            return false;
        }
    }
    
    /**
     * Delete model
     */
    public function delete(): bool
    {
        if (!$this->exists) {
            return false;
        }
        
        $this->fireEvent('beforeDelete');
        
        try {
            $this->connection->delete(
                $this->table,
                [$this->primaryKey => $this->getAttribute($this->primaryKey)]
            );
            
            $this->exists = false;
            $this->fireEvent('afterDelete');
            
            return true;
        } catch (\Exception $e) {
            $this->errors[] = $e->getMessage();
            return false;
        }
    }
    
    /**
     * Validate model
     */
    protected function validate(): bool
    {
        if (empty($this->rules)) {
            return true;
        }
        
        $validator = new Validator($this->attributes, $this->rules);
        
        if (!$validator->validate()) {
            $this->errors = $validator->errors();
            return false;
        }
        
        return true;
    }
    
    /**
     * Get validation errors
     */
    public function errors(): array
    {
        return $this->errors;
    }
    
    /**
     * Fire model event
     */
    protected function fireEvent(string $event): void
    {
        $method = $event;
        
        if (method_exists($this, $method)) {
            $this->$method();
        }
    }
    
    /**
     * Create new instance with data
     */
    public static function create(array $attributes): ?self
    {
        $instance = new static($attributes);
        
        if ($instance->save()) {
            return $instance;
        }
        
        return null;
    }
    
    /**
     * Find by ID
     */
    public static function findById($id): ?self
    {
        return static::where(static::make()->primaryKey, $id)->first();
    }
    
    /**
     * Find or fail
     */
    public static function findOrFail($id): self
    {
        $result = static::findById($id);
        
        if (!$result) {
            throw new \Exception("Model not found with ID: {$id}");
        }
        
        return $result;
    }
    
    /**
     * Get all records
     */
    public static function all(): array
    {
        return static::make()->get();
    }
    
    /**
     * Create new query instance
     */
    public static function make(): self
    {
        return new static();
    }
    
    /**
     * Where clause
     */
    public static function where(string $column, $operator, $value = null): self
    {
        $instance = static::make();
        return $instance->addWhere($column, $operator, $value);
    }
    
    /**
     * Add where clause
     */
    public function addWhere(string $column, $operator, $value = null): self
    {
        // If only 2 arguments, assume operator is '='
        if ($value === null) {
            $value = $operator;
            $operator = '=';
        }
        
        $this->wheres[] = [
            'column' => $column,
            'operator' => $operator,
            'value' => $value,
            'type' => 'AND'
        ];
        
        return $this;
    }
    
    /**
     * Or where clause
     */
    public function orWhere(string $column, $operator, $value = null): self
    {
        if ($value === null) {
            $value = $operator;
            $operator = '=';
        }
        
        $this->wheres[] = [
            'column' => $column,
            'operator' => $operator,
            'value' => $value,
            'type' => 'OR'
        ];
        
        return $this;
    }
    
    /**
     * Order by
     */
    public function orderBy(string $column, string $direction = 'ASC'): self
    {
        $this->orderByColumn = $column;
        $this->orderByDirection = strtoupper($direction);
        return $this;
    }
    
    /**
     * Limit
     */
    public function limit(int $limit): self
    {
        $this->limitValue = $limit;
        return $this;
    }
    
    /**
     * Offset
     */
    public function offset(int $offset): self
    {
        $this->offsetValue = $offset;
        return $this;
    }
    
    /**
     * Select columns
     */
    public function select(...$columns): self
    {
        $this->selectColumns = $columns;
        return $this;
    }
    
    /**
     * Get results
     */
    public function get(): array
    {
        $qb = $this->connection->createQueryBuilder();
        
        $qb->select(...$this->selectColumns)
           ->from($this->table);
        
        // Apply wheres
        foreach ($this->wheres as $index => $where) {
            $paramName = "param{$index}";
            
            if ($index === 0 || $where['type'] === 'AND') {
                $qb->andWhere("{$where['column']} {$where['operator']} :{$paramName}");
            } else {
                $qb->orWhere("{$where['column']} {$where['operator']} :{$paramName}");
            }
            
            $qb->setParameter($paramName, $where['value']);
        }
        
        // Apply order by
        if ($this->orderByColumn) {
            $qb->orderBy($this->orderByColumn, $this->orderByDirection);
        }
        
        // Apply limit
        if ($this->limitValue) {
            $qb->setMaxResults($this->limitValue);
        }
        
        // Apply offset
        if ($this->offsetValue) {
            $qb->setFirstResult($this->offsetValue);
        }
        
        try {
            $results = $qb->executeQuery()->fetchAllAssociative();
            
            return array_map(function($row) {
                return $this->newFromBuilder($row);
            }, $results);
        } catch (\Exception $e) {
            $this->errors[] = $e->getMessage();
            return [];
        }
    }
    
    /**
     * Get first result
     */
    public function first(): ?self
    {
        $results = $this->limit(1)->get();
        return $results[0] ?? null;
    }
    
    /**
     * Count results
     */
    public function count(): int
    {
        $qb = $this->connection->createQueryBuilder();
        
        $qb->select('COUNT(*) as total')
           ->from($this->table);
        
        // Apply wheres
        foreach ($this->wheres as $index => $where) {
            $paramName = "param{$index}";
            
            if ($index === 0 || $where['type'] === 'AND') {
                $qb->andWhere("{$where['column']} {$where['operator']} :{$paramName}");
            } else {
                $qb->orWhere("{$where['column']} {$where['operator']} :{$paramName}");
            }
            
            $qb->setParameter($paramName, $where['value']);
        }
        
        try {
            return (int) $qb->executeQuery()->fetchOne();
        } catch (\Exception $e) {
            return 0;
        }
    }
    
    /**
     * Create instance from database row
     */
    protected function newFromBuilder(array $attributes): self
    {
        $instance = new static();
        $instance->attributes = $attributes;
        $instance->original = $attributes;
        $instance->exists = true;
        
        return $instance;
    }
    
    /**
     * Refresh model from database
     */
    public function refresh(): bool
    {
        if (!$this->exists) {
            return false;
        }
        
        $fresh = static::findById($this->getAttribute($this->primaryKey));
        
        if ($fresh) {
            $this->attributes = $fresh->attributes;
            $this->original = $fresh->original;
            return true;
        }
        
        return false;
    }
    
    /**
     * Check if model is dirty (has changes)
     */
    public function isDirty(): bool
    {
        return $this->attributes !== $this->original;
    }
    
    /**
     * Get changed attributes
     */
    public function getDirty(): array
    {
        $dirty = [];
        
        foreach ($this->attributes as $key => $value) {
            if (!array_key_exists($key, $this->original) || $this->original[$key] !== $value) {
                $dirty[$key] = $value;
            }
        }
        
        return $dirty;
    }
    
    /**
     * Call dynamic scope method
     */
    public function __call(string $method, array $parameters)
    {
        // Check for scope methods
        if (str_starts_with($method, 'scope')) {
            return $this;
        }
        
        $scopeMethod = 'scope' . ucfirst($method);
        
        if (method_exists($this, $scopeMethod)) {
            return $this->$scopeMethod(...$parameters);
        }
        
        throw new \BadMethodCallException("Method {$method} does not exist.");
    }
    
    /**
     * Call static methods
     */
    public static function __callStatic(string $method, array $parameters)
    {
        $instance = new static();
        
        $scopeMethod = 'scope' . ucfirst($method);
        
        if (method_exists($instance, $scopeMethod)) {
            return $instance->$scopeMethod($instance, ...$parameters);
        }
        
        throw new \BadMethodCallException("Static method {$method} does not exist.");
    }
}
