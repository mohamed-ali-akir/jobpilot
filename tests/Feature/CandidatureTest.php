<?php

/*
| Vérifie automatiquement les droits du rôle candidat :
|
| Action                   | Invité | Visiteur | Candidat        | Éditeur | Admin
| Postuler à une offre     |   ❌   |    ❌    | ✅ (une fois)   |   ❌    |  ❌
| Retirer sa candidature   |   ❌   |    ❌    | ✅ (si postulé) |   ❌    |  ❌
| Voir « Mes candidatures »|   ❌   |    ❌    |       ✅        |   ❌    |  ❌
*/

use App\Models\Candidat;
use App\Models\Offer;
use App\Models\User;

test('un invité est renvoyé vers la connexion', function () {
    $offer = Offer::factory()->create();

    $this->get(route('candidatures.index'))->assertRedirect(route('login'));
    $this->post(route('candidatures.store', $offer))->assertRedirect(route('login'));
});

test('visiteur, éditeur et admin ne peuvent pas postuler', function () {
    $offer = Offer::factory()->create();
    $autres = [
        User::factory()->create(),            // visiteur (rôle par défaut)
        User::factory()->editeur()->create(),
        User::factory()->admin()->create(),
    ];

    foreach ($autres as $user) {
        $this->actingAs($user)->post(route('candidatures.store', $offer))->assertForbidden();
        $this->actingAs($user)->get(route('candidatures.index'))->assertForbidden();
    }

    expect(Candidat::count())->toBe(0);
});

test('un candidat postule : sa fiche est créée depuis son nom', function () {
    $user = User::factory()->candidat()->create(['name' => 'Lina Martin']);
    $offer = Offer::factory()->create();

    $this->actingAs($user)->post(route('candidatures.store', $offer))
        ->assertRedirect(route('offres.show', $offer))
        ->assertSessionHas('success', 'Candidature envoyée.');

    $candidat = $user->fresh()->candidat;
    expect($candidat->firstname)->toBe('Lina');
    expect($candidat->lastname)->toBe('Martin');
    expect($candidat->offers->pluck('id')->all())->toBe([$offer->id]);
});

test('un candidat ne peut pas postuler deux fois à la même offre', function () {
    $user = User::factory()->candidat()->create();
    $offer = Offer::factory()->create();

    $this->actingAs($user)->post(route('candidatures.store', $offer));
    $this->actingAs($user->fresh())->post(route('candidatures.store', $offer))->assertForbidden();

    expect($user->fresh()->candidat->offers()->count())->toBe(1);
});

test('un candidat retire sa candidature', function () {
    $user = User::factory()->candidat()->create();
    $offer = Offer::factory()->create();
    $this->actingAs($user)->post(route('candidatures.store', $offer));

    $this->actingAs($user->fresh())->delete(route('candidatures.destroy', $offer))
        ->assertSessionHas('success', 'Candidature retirée.');

    expect($user->fresh()->candidat->offers()->count())->toBe(0);
});

test('on ne peut pas retirer une candidature jamais envoyée', function () {
    $user = User::factory()->candidat()->create();
    $offer = Offer::factory()->create();

    $this->actingAs($user)->delete(route('candidatures.destroy', $offer))->assertForbidden();
});

test('« Mes candidatures » affiche les offres du candidat', function () {
    $this->withoutVite();
    $user = User::factory()->candidat()->create();
    [$postulee, $autre] = Offer::factory()->count(2)->create();
    $this->actingAs($user)->post(route('candidatures.store', $postulee));

    $this->actingAs($user->fresh())->get(route('candidatures.index'))
        ->assertOk()
        ->assertSee($postulee->name)
        ->assertDontSee($autre->name);
});

test('le bouton Postuler ne s\'affiche que pour un candidat', function () {
    $this->withoutVite();
    $offer = Offer::factory()->create();

    $this->actingAs(User::factory()->candidat()->create())
        ->get(route('offres.show', $offer))->assertSee('Postuler');

    $this->actingAs(User::factory()->editeur()->create())
        ->get(route('offres.show', $offer))->assertDontSee('Postuler');
});

test('supprimer le compte supprime la fiche candidat', function () {
    $user = User::factory()->candidat()->create();
    $offer = Offer::factory()->create();
    $this->actingAs($user)->post(route('candidatures.store', $offer));

    $user->delete();

    expect(Candidat::count())->toBe(0);
    expect($offer->candidats()->count())->toBe(0);
});