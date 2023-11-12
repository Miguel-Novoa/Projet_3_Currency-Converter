<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pair;

class PairSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data =
            [
                [
                    'source_currency_id' => 1,
                    'target_currency_id' => 2,
                    'rate' => 0.93,
                    'nb_conversions' => 0
                ],
                [
                    'source_currency_id' => 2,
                    'target_currency_id' => 1,
                    'rate' => 1.07,
                    'nb_conversions' => 10
                ],
                [
                    'source_currency_id' => 1,
                    'target_currency_id' => 3,
                    'rate' => 151.54,
                    'nb_conversions' => 2
                ],
                [
                    'source_currency_id' => 3,
                    'target_currency_id' => 1,
                    'rate' => 0.006,
                    'nb_conversions' => 0
                ],
                [
                    'source_currency_id' => 2,
                    'target_currency_id' => 3,
                    'rate' => 162.03,
                    'nb_conversions' => 25
                ],
                [
                    'source_currency_id' => 3,
                    'target_currency_id' => 2,
                    'rate' => 0.0062,
                    'nb_conversions' => 3
                ]


            ];

        foreach ($data as $pairData) {
            Pair::create([
                'source_currency_id' => $pairData['source_currency_id'],
                'target_currency_id' => $pairData['target_currency_id'],
                'rate' => $pairData['rate'],
                'nb_conversions' => $pairData['nb_conversions']
            ]);
        }
    }
}
