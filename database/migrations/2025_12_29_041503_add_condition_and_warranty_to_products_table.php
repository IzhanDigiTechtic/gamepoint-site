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
        Schema::table('products', function (Blueprint $table) {
            $table->enum('condition', ['new', 'used', 'refurbished'])->default('new')->after('stock');
            $table->boolean('has_warranty')->default(false)->after('condition');
            $table->integer('warranty_months')->nullable()->after('has_warranty');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['condition', 'has_warranty', 'warranty_months']);
        });
    }
};
