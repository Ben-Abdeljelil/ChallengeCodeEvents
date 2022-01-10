<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Participations;
use Employees;

class Events extends Model
{
    use HasFactory;

    protected $table = 'events';

    /**
     * @var array $fillable
     */
    protected $fillable = [
        'name',
        'date'
    ];

    /**
     * The employees that belong to the event.
     */
    public function employees()
    {
        return $this->belongsToMany(Employees::class, Participations::class);
    }
}
