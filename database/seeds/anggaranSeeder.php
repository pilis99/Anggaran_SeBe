<?php

use Illuminate\Database\Seeder;

class anggaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tahun_aktif')->insert([
            'tahun' => '2021',
            'status' => 'Aktif'
        ]);
    }
}
