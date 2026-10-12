<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;

class CompanyController extends Controller
{
    /**
     * Liste des entreprises.
     */
    public function index()
    {
        $companies = Company::withCount('offers')->orderBy('nom')->get();

        return view('entreprises.index', compact('companies'));
    }

    /**
     * Formulaire d'ajout.
     */
    public function create()
    {
        return view('entreprises.create');
    }

    /**
     * Enregistre une nouvelle entreprise.
     */
    public function store(StoreCompanyRequest $request)
    {
        Company::create($request->validated());

        return redirect()
            ->route('entreprises.index')
            ->with('success', 'Entreprise ajoutée avec succès.');
    }

    /**
     * Détail d'une entreprise avec ses offres.
     */
    public function show(Company $company)
    {
        $company->load('offers.company');

        return view('entreprises.show', compact('company'));
    }

    /**
     * Formulaire de modification.
     */
    public function edit(Company $company)
    {
        return view('entreprises.edit', compact('company'));
    }

    /**
     * Met à jour une entreprise.
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $company->update($request->validated());

        return redirect()
            ->route('entreprises.index')
            ->with('success', 'Entreprise modifiée avec succès.');
    }

    /**
     * Supprime une entreprise (refusé si elle a encore des offres).
     */
    public function destroy(Company $company)
    {
        if ($company->offers()->exists()) {
            return redirect()
                ->route('entreprises.index')
                ->with('error', "Impossible de supprimer « {$company->nom} » : elle a encore des offres.");
        }

        $company->delete();

        return redirect()
            ->route('entreprises.index')
            ->with('success', 'Entreprise supprimée avec succès.');
    }
}
