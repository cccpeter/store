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
       .firstfloat{
        width:80%;
        height:60%;
        position: absolute;
        left:130px;
        top:80px;
        background: url(/bookstore/Public/images/resign.png) no-repeat;
        background-size:cover;
      }
      .firstfloat .secondfloat{
        width:350px;
        height:320px;
        position: absolute;
        top: 50px;
        left: 65%;
        background-color:rgba(0,0,0,0.5);
        display:absolute;
        padding:5px 8px;
        color: #fff;
      }
      .firstfloat .secondfloat h3{
        color: #fff;
        font-family: "华文行楷";
        font-size: 32px;
      }
      .p-style{
        padding:2px 20px;
        border-bottom:1px solid #ABABAB;
      }
      .word_hidden
        {

          overflow:hidden; 

          text-overflow:ellipsis;

          display:-webkit-box; 

          -webkit-box-orient:vertical;

          -webkit-line-clamp:3; 
        }
        .price_style
        {
          color:#ED6F00;
          font-size:15px;

        }
        .demo 
        {    
          background: url(/bookstore/Public/images/timg.jpg) no-repeat;
            width: 100%;    
            height: 400px;    
            border: 1px solid #999;    
            background-size:cover;
        }
    </style>
     <script type="text/javascript">
    var wait = 60;
    var send=true;
    function time(obj) {
      if (wait == 0) {
          obj.removeAttribute("disabled");
          obj.value = "获取验证码";
          wait = 60;
          send=true;
      } else {
          obj.setAttribute("disabled", true);
          obj.value = wait + "秒后重新获取验证码";
          wait--;
          setTimeout(function () {
              time(obj);
          },
          1000);
          if(send){
            sendcode();
          }
          send=false;
      }
    }
    function sendcode(){
      var url="<?php echo U('Home/Login/findsecret');?>";
      var phone=$('#phone').val();
      if(phone==""){
        alert("请输入手机号码！");
        return;
      }
      $.post(url,{phone:phone},
        function(data){
          if(data==-1){
            alert("该手机号码未注册过");
          }else{
            alert("发送验证码成功");
          }
      },
      "text");//这里返回的类型有：json,html,xml,text
    }
    function sub(){
      var url="<?php echo U('home/Login/findcheck');?>";
      var indexurl="<?php echo U('home/Login/index');?>";
      var phone=$('#phone').val();
      var code=$('#code').val();
      var password=$('#password').val();
      $.post(url,{phone:phone,code:code,password:password},
        function(data){
          if(data==-1){
            alert("该手机号码未注册过");
          }else if(data==-2){
            alert("验证码过期");
          }else{
            alert("重置密码成功，即将返回登录页");
            location.href=indexurl;
          }
      },
      "text");

    }
    </script>
  </head>
  <body style="margin-bottom:5px">

  
    <div class="container firstfloat ">
      <div class="secondfloat">
        <h3>BookStore</h3>
        <div class="row " style="font-size:16px;padding:20px 0px 0px 0px;margin-right:10px;margin-left:10px">
          <div class="col-xs-4" style="padding:5px 0px 0px 0px;">
            手机号码
          </div>
          <div class="col-xs-8" >
            <input type="text" class="form-control" id="phone" placeholder="请输入" size="16">
            </div>
        </div>
         <div class="row " style="font-size:16px;padding:20px 0px 0px 0px;margin-right:10px;margin-left:10px">
          <div class="col-xs-4" style="padding:5px 0px 0px 0px;">
            重置密码
          </div>
          <div class="col-xs-8" >
            <input type="text" class="form-control" id="password" placeholder="请输入" size="16">
            </div>
        </div>
        <div class="row " style="font-size:16px;padding:20px 0px 0px 5px;margin-right:10px;margin-left:10px">
          <div class="col-xs-7" style="padding:5px 0px 0px 0px;text-align:right;">
            <input type="text" class="form-control" id="" placeholder="请输入" size="16">
            </div>
          <div class="col-xs-5" style="margin-top:10px;">
            <input style="border:1px solid #34352C;padding:5px ;font-size:14px;color:#aaa;background:#34352C;width:100%;height:100%;border-radius:5px;" value="获取验证码"  readonly onclick="time(this)">
          </div>
          
          </div>
           
           <!--跳转-->
        <div style="padding:30px 0px 10px 10px ;" >
                          <!--跳转-->
             <a type="button" class="btn btn-default" style="padding:5px;color:white;background:#34352C;width:90%;height:100%;" onclick="sub();">确定</a>   
        </div>
      

      
  </div>
  
  
  </body>
</html>