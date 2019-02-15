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
        for ($counter = 1; $counter <= 10; $counter++) {
            factory(\App\Models\File::class)->create();
        }
    }
}
