<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Services\Parsers\PikParserService;
use Illuminate\Http\Request;

class ApartmentController extends Controller
{
    public function index()
    {
        $apartments = Apartment::with('prices')->latest()->get();
        return view('apartment.index', compact('apartments'));
    }

    public function show(Apartment $apartment)
    {
        return view('apartment.show', compact('apartment'));
    }

    public function store(Request $request, PikParserService $parser)
    {
        $validated = $request->validate([
             'url' => 'required|url|starts_with:https://www.pik.ru,https://pik.ru'
        ]);

        $url = $validated['url'];

        $data = $parser->parse($url);

        if (!$data) {
            return back()->with('error', 'Не удалось извлечь данные о квартире. Проверьте ссылку');
        }

        $apartment = Apartment::firstOrNew(['url' => $url]);

        if (!$apartment->exists) {
            $apartment->fill($data);
            $apartment->initial_price = $data['price'];
            $apartment->save();
            $apartment->prices()->create(['price' => $data['price']]);
            return redirect()->route('apartments.show', $apartment)->with('success', 'Квартира добавлена');
        } else {
            $apartment->refreshData($data['price']);
            return redirect()->route('apartments.show', $apartment)->with('success', 'Квартира уже отслеживается');
        }
    }

    public function destroy(Apartment $apartment)
    {
        $apartment->delete();

        return redirect()->route('apartments.index')->with('success', 'Квартира больше не отслеживается');
    }

    public function refresh(Apartment $apartment, PikParserService $parser)
    {
        $currentPrice = $apartment->price;

        $data = $parser->parse($apartment->url);

        if (!$data) {
            return back()->with('error', 'Не удалось извлечь данные о квартире. Проверьте ссылку');
        }

        if ($apartment->refreshData($data['price'])) {
            if ($data['price'] < $currentPrice) {
                return back()->with('success', 'Цена квартиры снизилась');
            } else {
                return back()->with('error', 'Цена квартиры возросла');
            }
        }
        return back()->with('info', 'Цена квартиры не изменилась');
    }
}
