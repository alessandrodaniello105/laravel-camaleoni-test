<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Musician extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'surname',
        'email',
        'ig_account'
    ];

    public function instrument():BelongsTo {
        return $this->belongsTo(Instrument::class);
    }

    public function bands():BelongsToMany {
        return $this->belongsToMany(Band::class)->withTimestamps();
    }

    // % Accessor % to read if musician has already played
    // protected function has_played():Attribute {
    //     return Attribute::make(
    //         get: fn (bool $value) => $value,
    //         set: fn (bool $value) => $value
    //     );
    // }


    public function getFullNameAttribute() {
        return $this->attributes['name'] . ' ' . $this->attributes['surname'];
    }


    // % Inseriamo due Accessor per leggere nome e cognome
    // public function getNameAttribute($value):String {
    //     return $value;
    // }

    // public function getSurnameAttribute($value):String {
    //     return $value;
    // }

    // public function setFullNameAttribute($value) {
    //     $name = $this->getNameAttribute($value);
    //     $surname = $this->getSurnameAttribute($this->surname);
    //     $this->attributes['full_name'] = $name . ' ' . $surname;
    // }
    // try this below as alternative to accessor/mutator solution
    // protected function casts():Array {

    //     return [
    //         'has_played' => 'boolean',
    //     ];
    // }
}
