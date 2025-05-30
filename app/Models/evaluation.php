<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'type',
        'date',
        'user_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'date',
    ];

    /**
     * Get the teacher that owns the evaluation.
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the students for the evaluation.
     */
    public function etudiants()
    {
        return $this->belongsToMany(Etudiant::class, 'etudiant_evaluation')
                    ->withPivot('note', 'is_submitted')
                    ->withTimestamps();
    }
}