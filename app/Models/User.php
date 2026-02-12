<?php

namespace App\Models;

use Database\ORM\Base\BaseModel;
use Database\ORM\Traits\HasTimestamps;
use Database\ORM\Traits\SoftDeletes;

/**
 * User Model
 */
class User extends BaseModel
{
    use HasTimestamps, SoftDeletes;
    
    protected string $table = 'users';
    
    protected array $fillable = [
        'name',
        'email',
        'password',
        'role',
        'department',
        'status',
        'phone',
        'avatar',
        'last_login'
    ];
    
    protected array $guarded = ['id'];
    
    protected array $hidden = ['password'];
    
    protected array $casts = [
        'last_login' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    protected array $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email|unique:users,email',
        'role' => 'required|in:admin,manager,operator,viewer',
        'department' => 'required|in:administrativo,financeiro,manutencao,seguranca,ti',
    ];
    
    /**
     * Query Scope - Active users
     */
    public function scopeActive($query): self
    {
        return $this->where('status', 'active');
    }
    
    /**
     * Query Scope - By role
     */
    public function scopeByRole($query, string $role): self
    {
        return $this->where('role', $role);
    }
    
    /**
     * Query Scope - By department
     */
    public function scopeByDepartment($query, string $department): self
    {
        return $this->where('department', $department);
    }
    
    /**
     * Event Hook - Before Save
     * Hash password if it's being set
     */
    protected function beforeSave(): void
    {
        // Hash password if it's being set or changed
        if (isset($this->attributes['password']) && 
            (!$this->exists || $this->isDirty())) {
            
            $password = $this->attributes['password'];
            
            // Only hash if it's not already hashed
            if (!password_get_info($password)['algo']) {
                $this->attributes['password'] = password_hash($password, PASSWORD_DEFAULT);
            }
        }
    }
    
    /**
     * Verify password
     */
    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->attributes['password']);
    }
    
    /**
     * Update last login timestamp
     */
    public function updateLastLogin(): bool
    {
        $this->setAttribute('last_login', date('Y-m-d H:i:s'));
        return $this->save();
    }
    
    /**
     * Check if user has role
     */
    public function hasRole(string $role): bool
    {
        return $this->getAttribute('role') === $role;
    }
    
    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }
    
    /**
     * Check if user is active
     */
    public function isActive(): bool
    {
        return $this->getAttribute('status') === 'active';
    }
    
    /**
     * Get full name with email
     */
    public function getFullIdentity(): string
    {
        return "{$this->name} ({$this->email})";
    }
}
