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
        .fsize{
          font-size: 16px;
        }
        ul.pagination {
          display: inline-block;
          padding: 0;
          margin: 0;
        }

      ul.pagination li {display: inline;}

      ul.pagination li a {
        color: black;
        float: left;
        padding: 8px 16px;
        text-decoration: none;
        border-radius: 5px;
        }

      ul.pagination li a.active {
        background-color: #4CAF50;
        color: white;
        border-radius: 5px;
      }

      ul.pagination li a:hover:not(.active) {background-color: #ddd;}
    </style>
     <script type="text/javascript">
    function sclick(book_id){  
      var url="<?php echo U('Home/Index/shopcontent');?>"+"?book_id="+book_id;
      onclick=window.open(url);
    }
    </script>
    <script type="text/javascript">
     var time_id="1";
     var search="<?php echo ($search); ?>";
     var type_id="<?php echo ($type[0]['type_id']); ?>";
      function time(){
        time_id="1";
        search1();
      } 
      function price(){
        time_id="2";
        search1();
      }    
      function search1(){
        var p1 = document.getElementById("search2");  
        var p2 = document.getElementById("type_id");  
        var p2 = document.getElementById("time_id");  
        p1.value=search;
        p2.value=type_id;
        p3.value=time_id;
        document.getElementById("fo").submit();
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

          
    <!--书籍分类-->
    <div style="width:22%;float:left"">
      <img src="/bookstore/Public/images/bookstores.png"
                 alt="通用的占位符缩略图" width="230px" height="74px">
    <div style="border-bottom:2px solid #ABABAB;border-top:1px solid #ABABAB;border-right:2px solid #ABABAB;border-left:2px solid #ABABAB;width:100%;height:100%;">
        <div class="col-xs-12" style="padding:2px 0px 0px 0px">
            <p  style="font-size:16px;background-color:#2E3161;color:white">最新书籍</p>
            
            
       <p class="p-style">
          <a href="<?php echo U('/Search/booktype',array('type_id'=>4));?>">
            <span class="glyphicon glyphicon-hand-right">人文科学</span>
          </a>
        </p>
        <p class="p-style">
          <a href="<?php echo U('/Search/booktype',array('type_id'=>6));?>">
            <span class="glyphicon glyphicon-hand-right">外语学习</span>
          </a>
        </p>
        <p class="p-style">
          <a href="<?php echo U('/Search/booktype',array('type_id'=>7));?>">
            <span class="glyphicon glyphicon-hand-right">文学艺术</span>
          </a>
        </p>
        <p class="p-style">
          <a href="<?php echo U('/Search/booktype',array('type_id'=>5));?>">
            <span class="glyphicon glyphicon-hand-right">生活休闲</span>
          </a>
        </p>
        <p class="p-style"> 
          <a href="<?php echo U('/Search/booktype',array('type_id'=>2));?>">
            <span class="glyphicon glyphicon-hand-right">经济管理</span>
          </a>
        </p>
        <p class="p-style">
          <a href="<?php echo U('/Search/booktype',array('type_id'=>3));?>">
            <span class="glyphicon glyphicon-hand-right">考试教育</span>
          </a>
        </p>
        <p class="p-style">
          <a href="<?php echo U('/Search/booktype',array('type_id'=>9));?>">
            <span class="glyphicon glyphicon-hand-right">自然科学</span>
          </a>
        </p>
        <p class="p-style">
          <a href="<?php echo U('/Search/booktype',array('type_id'=>10));?>">
            <span class="glyphicon glyphicon-hand-right">计算机</span>
          </a>
        </p>
        <p class="p-style">
          <a href="<?php echo U('/Search/booktype',array('type_id'=>8));?>">
            <span class="glyphicon glyphicon-hand-right">医学</span>
          </a>
        </p>
        <p style="padding:0px 0px 20px 20px;margin-bottom: -12px ">
          <a href="<?php echo U('/Search/booktype',array('type_id'=>1));?>">
            <span class="glyphicon glyphicon-hand-right">所有分类</span>
          </a>
        </p>

      </div>
    </div><!--导航栏结束-->
</div>
  
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

      <div style="width:78%;height:25%;float:right;padding:20px 0px 0px  0px">
      <div class="row " style="width:100%;margin-top:-21px;margin-left:1px;border-bottom:2px solid #080D5E;border-top:1px solid #C9CABB;padding:5px 0px 0px 3px;">
        <div class="col-xs-12" style="text-align:left;padding:5px;font-size:18px; ">
          <a href="#">          
            搜索结果
          </a>
        </div>
        

      </div>
      <div class="row clearfix" style="padding:5px 0px;">
        <div class="col-md-12 column">
          <div class="btn-group">
            <button  class="btn btn-default" type="button" onclick="price();">
              <em></em>
              价格 
            </button> 
            <button class="btn btn-default" type="button" onclick="time();">
              <em></em> 
              上架时间
            </button> 
            <button class="btn btn-default" type="button">
              <em></em> 
              <?php echo ($type[0]['type_name']); ?>
            </button> 
          </div>
        </div>
      </div>
      <form action="<?php echo U('Search/search');?>" method="post" id="fo">
        <input type="hidden" name="search" id="search2" value="1">
        <input type="hidden" name="time_id" id="time_id" value="1">
        <input type="hidden" id="type_id" name="type_id" value="1">
      </form>
      <div class="row">
       <?php if(is_array($book_search)): foreach($book_search as $key=>$vo): ?><div class="col-sm-6 col-md-3" onclick="sclick('<?php echo ($vo["book_id"]); ?>')">
               <div class="thumbnail">
                  <img src="/bookstore/Public/uploads/<?php echo ($vo["book_urls"]); ?>" 
                   alt="通用的占位符缩略图" style="width:160px;height:105px">
                  <div class="caption">
                      <h5><?php echo ($vo["book_name"]); ?> | <?php echo ($vo["book_author"]); ?></h5>
                      <p class="price_style"><?php echo ($vo["book_price"]); ?></p>
                      
                  </div>
               </div>
          </div><?php endforeach; endif; ?>
        </div>
        <div align="center">
        <!-- <ul class="pagination">
          <li><a href="#">«</a></li>
          <li><a href="#" class="active">1</a></li>
          <li><a href="#">2</a></li>
          <li><a href="#">3</a></li>
          <li><a href="#">4</a></li>
          <li><a href="#">5</a></li>
          <li><a href="#">6</a></li>
          <li><a href="#">7</a></li>
          <li><a href="#">»</a></li>
        </ul> -->
        <?php echo ($show); ?>
        </div>
        <!-- 结束  --> 
          
      </div>
    </div> 
  </div>

         


   <div><!--底部了-->
  <div class="container" style="width:78%;padding:20px 0px 0px  0px ;height:25%;border-top:2px solid #2E3161;">
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