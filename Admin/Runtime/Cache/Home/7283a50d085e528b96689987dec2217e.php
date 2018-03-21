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
        .fsize{
          font-size: 16px;
        }
    </style>
     <script type="text/javascript">
    function sub(){
      var url="<?php echo U('Index/makeorder');?>";
      var book_id="<?php echo ($book['book_id']); ?>";
      var indexurl="<?php echo U('Index/index');?>";
      var remark=$('#remark').val();
      if(remark==''){
        alert('给卖家留个言呗~');
      }else{
        var local=$('#local').val();
      $.post(url,{remark:remark,local:local,book_id:book_id},
        function(data){
          if(data=="0"){
           alert("该书已经卖完。");
          }else{
            alert("下单成功，请留意你的短信通知并与卖家取得联系并交易。");
            location.href=indexurl;
          }
      },
      "text");//这里返回的类型有：json,html,xml,text
      }
    }
    </script>
  </head>
  <body style="margin-bottom:10px">
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
    <div style="width:40%;float:left"">
      <img src="/bookstore/Public/uploads/<?php echo ($book['book_urls']); ?>"
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

   <!--订单部分-->

   <div class="container" style="width:75%;height:30% ;margin-bottom:20px;">
     <!--订单填写内容-->


     <h5 style="margin-top:40px;padding:20px 0px">确认订单信息</h5>
     <div >
      <div class="col-xs-12" style="color: #ABABAB;border-bottom:2px solid #2E3161">
        <span style="padding:0px 0px 0px 80px">卖家宝贝</span>
        <span style="padding:0px 130px">数量</span>
        <span style="padding:0px 80px"> 价格</span>
        <span style="padding:0px 80px">小计</span>
      </div>
      <!--卖家图片-->
      <div class="col-xs-12" style="padding:5px 5px 0px 0px;border-bottom:1px solid #ABABAB;">   
        <div  class="row">
          <div class="col-xs-1" style="  border-right:1px solid #666;">
            <a href="#" >
            <!--卖家用户头像-->
              <img src="/bookstore/Public/uploads/<?php echo ($user['user_photo']); ?>" width="50px" height="30px">
            </a>
          </div>
          <div class="col-xs-8" style="padding:0px 0px 0px 10px;font-size:16px">
            <p><?php echo ($user['user_name']); ?></p> 
          </div>
        </div>
      </div>
      <!--卖家图片结束-->

      <!--商品信息-->
      <div class="col-xs-12" style="padding:10px 5px;border-bottom:2px solid #2E3161">
        <span  style="text-align:left;">
           <a href="#" >
            <!--商品图片-->
              <img src="/bookstore/Public/uploads/<?php echo ($book['book_urls']); ?>" width="70px" height="80px">
            </a>
            <label  style="font-size:14px;width:120px;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;"><?php echo ($book['book_name']); ?></label>
        </span>
        <span style="padding:0px 90px"><?php echo ($book['book_number']); ?></span>
        <span style="padding:0px 110px"><?php echo ($book['book_price']); ?></span>
        <span style="padding:0px 60px"><?php echo ($book['book_price']); ?></span>
        <div class="col-xs-12" style="font-size:16px;padding:20px 10px 0px 0px;">
          <div class="col-xs-1" style="padding:5px 0px 0px 0px;"> 留言</div>
          <div class="col-xs-11" style="text-align:right">
            <input type="text" class="form-control" id="remark" placeholder="请输入" size="16">
          </div>      
        </div>

      </div>
      <!--商品信息结束-->
      <div>
       
        <div class="col-xs-12" style="text-align: right;padding:1px;">
          <span style="font-size:16px"><?php echo ($book['book_price']); ?></span>
          <a onclick="sub();" type="button" class="btn btn-default"  style=" color:white;background:#2E3161;width:25%;height:100%;font-size:20px">订单确认</a>
        </div>
      </div>
        

   </div>
   <!--订单-->

    <div class="container" style="width:100%;margin-top:350px;padding:20px 0px 0px  0px ;height:25%;border-top:2px solid #2E3161;">
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

  <!--底部导航栏-->
  <div style="width:100%;margin-top:20px;padding:5px 5px 0px  0px ;height:25%;border-top:2px solid #C9CABB;text-align:center;font-size:12px">
      <p>
      Copyright (C) 旧书交易平台 2017, All Rights Reserved
      </p>
      <p>
        联系地址：广州市从化区温泉大道882号中山大学南方学院行政楼A2-320 邮编:510970
      </p>
    </div> 
   


      
    

  </body>
</html>