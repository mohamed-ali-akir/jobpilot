<?php

namespace App\Http\Controllers;

use App\Models\candidat;
use App\Http\Requests\StorecandidatRequest;
use App\Http\Requests\UpdatecandidatRequest;

class CandidatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $candidats = Candidat::all();
        return view('candidat.index', compact('candidats'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('candidat.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorecandidatRequest $request)
    {
        $validated = $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
        ]);

        Candidat::create($validated);
        return redirect()->route('candidat.index')->with('success','candidat ajouté avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(candidat $candidat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(candidat $candidat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatecandidatRequest $request, candidat $candidat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(candidat $candidat)
    {
        $candidat->delete();
        return redirect()
            ->route('candidat.index')
            ->with('success', 'Offre supprimée avec succès.');
    }
}
