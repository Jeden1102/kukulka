<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->renameColumn('id', 'order_id')->nullable()->change();
            $table->renameColumn('name', 'order_source')->nullable()->change();
            $table->integer('order_source_id')->nullable();
            $table->integer('order_status_id')->nullable();
            $table->boolean('confirmed')->nullable();
            $table->string('date_confirmed')->nullable();
            $table->string('date_add')->nullable();
            $table->string('date_in_status')->nullable();
            $table->string('user_login')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('currency')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('delivery_fullname')->nullable();
            $table->string('delivery_company')->nullable();
            $table->string('delivery_address')->nullable();
            $table->string('delivery_city')->nullable();
            $table->string('delivery_postcode')->nullable();
            $table->string('delivery_country_code')->nullable();
            $table->string('invoice_company')->nullable();
            $table->string('invoice_nip')->nullable();
            $table->string('invoice_address')->nullable();
            $table->string('invoice_city')->nullable();
            $table->string('invoice_postcode')->nullable();
            $table->string('invoice_country_code')->nullable();
            $table->string('invoice_country')->nullable();
            $table->string('delivery_country')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
