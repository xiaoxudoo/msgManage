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
    <script type="text/javascript" src="{{asset('js/laydate.js')}}"></script>
    <script type="text/javascript" src="{{asset('ckeditor/ckeditor.js')}}"></script>
    <script type="text/javascript" src="{{asset('ckfinder/ckfinder.js')}}"></script>
</head>
<body>

    <!-- main-->
    <div class="main clearfix">
         <div class="main-right">
             <ul class="rightTop myTab">
                 <li><a href="/">消息记录</a></li>
                 <li class="cur"><a href="/manage">消息设置</a></li>
                 <li><a href="">人群分组</a></li>
             </ul>
             <div class="rightDetail tabList" id="messSet">
                 <form class="form-search" method="post" action="{{url('/manage/searchMsgRecord')}}">
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
                 <div class="btnBox"><input class="myBtn" id="addBtn" type="button" value="新增"></div>
                 <table class="myTable">
                     <tr>
                         <th>消息ID</th>
                         <th>发送时间</th>
                         <th>消息名称</th>
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
                            <td>{{$MsgRecord->msg_name}}</td>
                            @if(strtotime($MsgRecord->m_send_timestamp) < time())
                                <td>
                                    <span class="dis">编辑</span>
                                    <span class="dis">删除</span>
                                </td>
                            @else
                                <td>
                                    <span onclick="javascript:editMsgRecord({{$MsgRecord->m_id}});" class="edit enl">编辑</span>
                                    <span onclick="javascript:deleMsgRecord({{$MsgRecord->m_id}});" class="dele enl">删除</span>
                                </td> 
                            @endif
                        </tr>
                    @endforeach
                 </table>
                 <!-- 分页 -->

                 {!! $MsgRecords->appends(['groups' => $groups])->render() !!}

                 <!-- 消息详情弹出页-->
                 <div id="demo1" class="layerMask">
                     <div id="layerWrap2" class="layerWrap2">
                         <a href="javascript:void(0);" title="关闭" class="layer_closeBtn" id="layer_closeBtn3">×</a>
                         <div class="editDetail2" id="editDetail2">
                             <h3>消息预览</h3>

                             <div class="txtPre">
                                 <h4 class="title" ></h4>
                                 <span class="time"></span>
                                 <div class="detailMes" class="txtCon"></div>
                             </div>
                         </div><!-- editDetail结束-->
                     </div><!-- layerWrap结束-->
                 </div><!-- layerMask2结束-->
                 <!-- 编辑弹出层-->
                 <div id="layerMask" class="layerMask">
                      <div id="layerWrap" class="layerWrap">
                          <a href="javascript:void(0);" title="关闭" class="layer_closeBtn" id="layer_closeBtn">×</a>
                         <div class="editDetail" id="editDetail"> 
                             <h3>编辑消息</h3>
                              <table class="align">
                                    <input name="updateOrCreateId" value="-1" type="hidden" />
                                    <tr>
                                        <td class="tdLeft">消息名称：</td>
                                        <td class="tdRight"><input type="text" name="msg_name" id="txtName"></td>
                                    </tr>
                                    <tr>
                                        <td class="tdLeft">消息内容：</td>
                                        <td class="tdRight"><textarea name="msg_area" id="txtArea" cols="30" rows="10"></textarea></td>
                                    </tr>
                                  <tr>
                                      <td class="tdLeft">发送时间：</td>
                                      <td class="tdRight" style="position:relative">
                                          <div class="demo2">
                                              <input id="txtDate" name="msg_date" placeholder="请输入日期" class="laydate-icon" onClick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})">
                                          </div>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td class="tdLeft">发送人群：</td>
                                      <td class="tdRight" >
                                          <!-- first_groups -->
                                          <select id="first_groups" name="first_groups">
                                              
                                          </select>
                                          <!-- second_groups -->
                                          <select id="second_groups" style="display: inline-block;" name="second_groups" class="sub">
                                              <option></option>
                                          </select>
                                      </td>
                                  </tr>
                              </table>
                             <div class="btnGroup">
                                  <input class="myBtn" id="calBtn" type="button" value="取消">
                                  <input class="myBtn" id="preBtn" type="button" value="预览">
                                  <input class="myBtn" id="savBtn" type="button" value="保存">
                             </div>
                         </div><!-- editDetail结束-->
                      </div><!-- layerWrap结束-->
                 </div><!-- layerMask结束-->
                 <!-- 预览弹出层-->
                 <div id="layerMask2" class="layerMask">
                     <div id="layerWrap2" class="layerWrap">
                         <a href="javascript:void(0);" title="关闭" class="layer_closeBtn" id="layer_closeBtn2">×</a>
                         <div class="editDetail" id="editDetail">
                             <h3>消息预览</h3>
                              <div class="txtPre">
                                    <h4 id="txtTitle"></h4>
                                    <span id="sendTime"></span>
                                    <p id="txtCon"></p>
                              </div>
                         </div><!-- editDetail结束-->
                     </div><!-- layerWrap结束-->
                 </div><!-- layerMask结束-->
             </div><!-- messRecorde结束-->
         </div><!-- mainright结束-->
    </div><!-- main结束-->
</body>
</html>


<!-- 日历与时间选择-->
<script type="text/javascript">
    !function(){
        laydate.skin('molv');//切换皮肤，请查看skins下面皮肤库
        laydate({elem: '#demo'});//绑定元素
    }();

</script>

<!-- 二级联动select   **修改 by xiaoxudoo -->
<script type="text/javascript">

    $(document).ready(function(){

        $.post("/groups",function(res){
            if(res.status == 0){
                window.first_class = res.first_class; //设置为JavaScript全局变量
                console.log(window.first_class);

                var f_selectObj = $("#first_groups");
                f_selectObj.children().remove();
                var s_selectObj = $("#second_groups");
                s_selectObj.children().remove();
                var selectData = res.first_class;
                f_selectObj.append(new Option("--   请选择  --",'-1'));
                s_selectObj.append(new Option("--   请选择  --",'-1'));
                //添加options
                for(var i=0;i<res.first_class_amount;i++){
                  var first_groups = selectData[i];
                  var second_groups = first_groups.second_class;
                  var second_class_amount = first_groups.second_class_amount;
                  var optionObj = new Option(first_groups.mfg_name,first_groups.mfg_id);

                  // 添加一级分组
                  f_selectObj.append(optionObj);

                  // 添加二级分组
                  for(var j=0;j<second_class_amount;j++){
                    s_selectObj.append(new Option(second_groups[j].msg_name,second_groups[j].msg_id));
                  }
                }
                // 选择options
                $("#first_groups").change(function(){
                    s_selectObj.children().hide();
                    for(var i in selectData){
                        var first_groups = selectData[i];
                        var second_groups = first_groups.second_class;
                        var second_class_amount = first_groups.second_class_amount;
                        if($(this).val() == first_groups.mfg_id){
                            s_selectObj.children().eq(0).show();
                            for(var j=0;j<second_class_amount;j++){
                                // 显示指定的option
                                for(var k=0;k<s_selectObj.children().length;k++){
                                    if(s_selectObj.children().eq(k).val() == second_groups[j].msg_id){
                                        s_selectObj.children().eq(k).show();
                                    }
                                }
                            }
                        }
                    }
                    console.log($("#first_groups").val());
                    console.log($("#second_groups").val());
                }).trigger("change");
                
            }
        },'json');
    });

</script>

<script type="text/javascript">
        var editor = CKEDITOR.replace('txtArea');          // 创建编辑器
        CKFinder.setupCKEditor(editor, '/PlugIns/ckfinder/');   // 为编辑器绑定"上传控件"

        var calBtn=document.getElementById("calBtn");
        var preBtn=document.getElementById("preBtn");
        var savBtn=document.getElementById("savBtn");
        var txtName=document.getElementById("txtName");
        var txtArea=document.getElementById("txtArea");
        var txtDate=document.getElementById("txtDate");
        var txtTitle=document.getElementById("txtTitle");
        var txtCon=document.getElementById("txtCon");
        var sendTime=document.getElementById("sendTime");

        var first_groups = document.getElementById("first_groups");
        var second_groups = document.getElementById("second_groups");

        // 增加记录按钮
        $("#addBtn").click(function(){
            $("#layerMask").show();
        });
        // 弹出框取消按钮
        $("#layer_closeBtn").click(function(){
            $("#layerMask").hide();
            txtName.value="";
            editor.setData();
            txtDate.value="";
            first_groups.value = -1;
            second_groups.value = -1;
        });

        $("#layer_closeBtn3").click(function(){
            $("#demo1").hide();
        });

        // 预览 应该按照原来的界面
        $("#preBtn").click(function(){
            $("#layerMask2").show();
        });

        $("#layer_closeBtn2").click(function(){
            $("#layerMask2").hide();
        });
        
        calBtn.onclick = function(){
            txtName.value="";
            editor.setData();
            txtDate.value="";
            first_groups.value = -1;
            second_groups.value = -1;
        };
        preBtn.onclick =function(){
            var editor_data=editor.getData();
            txtTitle.innerHTML=txtName.value;
            txtCon.innerHTML=editor_data;
            sendTime.innerHTML=txtDate.value;
        }
        savBtn.onclick=function(evt){

            // 表单验证需完善
            if(txtName.value==""){
                alert("请填写完整的信息名称");
            }
            else{
                // 增加、更新代码
                createOrUpdate();
            }
        }

        function createOrUpdate(){
            var $m_id = $("#editDetail input[name='updateOrCreateId']").val();
            var $m_title = $("#editDetail input[name='msg_name']").val();
            var $m_content = editor.getData();
            var $m_create_date = $("#editDetail input[name='msg_date']").val();
            var $msg_id = $("#second_groups").val();

            var $data = {'m_id':$m_id,'m_title':$m_title,'m_content':$m_content,'m_create_date':$m_create_date,'msg_id':$msg_id};
            $.ajax({
                type:"POST",
                url :"/manage/merge",
                data: $data,
                timeout:60000,
                dataType:'json',
                success: function(res){
                    if(res.status==0){
                        console.log(res);  
                        alert(res.msg);
                        location.href = location.href;
                    }else{
                        alert(res.msg);                        
                    }
                },
                error:function(res){
                    alert("请求失效");
                }
            });
        }

        function editMsgRecord($mid){
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
                        // 往表单中填入数据
                        $("#editDetail input[name='updateOrCreateId']").val(res.data.m_id);  //设置为更新记录
                        $("#editDetail input[name='msg_name']").val(res.data.m_title);
                        editor.setData(res.data.m_content); 
                        $("#editDetail input[name='msg_date']").val(res.data.m_send_timestamp);
                        $("#second_groups").val(res.data.msg_id);

                        // 分组信息
                        $("#layerMask").show();
                    }else{
                        alert(res.msg);
                    }
                },
                fail:function(data){
                    alert("请求失效");
                }
            });
        }

</script>


<!-- interaction javascript written by xiaoxudoo  -->
<script type="text/javascript">
    // 分组检索
    function select_group($gid){
        location.href = '/manage/selectGroup?groups=' + $gid;
    }
    //消息预览
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
                  $("#demo1").show();
                }else{
                  alert(res.msg);
                }
              },
              fail:function(data){
                  alert("请求失效");
              }
          });
    }

    function deleMsgRecord($mid){
        var $data = {'message_id':$mid};
        var r =confirm("确认要删除这条消息么？");
        if (r==true){
            $.ajax({
              type:"POST",
              url :"/manage/delete",
              data: $data,
              timeout:60000,
              dataType:'json',
              success: function(res){
                if(res.status==0){
                  alert(res.msg);
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