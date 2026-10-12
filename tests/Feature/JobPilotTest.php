<?php

use App\Models\Candidat;
use App\Models\Company;
use App\Models\Offer;
use App\Models\User;

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

test('les invités sont redirigés vers la connexion', function () {
    auth()->logout();

    $this->get(route('offres.index'))->assertRedirect(route('login'));
});

test('toutes les pages s\'affichent', function () {
    $offer = Offer::factory()->create();
    $candidat = Candidat::factory()->create();
    $candidat->offers()->attach($offer);

    $this->get(route('dashboard'))->assertOk()->assertSee($offer->name);

    $this->get(route('offres.index'))->assertOk()->assertSee($offer->name)->assertSee($offer->type_contrat);
    $this->get(route('offres.create'))->assertOk();
    $this->get(route('offres.show', $offer))->assertOk()->assertSee($candidat->full_name);
    $this->get(route('offres.edit', $offer))->assertOk()->assertSee($offer->name);

    $this->get(route('entreprises.index'))->assertOk()->assertSee($offer->company->nom);
    $this->get(route('entreprises.create'))->assertOk();
    $this->get(route('entreprises.show', $offer->company))->assertOk()->assertSee($offer->name);
    $this->get(route('entreprises.edit', $offer->company))->assertOk();

    $this->get(route('candidats.index'))->assertOk()->assertSee($candidat->full_name);
    $this->get(route('candidats.create'))->assertOk();
    $this->get(route('candidats.show', $candidat))->assertOk()->assertSee($offer->name);
    $this->get(route('candidats.edit', $candidat))->assertOk();
});

test('CRUD complet d\'une offre avec messages flash', function () {
    $company = Company::factory()->create();
    $data = [
        'name' => 'Développeur Laravel',
        'company_id' => $company->id,
        'type_contrat' => 'CDI',
        'date_debut' => '2026-11-02',
        'salaire' => 2500,
        'address' => 'Lyon',
    ];

    // Create
    $this->post(route('offres.store'), $data)
        ->assertRedirect(route('offres.index'))
        ->assertSessionHas('success', 'Offre ajoutée avec succès.');
    $offer = Offer::firstWhere('name', 'Développeur Laravel');
    expect($offer->company->nom)->toBe($company->nom);

    // Le message flash est bien affiché sur la page suivante
    $this->followingRedirects()->post(route('offres.store'), $data)->assertSee('Offre ajoutée avec succès.');

    // Update
    $this->put(route('offres.update', $offer), [...$data, 'type_contrat' => 'CDD'])
        ->assertRedirect(route('offres.index'))
        ->assertSessionHas('success', 'Offre modifiée avec succès.');
    expect($offer->fresh()->type_contrat)->toBe('CDD');

    // Delete
    $this->delete(route('offres.destroy', $offer))
        ->assertSessionHas('success', 'Offre supprimée avec succès.');
    expect(Offer::find($offer->id))->toBeNull();
});

test('la validation des offres refuse les données invalides', function () {
    $this->from(route('offres.create'))
        ->post(route('offres.store'), ['salaire' => -5, 'type_contrat' => 'Freelance', 'company_id' => 999])
        ->assertRedirect(route('offres.create'))
        ->assertSessionHasErrors(['name', 'company_id', 'type_contrat', 'date_debut', 'salaire', 'address']);

    expect(Offer::count())->toBe(0);
});

test('CRUD d\'une entreprise et refus de suppression si elle a des offres', function () {
    $this->post(route('entreprises.store'), ['nom' => 'JobCorp'])
        ->assertSessionHas('success');
    $company = Company::firstWhere('nom', 'JobCorp');

    $this->put(route('entreprises.update', $company), ['nom' => 'JobCorp SAS'])
        ->assertSessionHas('success');
    expect($company->fresh()->nom)->toBe('JobCorp SAS');

    Offer::factory()->for($company)->create();
    $this->delete(route('entreprises.destroy', $company))->assertSessionHas('error');
    expect(Company::find($company->id))->not->toBeNull();

    $company->offers()->delete();
    $this->delete(route('entreprises.destroy', $company))->assertSessionHas('success');
    expect(Company::find($company->id))->toBeNull();
});

test('un candidat postule à plusieurs offres (many-to-many)', function () {
    $offers = Offer::factory()->count(3)->create();

    $this->post(route('candidats.store'), [
        'firstname' => 'Nabil',
        'lastname' => 'Martin',
        'offers' => $offers->take(2)->pluck('id')->all(),
    ])->assertSessionHas('success');

    $candidat = Candidat::firstWhere('lastname', 'Martin');
    expect($candidat->offers)->toHaveCount(2)
        ->and($offers->first()->candidats->first()->id)->toBe($candidat->id);

    $this->put(route('candidats.update', $candidat), [
        'firstname' => 'Nabil',
        'lastname' => 'Martin',
        'offers' => [$offers->last()->id],
    ])->assertSessionHas('success');
    expect($candidat->fresh()->offers->pluck('id')->all())->toBe([$offers->last()->id]);

    $this->delete(route('candidats.destroy', $candidat))->assertSessionHas('success');
    expect(Candidat::count())->toBe(0);
});
