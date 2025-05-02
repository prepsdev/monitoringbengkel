<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Technician extends Model
{
    protected $fillable = ['name', 'status'];

    public function works()
    {
        return $this->belongsToMany(Work::class);
    }
}
