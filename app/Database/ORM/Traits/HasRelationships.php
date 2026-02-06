<?php

namespace App\Database\ORM\Traits;

/**
 * Trait HasRelationships
 * Adiciona funcionalidade de relacionamentos entre models
 */
trait HasRelationships
{
    protected array $relations = [];
    protected array $relationshipCache = [];
    
    /**
     * Define hasMany relationship
     */
    protected function hasMany(string $related, ?string $foreignKey = null, ?string $localKey = null): array
    {
        $foreignKey = $foreignKey ?? $this->getForeignKey();
        $localKey = $localKey ?? $this->primaryKey;
        
        $cacheKey = "hasMany:{$related}:{$foreignKey}:{$localKey}";
        
        if (isset($this->relationshipCache[$cacheKey])) {
            return $this->relationshipCache[$cacheKey];
        }
        
        $relatedInstance = new $related();
        
        $results = $relatedInstance
            ->where($foreignKey, $this->getAttribute($localKey))
            ->get();
        
        $this->relationshipCache[$cacheKey] = $results;
        
        return $results;
    }
    
    /**
     * Define belongsTo relationship
     */
    protected function belongsTo(string $related, ?string $foreignKey = null, ?string $ownerKey = null): ?object
    {
        $relatedInstance = new $related();
        $foreignKey = $foreignKey ?? $this->getForeignKeyForRelation($related);
        $ownerKey = $ownerKey ?? $relatedInstance->primaryKey;
        
        $cacheKey = "belongsTo:{$related}:{$foreignKey}:{$ownerKey}";
        
        if (isset($this->relationshipCache[$cacheKey])) {
            return $this->relationshipCache[$cacheKey];
        }
        
        $result = $relatedInstance
            ->where($ownerKey, $this->getAttribute($foreignKey))
            ->first();
        
        $this->relationshipCache[$cacheKey] = $result;
        
        return $result;
    }
    
    /**
     * Define hasOne relationship
     */
    protected function hasOne(string $related, ?string $foreignKey = null, ?string $localKey = null): ?object
    {
        $foreignKey = $foreignKey ?? $this->getForeignKey();
        $localKey = $localKey ?? $this->primaryKey;
        
        $cacheKey = "hasOne:{$related}:{$foreignKey}:{$localKey}";
        
        if (isset($this->relationshipCache[$cacheKey])) {
            return $this->relationshipCache[$cacheKey];
        }
        
        $relatedInstance = new $related();
        
        $result = $relatedInstance
            ->where($foreignKey, $this->getAttribute($localKey))
            ->first();
        
        $this->relationshipCache[$cacheKey] = $result;
        
        return $result;
    }
    
    /**
     * Get foreign key for this model
     */
    protected function getForeignKey(): string
    {
        $className = class_basename(static::class);
        return strtolower($className) . '_id';
    }
    
    /**
     * Get foreign key for related model
     */
    protected function getForeignKeyForRelation(string $related): string
    {
        $className = class_basename($related);
        return strtolower($className) . '_id';
    }
    
    /**
     * Load relationship
     */
    public function load(string $relation): self
    {
        if (method_exists($this, $relation)) {
            $this->relations[$relation] = $this->$relation();
        }
        
        return $this;
    }
    
    /**
     * Get loaded relationship
     */
    public function getRelation(string $relation)
    {
        return $this->relations[$relation] ?? null;
    }
    
    /**
     * Check if relationship is loaded
     */
    public function relationLoaded(string $relation): bool
    {
        return isset($this->relations[$relation]);
    }
    
    /**
     * Magic method to access relationships
     */
    public function __get(string $key)
    {
        // Check if it's a relationship method
        if (method_exists($this, $key)) {
            if (!$this->relationLoaded($key)) {
                $this->load($key);
            }
            return $this->getRelation($key);
        }
        
        // Fall back to parent getAttribute
        return $this->getAttribute($key);
    }
}

/**
 * Helper function to get class basename
 */
if (!function_exists('class_basename')) {
    function class_basename($class): string
    {
        $class = is_object($class) ? get_class($class) : $class;
        return basename(str_replace('\\', '/', $class));
    }
}
