<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pair;
use Illuminate\Http\JsonResponse;

class PairController extends Controller
{
    /**
     * Store a newly created pair in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        $pair = new Pair;
        $pair->source_currency_id = $request->input('source_currency_id');
        $pair->target_currency_id = $request->input('target_currency_id');
        $pair->rate = $request->input('rate');
        $pair->nb_conversions = $request->input('nb_conversions', 0);

        $request->validate([
            'source_currency_id' => 'required',
            'target_currency_id' => 'required',
            'rate' => 'required'
        ]);

        $pair->save();

        return response()->json([
            'message' => 'Nouvelle paire ajoutée !',
            'data' => $pair,
        ]);
    }

    /**
     * get all pairs from database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getAllPairs()
    {
        $pairs = pair::all();
        return response()->json([
            'message' => 'Paires récupérées !',
            'data' => $pairs
        ]);
    }

    /**
     * Update the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function updatePair(Request $request, Pair $pair): JsonResponse
    {
        $request->validate([
            'rate' => 'required',
        ]);

        $pair->update([
            'rate' => $request->input('rate'),
        ]);

        return response()->json([
            'message' => 'Paire mise à jour avec succès!',
            'data' => $pair,
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

    /**
     * Count conversions.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function countConversions(Pair $pair)
    {
        $pair->update([
            'nb_conversions' => $pair->getAttribute('nb_conversions') + 1
        ]);
        return response()->json([
            'message' => 'Nouvelle conversion effectuée !',
            'data' => $pair
        ]);
    }
}
