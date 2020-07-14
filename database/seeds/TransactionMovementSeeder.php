<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionMovementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('transaction_movements')->insert([
            'name' => 'Crédito',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('transaction_movements')->insert([
            'name' => 'Débito',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);
    }
}
