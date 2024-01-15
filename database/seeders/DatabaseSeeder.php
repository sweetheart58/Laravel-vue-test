<?php

namespace Database\Seeders;

use App\Models\Url;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Url::create([
            'realUrl' => 'example.com/testUrl',
            'hashUrl' => 'example.com/cvbgyy',
        ]);
    }
}
