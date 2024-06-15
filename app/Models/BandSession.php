<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BandSession extends Model
{
    use HasFactory;

    public function __construct(
                private Musician $drummer,
                private Musician $bassist,
                private Musician $guitarist,
                private Musician $singer,
                private Musician $otherist,
                public bool $hasPlayed = false,
    )
    {
    }


}
