<?php

use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;
use CompanyNameGenerator\FakerProvider;


class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('App\Project');
        $faker->addProvider(new CompanyNameGenerator\FakerProvider($faker));
        for ($i=0; $i<10; $i++) {
                DB::table('projects')->insert([
                    'name' => $faker->unique()->companyName,
                    'created_at' => date('Y-m-d H:i:s'),
                    'Updated_at' => date('Y-m-d H:i:s')
                ]);
        }

    }
}
