<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\MessageFirstGroup;

class FirstGroupTableSeeder extends Seeder {

  public function run()
  {
    DB::table('message_first_group')->delete();
    DB::table('message_first_group')->insert([
      'mfg_id' => 0,
      'mfg_name' => '孕期'    
    ]);
    DB::table('message_first_group')->insert([
      'mfg_id' => 1,
      'mfg_name' => '孕期疾病'
    ]);
    DB::table('message_first_group')->insert([
      'mfg_id' => 2,
      'mfg_name' => '年龄'
    ]);
    DB::table('message_first_group')->insert([
      'mfg_id' => 3,
      'mfg_name' => '体重'
    ]);
    DB::table('message_first_group')->insert([
      'mfg_id' => 4,
      'mfg_name' => '地区'
    ]);
    DB::table('message_first_group')->insert([
      'mfg_id' => 5,
      'mfg_name' => '活跃度'
    ]);
    DB::table('message_first_group')->insert([
      'mfg_id' => 127,
      'mfg_name' => '全部'
    ]);
  }

}

?>