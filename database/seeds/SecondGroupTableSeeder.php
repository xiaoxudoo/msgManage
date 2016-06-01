<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\MessageSecondGroup;

class SecondGroupTableSeeder extends Seeder {

  public function run()
  {
    DB::table('message_second_group')->delete();
    DB::table('message_second_group')->insert([
      'msg_id' => 1,
      'mfg_id' => 0,
      'msg_name' => '孕前期'    
    ]);
    DB::table('message_second_group')->insert([
      'msg_id' => 2,
      'mfg_id' => 0,
      'msg_name' => '孕中期'    
    ]);
    DB::table('message_second_group')->insert([
      'msg_id' => 3,
      'mfg_id' => 0,
      'msg_name' => '孕后期'    
    ]);
    DB::table('message_second_group')->insert([
      'msg_id' => 4,
      'mfg_id' => 1,
      'msg_name' => '高血压'    
    ]);
    DB::table('message_second_group')->insert([
      'msg_id' => 11,
      'mfg_id' => 1,
      'msg_name' => '糖尿病'    
    ]);
    DB::table('message_second_group')->insert([
      'msg_id' => 14,
      'mfg_id' => 1,
      'msg_name' => '缺铁性贫血'    
    ]);
    DB::table('message_second_group')->insert([
      'msg_id' => 30,
      'mfg_id' => 2,
      'msg_name' => '20~30岁'    
    ]);
    DB::table('message_second_group')->insert([
      'msg_id' => 31,
      'mfg_id' => 2,
      'msg_name' => '31~40岁'    
    ]);
    DB::table('message_second_group')->insert([
      'msg_id' => 32,
      'mfg_id' => 2,
      'msg_name' => '40岁以上'    
    ]);
    DB::table('message_second_group')->insert([
      'msg_id' => 40,
      'mfg_id' => 3,
      'msg_name' => '超重'    
    ]);
    DB::table('message_second_group')->insert([
      'msg_id' => 41,
      'mfg_id' => 3,
      'msg_name' => '正常'    
    ]);
    DB::table('message_second_group')->insert([
      'msg_id' => 42,
      'mfg_id' => 3,
      'msg_name' => '消瘦'    
    ]);
    DB::table('message_second_group')->insert([
      'msg_id' => 50,
      'mfg_id' => 5,
      'msg_name' => '新注册'    
    ]);
    DB::table('message_second_group')->insert([
      'msg_id' => 51,
      'mfg_id' => 5,
      'msg_name' => '活跃'    
    ]);
    DB::table('message_second_group')->insert([
      'msg_id' => 52,
      'mfg_id' => 5,
      'msg_name' => '沉默'    
    ]);
    DB::table('message_second_group')->insert([
      'msg_id' => 53,
      'mfg_id' => 5,
      'msg_name' => '流失'    
    ]);
    DB::table('message_second_group')->insert([
      'msg_id' => 127,
      'mfg_id' => 127,
      'msg_name' => '全部'    
    ]);
    
  }

}

?>