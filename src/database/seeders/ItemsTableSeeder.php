<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'image' => 'images/Armani+Mens+Clock.jpg',
            'name' => '腕時計',
            'brand_name' => 'Rolax',
            'price' => 15000,
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
            'condition_id' => 1
        ];
        DB::table('items')->insert($param);
        $param = [
            'image' => 'images/HDD+Hard+Disk.jpg',
            'name' => 'HDD',
            'brand_name' => '西芝',
            'price' => 5000,
            'description' => '高速で信頼性の高いハードディスク',
            'condition_id' => 2
        ];
        DB::table('items')->insert($param);
        $param = [
            'image' => 'images/iLoveIMG+d.jpg',
            'name' => '玉ねぎ3束',
            'brand_name' => 'なし',
            'price' => 300,
            'description' => '新鮮な玉ねぎ3束のセット',
            'condition_id' => 3
        ];
        DB::table('items')->insert($param);
        $param = [
            'image' => 'images/Leather+Shoes+Product+Photo.jpg',
            'name' => '革靴',
            'price' => 4000,
            'description' => 'クラシックなデザインの革靴',
            'condition_id' => 4
        ];
        DB::table('items')->insert($param);
        $param = [
            'image' => 'images/Living+Room+Laptop.jpg',
            'name' => 'ノートPC',
            'price' => 45000,
            'description' => '高性能なノートパソコン',
            'condition_id' => 1
        ];
        DB::table('items')->insert($param);
        $param = [
            'image' => 'images/Music+Mic+4632231.jpg',
            'name' => 'マイク',
            'brand_name' => 'なし',
            'price' => 8000,
            'description' => '高音質のレコーディング用マイク',
            'condition_id' => 2
        ];
        DB::table('items')->insert($param);
        $param = [
            'image' => 'images/Purse+fashion+pocket.jpg',
            'name' => 'ショルダーバッグ',
            'price' => 3500,
            'description' => 'おしゃれなショルダーバッグ',
            'condition_id' => 3
        ];
        DB::table('items')->insert($param);
        $param = [
            'image' => 'images/Tumbler+souvenir.jpg',
            'name' => 'タンブラー',
            'brand_name' => 'なし',
            'price' => 500,
            'description' => '使いやすいタンブラー',
            'condition_id' => 4
        ];
        DB::table('items')->insert($param);
        $param = [
            'image' => 'images/Waitress+with+Coffee+Grinder.jpg',
            'name' => 'コーヒーミル',
            'brand_name' => 'Starbacks',
            'price' => 4000,
            'description' => '手動のコーヒーミル',
            'condition_id' => 1
        ];
        DB::table('items')->insert($param);
        $param = [
            'image' => 'images/MakeUpSet.jpg',
            'name' => 'メイクセット',
            'price' => 2500,
            'description' => '便利なメイクアップセット',
            'condition_id' => 2
        ];
        DB::table('items')->insert($param);
    }
}
