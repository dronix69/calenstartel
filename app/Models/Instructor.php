<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function members ()
    {
        return $this->belongsToMany(User::class, 'instructor_user', 'instructor_id', 'user_id');
    }
    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class);
    }
}
