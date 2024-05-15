<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Band extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        // 'has_played',
        'played_at'
    ];

    public function musicians():BelongsToMany {
        return $this->belongsToMany(Musician::class)->withTimestamps();
    }
}
