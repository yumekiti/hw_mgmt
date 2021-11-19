<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
        User::factory()->create([
            'id'=> '1',
            'name' => 'test1',
            'email' => 'test1@test.jp',
            'password' => bcrypt('testtest'),
            'email' => 'test1@test1.jp',
            'email_verified_at' =>'test1@1test1.jp', 
            'timestamps' =>'time1',
            'rememberToken'=>'resetpassword'
        ]);
        DB::table('users')->insert([
            'id'=> '2',
            'name' => 'test2',
            'email' => 'test2@test.jp',
            'password' => Hash::make('password'),
            'email' => 'test2@test2.jp',
            'email_verified_at' =>'test2@2test2.jp', 
            'timestamps' =>'time2',
            'rememberToken'=>'resetpassword2'
        ]);
        User::factory()->count(8)->create();
        */

        # 初期化
        DB::table('users')->delete();

        # テストデータ挿入
        DB::table('users')->insert([
            'name'    => 'user1',
            'email' => 'user1@example.com',
            'email_verified_at' => new DateTime(),
            # 「secret」でログイン
            'password' => Hash::make('secret')
        ]);
    }
}
