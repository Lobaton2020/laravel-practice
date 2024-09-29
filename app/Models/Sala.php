<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sala extends Model
{
    use HasFactory;
    protected $fillable = ['nombre'];
    public function eventos()
    {
        return $this->hasMany(Event::class, 'id_sala');
    }
}
