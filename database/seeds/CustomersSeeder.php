<?php

use Illuminate\Database\Seeder;

class CustomersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */


    public function run()
    {
        $customers = [
            [
                'customer_name' => 'היכל תרבות נתניה',
                'phone_number' => '0501234567'
            ],
            [
                'customer_name' => 'אמפי חיפה',
                'phone_number' => '0521234567'
            ],
            [
                'customer_name' => 'סינמה סיטי',
                'phone_number' => '0531234567'
            ],

        ];

        DB::table('customers')->insert($customers);

    }
}
