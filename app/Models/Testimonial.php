<?php

namespace App\Models;

use Database\ORM\Base\BaseModel;
use Database\ORM\Traits\HasTimestamps;
use Database\ORM\Traits\SoftDeletes;

/**
 * Testimonial Model
 * Gerencia depoimentos de clientes
 */
class Testimonial extends BaseModel
{
    use HasTimestamps, SoftDeletes;
    
    protected string $table = 'testimonials';
    
    protected array $fillable = [
        'name',
        'email',
        'company_role',
        'message',
        'rating',
        'status',
        'approved_by',
        'approved_at',
        'consent_given',
        'consent_ip',
        'consent_date',
        'privacy_policy_version'
    ];
    
    protected array $guarded = ['id'];
    
    protected array $casts = [
        'rating' => 'integer',
        'consent_given' => 'boolean',
        'approved_at' => 'datetime',
        'consent_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    protected array $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email',
        'message' => 'required|min:10',
        'rating' => 'required|integer|min:1|max:5',
    ];
    
    /**
     * Query Scope - Depoimentos aprovados
     */
    public function scopeApproved(): self
    {
        return $this->where('status', 'approved');
    }
    
    /**
     * Query Scope - Depoimentos pendentes
     */
    public function scopePending(): self
    {
        return $this->where('status', 'pending');
    }
    
    /**
     * Query Scope - Depoimentos rejeitados
     */
    public function scopeRejected(): self
    {
        return $this->where('status', 'rejected');
    }
    
    /**
     * Busca depoimentos aprovados ordenados por data (mais recentes primeiro)
     * Exclui registros com soft delete (deleted_at preenchido)
     * 
     * @param int $limit Limite de resultados (padrão: 10)
     * @return array Array de objetos Testimonial
     */
    public static function getApprovedOrdered(int $limit = 10): array
    {
        return static::make()
            ->approved()
            ->whereNull('deleted_at')  // Ignora registros soft deleted
            ->orderBy('created_at', 'DESC')
            ->limit($limit)
            ->get();
    }
    
    /**
     * Busca depoimentos pendentes ordenados por data
     * 
     * @return array Array de objetos Testimonial
     */
    public static function getPendingOrdered(): array
    {
        return static::make()
            ->pending()
            ->orderBy('created_at', 'ASC')
            ->get();
    }
    
    /**
     * Aprova o depoimento
     * 
     * @param int $approvedBy ID do usuário que aprovou
     * @return bool
     */
    public function approve(int $approvedBy): bool
    {
        $this->setAttribute('status', 'approved');
        $this->setAttribute('approved_by', $approvedBy);
        $this->setAttribute('approved_at', date('Y-m-d H:i:s'));
        return $this->save();
    }
    
    /**
     * Rejeita o depoimento
     * 
     * @return bool
     */
    public function reject(): bool
    {
        $this->setAttribute('status', 'rejected');
        return $this->save();
    }
    
    /**
     * Verifica se o depoimento está aprovado
     * 
     * @return bool
     */
    public function isApproved(): bool
    {
        return $this->getAttribute('status') === 'approved';
    }
    
    /**
     * Verifica se o depoimento está pendente
     * 
     * @return bool
     */
    public function isPending(): bool
    {
        return $this->getAttribute('status') === 'pending';
    }
    
    /**
     * Verifica se o depoimento está rejeitado
     * 
     * @return bool
     */
    public function isRejected(): bool
    {
        return $this->getAttribute('status') === 'rejected';
    }
    
    /**
     * Retorna as estrelas como string HTML
     * 
     * @return string
     */
    public function getStarsHtml(): string
    {
        $rating = $this->getAttribute('rating');
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $rating) {
                $stars .= '<i class="fas fa-star text-warning"></i>';
            } else {
                $stars .= '<i class="far fa-star text-warning"></i>';
            }
        }
        return $stars;
    }
    
    /**
     * Event Hook - Before Save
     * Valida rating
     */
    protected function beforeSave(): void
    {
        // Garante que o rating está entre 1 e 5
        if (isset($this->attributes['rating'])) {
            $rating = (int) $this->attributes['rating'];
            if ($rating < 1) $rating = 1;
            if ($rating > 5) $rating = 5;
            $this->attributes['rating'] = $rating;
        }
    }
}
