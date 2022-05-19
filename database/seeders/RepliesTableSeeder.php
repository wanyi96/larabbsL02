<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reply;
use Illuminate\Foundation\Testing\WithoutEvents;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RepliesTableSeeder extends Seeder
{
    public function run()
    {
        Reply::factory()->count(100)->create();
    }
}

