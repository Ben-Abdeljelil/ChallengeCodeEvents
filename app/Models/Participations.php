<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participations extends Model
{
    use HasFactory;

    protected $table = "participations";

    protected $fillable = [
        "event_id",
        "employee_id",
        "fee",
        "version"
    ];

    public $timestamps = false;
}
