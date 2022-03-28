<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_components', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('product_id');
            $table->unsignedbigInteger('ingredient_id');
            $table->unsignedbigInteger('variant_id')->nullable();
            $table->string('unit');
            $table->float('quantity', 8, 3);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('variant_id')->references('id')->on('variants');
            $table->foreign('product_id')->references('id')->on('products');
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
        Schema::dropIfExists('product_components');
    }
}
