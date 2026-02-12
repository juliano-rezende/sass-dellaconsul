<?php

namespace App\Models;

use Database\ORM\Base\BaseModel;
use Database\ORM\Traits\HasRelationships;
use Database\ORM\Traits\HasTimestamps;

/**
 * CareerArea Model
 */
class CareerArea extends BaseModel
{
    use HasTimestamps, HasRelationships;
    
    protected string $table = 'career_areas';
    
    protected array $fillable = [
        'name',
        'description',
        'status'
    ];
    
    protected array $guarded = ['id'];
    
    protected array $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    protected array $rules = [
        'name' => 'required|min:3|max:100',
        'status' => 'required|in:active,inactive',
    ];
    
    /**
     * Relationship - Has many Curriculum
     */
    public function curriculums(): array
    {
        return $this->hasMany(Curriculum::class, 'career_area_id');
    }
    
    /**
     * Query Scope - Active areas
     */
    public function scopeActive($query): self
    {
        return $this->where('status', 'active');
    }
    
    /**
     * Check if area is active
     */
    public function isActive(): bool
    {
        return $this->getAttribute('status') === 'active';
    }
    
    /**
     * Get count of curriculums
     */
    public function getCurriculumCount(): int
    {
        return count($this->curriculums());
    }
    
    /**
     * Get active curriculums
     */
    public function getActiveCurriculums(): array
    {
        $curriculum = new Curriculum();
        return $curriculum->where('career_area_id', $this->getAttribute('id'))
                         ->where('status', '!=', 'reprovado')
                         ->get();
    }
}
