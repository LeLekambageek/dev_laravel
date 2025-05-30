<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\Evaluation;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $evaluations = Evaluation::all(); // Récupérer toutes les évaluations sans filtrer par user_id
        return view('evaluations.index', compact('evaluations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $etudiants = Etudiant::all(); // Récupérer tous les étudiants
        return view('evaluations.create', compact('etudiants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:exam,homework',
            'date' => 'required|date',
            'user_id' => 'required|exists:users,id', // L'utilisateur doit être sélectionné manuellement
            'etudiants' => 'nullable|array',
            'etudiants.*' => 'exists:etudiants,id',
        ]);

        $evaluation = Evaluation::create($request->all());

        // Attacher les étudiants sélectionnés à l'évaluation
        if ($request->has('etudiants')) {
            $evaluation->etudiants()->attach($request->etudiants);
        }

        return redirect()->route('evaluations.index')
            ->with('success', 'Évaluation créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Evaluation $evaluation)
    {
        return view('evaluations.show', compact('evaluation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Evaluation $evaluation)
    {
        $etudiants = Etudiant::all(); // Récupérer tous les étudiants
        $selectedEtudiants = $evaluation->etudiants->pluck('id')->toArray();

        return view('evaluations.edit', compact('evaluation', 'etudiants', 'selectedEtudiants'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Evaluation $evaluation)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:exam,homework',
            'date' => 'required|date',
            'user_id' => 'required|exists:users,id', // L'utilisateur doit être sélectionné manuellement
            'etudiants' => 'nullable|array',
            'etudiants.*' => 'exists:etudiants,id',
        ]);

        $evaluation->update($request->all());

        // Mettre à jour les étudiants associés à l'évaluation
        if ($request->has('etudiants')) {
            $evaluation->etudiants()->sync($request->etudiants);
        } else {
            $evaluation->etudiants()->detach();
        }

        return redirect()->route('evaluations.index')
            ->with('success', 'Évaluation mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Evaluation $evaluation)
    {
        $evaluation->delete();

        return redirect()->route('evaluations.index')
            ->with('success', 'Évaluation supprimée avec succès.');
    }

    /**
     * Show the form for grading students.
     */
    public function grade(Evaluation $evaluation)
    {
        return view('evaluations.grade', compact('evaluation'));
    }

    /**
     * Update grades for students.
     */
    public function updateGrades(Request $request, Evaluation $evaluation)
    {
        $request->validate([
            'notes' => 'required|array',
            'notes.*' => 'nullable|numeric|min:0|max:20',
        ]);

        foreach ($request->notes as $etudiantId => $note) {
            $evaluation->etudiants()->updateExistingPivot($etudiantId, [
                'note' => $note,
            ]);
        }

        return redirect()->route('evaluations.show', $evaluation)
            ->with('success', 'Notes mises à jour avec succès.');
    }
}