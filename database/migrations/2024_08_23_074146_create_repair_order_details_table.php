<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepairOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('repair_order_details', function (Blueprint $table) {
            $table->id();

            #foreign key column declaration
            $table->unsignedBigInteger('repair_order_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('service_id');

            $table->integer('quantity');
            $table->integer('cost_per_service');
            $table->timestamps();

            #foreign key constraint
            $table->foreign('repair_order_id')->references('id')->on('repair_orders');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('service_id')->references('id')->on('services');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repair_order_details');
    }
};
