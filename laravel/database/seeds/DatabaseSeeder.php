<?php

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
        $this->call(UserTableSeeder::class);
        $this->call(LessonTableSeeder::class);
        $this->call(TimetableTableSeeder::class);
        $this->call(TaskTableSeeder::class);
        $this->call(InviteTableSeeder::class);
    }
}
