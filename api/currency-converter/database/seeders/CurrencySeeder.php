<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Currency;

class CurrencySeeder extends Seeder
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
              'code' => 'USD',
              'infos' => 'Dollar américain',
            ],
            [
                'code' => 'EUR',
                'infos' => 'EURO',
            ],
            [
                'code' => 'YEN',
                'infos' => 'Yen japonais',
            ],
        ];

        foreach ($data as $currencyData) {
            Currency::create([
                'code' => $currencyData['code'],
                'infos' => $currencyData['infos'],
            ]);
        }
    }
}
