<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Participations;
use Events;

class Employees extends Model
{
    use HasFactory;
    
    protected $table = 'employees';
    
    /**
     * @var array $fillable
     */
    protected $fillable = [
        'name',
        'email'
    ];

    /**
     * The events that belong to the employee.
     */
    public function events()
    {
        return $this->belongsToMany(Events::class, Participations::class);
    }
}
