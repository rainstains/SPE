<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        for ($i=0; $i <25; $i++) {
            DB::table('siswa')->insert([
                'nama' => $faker->name,
                'kelas' => $faker->randomElement($arraykelas = array('10-A','10-B','10-C','11-A','11-B','11-C','12-A','12-B','12-C',))
            ]);
        }
    }
}
