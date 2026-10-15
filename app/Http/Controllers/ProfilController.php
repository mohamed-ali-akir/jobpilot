<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfilController extends Controller
{
    /**
     * Handle the incoming request.
     */
       public function __invoke(\Illuminate\Http\Request $request)
    {
        return view('profil', ['user' => $request->user()->loadCount('offers')]);
    }
}
