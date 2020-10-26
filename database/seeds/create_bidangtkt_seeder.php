<?php

use Illuminate\Database\Seeder;

class create_bidangtkt_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('01_bidangtkt')->insert(array(
        [
         'bidang' => 'Farmasi'
        ],
        [
         'bidang' => 'Kesehatan - Alat Kesehatan'
        ],
        [
         'bidang' => 'Kesehatan - Vaksin Hayati'
        ],
        [
         'bidang' => 'Pertanian, Perikanan dan Perternakan'
        ],
        [
         'bidang' => 'Software'
        ],
        [
         'bidang' => 'Sosial dan Humaniora'
        ],
        [
         'bidang' => 'Umum dan Engineering'
        ]
      ));
    }
}
