<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreignId('warehouse_id')->nullable();
            $table->foreignId('purchase_order_id')->constrained()->onDelete('cascade');
            $table->unsignedInteger('supplier_id');
            $table->bigInteger('purchaser_freight_forwarder_id')->nullable();
            $table->bigInteger('supplier_freight_forwarder_id')->nullable();
            $table->string('draft_file')->nullable();
            $table->string('packaging_list_file')->nullable();
            $table->string('invoice_file')->nullable();
            $table->string('china_invoice_file')->nullable();
            $table->string('bill_of_lading_file')->nullable();
            $table->string('telex_release_file')->nullable();
            $table->string('email_sent')->nullable();
            $table->string('departure_port')->nullable();
            $table->string('shipping_line')->nullable();
            $table->string('container_number')->nullable();
            $table->string('booking_number')->nullable();
            $table->string('bill_of_lading_number')->nullable();
            $table->string('container_seal_number')->nullable();
            $table->string('off_load_hours')->nullable();
            $table->bigInteger('total_cartons')->nullable();
            $table->dateTime('vessel_etd')->nullable();
            $table->dateTime('uk_eta')->nullable();
            $table->date('email_date')->nullable();
            $table->date('goods_load_date')->nullable();
            $table->date('load_date')->nullable();
            $table->date('expected_container_delivery_date')->nullable();
            $table->date('shipment_date')->nullable();
            $table->string('shipment_status')->nullable();
            $table->string('shipment_agent')->nullable();
            $table->date('actual_container_ship_date')->nullable();
            $table->dateTime('actual_arrival_date')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('shipments');
    }
}
