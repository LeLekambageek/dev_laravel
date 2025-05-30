<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use Illuminate\Http\Request;

class EtudiantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $etudiants = Etudiant::where('user_id', auth()->id())->get();
        return view('etudiants.index', compact('etudiants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('etudiants.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'student_id' => 'nullable|string|max:255|unique:etudiants',
        ]);

        $etudiant = new Etudiant($request->all());
        $etudiant->user_id = auth()->id();
        $etudiant->save();

        return redirect()->route('etudiants.index')
            ->with('success', 'Étudiant ajouté avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Etudiant $etudiant)
    {
        // Vérifier que l'étudiant appartient à l'enseignant connecté
        if ($etudiant->user_id !== auth()->id()) {
            abort(403);
        }

        return view('etudiants.show', compact('etudiant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Etudiant $etudiant)
    {
        // Vérifier que l'étudiant appartient à l'enseignant connecté
        if ($etudiant->user_id !== auth()->id()) {
            abort(403);
        }

        return view('etudiants.edit', compact('etudiant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Etudiant $etudiant)
    {
        // Vérifier que l'étudiant appartient à l'enseignant connecté
        if ($etudiant->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'etudiants_id' => 'nullable|string|max:255|unique:etudiants,student_id,' . $etudiant->id,
        ]);

        $etudiant->update($request->all());

        return redirect()->route('etudiants.index')
            ->with('success', 'Étudiant mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Etudiant $etudiant)
    {
        // Vérifier que l'étudiant appartient à l'enseignant connecté
        if ($etudiant->user_id !== auth()->id()) {
            abort(403);
        }

        $etudiant->delete();

        return redirect()->route('etudiants.index')
            ->with('success', 'Étudiant supprimé avec succès.');
    }
}