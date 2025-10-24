<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Financeiro extends Model
{
    protected $table = 'cfg_financeiro';

    protected $fillable = [
        'user_id',
        'salary',
        'limit_spend'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
