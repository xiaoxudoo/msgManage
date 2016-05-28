<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$this->call('FirstGroupTableSeeder');
        $this->call('SecondGroupTableSeeder');
        $this->call('MessageTableSeeder'); 
    }
}
