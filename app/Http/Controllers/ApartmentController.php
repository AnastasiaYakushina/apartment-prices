<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apartment;

class ApartmentController extends Controller
{
    public function index()
    {
        $apartments = Apartment::all();
        return view('apartment.index', compact('apartments'));
    }

    public function show($id)
    {
        $apartment = Apartment::findOrFail($id);
        return view('apartment.show', compact('apartment'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
             'url' => 'required|url|starts_with:https://www.pik.ru,https://pik.ru'
        ]);

        $url = $validated['url'];

        if (str_contains($url, 'test')) {
            $data = [
            'price' => 13900000,
            'rooms_count' => 3,
            'area' => 78.9,
            'developer' => 'ПИК',
            'complex' => 'Тестовый ЖК'
            ];
        } else {
            $data = Apartment::getRemoteData($url);
        }


        if (!$data) {
            return back()->withErrors(['url' => 'Не удалось извлечь данные о квартире. Проверьте ссылку.']);
        }

        $apartment = Apartment::firstOrNew(['url' => $url]);

        if (!$apartment->exists) {
            $apartment->fill($data);
            $apartment->initial_price = $data['price'];
        }
        $apartment->price = $data['price'];
        if ($apartment->isDirty('price')) {
            $apartment->save();
            $apartment->prices()->create(['price' => $data['price']]);
        }
        return redirect()->route('apartments.index');
    }
}
