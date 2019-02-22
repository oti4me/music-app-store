<?php

use Illuminate\Database\Seeder;

class FilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($counter = 1; $counter <= 2; $counter++) {
            factory(\App\Models\Song::class)->create();
        }
    }
}
