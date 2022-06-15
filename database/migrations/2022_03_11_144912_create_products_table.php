<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('SNo')->unique();
            $table->string('name')->nullable();
            $table->string('category')->nullable();
            $table->string('description')->nullable();
            $table->string('status')->nullable();
            $table->date('inactive_date')->nullable();
            $table->date('dateofpurchase')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('cost')->nullable();
            $table->string('disposal_cost')->nullable();
            $table->string('assigned')->nullable();
            $table->string('condition')->nullable();
            $table->string('book_value')->nullable();
            $table->string('deptrate')->nullable();
            $table->string('NBV')->nullable();
            $table->string('depreciation')->nullable();
            $table->string('disposal_depreciation')->nullable();
            $table->string('accumulated_dept')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}