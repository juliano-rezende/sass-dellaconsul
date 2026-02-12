<?php

namespace Database\ORM\Traits;

/**
 * Trait HasTimestamps
 * Adiciona funcionalidade de timestamps automáticos (created_at, updated_at)
 */
trait HasTimestamps
{
    /**
     * Boot the trait
     */
    protected function initializeHasTimestamps(): void
    {
        $this->timestamps = true;
    }
    
    /**
     * Get created at column name
     */
    public function getCreatedAtColumn(): string
    {
        return $this->createdAtColumn ?? 'created_at';
    }
    
    /**
     * Get updated at column name
     */
    public function getUpdatedAtColumn(): string
    {
        return $this->updatedAtColumn ?? 'updated_at';
    }
    
    /**
     * Get created at timestamp
     */
    public function getCreatedAt(): ?\DateTime
    {
        $value = $this->getAttribute($this->getCreatedAtColumn());
        
        if ($value instanceof \DateTime) {
            return $value;
        }
        
        if (is_string($value)) {
            return new \DateTime($value);
        }
        
        return null;
    }
    
    /**
     * Get updated at timestamp
     */
    public function getUpdatedAt(): ?\DateTime
    {
        $value = $this->getAttribute($this->getUpdatedAtColumn());
        
        if ($value instanceof \DateTime) {
            return $value;
        }
        
        if (is_string($value)) {
            return new \DateTime($value);
        }
        
        return null;
    }
    
    /**
     * Touch timestamps (update updated_at)
     */
    public function touch(): bool
    {
        if (!$this->timestamps) {
            return false;
        }
        
        $this->setAttribute($this->getUpdatedAtColumn(), date('Y-m-d H:i:s'));
        
        if ($this->exists) {
            return $this->save();
        }
        
        return true;
    }
}
