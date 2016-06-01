<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MessageSecondGroup extends Model
{
    public $primaryKey='msg_id';

    protected $table = 'message_second_group';

    public $timestamps = false;
}
