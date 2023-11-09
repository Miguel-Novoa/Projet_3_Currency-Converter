<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function add(Request $request){
        $currency = new Currency;
        $currency->code = $request->input('code');
        $currency->infos = $request->input('infos');

        $request->validate([
            'code' => 'required|string|max:3',
            'infos' => 'required|string|max:50',
        ]);

        $currency->save();

        return response()->json([
            'message' => 'Nouvelle devise ajoutée !',
            'data' => $currency,
        ]);
    }

    public function getAllCurrencies(){
        $currencies = currency::all();
        return response()->json([
            'message' => 'Devises récupérées !',
            'data' => $currencies
        ]);
    }
}
