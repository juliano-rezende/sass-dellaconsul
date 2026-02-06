<?php

namespace App\Traits;

/**
 * Trait SoftDeletes
 * Implementa soft deletes (deleted_at ao invés de deletar permanentemente)
 */
trait SoftDeletes
{
    protected string $deletedAtColumn = 'deleted_at';
    protected bool $forceDeleting = false;
    
    /**
     * Boot the trait
     */
    protected function initializeSoftDeletes(): void
    {
        // Adiciona filtro automático para excluir registros deletados
        $this->addGlobalScope();
    }
    
    /**
     * Add global scope to exclude soft deleted records
     */
    protected function addGlobalScope(): void
    {
        // Adiciona where para excluir registros com deleted_at não nulo
        if (!$this->forceDeleting && empty($this->withTrashedFlag)) {
            $this->wheres[] = [
                'column' => $this->deletedAtColumn,
                'operator' => 'IS',
                'value' => null,
                'type' => 'AND'
            ];
        }
    }
    
    /**
     * Override delete to perform soft delete
     */
    public function delete(): bool
    {
        if ($this->forceDeleting) {
            return $this->forceDelete();
        }
        
        if (!$this->exists) {
            return false;
        }
        
        $this->fireEvent('beforeDelete');
        
        // Set deleted_at timestamp
        $this->setAttribute($this->deletedAtColumn, date('Y-m-d H:i:s'));
        
        $result = $this->save();
        
        if ($result) {
            $this->fireEvent('afterDelete');
        }
        
        return $result;
    }
    
    /**
     * Force delete (permanently delete)
     */
    public function forceDelete(): bool
    {
        $this->forceDeleting = true;
        
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
     * Restore soft deleted model
     */
    public function restore(): bool
    {
        if (!$this->exists) {
            return false;
        }
        
        $this->setAttribute($this->deletedAtColumn, null);
        
        return $this->save();
    }
    
    /**
     * Check if model is soft deleted
     */
    public function trashed(): bool
    {
        return !is_null($this->getAttribute($this->deletedAtColumn));
    }
    
    /**
     * Include soft deleted records in query
     */
    public function withTrashed(): self
    {
        $this->withTrashedFlag = true;
        
        // Remove deleted_at filter
        $this->wheres = array_filter($this->wheres, function($where) {
            return $where['column'] !== $this->deletedAtColumn;
        });
        
        return $this;
    }
    
    /**
     * Get only soft deleted records
     */
    public function onlyTrashed(): self
    {
        // Remove existing deleted_at filters
        $this->wheres = array_filter($this->wheres, function($where) {
            return $where['column'] !== $this->deletedAtColumn;
        });
        
        // Add filter for only trashed
        $this->wheres[] = [
            'column' => $this->deletedAtColumn,
            'operator' => 'IS NOT',
            'value' => null,
            'type' => 'AND'
        ];
        
        return $this;
    }
    
    /**
     * Get deleted at column name
     */
    public function getDeletedAtColumn(): string
    {
        return $this->deletedAtColumn;
    }
}
