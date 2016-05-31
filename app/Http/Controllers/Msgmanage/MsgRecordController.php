<?php

namespace App\Http\Controllers\MsgManage;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use DB, Log;

use App\Message;
use App\MessageFirstGroup;
use App\MessageSecondGroup;

class MsgRecordController extends Controller
{
     /**
     * 显示所有的消息（消息列表）
     *
     * @return Response
     */
    public function getMsgRecordList(Request $request)
    {

        //构造假数据
        $itemNum=20;

        $MsgRecord = Message::
            leftJoin('message_second_groups', 'message_second_groups.msg_id', '=', 'messages.msg_id')
            ->select('messages.*','message_second_groups.msg_name')
            ->orderBy('m_send_timestamp', 'desc')
            ->paginate($itemNum);
        
        return view('message.index')->with(array('MsgRecords' => $MsgRecord))->with(array('groups' => ''));

    } 

    public function searchMsgRecord(Request $request)
    {

        $validator = Validator::make($request->all(), [
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

        return view('message.index')->with(array('MsgRecords' => $MsgRecord))->with(array('groups' => ''));
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

        return view('message.index')->with(array('MsgRecords' => $MsgRecord))->with(array('groups' => $groups));
    }


    public function displayMsgRecord(Request $request){

        //初始化返回值
        $ret = array('data' => array(),'status' => '-1','msg' => '');

        $validator = Validator::make($request->all(), [
            'is_display' => 'required|integer',
            'message_id' => 'required|integer'
        ]);

        if($validator->fails()){
            $ret['msg'] = '客户端错误';
            Log::error('消息主键绑定错误');
            return json_encode($ret);
        }

        $is_display = $request->is_display;
        $message_id = $request->message_id;
        if($is_display == 1 || $is_display == 0){

            // $send_date = Message::where('m_id', '=', $message_id)->lists('m_send_timestamp');
            $send_date = Message::where('m_id', $message_id)->value('m_send_timestamp');
            if(strtotime($send_date) > time()){
                $ret['msg'] = '客户端错误';
                Log::error('隐藏按钮不可点击');
                return json_encode($ret);
            }else{
                if($is_display == 1) {
                    Message::where('m_id', '=', $message_id)->update(['m_is_display' => 0]);
                    $ret['status'] ='0';
                    $ret['msg'] ='隐藏成功';
                }elseif($is_display == 0){
                    Message::where('m_id', '=', $message_id)->update(['m_is_display' => 1]);
                    $ret['status'] ='0';
                    $ret['msg'] ='取消隐藏成功';
                }
   
                return json_encode($ret);
            }

        }else{
            $ret['msg'] = '客户端错误';
            Log::error('隐藏按钮不可点击');
            return json_encode($ret);
        }

    }

    // common API -- preview / group Info
    public function previewMsgRecord(Request $request)
    {
        //初始化返回值
        $ret = array('data' => array(),'status' => '-1','msg' => '');

        $validator = Validator::make($request->all(), [
            'message_id' => 'required|integer'
        ]);

        if($validator->fails()){
            $ret['msg'] = '消息主键绑定错误';
            Log::error('消息主键绑定错误');
            return json_encode($ret);
        }

        $message_id = $request->message_id;
        $MsgRecord = Message::
                leftJoin('message_second_groups', 'message_second_groups.msg_id', '=', 'messages.msg_id')
                ->select('messages.*','message_second_groups.mfg_id')
                ->where('messages.m_id', '=', $message_id)
                ->get();

        if(!$MsgRecord->isEmpty()){
            $MsgRecord = $MsgRecord->all(); //模型对象的集合转化为模型对象的数组
            $ret['status'] ='0';
            $ret['msg'] ='预览成功';
            $ret['data'] = $MsgRecord[0];  //一个模型对象的实例

            return json_encode($ret);
        }else{
            $ret['msg'] = '查询错误';
            Log::error('数据库查询错误');
            return json_encode($ret);
        }
        
    }

    public function getMsgGroup(Request $request){

        //初始化返回值
        $ret = array('first_class_amount' => 0,'first_class'=> array(),'status' => '-1','msg' => '');

        $firstGroup = MessageFirstGroup::select('mfg_id','mfg_name')
                            ->whereNotIn('mfg_id', [4, 5])->get();

        $ret['first_class_amount']  =  $firstGroup->count();

        $collection = $firstGroup->each(function($item, $key){
            $item->second_class = MessageSecondGroup::select('msg_id','msg_name')
                            ->where('mfg_id', '=', $item->mfg_id)->get();
            $item->second_class_amount = $item->second_class->count();

        });
        
        $ret['first_class'] = $collection->toArray();
        $ret['status'] = 0;

        return json_encode($ret);      
    }


}
