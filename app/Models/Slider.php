<?php

namespace App\Models;

use Database\ORM\Base\BaseModel;
use Database\ORM\Traits\HasTimestamps;

/**
 * Slider Model
 */
class Slider extends BaseModel
{
    use HasTimestamps;
    
    protected string $table = 'sliders';
    
    protected array $fillable = [
        'title',
        'subtitle',
        'description',
        'image',
        'button_text',
        'button_link',
        'order_position',
        'status'
    ];
    
    protected array $guarded = ['id'];
    
    protected array $casts = [
        'order_position' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    protected array $rules = [
        'title' => 'required|max:20',
        'subtitle' => 'max:50',
        'image' => 'required',
        'button_text' => 'max:100',
        'status' => 'required|in:active,inactive',
    ];
    
    /**
     * Query Scope - Active sliders
     */
    public function scopeActive($query): self
    {
        return $this->where('status', 'active');
    }
    
    /**
     * Query Scope - Ordered by position
     */
    public function scopeOrdered($query): self
    {
        return $this->orderBy('order_position', 'ASC');
    }
    
    /**
     * Get active sliders ordered by position
     */
    public static function getActiveOrdered(): array
    {
        return static::make()->where('status', 'active')->orderBy('order_position', 'ASC')->get();
    }
    
    /**
     * Check if slider is active
     */
    public function isActive(): bool
    {
        return $this->getAttribute('status') === 'active';
    }
    
    /**
     * Get image URL
     */
    public function getImageUrl(): string
    {
        $image = $this->getAttribute('image');
        
        // Se já for uma URL completa, retorna
        if (str_starts_with($image, 'http')) {
            return $image;
        }
        
        // Caso contrário, monta URL relativa
        return urlBase($image);
    }
    
    /**
     * Check if has button
     */
    public function hasButton(): bool
    {
        return !empty($this->getAttribute('button_text')) && 
               !empty($this->getAttribute('button_link'));
    }
}
