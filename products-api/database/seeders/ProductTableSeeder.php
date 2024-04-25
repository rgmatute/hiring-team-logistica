<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('product')->insert([
            [
                "serial_code" => "TCL-49-N",
                "name" => "TV - TCL 49'",
                "description" => "Televisor nuevo full HD",
                "price" => 450,
                "iva" => 15,
                "discount" => 0,
                "resource_id" => "",
                "stock" => 100,
                "status" => true,
                "catalog_id" => 1, // debe ser el id del catalogo disponible
                'created_by' => 'system-seeder',
                'last_modified_by' => 'system-seeder',
            ],
            [
                "serial_code" => "TCL-49-U",
                "name" => "TV - TCL 49'",
                "description" => "Televisor usado full HD",
                "price" => 450,
                "iva" => 15,
                "discount" => 30,
                "resource_id" => "",
                "stock" => 2,
                "status" => true,
                "catalog_id" => 1, // debe ser el id del catalogo disponible
                'created_by' => 'system-seeder',
                'last_modified_by' => 'system-seeder',
            ],
            [
                "serial_code" => "TCL-43-N",
                "name" => "TV - TCL 43'",
                "description" => "Televisor nuevo full HD - black friday",
                "price" => 400,
                "iva" => 15,
                "discount" => 60,
                "resource_id" => "",
                "stock" => 0,
                "status" => true,
                "catalog_id" => 1, // debe ser el id del catalogo disponible
                'created_by' => 'system-seeder',
                'last_modified_by' => 'system-seeder',
            ]
        ]);
    }
}
