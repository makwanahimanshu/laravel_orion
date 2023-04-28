<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        \App\Models\Post::factory(3)->create(["category" => "this is first category"]);
        \App\Models\Post::factory(3)->create(["category" => "this is second category"]);
        \App\Models\Post::factory(3)->create(["category" => "this is third category"]);
        \App\Models\Post::factory(3)->create(["category" => "this is forth category"]);
        \App\Models\Post::factory(3)->create(["category" => "this is fifth category"]);


        // \App\Models\User::factory(10)->create();
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
