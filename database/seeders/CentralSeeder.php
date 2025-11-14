<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CentralSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $centrals = [
            // Bali Area
            ['id_sentral' => 'DPSBNR', 'nama' => 'CT BANDARA NGURAH RAI', 'area' => 'BALI'],
            ['id_sentral' => 'DPSBPD', 'nama' => 'CT BPD BALI', 'area' => 'BALI'],
            ['id_sentral' => 'DPSCLU', 'nama' => 'CT INDOSAT CELUK', 'area' => 'BALI'],
            ['id_sentral' => 'GANMKF', 'nama' => 'CT INDOSAT MONKEY FOREST', 'area' => 'BALI'],
            ['id_sentral' => 'DPSIGS', 'nama' => 'CT INDOSAT GATOT SUBROTO', 'area' => 'BALI'],
            ['id_sentral' => 'DPSIKT', 'nama' => 'CT INDOSAT KUTA', 'area' => 'BALI'],
            ['id_sentral' => 'DPSNIX', 'nama' => 'CT DATACENTER NIX', 'area' => 'BALI'],
            ['id_sentral' => 'DPSPMV', 'nama' => 'CT DISKOMINFO PEMPROV BALI', 'area' => 'BALI'],
            ['id_sentral' => 'DPSTKU', 'nama' => 'CT LINTASARTA TEUKU UMAR', 'area' => 'BALI'],
            ['id_sentral' => 'GYRGIN', 'nama' => 'CT INDOSAT GIANYAR KOTA', 'area' => 'BALI'],
            ['id_sentral' => 'JRNGTS', 'nama' => 'CT JEMBRANA', 'area' => 'BALI'],
            ['id_sentral' => 'TABJPN', 'nama' => 'CT TABANAN KOTA', 'area' => 'BALI'],
            ['id_sentral' => 'TABBRI', 'nama' => 'CT DRC BRI TABANAN', 'area' => 'BALI'],
            ['id_sentral' => 'BADNSD', 'nama' => 'CT NUSA DUA', 'area' => 'BALI'],
            ['id_sentral' => 'KLGGJM', 'nama' => 'CT KLUNGKUNG', 'area' => 'BALI'],
            ['id_sentral' => 'KRSGTS', 'nama' => 'CT KARANGASEM', 'area' => 'BALI'],
            ['id_sentral' => 'BLIBNR', 'nama' => 'CT BANGLI', 'area' => 'BALI'],
            ['id_sentral' => 'DPSNDC', 'nama' => 'CT MORATEL NDC', 'area' => 'BALI'],
            ['id_sentral' => 'TABRDG', 'nama' => 'CT BAJERA', 'area' => 'BALI'],
            ['id_sentral' => 'JRNYMK', 'nama' => 'CT RAMBUT SIWI', 'area' => 'BALI'],
            ['id_sentral' => 'TABMBB', 'nama' => 'CT BEDUGUL', 'area' => 'BALI'],
            ['id_sentral' => 'JRNRDG', 'nama' => 'CT GILIMANUK', 'area' => 'BALI'],
            ['id_sentral' => 'KRSRPB', 'nama' => 'CT PADANG BAI', 'area' => 'BALI'],
            ['id_sentral' => 'TABPOS', 'nama' => 'CT TABANAN POS', 'area' => 'BALI'],
            ['id_sentral' => 'JRNPOS', 'nama' => 'CT JEMBRANA POS', 'area' => 'BALI'],
            ['id_sentral' => 'TABLLG', 'nama' => 'CT LALALINGGAH', 'area' => 'BALI'],
            ['id_sentral' => 'DPSNTX', 'nama' => 'CT NEUCENTRIX DENPASAR', 'area' => 'BALI'],
            ['id_sentral' => 'SRJPOS', 'nama' => 'CT SINGARAJA POS', 'area' => 'BALI'],

            //area ntt

            //area ntb

        ];

        $now = Carbon::now();
        foreach ($centrals as &$central) {
            $central['created_at'] = $now;
            $central['updated_at'] = $now;
        }

        DB::table('central')->insert($centrals);

        $this->command->info('Central data seeded successfully!');
        $this->command->info('Total records: ' . count($centrals));
    }
}
