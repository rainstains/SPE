<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        $id = Faker::create('ar_SA');

        for ($i=0; $i <25; $i++) {
            DB::table('students')->insert([
                'nis' => $id->unique()->idNumber,
                'name' => $faker->name,
                'class' => $faker->randomElement($arraykelas = array('10-A','10-B','10-C','11-A','11-B','11-C','12-A','12-B','12-C',)),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
