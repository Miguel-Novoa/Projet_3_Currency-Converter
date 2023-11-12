<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Pair;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class CurrencyController extends Controller
{
    /**
     * Store new currency in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request){
        $currency = new Currency;
        $currency->code = strtoupper($request->input('code'));
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

    /**
     * Get all currencies from database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getAllCurrencies(){
        $currencies = currency::all();
        return response()->json([
            'message' => 'Devises récupérées !',
            'data' => $currencies
        ]);
    }

    /**
     * Get one currency from database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getOneCurrency($id){
        $currency = Currency::find($id);

        if (!$currency) {
            return response()->json([
                'message' => 'Devise non trouvée',
            ], 404);
        }

        return response()->json([
            'message' => 'Devise récupérée !',
            'data' => $currency,
        ]);
    }

    /**
     * Delete one currency from database and delete all involved pairs.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deleteCurrency(Pair $pair, Currency $currency): JsonResponse
    {
        try {
            DB::beginTransaction();

            $pair::where('source_currency_id', $currency->id)
                ->orWhere('target_currency_id', $currency->id)
                ->delete();

            $currency->delete();

            DB::commit();

            return response()->json([
                'message' => 'Devise et paires associées supprimées avec succès!',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Une erreur s\'est produite lors de la suppression de la devise et des paires associées.',
            ], 500);
        }
    }
}
