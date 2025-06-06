<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom',
        'prenom',
        'student_id',
        'user_id',
    ];

    /**
     * Get the teacher that owns the student.
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the evaluations for the student.
     */
    public function evaluations()
    {
        return $this->belongsToMany(Evaluation::class, 'etudiants_evaluations')
                    ->withPivot('note', 'is_submitted')
                    ->withTimestamps();
    }

    /**
     * Get the full name of the student.
     */
    public function getFullNameAttribute()
    {
        return "{$this->nom} {$this->prenom}";
    }
}