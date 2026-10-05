<?php

namespace App\Http\Controllers;

use App\Models\offer;
use App\Models\company;
use App\Http\Requests\StoreofferRequest;
use App\Http\Requests\UpdateofferRequest;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $offers = Offer::all();
        return view('offer.index', compact('offers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = company::all();
        return view('offer.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreofferRequest $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'companies_id' => 'required',
            'date_debut' => 'required',
            'salaire' => 'required|numeric',
            'address' => 'required',
        ]);

        Offer::create($validated);
        return redirect() ->route('offer.index')->with('succes', 'offre ajouté avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(offer $offer)
    {
        return view('offer.show', compact('offer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(offer $offer)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateofferRequest $request, offer $offer)
    {
        $validated = $request->validate([
            'name' => 'required',
            'companies_id' => 'required',
            'date_debut' => 'required',
            'salaire' => 'required',
            'address' => 'required',
        ]);
        $offer->update($validated);
        return redirect()
            ->route('offer.index')
            ->with('success', 'Offre modifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(offer $offer)
    {
        $offer->delete();
        return redirect()
            ->route('offer.index')
            ->with('success', 'Offre supprimé avec succès.');
    }
}
