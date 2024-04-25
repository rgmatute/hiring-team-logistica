<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatalogTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            'TV',
            'Laptop',
            'Smartphone',
            'Tablet',
            'Headphones',
            'Camera',
            'Smartwatch',
            'Printer',
            'Gaming Console',
            'Speaker',
            'Monitor',
            'Router',
            'Keyboard',
            'Mouse',
            'External Hard Drive',
            'Fitness Tracker',
            'Projector',
            'Microphone',
            'Scanner',
            'Graphics Card',
            'Processor',
            'Motherboard',
            'RAM',
            'Solid State Drive (SSD)',
            'Video Game',
            'Software',
            'Book',
            'Clothing',
            'Shoes',
            'Accessory',
            'Home Appliance',
            'Furniture',
            'Tool',
            'Bicycle',
            'Car Part',
            'Garden Tool',
            'Pet Supply',
            'Sporting Goods',
            'Art Supplies',
            'Stationery',
            'Musical Instrument',
            'Toy'
        ];

        foreach ($types as $type) {
            DB::table('catalog')->insert([
                'catalog_key' => 'PRODUCT_TYPE',
                'item_name' => $type,
                'catalog_name' => $type,
                'created_by' => 'system-seeder',
                'last_modified_by' => 'system-seeder',
                'catalog_description' => 'Description for ' . $type,
                'status' => true
            ]);
        }
    }
}
