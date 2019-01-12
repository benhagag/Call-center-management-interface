<?php

use Illuminate\Database\Seeder;

class AgentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $agents = [
            [
                'agent_name' => 'סניר',
                'extension_number' => '1'
            ],
            [
                'agent_name' => 'מישל',
                'extension_number' => '2'
            ],
            [
                'agent_name' => 'בן',
                'extension_number' => '3'
            ],

        ];

        DB::table('agents')->insert($agents);
    }
}
