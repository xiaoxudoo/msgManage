<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MessageFirstGroup extends Model
{
	/**
     * 设置表的主键名
     *
     * @var string
     **/
    public $primaryKey='mfg_id';

    protected $table = 'message_first_group';

    public $timestamps = false;

    public function hasManySecondGroup()
	{
		return $this->hasMany('App\MessageSecondGroup', 'mfg_id', 'mfg_id');
	}
}
