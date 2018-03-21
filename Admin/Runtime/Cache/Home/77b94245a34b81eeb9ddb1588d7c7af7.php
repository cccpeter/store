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
    
  </head>
  <body style="margin-bottom:5px">

  
  <div 　class="container " style="width:80%;height:50%;margin-left:130px;margin-top:80px;background: url(/bookstore/Public/images/resign.png) no-repeat;
            width: 80%;    
            height: 400px;    
            /*border: 1px solid #999; */
             background-size:cover;   
         ">

      <!-- <img src="/bookstore/Public/images/timg.jpg"  width="100%" height="400px"> -->

      <div style="float:right;border-bottom:1px solid #ABABAB;border:1px solid #ABABAB;padding:0px 0px 10px 20px;margin-top:30px;margin-left:30px;margin-right:30px">
        <h3>BookStore</h3>
        <div class="row " style="font-size:16px;padding:20px 0px 0px 0px;margin-right:10px;margin-left:10px">
          <div class="col-xs-4" style="padding:5px 0px 0px 0px;">
            手机号码
          </div>
          <div class="col-xs-8" >
            <input type="text" class="form-control" id="" placeholder="请输入" size="16">
            </div>
        </div>
        <div class="row " style="font-size:16px;padding:20px 0px 0px 0px;margin-right:10px;margin-left:10px">
          <div class="col-xs-4" style="padding:5px 0px 0px 0px">
            密          码
          </div>
          <div class="col-xs-8" >
            <input type="text" class="form-control" id="" placeholder="请输入" size="16">
            </div>
          </div>
        <div class="row " style="font-size:16px;padding:20px 0px 0px 5px;margin-right:10px;margin-left:10px">
          <div class="col-xs-7" style="padding:5px 0px 0px 0px;text-align:right;">
            <input type="text" class="form-control" id="" placeholder="请输入" size="16">
            </div>
          <div class="col-xs-5" >
            <a href="#" type="button" class="btn btn-default" style="margin-top:5px;color:white;background:#34352C;width:100%;height:100%;">获取验证码</a>
          </div>
          
          </div>
           
           <!--跳转-->
        <div style="padding:30px 0px 10px 10px ;" >
                          <!--跳转-->
             <a href="#" type="button" class="btn btn-default" style="padding:5px;color:white;background:#34352C;width:90%;height:100%;">确定</a>   
        </div>
      

      
  </div>
  
      
  
 
 
  
  </body>
</html>