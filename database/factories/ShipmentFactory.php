<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Shipment;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShipmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Shipment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_id' => 1,
            'supplier_id' => 2,
            'purchaser_freight_forwarder_id' => 3,
            'supplier_freight_forwarder_id' => 4,
            'customer_id' => 7,
            'warehouse_id' => 1,
            'purchase_order_id' => 1,
            'draft_file' => $this->faker->sentence(),
            'packaging_list_file' => $this->faker->sentence(),
            'invoice_file' => $this->faker->sentence(),
            'china_invoice_file' => $this->faker->sentence(),
            'bill_of_lading_file' => $this->faker->sentence(),
            'telex_release_file' => $this->faker->sentence(),
            'email_sent' =>  $this->faker->sentence(),
            'departure_port' =>  $this->faker->sentence(),
            'shipping_line' => $this->faker->sentence(),
            'container_number' =>  $this->faker->sentence(),
            'booking_number' => $this->faker->sentence(),
            'bill_of_lading_number' => $this->faker->sentence(),
            'container_seal_number' =>  $this->faker->sentence(),
            'off_load_hours' => $this->faker->sentence(),
            'total_cartons' => 20,
            'vessel_etd' => $this->faker->dateTime(),
            'uk_eta' => $this->faker->dateTime(),
            'email_date' =>  $this->faker->date(),
            'goods_load_date' => $this->faker->date(),
            'load_date' => $this->faker->date(),
            'expected_container_delivery_date' => $this->faker->date(),
            'shipment_date' => $this->faker->date(),
            'actual_container_ship_date' => $this->faker->date(),
            'actual_arrival_date' => $this->faker->date(),
           
        ];
    }
}
