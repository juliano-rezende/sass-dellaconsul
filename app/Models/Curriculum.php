<?php

namespace App\Models;

use App\Traits\HasTimestamps;
use App\Traits\SoftDeletes;
use App\Traits\HasRelationships;

/**
 * Curriculum Model
 */
class Curriculum extends BaseModel
{
    use HasTimestamps, SoftDeletes, HasRelationships;
    
    protected string $table = 'curriculum';
    
    protected array $fillable = [
        'name',
        'email',
        'phone',
        'career_area_id',
        'position',
        'experience_years',
        'file_path',
        'message',
        'status'
    ];
    
    protected array $guarded = ['id'];
    
    protected array $casts = [
        'career_area_id' => 'integer',
        'experience_years' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    protected array $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email',
        'phone' => 'required',
        'career_area_id' => 'required|integer',
        'position' => 'required',
        'file_path' => 'required',
        'status' => 'required|in:novo,analise,aprovado,reprovado,entrevista',
    ];
    
    /**
     * Relationship - Belongs to CareerArea
     */
    public function careerArea(): ?object
    {
        return $this->belongsTo(CareerArea::class, 'career_area_id');
    }
    
    /**
     * Query Scope - By status
     */
    public function scopeByStatus($query, string $status): self
    {
        return $this->where('status', $status);
    }
    
    /**
     * Query Scope - New applications
     */
    public function scopeNew($query): self
    {
        return $this->where('status', 'novo');
    }
    
    /**
     * Query Scope - In analysis
     */
    public function scopeInAnalysis($query): self
    {
        return $this->where('status', 'analise');
    }
    
    /**
     * Query Scope - Approved
     */
    public function scopeApproved($query): self
    {
        return $this->where('status', 'aprovado');
    }
    
    /**
     * Query Scope - Recent (last 30 days)
     */
    public function scopeRecent($query): self
    {
        $date = date('Y-m-d H:i:s', strtotime('-30 days'));
        return $this->where('created_at', '>=', $date);
    }
    
    /**
     * Change status to analysis
     */
    public function markAsAnalysis(): bool
    {
        $this->setAttribute('status', 'analise');
        return $this->save();
    }
    
    /**
     * Approve curriculum
     */
    public function approve(): bool
    {
        $this->setAttribute('status', 'aprovado');
        return $this->save();
    }
    
    /**
     * Reject curriculum
     */
    public function reject(): bool
    {
        $this->setAttribute('status', 'reprovado');
        return $this->save();
    }
    
    /**
     * Mark for interview
     */
    public function markForInterview(): bool
    {
        $this->setAttribute('status', 'entrevista');
        return $this->save();
    }
    
    /**
     * Get file URL
     */
    public function getFileUrl(): string
    {
        $filePath = $this->getAttribute('file_path');
        
        if (str_starts_with($filePath, 'http')) {
            return $filePath;
        }
        
        return urlBase($filePath);
    }
    
    /**
     * Check if is new
     */
    public function isNew(): bool
    {
        return $this->getAttribute('status') === 'novo';
    }
    
    /**
     * Get status label in Portuguese
     */
    public function getStatusLabel(): string
    {
        $labels = [
            'novo' => 'Novo',
            'analise' => 'Em Análise',
            'aprovado' => 'Aprovado',
            'reprovado' => 'Reprovado',
            'entrevista' => 'Entrevista Agendada'
        ];
        
        return $labels[$this->getAttribute('status')] ?? 'Desconhecido';
    }
}
