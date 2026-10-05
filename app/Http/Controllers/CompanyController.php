<?php

namespace App\Http\Controllers;

use App\Models\company;
use App\Http\Requests\StorecompanyRequest;
use App\Http\Requests\UpdatecompanyRequest;

class companyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = company::all();
        return view('company.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('company.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorecompanyRequest $request)
    {
        $validated = $request->validate([
            'nom'=>'required',
        ]);

        company::create($validated);
        return redirect()->route('company.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatecompanyRequest $request, company $company)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(company $company)
    {
        $company->delete();
        return redirect()
            ->route('company.index')
            ->with('success', 'Entreprise supprimée avec succès.');
    }
}
