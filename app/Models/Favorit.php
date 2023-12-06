<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favorit extends Model
{
    protected $table = 'favorit';
    protected $fillable = ['id', 'user_id', 'buku_id'];

    public function buku(): BelongsTo
    {
        return $this->belongsTo(Buku::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}


