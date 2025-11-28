<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['first_name', 'last_name', 'email', 'course_id'];

    // Relación: un estudiante pertenece a un curso
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
