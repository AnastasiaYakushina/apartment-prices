<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apartment;

class ApartmentController extends Controller
{
    public function index()
    {
        $apartments = Apartment::paginate();
        return view('apartment.index', compact('apartments'));
    }

    public function show($id)
    {
        $apartment = Apartment::findOrFail($id);
        return view('apartment.show', compact('apartment'));
    }
}
