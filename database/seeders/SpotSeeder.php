<?php

namespace Database\Seeders;

use App\Models\Spot;
use Illuminate\Database\Seeder;

class SpotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $csv_path = storage_path('app/csv/sakura02.csv');
        $lines = new \SplFileObject($csv_path);

        foreach ($lines as $index => $line) {
            if($index > 0) {
                $line = mb_convert_encoding($line, 'UTF-8', 'SJIS-win');
                $values = str_getcsv($line);

                if(!is_null($values[0])) {
                    $spot_view = new Spot();
                    $spot_view->name = $values[1];
                    $spot_view->location = [
                        'latitude' => $values[2],
                        'longitude' => $values[3],
                    ];
                    $spot_view->address = $values[4];
                    $spot_view->save();
                }
            }
        }
    }
}
