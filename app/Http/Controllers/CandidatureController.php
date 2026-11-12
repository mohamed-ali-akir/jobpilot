<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use App\Models\Offer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Attributes\Controllers\Authorize;
use Illuminate\Routing\Attributes\Controllers\Middleware;

#[Middleware('auth')]
class CandidatureController extends Controller
{
    // Mes candidatures : réservé au rôle candidat (Gate)
    #[Authorize('candidater')]
    public function index(Request $request)
    {
        $offers = $request->user()->candidat?->offers()
            ->with('company')
            ->orderByPivot('created_at', 'desc')
            ->get() ?? collect();

        return view('candidatures.index', compact('offers'));
    }

    // Postuler : candidat qui n'a pas encore postulé (Policy apply)
    #[Authorize('apply', 'offer')]
    public function store(Request $request, Offer $offer)
    {
        $candidat = $this->ficheCandidat($request->user());
        $candidat->offers()->syncWithoutDetaching([$offer->id]);

        return to_route('offres.show', $offer)->with('success', 'Candidature envoyée.');
    }

    // Retirer : candidat qui a déjà postulé (Policy withdraw)
    #[Authorize('withdraw', 'offer')]
    public function destroy(Request $request, Offer $offer)
    {
        $request->user()->candidat->offers()->detach($offer->id);

        return back()->with('success', 'Candidature retirée.');
    }

    // Fiche candidat du compte, créée au premier "Postuler"
    private function ficheCandidat(User $user): Candidat
    {
        $morceaux = explode(' ', trim($user->name), 2);

        return $user->candidat()->firstOrCreate([], [
            'firstname' => $morceaux[0],
            'lastname' => $morceaux[1] ?? $morceaux[0],
        ]);
    }
}