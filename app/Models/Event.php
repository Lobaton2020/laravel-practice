<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $table = 'events';
    protected $fillable = [
        'title',
        'location',
        'start',
        'end',
        'state',
        'id_sala'
    ];

    protected $dates = [
        'start',
        'end'
    ];

    public function sala()
    {
        return $this->belongsTo(Sala::class, 'id_sala');
    }
}
