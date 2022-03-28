<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsumedStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consumed_stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ingredient_id');
            $table->string('ref_no');
            $table->float('quantity', 8, 3);
            $table->float('product_quantity', 8, 3);
            $table->string('unit');
            $table->tinyInteger('status')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('ingredient_id')->references('id')->on('ingredients');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('SET NULL');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consumed_stocks');
    }
}
