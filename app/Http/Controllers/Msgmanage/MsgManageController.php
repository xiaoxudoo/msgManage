<?php

namespace App\Http\Controllers\MsgManage;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\MessageFormPostRequest;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use DB, Log;

use App\Message;
use App\MessageSecondGroup;
use Session;

class MsgManageController extends Controller
{
	/**
     * 显示所有的消息（消息列表）
     *
     * @return Response
     */
    public function getMsgRecordList()
    {

        //构造假数据
        $itemNum=20;

        $MsgRecord = Message::
            leftJoin('message_second_groups', 'message_second_groups.msg_id', '=', 'messages.msg_id')
            ->select('messages.*','message_second_groups.msg_name')
            ->orderBy('m_send_timestamp', 'desc')
            ->paginate($itemNum);
        
        return view('message.manage')->with(array('MsgRecords' => $MsgRecord))->with(array('groups' => ''));

    }

   
    public function searchMsgRecord(Request $request)
    {

        $validator=Validator::make($request->all(), [
            'keywords' => 'required|string|max:50'
        ]);
        // return $request->keywords;
        // return $validator->errors();
        if($validator -> fails()){
            return Redirect::back()->withErrors($validator);

        }else{
            $validator = Validator::make($request->all(), [
                'keywords' => 'date'
            ]);

            $itemNum=20;
            $keywords=$request->keywords;
            if($validator -> fails()){
                $MsgRecord = Message::
                leftJoin('message_second_groups', 'message_second_groups.msg_id', '=', 'messages.msg_id')
                ->select('messages.*','message_second_groups.msg_name')
                ->where('messages.m_title', 'like', '%'.$keywords.'%')
                ->orderBy('m_send_timestamp', 'desc')
                ->paginate($itemNum);
            }else{
                $MsgRecord = Message::
                leftJoin('message_second_groups', 'message_second_groups.msg_id', '=', 'messages.msg_id')
                ->select('messages.*','message_second_groups.msg_name')
                ->where('messages.m_send_date', '=', $keywords)
                ->orderBy('m_send_timestamp', 'desc')
                ->paginate($itemNum);
            }
        }

        return view('message.manage')->with(array('MsgRecords' => $MsgRecord))->with(array('groups' => ''));
    }


    public function selectGroup(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'groups' => 'required|integer|max:128|min:-128'
        ]);


        $itemNum=20;
        $groups=$request->groups;
        $MsgRecord = Message::
            leftJoin('message_second_groups', 'message_second_groups.msg_id', '=', 'messages.msg_id')
            ->select('messages.*','message_second_groups.msg_name')
            ->where('messages.msg_id', '=', $groups)
            ->orderBy('m_send_timestamp', 'desc')
            ->paginate($itemNum);

        return view('message.manage')->with(array('MsgRecords' => $MsgRecord))->with(array('groups' => $groups));
    }

    // 增加、更新 API
    public function createMsgRecord(MessageFormPostRequest $request){
    	$ret = array('status' => '-1','msg' => '');

        $validator = Validator::make($request->all(), [
            'm_create_date' => 'after:today',
        ]);
    	if($validator -> fails()){
    		$ret['msg'] = '投放时间输入得好像有问题哦';
    		Log::error('客户端输入消息投放时间有误');
    		return json_encode($ret);
    	}

    	$msg_id = $request->msg_id;
        if($msg_id == -1){
        	$ret['msg'] = '请选择合适的人群分组';
	        Log::error('未选择分组');
        	return json_encode($ret);
        }

        $message_id = $request->m_id;
        if($message_id == -1){
        	//create
        	$validator = Validator::make($request->all(), [
	            'm_title' => 'unique:messages,m_title',
	        ]);
	        if($validator -> fails()){
	        	$ret['msg'] = '标题重复';
	        	Log::error('输入了同样的标题');
	        }else{

        		$message = new Message;
				$message->m_title = $request->m_title;

	        	$message->m_author = 0; //设置为session的值:Session::get('user_id');
	        	$message->m_create_date = date("Y-m-d");
	        	$message->m_send_date = date("Y-m-d",strtotime($request->m_create_date));
	        	$message->m_send_timestamp = $request->m_create_date;
	        	$message->m_content = $request->m_content;
	        	$message->msg_id = $request->msg_id;

	        	$message->save();   
	        	$ret['msg'] = '消息记录添加成功';
	        	$ret['status'] = 0;
        		
	        }

        }else{
        	//update
        	$validator = Validator::make($request->all(), [
	            'm_id' => 'unique:messages,m_id',
	        ]);
        	if($validator -> fails()){
        		$message= Message::find($message_id);

				$message->m_title = $request->m_title;
	        	$message->m_author = 0; //设置为session的值:Session::get('user_id');
	        	$message->m_create_date = date("Y-m-d");
	        	$message->m_send_date = date("Y-m-d",strtotime($request->m_create_date));
	        	$message->m_send_timestamp = $request->m_create_date;
	        	$message->m_content = $request->m_content;
	        	$message->msg_id = $request->msg_id;

	        	$message->save();  
	        	$ret['msg'] = '消息记录更改成功';
	        	$ret['status'] = 0; 
	        	
        	}else{
        		
        		$ret['msg'] ="客户端错误";
        		Log::error('非法的主键更新');

        	}
        } 

        return json_encode($ret);
    }

    public function deleteMsgRecord(Request $request){

    	$ret = array('data' => array(),'status' => '-1','msg' => '');

    	$validator = Validator::make($request->all(), [
            'message_id' => 'required|integer'
        ]);

        if($validator->fails()){
            $ret['msg'] = '客户端错误';
            Log::error('消息主键绑定错误');
            return json_encode($ret);
        }

        $message_id = $request->message_id;

        $MsgRecord = Message::where('m_id', '=', $message_id)->get();
        if(!$MsgRecord->isEmpty()){
        	// 执行删除操作
        	$deletedRows = Message::where('m_id', '=', $message_id)->delete();
            if($deletedRows == 1){
            	$ret['status'] ='0';
            	$ret['msg'] ='消息记录删除成功';
            }else{
            	$ret['msg'] ='服务器内部错误';
            	Log::error('删除操作错误');
            }
            
            return json_encode($ret);
        }else{
            $ret['msg'] = '客户端错误';
            Log::error('没有需要删除的主键');
            return json_encode($ret);
        }

    }

}