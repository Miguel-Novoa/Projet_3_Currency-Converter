<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pair;

class PairController extends Controller
{
    public function add(Request $request){
        $pair = new Pair;
        $pair->source_currency_id = $request->input('source_currency_id');
        $pair->target_currency_id = $request->input('target_currency_id');
        $pair->rate = $request->input('rate');
        $pair->nb_conversions = $request->input('nb_conversions');

        $pair->save();

        return response()->json([
            'message' => 'Nouvelle paire ajoutée !',
            'data' => $pair,
        ]);
    }

    public function getAllPairs(){
        $pairs = pair::all();
        return response()->json([
            'message' => 'Paires récupérées !',
            'data' => $pairs
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pair $pair)
    {
        $pair->delete();
        return response()->json([
            'message' => 'Paire correctement supprimée !',
        ]);
    }
}
