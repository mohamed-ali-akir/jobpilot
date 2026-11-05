<?php

test('l\'accueil redirige vers la liste des offres', function () {
    $this->get(route('home'))->assertRedirect(route('offres.index'));
});
