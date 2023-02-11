<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Article::factory(20)->create();
        \App\Models\Category::factory(5)->create();
        \App\Models\Comment::factory(40)->create();
        \App\Models\User::factory([
            "name" => "Alice",
            "email" => "alice@gmail.com",
        ])->create();
        \App\Models\User::factory([
            "name" => "Bob",
            "email" => "bob@gmail.com"
        ])->create();
    }
}
