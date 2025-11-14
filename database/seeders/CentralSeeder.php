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
            ['id_sentral' => 'KPGSTL', 'nama' => 'CT INDOSAT KUPANG', 'area' => 'NTT'],
            ['id_sentral' => 'BLUTTM', 'nama' => 'CT ATAMBUA', 'area' => 'NTT'],
            ['id_sentral' => 'FLTLRT', 'nama' => 'CT LARANTUKA', 'area' => 'NTT'],
            ['id_sentral' => 'MGRRTG', 'nama' => 'CT RUTENG', 'area' => 'NTT'],
            ['id_sentral' => 'EDEETR', 'nama' => 'CT ENDE', 'area' => 'NTT'],
            ['id_sentral' => 'SKANML', 'nama' => 'CT MAUMERE', 'area' => 'NTT'],
            ['id_sentral' => 'MGBSRN', 'nama' => 'CT LABUAN BAJO', 'area' => 'NTT'],
            ['id_sentral' => 'SBMJDS', 'nama' => 'CT WAINGAPU', 'area' => 'NTT'],

            //area ntb
            ['id_sentral' => 'BIMIDS', 'nama' => 'CT INDOSAT BIMA', 'area' => 'NTB'],
            ['id_sentral' => 'MTRAMP', 'nama' => 'CT INDOSAT AMPENAN', 'area' => 'NTB'],
            ['id_sentral' => 'MTRBPD', 'nama' => 'CT BPD NTBS', 'area' => 'NTB'],
            ['id_sentral' => 'MTRHOS', 'nama' => 'CT INDOSAT HOS COKRO', 'area' => 'NTB'],
            ['id_sentral' => 'PRYPYA', 'nama' => 'CT INDOSAT PRAYA', 'area' => 'NTB'],
            ['id_sentral' => 'SBWIDS', 'nama' => 'CT INDOSAT SUMBAWA', 'area' => 'NTB'],
            ['id_sentral' => 'DPUJDS', 'nama' => 'CT DOMPU', 'area' => 'NTB'],
            ['id_sentral' => 'LBBGRG', 'nama' => 'CT LOMBOK BARAT', 'area' => 'NTB'],
            ['id_sentral' => 'LBMSLG', 'nama' => 'CT  LOMBOK TIMUR', 'area' => 'NTB'],
            ['id_sentral' => 'LKGBNK', 'nama' => 'CT KOPANG', 'area' => 'NTB'],
            ['id_sentral' => 'LKGRYK', 'nama' => 'CT MANDALIKA', 'area' => 'NTB'],
            ['id_sentral' => 'SWBMLK', 'nama' => 'CT MALUK', 'area' => 'NTB'],
            ['id_sentral' => 'SBWLBK', 'nama' => 'CT LABANGKA', 'area' => 'NTB'],
            ['id_sentral' => 'SBWLTS', 'nama' => 'CT PLAMPANG', 'area' => 'NTB'],
            ['id_sentral' => 'SBWLSB', 'nama' => 'CT LOPOK', 'area' => 'NTB'],
            ['id_sentral' => 'SBWLST', 'nama' => 'CT LABUHAN BADAS', 'area' => 'NTB'],
            ['id_sentral' => 'SBWUTN', 'nama' => 'CT UTAN', 'area' => 'NTB'],
            ['id_sentral' => 'SBWRAB', 'nama' => 'CT ALAS BARAT', 'area' => 'NTB'],
            ['id_sentral' => 'SWBRTG', 'nama' => 'CT TALIWANG', 'area' => 'NTB'],
            ['id_sentral' => 'LBMLBH', 'nama' => 'CT LABUHAN HAJI', 'area' => 'NTB'],
            ['id_sentral' => 'SBWBDM', 'nama' => 'CT BUKIT DAMAI', 'area' => 'NTB'],


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
