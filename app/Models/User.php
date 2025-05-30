<?php

namespace App\Models;

// app/Models/User.php
public function etudiants()
{
    return $this->hasMany(Etudiant::class);
}

public function evaluations()
{
    return $this->hasMany(Evaluation::class);
}