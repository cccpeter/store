<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
  <head>
    <title>BookStore</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/bookstore/Public/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/bookstore/Public/css/all.css">
    <script src="/bookstore/Public/jq/jquery-3.1.0.min.js"></script>
    <script src="/bookstore/Public/bootstrap/js/bootstrap.min.js"></script>
    <style type="text/css">
      .p-style{
        padding:2px 20px;
        border-bottom:1px solid #ABABAB;
      }
      .word_hidden
        {
          overflow:hidden; 
          text-overflow:ellipsis
          display:-webkit-box; 
          -webkit-box-orient:vertical;
          -webkit-line-clamp:3; 
        }
        .price_style
        {
          color:#ED6F00;
          font-size:15px;

        }

      .wrapper {  display:inline-block; background-image: url("/bookstore/Public/images/upload.jpg"); height:50px; width:50px; overflow:hidden; cursor:pointer;float: left;}
      .wrapper input{ opacity: 0; height:50px; width:50px;}
      .photo_info{float: right;}
      .fsize{
          font-size: 16px;
        }

    </style>
     <script type="text/javascript">
        function sub(){
          alert("修改成功");
          document.getElementById("form2").submit();
        }
         function sub2(){
          alert("发布成功");
          document.getElementById("form3").submit();
        }
    </script>
 <script type="text/javascript">
    function del(book_id){
      var url="<?php echo U('Index/insalebook');?>";
      $.post(url,{book_id:book_id},
        function(data){
          if(data=="0"){
           alert("你的网络有问题！");
          }else{
            alert("下架成功");
          }
      },
      "text");
    }
    </script>
  </head>
  <body style="margin-bottom:5px">
    <nav class="navbar navbar-default" role="navigation" height="20px"> 
    <div class="container"> 
         <!--    <div class="navbar-header"> 
            <a class="navbar-brand" href="#">BookStore</a> 
        </div>-->
        <ul class="nav navbar-nav" style="padding:0 0 0 50px">
            <li class="fsize"><a href="<?php echo U('Index/index');?>">首页</a></li>
            <li class="fsize"><a href="<?php echo U('Search/index');?>">搜索</a></li>
            <li class="fsize"><a href="<?php echo U('Index/personal');?>">我的</a></li>
        </ul>
    
        <ul class="nav navbar-nav navbar-right"> 
            <li class="fsize"><a href="<?php echo U('Index/loginout');?>"><span class="glyphicon glyphicon-log-in"></span> 退出</a></li> 
        </ul>
    </div> 
</nav>

  
  <div class="container" style="width:80%;height:25%;">        
    <div style="width:22%;float:left"">
      <img src="/bookstore/Public/images/bookstores.png"
                 alt="通用的占位符缩略图" width="230px" height="74px">
   
    </div><!--22的部分-->
    <!--索索栏目-->
        <form action="<?php echo U('Search/index');?>" method="post">
    <div style="width:78%;margin-top:20px;margin-bottom:20px;float:right;"">
      <div class="col-xs-2" style=" text-align: right; vertical-align: center; padding:6px 1px 1px 1px">
        <span >搜索商品</span>
      </div>
      <div class="col-xs-7">
        <input type="text" class="form-control" name="search" placeholder="请输入要搜索的书籍" size="10">  
      </div>
      <div class="col-xs-3">
        <button type="submit" class="btn btn-default">搜索</button>
      </div>
    </div>
  </form>
   </div><!--底部了-->

   <!--个人信息部分-->
   <div class="container" style="width:70%;margin-bottom:10px">
   <!--个人图像-->
      <div class="row border_btm" style="padding:15px 0px 0px 0px;border:1px solid #ABABAB;">
        <div class="col-xs-1" >
        <!--用户头像-->
           <a href="#" >
            <img src="/bookstore/Public/uploads/<?php echo ($user['user_photo']); ?>" class="img-circle" width="80px" height="80px">
          </a> 
        </div>
        <div class="col-xs-10" style="padding:10px 0px 0px 40px; font-size:16px">
          <p><?php echo ($user['user_name']); ?></p>
          <p>积分:100</p>
        </div>
      </div><!--个人图像结束-->
      <!--跳跳框-->
      
        <div class="row clearfix" style="border:1px solid #ABABAB;">
          <div class="col-md-12 column">
            <div class="tabbable" id="tabs-373361">
              <ul class="nav nav-tabs">
                <li class="active">
                   <a href="#panel-502288" data-toggle="tab">书籍详情</a>
                </li>
               <!--  <li >
                   <a href="#panel-465421" data-toggle="tab">留言详细</a>
                </li> -->
                <li >
                   <a data-toggle="modal" href='#modal-id1' type="button" class="btn btn-default" role="button" style="width:120px;height:40px;margin-right:20px">
                    上架书籍
                  </a> 
                </li>
                <li >
                   <a data-toggle="modal" href='#modal-id2' type="button" class="btn btn-default" role="button" style="width:120px;height:40px;margin-right:20px">
                    修改个人信息
                  </a> 
                </li>

              </ul>
              <!--11111111111111-->
              <div class="tab-content">
                <div class="tab-pane active" id="panel-502288">
                <!--手风琴组合-->
                  <div class="panel-group" id="accordion">
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" 
                             href="#collapseOne">
                            在售书籍
                          </a>
                        </h4>
                      </div>
                  <div id="collapseOne" class="panel-collapse collapse in">
                    <?php if(is_array($book)): foreach($book as $key=>$vo): ?><div style class="panel-body">      
                        </div>
                        <!--在售列表-->
                          <div class="row" style="font-size:16px;line-height:28px;">
                            <div class="col-xs-2 " style="text-align:center">
                              <a href="#" >
                                  <img src="/bookstore/Public/uploads/<?php echo ($vo["book_urls"]); ?>"
                                       alt="通用的占位符缩略图" width="100px" height="80px"> 
                              </a>
                            </div>
                            <div class="col-xs-10" style="float:left">
                               <span >
                                   <?php echo ($vo["book_name"]); ?> | <?php echo ($vo["book_author"]); ?>
                                </span>
                                <div  style="color:#ED6F00;font-size:16px">
                                   <?php echo ($vo["book_price"]); ?>
                                </div>
                                <div  style="font-size:14px">
                                  <span>交易状态：</span>
                                  <span style="color:#ED6F00;">待售</span>
                                  
                                  <span style="color:#ED6F00;">
                                    <button style="margin-left:65px" type="button" class="btn btn-default"  onclick="del(<?php echo ($vo["book_id"]); ?>);">下架</button>
                                  </span>
                                </div>
                            </div>              
                          </div>  <!--在售列表end--><?php endforeach; endif; ?>
                    </div>
                  </div>

                    
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" 
                             href="#collapseTwo">
                            已售书籍
                          </a>
                        </h4>
                      </div>
                      <div id="collapseTwo" class="panel-collapse collapse">
                        <div class="panel-body">
                          <!--列表-->
                          <div class="row" style="font-size:16px;line-height:28px;border-bottom:1px solid #C3C5C9;">
                            <div class="col-xs-2 " style="text-align:center">
                              <a href="#" >
                                  <img src="/bookstore/Public/images/3.jpg"
                                       alt="通用的占位符缩略图" width="100px" height="80px"> 
                              </a>
                            </div>
                            <div class="col-xs-10" style="float:left">
                               <span >
                                  book | 作者
                                </span>
                                <div  style="color:#ED6F00;font-size:16px">
                                   jiage
                                </div>
                                <div  style="font-size:16px">
                                  <span >交易日期：201779900<?php echo ($vo["time"]); ?></span>
                                  <span style="margin-left:40px;">交易状态：</span>
                                  <span style="color:#ED6F00;">已售</span>
                                </div>
                            </div>         
                          </div><!--列表-->
                        </div>
                      </div>
                    </div>
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" 
                             href="#collapseThree">
                            已购书籍
                          </a>
                        </h4>
                      </div>
                      <div id="collapseThree" class="panel-collapse collapse">
                        <div class="panel-body">
                          <!--列表-->
                          <div class="row" style="font-size:16px;line-height:28px;border-bottom:1px solid #C3C5C9;">
                            <div class="col-xs-2 " style="text-align:center">
                              <a href="#" >
                                  <img src="/bookstore/Public/images/3.jpg"
                                       alt="通用的占位符缩略图" width="100px" height="80px"> 
                              </a>
                            </div>
                            <div class="col-xs-10" style="float:left">
                               <span >
                                  book | 作者
                                </span>
                                <div  style="color:#ED6F00;font-size:16px">
                                   jiage
                                </div>
                                <div  style="font-size:16px">
                                  <span >交易日期：201779900<?php echo ($vo["time"]); ?></span>
                                  <span style="margin-left:40px;">交易状态：</span>
                                  <span style="color:#ED6F00;">已购</span>
                                </div>
                            </div>         
                          </div><!--列表-->
                        </div>
                      </div>
                    </div>
                    
                      <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" 
                             href="#collapseFour">
                            所有书籍
                          </a>
                        </h4>
                      </div>
                      <div id="collapseFour" class="panel-collapse collapse">
                        <div class="panel-body">
                          <!--列表-->
                          <div class="row" style="font-size:16px;line-height:28px;border-bottom:1px solid #C3C5C9;">
                            <div class="col-xs-2 " style="text-align:center">
                              <a href="#" >
                                  <img src="/bookstore/Public/images/3.jpg"
                                       alt="通用的占位符缩略图" width="100px" height="80px"> 
                              </a>
                            </div>
                            <div class="col-xs-10" style="float:left">
                               <span >
                                  book | 作者
                                </span>
                                <div  style="color:#ED6F00;font-size:16px">
                                   jiage
                                </div>
                                <div  style="font-size:16px">
                                  <span >交易日期：201779900<?php echo ($vo["time"]); ?></span>
                                  <span style="margin-left:40px;">交易状态：</span>
                                  <span style="color:#ED6F00;">random</span>
                                </div>
                            </div>         
                          </div><!--列表-->
                        </div>
                      </div>
                    </div>  
                  </div>
                <!--手风琴组合结束-->
                </div>
                <!--222222-->
                <div class="tab-pane " id="panel-465421">
                 <!--  <div  class="row" style="border-bottom:1px solid #ABABAB;margin-right:-4px;margin-top: 10px;">
                  <div class="col-xs-2" style="  border-right:1px solid #666;">
                    <a href="#" >
                      <img src="/bookstore/Public/images/3.jpg" width="80px" height="50px">
                    </a>
                  </div>
                  <div class="col-xs-10" style="padding:0px 0px 0px 10px;font-size:16px">
                    <div >
                      <span>name</span>
                      <span style="float:right;">riqi</span>
                    </div>
                    <div style="font-size:14px;word-wrap: break-word;">
                         回复内容:
                         &nbsp;&nbsp;&nbsp;&nbsp;chibaol的大宝宝不想和宝宝玩了
                      </div>
                      <div style="font-size:14px;word-wrap: break-word;color:#727272;">
                        来源于：<?php echo ($vo["hole_message"]); ?>
                    </div>
                  </div>
                </div> --><!--留言板块-->
      
                </div>
              </div>
            </div>
          </div>
        </div>
        <!--跳跳框结束-->
        <!--留言弹出窗-->
        <div class="modal fade" id="modal-id1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="padding:10px">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">上传商品</h4>
                    </div>
                    <div class="modal-body">
                        <form action="<?php echo U('Index/addgoods');?>" method="POST" class="form-horizontal" id="form3" enctype="multipart/form-data">
                        <!--信息填写-->
                           <div class="row border_btm" style="font-size:18px;padding:70px 0px 0px 0px;">
        <div class="col-xs-3" >
          书名
        </div>
        <div class="col-xs-9" >
          <input type="text" class="form-control" id="bookname" name="bookname" placeholder="请输入" size="16">
          </div>
        </div>
        <div class="row border_btm" style="font-size:18px;padding:10px 0px">
        <div class="col-xs-3" >
          作者
        </div>
        <div class="col-xs-9" >
          <input type="text" class="form-control" id="auth" name="auth" placeholder="请输入" size="16">
          </div>
        </div>
        <div class="row border_btm" style="font-size:18px;padding:10px 0px">
        <div class="col-xs-3" >
          价格
        </div>
        <div class="col-xs-9" >
          <input type="text" class="form-control" id="price" name="price" placeholder="请输入" size="16">
          </div>
        </div>
        <div class="row border_btm" style="font-size:18px;padding:10px 0px">
        <div class="col-xs-3" >
          几成新
        </div>
        <div class="col-xs-9" >
          <input type="text" class="form-control" id="old" name="old" placeholder="请输入" size="16">
          </div>
        </div>
        <div class="row " style="font-size:18px;padding:10px 0px">
          <div class="col-xs-3" >
            简介
          </div>
          <div class="col-xs-9" style=" float:left;">
            <!--textarea 设置ID传值-->
            <textarea rows="5" cols="20" id="content" name="content" style=" resize:none;"></textarea>
          </div>
        </div>
        <div class="row border_btm" style="font-size:18px;padding:10px 0px">
        <div class="col-xs-3" >
          数量
        </div>
        <div class="col-xs-9" >
          <input type="text" class="form-control" id="booknumber" name="booknumber" placeholder="请输入" size="16">
          </div>
        </div>
      <div class="col-xs-6" >
        <select name="type_id" id="type_id"  style="width:155px">
            <?php if(is_array($type)): foreach($type as $key=>$vo): ?><option value="<?php echo ($vo["type_id"]); ?>"><?php echo ($vo["type_name"]); ?></option><?php endforeach; endif; ?>
          </select>
      </div>
      <div class="col-xs-6" style="text-align:right">
        <input type="checkbox" name="isname" id="isname" value="1"> 是否匿名 
      </div>
                          <!--图片上传  需要修改-->
                          <div class="form-group">
                            <label class="sr-only col-sm-2 control-label" for="inputfile">文件输入</label>
                            <!--图片上传-->
                          <table>
                          <tr>
                          <td>
                            <a href="javascript:" class="wrapper"><input name="info_photo" type="file" value="" id="info_photo" onchange='PreviewImage(this)' width="50px" height="50px" /></a>
                            <!-- <input name="upload" type="submit" value="上传" /> -->
                          </td>
                          <td id="photo_info" class="photo_info"></td>
                          </tr>
                          </table>
                          </div>

                          <div style="padding:0px 0px 0px 90px">
                          <!--跳转-->
                            <a onclick="sub2();" type="button" class="btn btn-default" style="color:white;background:#34352C;width:80%;height:100%;">发布书籍</a>
                          </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><!--留言弹出窗1-->

         <!--留言弹出窗2-->
        <div class="modal fade" id="modal-id2">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="padding:10px">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">个人信息</h4>
                    </div>
                    <div class="modal-body">
                        <form action="<?php echo U('Home/Index/personal1');?>" method="POST" class="form-horizontal" id="form2" enctype="multipart/form-data">
                        <!--信息填写-->
                          <div class="form-group">
                            <label class="sr-only col-sm-2 control-label" for="inputfile">更换头像</label>

                            <!--图片上传-->
                            <table>
                            <tr>
                            <td>
                              <a href="javascript:" class="wrapper"><input name="info_photo" type="file" value="" id="info_photo" onchange='Preview(this)' width="50px" height="50px" /></a>
                              <!-- <input name="upload" type="submit" value="上传" /> -->
                              </td>
                              <td id="photo" class="photo"></td>
                              </tr>
                              </table>

                          </div>
                          <div style="padding:0px 0px 0px 90px">
                          <div class="form-group">
                            <label for="firstname" class="col-sm-2 control-label">昵称</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" name="name" id="firstname" placeholder="请输入">
                            </div>
                          </div>
                          

                          <div style="padding:0px 0px 0px 90px">
                          <!--跳转-->
                            <a onclick="sub();" type="button" class="btn btn-default" style="color:white;background:#34352C;width:80%;height:100%;">确认信息</a>
                          </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><!--留言弹出窗-->


   </div>


   <!--底部固定-->
   <div class="container" style="margin-top:10px;width:80%;padding:20px 0px 0px  0px ;height:25%;border-top:2px solid #2E3161;">
    <div style="text-align:center;">
      <div  class="col-xs-4" style="border-right:1px solid #ABABAB;">
        <img src="/bookstore/Public/images/zheng.png" class="img-circle" width="70px" height="70px">
        正品保障
      </div>
      <div class="col-xs-4" style="border-right:1px solid #ABABAB;；">
        <img src="/bookstore/Public/images/gou.png" class="img-circle" width="70px" height="70px">
        放心购物
      </div>
      <div class="col-xs-4" >
        <img src="/bookstore/Public/images/mian.png" class="img-circle" width="70px" height="70px">
        当面交付
      </div>
      
    </div>
    

  </div>

  <div style="width:100%;margin-top:20px;padding:5px 5px 0px  0px ;height:25%;border-top:2px solid #C9CABB;text-align:center;font-size:12px">
      <p>
      Copyright (C) 旧书交易平台 2017, All Rights Reserved
      </p>
      <p>
        联系地址：广州市从化区温泉大道882号中山大学南方学院行政楼A2-320 邮编:510970
      </p>
    </div>


    <script type="text/javascript">
      function PreviewImage(imgFile) {
      var filextension = imgFile.value.substring(imgFile.value
        .lastIndexOf("."), imgFile.value.length);
      filextension = filextension.toLowerCase();
      if ((filextension != '.jpg') && (filextension != '.gif')
        && (filextension != '.jpeg') && (filextension != '.png')
        && (filextension != '.bmp')) {
       alert("对不起，系统仅支持标准格式的照片，请您调整格式后重新上传，谢谢 !");
       imgFile.focus();
      } else {
       var path;
       if (document.all)//IE
       {
        imgFile.select();
        path = document.selection.createRange().text;
        document.getElementById("photo_info").innerHTML = "";
        document.getElementById("photo_info").style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled='true',sizingMethod='scale',src=\""
          + path + "\")";//使用滤镜效果  
       } else//FF
       {
        path = window.URL.createObjectURL(imgFile.files[0]);// FF 7.0以上
        //path = imgFile.files[0].getAsDataURL();// FF 3.0
        document.getElementById("photo_info").innerHTML = "<img id='img1' width='120px' height='100px' src='"+path+"'/>";
        //document.getElementById("img1").src = path;
       }
      }
     }
     function Preview(imgFile) {
      var filextension = imgFile.value.substring(imgFile.value
        .lastIndexOf("."), imgFile.value.length);
      filextension = filextension.toLowerCase();
      if ((filextension != '.jpg') && (filextension != '.gif')
        && (filextension != '.jpeg') && (filextension != '.png')
        && (filextension != '.bmp')) {
       alert("对不起，系统仅支持标准格式的照片，请您调整格式后重新上传，谢谢 !");
       imgFile.focus();
      } else {
       var path;
       if (document.all)//IE
       {
        imgFile.select();
        path = document.selection.createRange().text;
        document.getElementById("photo").innerHTML = "";
        document.getElementById("photo").style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled='true',sizingMethod='scale',src=\""
          + path + "\")";//使用滤镜效果  
       } else//FF
       {
        path = window.URL.createObjectURL(imgFile.files[0]);// FF 7.0以上
        //path = imgFile.files[0].getAsDataURL();// FF 3.0
        document.getElementById("photo").innerHTML = "<img id='img1' width='120px' height='100px' src='"+path+"'/>";
        //document.getElementById("img1").src = path;
       }
      }
     }
    </script>
    

  </body>
</html>