<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
    <title>消息管理系统</title>
    <link rel="stylesheet" href="{{asset('css/base.css')}}" />
    <link rel="stylesheet" href="{{asset('css/style.css')}}" />
    <style type="text/css">
        .pagination{padding:10px;margin:0 auto;font-family:"微软雅黑";}
        .pagination li{float:left;margin-right:10px;}
        .pagination li a,span{display:inline-block;height:23px;line-height:23px;padding:0 8px;
            margin:5px 1px 0 0;background:#fff;border:1px solid #e5e5e5;color:#333;text-decoration: none;}
        .pagination li a:hover, .pagination li a:active{border:1px solid #0196F0;}
        .pagination .active span{background:#0196F0;color:#fff}
    </style>
    <script type="text/javascript" src="{{asset('js/jquery-1.7.2.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery.layerModel.js')}}"></script>
</head>
<body>
    <!-- main-->
    <div class="main clearfix">
         <div class="main-right">
             <ul class="rightTop">
                 <li class="cur"><a href="/">消息记录</a></li>
                 <li><a href="/manage">消息设置</a></li>
                 <li><a href="">人群分组</a></li>
             </ul>
             <div class="rightDetail" id="messRecord">
                 <form class="form-search" method="post" action="{{url('/searchMsgRecord')}}">
                    {{ csrf_field() }}    
                     <input type="text" name="keywords" class="searchQuery"/>
                     <input type="submit" class="searchBtn" value="搜索" >
                 </form>
                 @if (count($errors) > 0)
                  <div class="alert alert-danger">
                      <ul>
                        <li>test</li>
                          @foreach ($errors as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
                 @endif
                 <table class="myTable">
                       <tr>
                            <th>消息ID</th>
                            <th>发送时间</th>
                            <th>消息名称</th>
                            <th>已接收</th>
                            <th>已发送<br/>未接收</th>
                            <th>总数</th>
                            <th>
                                <select name="groups" onchange="javascipt:select_group(this.value);">
                                    <option value="127">人群分组</option>
                                    <option value="127">全部</option>
                                    <option value="1">孕前</option>
                                    <option value="2">孕中</option>
                                    <option value="3">孕后</option>
                                    <option value="4">高血压</option>
                                    <option value="11">糖尿病</option>
                                    <option value="14">缺铁性贫血</option>
                                    <option value="30">20~30岁</option>
                                    <option value="31">31~40岁</option>
                                    <option value="32">40岁以上</option>
                                    <option value="40">超重</option>
                                    <option value="41">正常</option>
                                    <option value="42">消瘦</option>
                                </select>
                            </th>
                            <th>操作</th>
                        </tr>  
                        @foreach($MsgRecords as $MsgRecord)
                        <tr>
                            <td>{{$MsgRecord->m_id}}</td>
                            <td>{{$MsgRecord->m_send_timestamp}}</td>
                            <td><span onclick="javascript:preview({{$MsgRecord->m_id}})" class="name">{{$MsgRecord->m_title}}</span></td>
                            <td>{{$MsgRecord->m_received_amount}}</td>
                            <td>{{$MsgRecord->m_sent_unreceived_amount}}</td>
                            <td>{{$MsgRecord->m_total_amount}}</td>
                            <td>{{$MsgRecord->msg_name}}</td>
                            @if(strtotime($MsgRecord->m_send_timestamp) > time())
                                <td class="dis">隐藏</td>
                            @elseif($MsgRecord->m_is_display == 1)  
                                <td onclick="javascript:queryCallback({{$MsgRecord->m_id}},1)" class="no">隐藏</td>  
                            @elseif($MsgRecord->m_is_display == 0)
                                <td onclick="javascript:queryCallback({{$MsgRecord->m_id}},0)" class="enl">取消隐藏</td>    
                            @endif 
                        </tr>
                        @endforeach
                   </table>
                   <!-- 分页 -->

                   {!! $MsgRecords->appends(['groups' => $groups])->render() !!}
                   
                 <!-- 消息详情弹出页-->

                 <div id="demo1">
                      <h3 class="title"></h3>
                      <span class="time"></span>
                      <p class="detailMes">
                          　
                      </p>
                 </div>

             </div><!-- messRecorde结束-->
         </div><!-- mainright结束-->
    </div><!-- main结束-->
</body>
</html>
<script type="text/javascript">

    function select_group($gid){
        location.href = '/selectGroup?groups=' + $gid;
    }

    function preview($mid){
        var $data = {'message_id':$mid}; 
        $.ajax({
              type:"POST",
              url :"/preview",
              data: $data,
              timeout:60000,
              dataType:'json',
              success: function(res){
                if(res.status==0){
                  console.log(res);
                  $("#demo1 .title").html(res.data.m_title);
                  $("#demo1 .time").html(res.data.m_send_date);
                  $("#demo1 .detailMes").html(res.data.m_content);
                  $("#demo1").layerModel();
                }else{
                  alert(res.msg);
                }
              },
              fail:function(data){
                  alert("请求失效");
              }
          });
    }
    
    function queryCallback($mid,$state){
        var $data = {'is_display':$state,'message_id':$mid};
        var r =confirm("确认要进行此操作么？");
        if (r==true){
          $.ajax({
              type:"POST",
              url :"/display",
              data: $data,
              timeout:60000,
              dataType:'json',
              success: function(res){
                if(res.status==0){
                  alert(res.msg);
                  console.log(res);
                  location.href = location.href;
                }else{
                  alert(res.msg);
                }
              },
              fail:function(data){
                  alert("请求失效");
              }
          });
        }        
    }
</script>