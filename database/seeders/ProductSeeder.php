<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        Product::create([
            'name' => 'Kaos Biru Premium',
            'description' => 'Kaos premium dengan bahan cotton combed 30s yang nyaman dipakai sehari-hari',
            'price' => 85000,
            'stock' => 50,
        ]);

        Product::create([
            'name' => 'Celana Jeans Biru',
            'description' => 'Celana jeans dengan warna biru classic, cocok untuk berbagai acara',
            'price' => 250000,
            'stock' => 30,
        ]);

        Product::create([
            'name' => 'Sepatu Sneakers Biru',
            'description' => 'Sepatu sneakers casual dengan desain modern dan nyaman',
            'price' => 350000,
            'stock' => 20,
        ]);

        Product::create([
            'name' => 'Tas Ransel Biru',
            'description' => 'Tas ransel dengan kapasitas besar dan banyak kantong',
            'price' => 175000,
            'stock' => 40,
        ]);

        Product::create([
            'name' => 'Topi Baseball Biru',
            'description' => 'Topi baseball dengan bahan berkualitas dan desain trendy',
            'price' => 65000,
            'stock' => 60,
        ]);

        Product::create([
            'name' => 'Jaket Hoodie Biru',
            'description' => 'Jaket hoodie hangat dengan bahan fleece yang lembut',
            'price' => 200000,
            'stock' => 25,
        ]);
    }
}