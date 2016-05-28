<?php

use Illuminate\Database\Seeder;
use App\Message;

class MessageTableSeeder extends Seeder {

  public function run()
  {
    DB::table('messages')->delete();

    for ($i=0; $i < 100; $i++) {
      Message::create([
        'm_title'   => 'Title '.$i,
        'm_create_date' => '2016-07-10',
        'm_send_date'  => '2016-07-11',
        'm_send_timestamp' => '1256112010',
        'm_content'    => 'Body '.$i,
        'msg_id' => 14
      ]);
    }
  }

}

?>