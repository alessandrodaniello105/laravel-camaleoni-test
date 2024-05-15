<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Instrument extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'icon',
        'description'
    ];

    public function musician(): HasMany {
        return $this->hasMany(Musician::class);
    }

    public function getName(): String {
        return $this->getName();
    }
}
