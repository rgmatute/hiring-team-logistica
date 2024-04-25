<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string('serial_code');
            $table->string('name');
            $table->string('description');
            $table->decimal('price');
            $table->integer('iva')->default(15);
            $table->decimal('discount');
            $table->string('resource_id');
            // $table->integer('type');
            $table->integer('stock')->default(0);
            $table->boolean('status')->default(true);

            $table->unsignedBigInteger('catalog_id'); // Clave foránea

            $table->string('created_by')->nullable();
            $table->string('last_modified_by')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
