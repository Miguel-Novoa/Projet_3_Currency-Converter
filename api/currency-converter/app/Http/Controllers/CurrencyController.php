<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Pair;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

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

    public function deleteCurrency(Pair $pair, Currency $currency): JsonResponse
    {
        try {
            DB::beginTransaction();

            // Delete all pairs using the deleted currency
            $pair::where('source_currency_id', $currency->id)
                ->orWhere('target_currency_id', $currency->id)
                ->delete();

            // Delete the currency
            $currency->delete();

            DB::commit();

            return response()->json([
                'message' => 'Devise et paires associées supprimées avec succès!',
            ]);
        } catch (\Exception $e) {
            // Cancel the transaction if an error occurs
            DB::rollBack();

            return response()->json([
                'message' => 'Une erreur s\'est produite lors de la suppression de la devise et des paires associées.',
            ], 500);
        }
    }
}
