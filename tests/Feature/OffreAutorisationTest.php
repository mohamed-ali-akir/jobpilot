<?php

/*
| Vérifie automatiquement la matrice des droits de la séance 6b :
|
| Action                    | Invité | Visiteur | Éditeur    | Admin
| Voir la liste / le détail |   ✅   |    ✅    |     ✅     |  ✅
| Accéder à son profil      |   ❌   |    ✅    |     ✅     |  ✅
| Créer une offre           |   ❌   |    ❌    |     ✅     |  ✅
| Modifier une offre        |   ❌   |    ❌    | Ses offres | Toutes
| Supprimer une offre       |   ❌   |    ❌    |     ❌     |  ✅
| Gérer les rôles           |   ❌   |    ❌    |     ❌     |  ✅
*/

use App\Enums\Role;
use App\Models\Company;
use App\Models\Offer;
use App\Models\User;

function donneesOffre(): array
{
    return [
        'name' => 'Développeur Laravel',
        'company_id' => Company::factory()->create()->id,
        'type_contrat' => 'CDI',
        'date_debut' => '2026-12-01',
        'salaire' => 2500,
        'address' => 'Dijon',
    ];
}

// ---------- Invité ----------

test('un invité voit la liste et le détail des offres', function () {
    $offer = Offer::factory()->create();

    $this->get(route('offres.index'))->assertOk()->assertSee($offer->name);
    $this->get(route('offres.show', $offer))->assertOk();
});

test('un invité est redirigé vers le login pour toute action protégée', function () {
    $offer = Offer::factory()->create();

    $this->get(route('profil'))->assertRedirect(route('login'));
    $this->get(route('offres.create'))->assertRedirect(route('login'));
    $this->post(route('offres.store'), donneesOffre())->assertRedirect(route('login'));
    $this->get(route('offres.edit', $offer))->assertRedirect(route('login'));
    $this->delete(route('offres.destroy', $offer))->assertRedirect(route('login'));
    $this->get(route('admin.users.index'))->assertRedirect(route('login'));

    $this->assertModelExists($offer);
});

test('un invité ne voit aucun bouton d\'action', function () {
    $offer = Offer::factory()->create();

    $this->get(route('offres.index'))
        ->assertDontSee('Ajouter une offre')
        ->assertDontSee('Modifier')
        ->assertDontSee('Supprimer');

    $this->get(route('offres.show', $offer))
        ->assertDontSee('Modifier')
        ->assertDontSee('Candidats (');
});

// ---------- Visiteur ----------

test('un visiteur accède à son profil', function () {
    $visiteur = User::factory()->create();

    $this->actingAs($visiteur)->get(route('profil'))->assertOk()->assertSee('Visiteur');
});

test('un visiteur ne peut ni créer, ni modifier, ni supprimer une offre', function () {
    $offer = Offer::factory()->create();
    $this->actingAs(User::factory()->create());

    $this->get(route('offres.create'))->assertForbidden();
    $this->post(route('offres.store'), donneesOffre())->assertForbidden();
    $this->get(route('offres.edit', $offer))->assertForbidden();
    $this->put(route('offres.update', $offer), donneesOffre())->assertForbidden();
    $this->delete(route('offres.destroy', $offer))->assertForbidden();

    $this->assertModelExists($offer);
});

test('un visiteur ne voit pas les boutons de création, modification et suppression', function () {
    $offer = Offer::factory()->create();
    $this->actingAs(User::factory()->create());

    $this->get(route('offres.index'))
        ->assertDontSee('Ajouter une offre')
        ->assertDontSee('Modifier')
        ->assertDontSee('Supprimer');
});

test('un visiteur n\'accède ni aux entreprises, ni aux candidats, ni à l\'administration', function () {
    $this->actingAs(User::factory()->create());

    $this->get(route('entreprises.index'))->assertForbidden();
    $this->get(route('candidats.index'))->assertForbidden();
    $this->get(route('admin.users.index'))->assertForbidden();
});

// ---------- Éditeur ----------

test('un éditeur crée une offre dont il devient l\'auteur', function () {
    $editeur = User::factory()->editeur()->create();

    $this->actingAs($editeur)
        ->post(route('offres.store'), donneesOffre())
        ->assertRedirect(route('offres.index'));

    expect(Offer::firstWhere('name', 'Développeur Laravel')->user_id)->toBe($editeur->id);
});

test('l\'auteur d\'une offre ne peut pas être forcé par le formulaire', function () {
    $editeur = User::factory()->editeur()->create();
    $autre = User::factory()->editeur()->create();

    $this->actingAs($editeur)
        ->post(route('offres.store'), [...donneesOffre(), 'user_id' => $autre->id]);

    expect(Offer::firstWhere('name', 'Développeur Laravel')->user_id)->toBe($editeur->id);
});

test('un éditeur modifie ses propres offres', function () {
    $editeur = User::factory()->editeur()->create();
    $offer = Offer::factory()->for($editeur)->create();

    $this->actingAs($editeur);
    $this->get(route('offres.edit', $offer))->assertOk();
    $this->put(route('offres.update', $offer), [...donneesOffre(), 'name' => 'Titre modifié'])
        ->assertRedirect(route('offres.index'));

    expect($offer->fresh()->name)->toBe('Titre modifié');
});

test('un éditeur ne modifie pas l\'offre d\'un autre éditeur', function () {
    $auteur = User::factory()->editeur()->create();
    $offer = Offer::factory()->for($auteur)->create();

    $this->actingAs(User::factory()->editeur()->create());
    $this->get(route('offres.edit', $offer))->assertForbidden();
    $this->put(route('offres.update', $offer), donneesOffre())->assertForbidden();
});

test('un éditeur ne peut pas supprimer une offre, même la sienne', function () {
    $editeur = User::factory()->editeur()->create();
    $offer = Offer::factory()->for($editeur)->create();

    $this->actingAs($editeur)
        ->delete(route('offres.destroy', $offer))
        ->assertForbidden();

    $this->assertModelExists($offer);
});

test('« Mes offres » n\'affiche que les offres de l\'éditeur', function () {
    $editeur = User::factory()->editeur()->create();
    Offer::factory()->for($editeur)->create(['name' => 'Mon offre à moi']);
    Offer::factory()->for(User::factory()->editeur())->create(['name' => 'Offre d\'un collègue']);

    $this->actingAs($editeur)
        ->get(route('offres.mine'))
        ->assertOk()
        ->assertSee('Mon offre à moi')
        ->assertDontSee('Offre d\'un collègue');
});

test('un éditeur n\'accède pas à l\'administration', function () {
    $this->actingAs(User::factory()->editeur()->create())
        ->get(route('admin.users.index'))
        ->assertForbidden();
});

// ---------- Admin ----------

test('un admin modifie n\'importe quelle offre', function () {
    $offer = Offer::factory()->create();

    $this->actingAs(User::factory()->admin()->create())
        ->get(route('offres.edit', $offer))
        ->assertOk();
});

test('un admin peut supprimer une offre', function () {
    $offer = Offer::factory()->create();

    $this->actingAs(User::factory()->admin()->create())
        ->delete(route('offres.destroy', $offer))
        ->assertRedirect(route('offres.index'));

    $this->assertModelMissing($offer);
});

test('un admin change le rôle d\'un utilisateur', function () {
    $visiteur = User::factory()->create();

    $this->actingAs(User::factory()->admin()->create());
    $this->get(route('admin.users.index'))->assertOk()->assertSee($visiteur->email);
    $this->patch(route('admin.users.role', $visiteur), ['role' => 'editeur'])
        ->assertSessionHas('success');

    expect($visiteur->fresh()->role)->toBe(Role::Editeur);
});

test('un admin ne peut pas modifier son propre rôle', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->patch(route('admin.users.role', $admin), ['role' => 'visiteur'])
        ->assertSessionHas('error');

    expect($admin->fresh()->role)->toBe(Role::Admin);
});

test('un rôle inexistant est refusé', function () {
    $visiteur = User::factory()->create();

    $this->actingAs(User::factory()->admin()->create())
        ->patch(route('admin.users.role', $visiteur), ['role' => 'superadmin'])
        ->assertSessionHasErrors('role');

    expect($visiteur->fresh()->role)->toBe(Role::Visiteur);
});

// ---------- Inscription ----------

test('un nouvel inscrit est visiteur, même s\'il envoie un champ role', function () {
    $this->post(route('register.store'), [
        'name' => 'Pirate',
        'email' => 'pirate@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'role' => 'admin',
    ]);

    expect(User::firstWhere('email', 'pirate@example.com')->role)->toBe(Role::Visiteur);
});
