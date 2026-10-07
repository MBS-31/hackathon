<?php

namespace App\Abstracts;

use Illuminate\Database\Eloquent\Model;

/**
 * BaseModel
 *
 * Abstract base model that all CRM domain models extend.
 * Provides consistent defaults: timestamps, guarded=[],
 * and a UUID primary key convention.
 */
abstract class BaseModel extends Model
{
    /**
     * Use mass-assignable protection via $fillable in each model.
     * Override in specific models.
     */
    protected $guarded = ['id'];

    /**
     * Default attribute casting.
     * Override / extend in domain models.
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Scope to order by created_at descending (most recent first).
     */
    public function scopeLatestFirst($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
