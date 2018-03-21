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
      a:hover{
        color: black;
      }
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
        width:300px;
        height:300px;
        position: absolute;
        top: 50px;
        left: 65%;
        background-color:rgba(0,0,0,0.5);
        display:absolute;
        padding:5px 8px;
      }
      .firstfloat .secondfloat h3{
        color: #fff;
        font-family: "华文行楷";
        font-size: 32px;
      }
      .btnstyle{
        padding:5px;
        color:white;
        background:#34352C;
        width:100%;height:40px;
        font-size:18px;
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
    /*
     * 添加验证
     * 2017/4/19
    */
    function check(){
      var url="<?php echo U('Home/Login/index');?>";
      var indexurl="<?php echo U('Home/Index/index');?>";
      var account=$('#account').val();
      var checkNum=/^(0|86|17951)?(13[0-9]|15[012356789]|18[0-9]|14[57])[0-9]{8}$/;
      if(checkNum.test(account)){
        var password=$('#password').val();
        if(password==''){
          alert("密码不能为空");
        }else{
      $.post(url,{account:account,password:password},
        function(data){
          if(data=="0"){
           alert("账号或者密码不对！");
          }else{
            alert("登录成功");
            location.href=indexurl;
          }
      },
      "text");//这里返回的类型有：json,html,xml,text
        }
      }else{
        alert("手机号码有误");
      }
      
    }

    function find(){
      var findurl="<?php echo U('Home/Login/findsecret');?>"
      location.href=findurl;
    }
    </script>
  </head>
  <body style="margin-bottom:5px">

  
  <div class="container firstfloat ">
    <div class="secondfloat">
        <h3>BookStore</h3>
        <div class="row " style="font-size:16px;padding:20px 0px 0px 5px;margin-right:10px">
        <div class="col-xs-3" style="color:#fff;padding:5px 0px 0px 0px;text-align:right">
          账号
        </div>
        <div class="col-xs-9" >
          <input type="text" class="form-control" id="account" placeholder="请输入" size="16">
          </div>
        </div>
        <div class="row " style="font-size:16px;padding:20px 0px 0px 5px;margin-right:10px">
          <div class="col-xs-3" style="color:#fff;padding:5px 0px 0px 0px;text-align:right">
            密码
          </div>
          <div class="col-xs-9" >
            <input type="password" class="form-control" id="password" placeholder="请输入" size="16">
          </div>
        </div>
        <div class="row">
          <div class="col-xs-11" style="color:#aaa;padding:5px 5px 0px 5px;text-align:right;" onclick="find();">
            忘记密码->         
           </div>
        </div>
        <div class="row" style="color:#aaa;padding:5px 5px 0px 5px;">
          <div class="col-xs-6">
             <a type="button" class="btn btn-default btnstyle "  onclick="check();">登陆</a>     
           </div>
           <div class="col-xs-6">
              <a href="<?php echo U('Home/Login/register');?>" type="button" class="btn btn-default btnstyle">注册</a> 
           </div>
        </div>
        
      

      
  </div>
  
      
  
 
 
  
  </body>
</html>