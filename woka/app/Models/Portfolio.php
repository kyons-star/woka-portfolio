<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Portfolio extends Model
{
    protected $fillable = [
        'user_id',
        'number',
        'style',
        'data',
        'picture',
    ];

    protected function casts(): array
    {
        return [
            'data' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** Everything the portfolio partial needs, including the picture URL. */
    public function viewData(): array
    {
        return array_merge($this->data ?? [], [
            'pic' => $this->picture ? asset('storage/' . $this->picture) : null,
        ]);
    }
}