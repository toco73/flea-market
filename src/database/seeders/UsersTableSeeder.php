<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Profile;
use App\Models\Item;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = User::create([
            'email' => 'seller_a@example.com',
            'password' => Hash::make('password123'),
        ]);
        $user1->profile()->create([
            'username' => 'ユーザーa',
            'post_code' => '123-4567',
            'address' => '東京都',
        ]);
        Item::whereIn('id',[23,24,25,26,27])->update(['seller_id' => $user1->id]);

        $user2 = User::create([
            'email' => 'seller_b@example.com',
            'password' => Hash::make('password123'),
        ]);
        $user2->profile()->create([
            'username' => 'ユーザーb',
            'post_code' => '234-5678',
            'address' => '東京都',
        ]);
        
        Item::whereIn('id',[28,29,30,31,32])->update(['seller_id' => $user2->id]);

        $user3 = User::create([
            'email' => 'no_item@example.com',
            'password' => Hash::make('password123'),
        ]);
        $user3->profile()->create([
            'username' => 'ユーザーc',
            'post_code' => '345-6789',
            'address' => '東京都',
        ]);
    }
}
