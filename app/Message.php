<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public $primaryKey='m_id';

    protected $table = 'message';

    protected $fillable = ['m_title', 'm_create_date', 'm_send_date', 'm_send_timestamp', 'm_content', 'msg_id'];

    public function hasoneSecondGroupName()
    {
        return $this->hasOne('App\MessageSecondGroup', 'msg_id', 'msg_id');
    }
}
