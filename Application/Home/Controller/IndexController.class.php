<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $booknumber=M('book')->where(array('book_isdel'=>0,'book_state'=>0))->count();
        if($booknumber>10){
            $book=M('book')->where(array('book_isdel'=>0,'book_state'=>0))->limit($booknumber-10,$booknumber)->select();
        }else{
            $book=M('book')->where(array('book_isdel'=>0,'book_state'=>0))->select();
        }
        $i=0;
        foreach ($book as $key => $value) {
            $i++;
        }
        for($j=0;$j<$i;$j++){
            $saleuser=M('user')->where(array(
                'user_id'=>$book[$j]['user_id']
                ))->field('user_id','user_name','user_photo')->find();
            if($book[$j]['book_isname']==1){
                $book[$j]['sale_name']="匿名";
                $book[$j]['sale_photo']="isname.jpg";
            }else{
                $book[$j]['sale_name']=$saleuser['user_name'];
                $book[$j]['sale_photo']=$saleuser['user_photo'];
            }
            $book[$j]['book_time']="20".date("y-m-d", $book[$j]['book_time']);
            $book[$j]['message_number']=M('message')->where(array('book_id'=>$book[$j]['book_id']))->count();
        }
        $book=$this->change($book);
        $this->assign('book',$book);
        // $this->assign('user',$user);
        // dump($book);差一个留言的数量
    	$this->display();
    }
    public function leavemessage(){
        if(IS_AJAX){
            $message=$this->getleavemessage();
            if($message){
                M('message')->add($message);
                echo 1;
            }else{
                echo 0;
            }
        }else{
            $book_id=I('get.book_id');
            $this->assign('book_id',$book_id);
    	    $this->display();
        }
    }
    private function getleavemessage(){
        $message['book_id']=I('post.book_id');
        $re=M('book')->where(array(
            'book_id'=>$message['book_id'],
            'book_isdel'=>0,
            'book_state'=>0
            ))->find();
        if($re){
            $phone=$_COOKIE['user_phone'];
            $user_id=M('user')->where(array('user_phone'=>$phone))->find();
            $message['user_id']=$user_id['user_id'];
            $message['message_content']=I('post.message');
            $message['message_time']=time();
            return $message;
        }else{
            return false;
        }
        
    }
    public function makeorder(){
        if(IS_AJAX){
            $order=$this->getmakeorder();
            $re=M('order')->add($order);
            if($re){
                echo 1;
            }else{
                echo 0;
            }
        }else{
            $book_id=I('get.book_id');
            $phone=$_COOKIE['user_phone'];
            $user=M('user')->where(array('user_phone'=>$phone))->find();
            $book=M('book')->where(array('book_id'=>$book_id))->find();
            $this->assign('user',$user);
            $this->assign('book',$book);
            $this->assign('book_id',$book_id);
            $this->display();
        }
        
    }
     private function getmakeorder(){
        $order['book_id']=I('post.book_id');
        $re=M('book')->where(array(
            'book_id'=>$order['book_id'],
            'book_isdel'=>0,
            'book_state'=>0
            ))->find();
        if($re){
            $phone=$_COOKIE['user_phone'];
            $user_id=M('book')->where(array('book_id'=>$order['book_id']))->find();
            $order['user_id']=$user_id['user_id'];
            $buyuser_id=M('user')->where(array('user_phone'=>$phone))->find();
            $order['order_buyerid']=$buyuser_id['user_id'];
            $order['order_remark']=I('post.remark');
            $order['order_local']=I('post.local');
            $order['order_time']=time();
            M('book')->where(array('book_id'=>$order['book_id']))->save(array('book_state'=>2));
            $salename=M('user')->where(array('user_id'=>$user_id['user_id']))->field('user_name,user_phone')->find();
            $this->sendbuyorder($salename['user_name'],$user_id['book_name'],$phone,$salename['user_phone']);
            $this->sendsaleorder($buyuser_id['user_name'],$user_id['book_name'],$phone,$salename['user_phone']);
            return $order;
        }else{
            return false;
        }
        
    }
    private function sendbuyorder($name,$goods,$phone,$salephone){
        $url="http://dear-wl.com.cn/bookstore/index.php/home/Msg/buyorder?name=".$name."&phone=".$phone."&goods=".$goods."&salephone=".$salephone;
        $ch=curl_init(); 
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);//如果成功将结果返回,如果失败返回false
        curl_setopt($ch,CURLOPT_USERAGENT,"jb51.net's CURL Example beta");
        $data=curl_exec($ch);//行当前curl句柄的子连接
        curl_close($ch);//关闭一个curl会话
        return $data;
    }
    private function sendsaleorder($name,$goods,$phone,$salephone){
        $url="http://dear-wl.com.cn/bookstore/index.php/home/Msg/saleorder?name=".$name."&phone=".$phone."&goods=".$goods."&salephone=".$salephone;
        $ch=curl_init(); 
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);//如果成功将结果返回,如果失败返回false
        curl_setopt($ch,CURLOPT_USERAGENT,"jb51.net's CURL Example beta");
        $data=curl_exec($ch);//行当前curl句柄的子连接
        curl_close($ch);//关闭一个curl会话
        return $data;
    }
    public function shopcontent(){
        $book_id=I('get.book_id');
        $book_detal=M('book')->where(array('book_id'=>$book_id))->find();
        $book_detal['book_time']=date("m-d", $book_detal['book_time']);
        $message=M('message')->where(array('book_id'=>$book_id))->select();
        $user=M('user')->where(array('user_id'=>$book_detal['user_id']))->find();
        if($book_detal['book_isname']==1){
            $user['user_photo']="isname.jpg";
            $user['user_name']="匿名";
        }
        $i=0;
        foreach ($message as $key => $value) {
            $i++;
        }
        for($j=0;$j<$i;$j++){
            $photo=M('user')->where(array('user_id'=>$message[$j]['user_id']))->field('user_photo')->find();
            $message[$j]['user_photo']=$photo['user_photo'];

            $name=M('user')->where(array('user_id'=>$message[$j]['user_id']))->field('user_name')->find();
            $message[$j]['user_name']=$name['user_name'];
            $message[$j]['message_time']="20".date("y-m-d",$message[$j]['message_time']);
        }
        $this->assign('user',$user);
        $this->assign('message',$message);
        $this->assign('book_detal',$book_detal);
    	$this->display();
    }
    //树洞区
    public function shudong(){
        $hole=M('hole')->select();
        $i=0;
        foreach ($hole as $key => $value) {
            $i++;
        }
        for($j=0;$j<$i;$j++){
            $hole[$j]['hole_time']="20".date("y-m-d", $hole[$j]['hole_time']);
            $user=M('user')->where(array('user_id'=>$hole[$j]['user_id']))->find();
            if($hole[$j]['hole_anonymous']=="1"){//匿名
                $hole[$j]['user_name']="匿名";
                $hole[$j]['user_photo']="anonymous.jpg";
            }else{//不匿名
                $hole[$j]['user_name']=$user['user_name'];
                $hole[$j]['user_photo']=$user['user_photo'];
            }
            if($hole[$j]['hole_url']==""){
                $hole[$j]['hole_url']=-1;
            }
            $hole[$j]['number']=M('holemessage')->where(array('hole_id'=>$hole[$j]['hole_id']))->count();
        }
        $hole=$this->change($hole);
        $this->assign('hole',$hole);
    	$this->display();
    }
    public function addgoods(){
        if(IS_POST){
            $bookname=I('post.bookname');
            $auth=I('post.auth');
            $price=I('post.price');
            $old=I('post.old');
            $bookcontent=I('post.content');
            $booknumber=I('post.booknumber');
            $type_id=I('post.type_id');
            $isname=I('post.isname');
            $upload = new \Think\Upload(); // 实例化上传类
            $upload->maxSize = 1024*1024 ;// 设置附件上传大小 (-1) 是不限值大小
            $upload->exts = array(
            'jpg','gif','png','jpeg'
             );// 设置附件上传类型
            $upload->rootPath  = './Public/'; // 设置附件上传根目录
            $upload->savePath = 'uploads/';// 设置附件子目录上传目录
            $upload->replace = true; //存在同名文件是否是覆盖
            // 是否使用子目录保存上传文件
            $upload->autoSub = false;
            $info = $upload->upload();
            if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
            }else{// 上传成功 获取上传文件信息
                $filename="";
                 foreach($info as $file){
                    $filename = $file['savePath'].$file['savename'];
                 }
                $user_phone=cookie('user_phone');
                $user_id=M('user')->where(array('user_phone'=>$user_phone))->find();
                if(!$user_id){
                    $this->error("请不要玩小孩子的把戏");
                }
                if($isname=="1"){//选择匿名发布
                    $add=array(
                        'book_number'=>$booknumber,
                        'book_content'=>$bookcontent,
                        'book_name'=>$bookname,
                        'book_time'=>time(),
                        'book_urls'=>$filename,
                        'user_id'=>$user_id['user_id'],
                        'book_isname'=>1,
                        'book_old'=>$old,
                        'book_author'=>$auth,
                        'book_price'=>$price,
                        'type_id'=>$type_id
                        );
                   
                    $re=M('book')->add($add);
                    $this->redirect('Home/Index/index');
                }else{//非匿名发布
                    $add=array(
                        'book_number'=>$booknumber,
                        'book_content'=>$bookcontent,
                        'book_name'=>$bookname,
                        'book_time'=>time(),
                        'book_urls'=>$filename,
                        'user_id'=>$user_id['user_id'],
                        'book_isname'=>0,
                        'book_old'=>$old,
                        'book_author'=>$auth,
                        'book_price'=>$price,
                        'type_id'=>$type_id
                        );
                    $re=M('book')->add($add);
                    $this->redirect('Home/Index/index');
                }
            }
        }
        $type=M('type')->select();
        $this->assign('type',$type);
        $this->display();
    }
    public function personal1(){
        if(IS_POST){
            $name=I('post.name');
            $user_phone=cookie('user_phone');
            $user_id=M('user')->where(array('user_phone'=>$user_phone))->find();
            $re=M('user')->where(array('user_id'=>$user_id['user_id']))->save(array('user_name'=>$name));
            $this->redirect('Home/Index/personal');
        }else{
            $this->error("不要乱玩");
        }
    }
    //书籍留言并入
    public function personal(){
        if(IS_POST){
            $upload = new \Think\Upload(); // 实例化上传类
            $upload->maxSize = 1024*1024 ;// 设置附件上传大小 (-1) 是不限值大小
            $upload->exts = array(
            'jpg','gif','png','jpeg'
             );// 设置附件上传类型
            $upload->rootPath  = './Public/'; // 设置附件上传根目录
            $upload->savePath = 'uploads/';// 设置附件子目录上传目录
            $upload->replace = true; //存在同名文件是否是覆盖
            // 是否使用子目录保存上传文件
            $upload->autoSub = false;
            $info = $upload->upload();
            if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
            }else{// 上传成功 获取上传文件信息
                $filename="";
                 foreach($info as $file){
                    $filename = $file['savePath'].$file['savename'];
                 }
                $user_phone=cookie('user_phone');
                $user_id=M('user')->where(array('user_phone'=>$user_phone))->find();
                if(!$user_id){
                    $this->error("请不要玩小孩子的把戏");
                }
                $save=array(
                    'user_photo'=>$filename
                    );
                $re=M('user')->where(array('user_id'=>$user_id['user_id']))->save($save);
                $this->redirect('Home/Index/personal');
            }
        }
        $user_phone=cookie('user_phone');
        $user=M('user')->where(array('user_phone'=>$user_phone))->find();
        $nowbook=M('book')->where(array(
            'user_id'=>$user['user_id'],
            'book_state'=>0,
            'book_isdel'=>0
            ))->count();
        $solebook=M('order')->where(array(
            'order_buyerid'=>$user['user_id']
            ))->count();
        $ordernum=M('order')->where(array(
            'user_id'=>$user['user_id']
            ))->count();
        $bookmessage=M('book')->where(array(
            'user_id'=>$user['user_id']
            ))->field('book_id')->select();
        $i=0;
        foreach ($bookmessage as $key => $value) {
            $i++;
        }
        $messagenum=0;//别人回复他书籍的留言条数
        for($j=0;$j<$i;$j++){
            $messagenum+=M('message')->where(array(
            'book_id'=>$bookmessage[$j]['book_id']
            ))->count();
        }
        
        $this->assign('user',$user);
        $this->assign('nowbook',$nowbook);
        $this->assign('solebook',$solebook);
        $this->assign('ordernum',$ordernum);
        $this->assign('messagenum',$messagenum);
        $this->display();
    }
    public function holemessage(){
        if(IS_POST){
            $content=I('post.content');
            $isname=I('post.isname');
            $up=I('post.is');
            if($up){
                $upload = new \Think\Upload(); // 实例化上传类
                $upload->maxSize = 1024*1024 ;// 设置附件上传大小 (-1) 是不限值大小
                $upload->exts = array(
                'jpg','gif','png','jpeg'
                 );// 设置附件上传类型
                $upload->rootPath  = './Public/'; // 设置附件上传根目录
                $upload->savePath = 'uploads/';// 设置附件子目录上传目录
                $upload->replace = true; //存在同名文件是否是覆盖
                // 是否使用子目录保存上传文件
                $upload->autoSub = false;
                $info = $upload->upload();
                if(!$info) {// 上传错误提示错误信息
                $this->error($upload->getError());
                }else{// 上传成功 获取上传文件信息
                    $filename="";
                     foreach($info as $file){
                        $filename = $file['savePath'].$file['savename'];
                     }
                    $user_phone=cookie('user_phone');
                    $user_id=M('user')->where(array('user_phone'=>$user_phone))->field('user_id')->find();
                    if(!$user_id){
                        $this->error("请不要玩小孩子的把戏");
                    }
                    if($isname=="1"){//选择匿名发布
                        $add=array(
                            'user_id'=>$user_id['user_id'],
                            'hole_message'=>$content,
                            'hole_time'=>time(),
                            'hole_anonymous'=>1,
                            'hole_url'=>$filename
                            );
                        $re=M('hole')->add($add);
                        $this->redirect('Home/Index/shudong');
                    }else{//非匿名发布
                        $add=array(
                            'user_id'=>$user_id['user_id'],
                            'hole_message'=>$content,
                            'hole_time'=>time(),
                            'hole_anonymous'=>1,
                            'hole_url'=>$filename
                            );
                        $re=M('hole')->add($add);
                        $this->redirect('Home/Index/shudong');
                    }
                }
            }else{//没有发布图片
                $user_phone=cookie('user_phone');
                $user_id=M('user')->where(array('user_phone'=>$user_phone))->field('user_id')->find();
                $add=array(
                            'user_id'=>$user_id['user_id'],
                            'hole_message'=>$content,
                            'hole_time'=>time(),
                            'hole_anonymous'=>1,
                            'hole_url'=>$filename
                            );
                $re=M('hole')->add($add);
                $this->redirect('Home/Index/shudong');
            }
            
        }
        return;
    }

    //树洞详情
    public function shudongcontent(){
        $hole_id=I('get.hole_id');
        $hole=M('hole')->where(array('hole_id'=>$hole_id))->find();
        $hole['hole_time']="20".date("y-m-d", $hole['hole_time']);
        $user=M('user')->where(array('user_id'=>$hole['user_id']))->find();
        if($hole['hole_anonymous']=="1"){//匿名
            $hole['user_name']="匿名";
            $hole['user_photo']="anonymous.jpg";
        }else{//不匿名
            $hole['user_name']=$user['user_name'];
            $hole['user_photo']=$user['user_photo'];
        }
        if($hole['hole_url']==""){
            $hole['hole_url']=-1;
        }
        $holemessage=M('holemessage')->where(array('hole_id'=>$hole['hole_id']))->select();
        $i=0;
        foreach ($holemessage as $key => $value) {
            $i++;
        }
        //此处树洞留言默认直接给不匿名
        for($j=0;$j<$i;$j++){
            $user_id=$holemessage[$j]['holemessage_user'];
            $user=M('user')->where(array('user_id'=>$user_id))->find();
            $holemessage[$j]['user_name']=$user['user_name'];
            $holemessage[$j]['user_photo']=$user['user_photo'];
            $holemessage[$j]['holemessage_time']="20".date("y-m-d", $holemessage[$j]['holemessage_time']);
        }
        $this->assign('hole',$hole);
        $this->assign('holemessage',$holemessage);
        $this->display();
    }
    public function leavehole(){
        if(IS_AJAX){
            $message=$this->getleavehole();
            if($message){
                M('holemessage')->add($message);
                echo 1;
            }else{
                echo 0;
            }
        }else{
            $hole_id=I('get.hole_id');
            $this->assign('hole_id',$hole_id);
            $this->display();
        }
    }
    private function getleavehole(){
        $message['hole_id']=I('post.hole_id');
        $phone=$_COOKIE['user_phone'];
        $user_id=M('user')->where(array('user_phone'=>$phone))->find();
        $message['holemessage_user']=$user_id['user_id'];
        $message['holemessage_message']=I('post.message');
        $message['holemessage_time']=time();
        return $message;
    }
      //树洞留言
    public function message(){
        $phone=$_COOKIE['user_phone'];
        $user_id=M('user')->where(array('user_phone'=>$phone))->find();
        $hole=M('hole')->where(array('user_id'=>$user_id['user_id']))->field('hole_message,hole_id')->select();
        $i=0;
        $holemessage=array();
        foreach ($hole as $key => $value) {
            $i++;
        }
        $n=0;
        for($j=0;$j<$i;$j++){
            $message=M('holemessage')->where(array('hole_id'=>$hole[$j]['hole_id']))->select();
            foreach ($message as $key => $value) {
                $holemessage[$n]['user_id']=$value['holemessage_user'];
                $us=M('user')->where(array('user_id'=>$value['holemessage_user']))->field('user_name,user_photo')->find();
                $holemessage[$n]['user_name']=$us['user_name'];
                $holemessage[$n]['user_photo']=$us['user_photo'];
                $holemessage[$n]['holemessage_message']=$value['holemessage_message'];
                $holemessage[$n]['holemessage_time']="20".date("y-m-d H:i:s",$value['holemessage_time']);
                $holemessage[$n]['hole_id']=$hole[$j]['hole_id'];
                $content=M('hole')->where(array('hole_id'=>$hole[$j]['hole_id']))->field('hole_message')->find();
                $holemessage[$n]['hole_message']=$content['hole_message'];
                $n++;
            }
        }
        $this->assign('holemessage',$holemessage);
        $this->display();
    }
    public function orderlist(){
        $phone=$_COOKIE['user_phone'];
        $user=M('user')->where(array('user_phone'=>$phone))->find();
        $order=M('order')->where(array('user_id'=>$user['user_id']))->select();
        $i=0;
        foreach ($order as $key => $value) {
            $i++;
        }
        for($j=0;$j<$i;$j++){
            $us=M('user')->where(array('user_id'=>$order[$j]['user_id']))->field('user_name,user_photo')->find();
            $orderlist[$j]['user_name']=$us['user_name'];
            $orderlist[$j]['user_photo']=$us['user_photo'];
            $book=M('book')->where(array('book_id'=>$order[$j]['book_id']))->field('book_name,book_author,book_price,book_urls')->find();
            $orderlist[$j]['book_name']=$book['book_name'];
            $orderlist[$j]['order_id']=$order[$j]['order_id'];
            $orderlist[$j]['book_author']=$book['book_author'];
            $orderlist[$j]['book_price']=$book['book_price'];
            $orderlist[$j]['book_urls']=$book['book_urls'];
            $orderlist[$j]['time']="20".date("y-m-d H:i:s",$order[$j]['order_time']);
        }
        $this->assign('orderlist',$orderlist);
        $this->display();
    }
    public function ordercontent(){
        $order_id=I('get.order_id');
        $order=M('order')->where(array('order_id'=>$order_id))->find();
        $us=M('user')->where(array('user_id'=>$order['user_id']))->field('user_name,user_photo')->find();
        $order['user_name']=$us['user_name'];
        $order['time']="20".date("y-m-d H:i:s",$order['order_time']);
        $order['user_photo']=$us['user_photo'];
        $book=M('book')->where(array('book_id'=>$order['book_id']))->find();
        $this->assign('book',$book);
        $this->assign('order',$order);
        $this->display();
    }
    public function insalebook(){
        if(IS_POST){
            $book_id=I('post.book_id');
            $re=M('book')->where(array('book_id'=>$book_id))->save(array('book_state'=>1));
            if($re){
                echo 1;
            }else{
                echo 0;
            }
        }
        $phone=$_COOKIE['user_phone'];
        $user=M('user')->where(array('user_phone'=>$phone))->find();
        $book=M('book')->where(array('user_id'=>$user['user_id'],'book_isdel'=>0,'book_state'=>0))->select();
        // dump($book);
        // die;
        $this->assign('book',$book);
        $this->display();
    }
    public function buybook(){
        $phone=$_COOKIE['user_phone'];
        $user=M('user')->where(array('user_phone'=>$phone))->find();
        $book_id=M('order')->where(array('order_buyerid'=>$user['user_id']))->field('book_id')->select();
        $i=0;
        // dump($book_id);
        // die;
        foreach ($book_id as $key => $value) {
            # code...
            $i++;
        }
        for($j=0;$j<$i;$j++){
            $book[$j]=M('book')->where(array('book_id'=>$book_id[$j]['book_id']))->find();
        }
        // dump($book);
        // die;
        $this->assign('book',$book);
        $this->display();
    }
    public function bookmessage(){
        // $phone=$_COOKIE['user_phone'];
        // $user=M('user')->where(array('user_phone'=>$phone))->find();
        // $book_id=M('book')->where(array('user_id'=>$user['user_id']))->field('book_id,book_name')->select();
        // $i=0;
        // foreach ($book_id as $key => $value) {
        //     # code...
        //     $i++;
        // }
        // $n=0;
        // for($j=0;$j<$i;$j++){
        //     $book=M('message')->where(array('book_id'=>$book_id[$j]['book_id']))->find();
        //     $message[$n]['message_content']=$book['message_content'];
        //     $message[$n]['message_time']="20".date("y-m-d H:i:s",$book['message_time']);
        //     $message[$n]['book_id']=$book['book_id'];
        //     $bo=M('book')->where(array('book_id'=>$book_id[$j]['book_id']))->field('book_name')->find();
        //     $message[$n]['book_name']=$bo['book_name'];
        //     $user=M('user')->where(array('user_id'=>$book_id[$j]['user_id']))->field('user_name,user_photo')->find();
        //     $message[$n]['user_name']=$user['user_name'];
        //     $message[$n]['user_photo']=$user['user_photo'];
        //     // if($message[$n]['user_id']){
        //     //     $n++;
        //     // }
        //     $n++;
        // }
        // dump($message);
        // die;
        $this->assign('bookmessage',$message);
        $this->display();
    }
    //封装转换类
    private function change($changearr){
        $i=0;
        $n=0;
        foreach ($changearr as $key => $value) {
            $i++;
        }
        $n=$i-1;
        for($j=0;$j<$i;$j++){
            $arr[$j]=$changearr[$n];
            $n--;
        }
        return $arr;
    }
    public function text(){
        $this->display();
    }
    //   private function requestAndCheck($url, $method = 'GET', $fields = [])
    // {
    //     $return = $this->httpRequest($url, $method, $fields);
    //     if ($return === false) {
    //         if ($this->debug) {
    //             $this->setError("http请求出错！ " . Requests::$error);
    //         } else {
    //             $this->setError("http请求出错！");
    //         }
    //         return false;
    //     }

    //     $wxdata = json_decode($return, true);
    //     $this->debug && $this->logDebugFile(['url' => $url,'fields' => $fields,'wxdata' => $wxdata]);
    //     if (isset($wxdata['errcode']) && $wxdata['errcode'] != 0) {
    //         if ($wxdata['errcode'] == 40001) {
    //             $this->config['web_expires'] = 0;
    //             M('wx_user')->where('id', $this->config['id'])->save(['web_expires' => 0]);//token错误
    //         }
    //         if ($this->debug) {
    //             $this->setError("微信错误代码：{$wxdata['errcode']};<br>错误信息：{$wxdata['errmsg']}<br>请求链接：$url");
    //         } else {
    //             $this->setError("操作失败，微信错误码：{$wxdata['errcode']};");
    //         }
    //         return false;
    //     }

    //     if (strtoupper($method) === 'GET' && empty($wxdata)) {
    //         if ($this->debug) {
    //             $this->setError("微信http请求返回为空！请求链接：$url");
    //         } else {
    //             $this->setError("微信http请求返回为空！操作失败");
    //         }
    //         return false;
    //     }

    //     return $wxdata;
    // }
    //     /**
    //  * http请求
    //  * @param type $url
    //  * @param type $method
    //  * @param type $fields
    //  * @return 
    //  */
    // private function httpRequest($url, $method = 'GET', $fields = [])
    // {
    //     $ch = curl_init();
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);

    //     $method = strtoupper($method);
    //     if ($method == 'GET' && !empty($fields)) {
    //         is_array($fields) && $fields = http_build_query($fields);
    //         $url = $url . (strpos($url,"?")===false ? "?" : "&") . $fields;
    //     }
    //     curl_setopt($ch, CURLOPT_URL, $url);

    //     if ($method != 'GET') {
    //         curl_setopt($ch, CURLOPT_POST, true);
    //         if (!empty($fields)) {
    //             if (is_array($fields)) {
    //                 $hadFile = false;
    //                 /* 支持文件上传 */
    //                 if (class_exists('\CURLFile')) {
    //                     curl_setopt($ch, CURLOPT_SAFE_UPLOAD, true);
    //                     foreach ($fields as $key => $value) {
    //                         if ($this->isPostHasFile($value)) {
    //                             $fields[$key] = new \CURLFile(realpath(ltrim($value, '@')));
    //                             $hadFile = true;
    //                         }
    //                     }
    //                 } elseif (defined('CURLOPT_SAFE_UPLOAD')) {
    //                     if ($this->isPostHasFile($value)) {
    //                         curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false);
    //                         $hadFile = true;
    //                     }
    //                 }
    //             }
    //             $fields = (!$hadFile && is_array($fields)) ? http_build_query($fields) : $fields;
    //             curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    //         }
    //     }

    //     /* 关闭https验证 */
    //     if ("https" == substr($url, 0, 5)) {
    //         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    //     }

    //     $content = curl_exec($ch);
    //     curl_close($ch);

    //     return $content;
    // }
    //  /**
    //  * 上传临时材料（3天内有效）
    //  * 文档：https://mp.weixin.qq.com/wiki?action=doc&id=mp1444738726
    //  * @parem type $path 素材地址
    //  * @param string $type 类型有image,voice,video,thumb
    //  * @return {"type":"TYPE","media_id":"MEDIA_ID","created_at":123456789}
    //  */
    // public function uploadTempMaterial($path, $type = 'image')
    // {
    //     if (!($access_token = $this->getAccessToken())) {
    //         return false;
    //     }
        
    //     $post_arr = ['media' => '@'.$path];  
    //     $url ="https://api.weixin.qq.com/cgi-bin/media/upload?access_token={$access_token}&type={$type}";
    //     $return = $this->requestAndCheck($url, 'POST', $post_arr);
    //     if ($return === false) {
    //         return false;
    //     }
        
    //     return $return;
    // }
    // /**
    //  * 创建图片回复消息
    //  * @param type $fromUser
    //  * @param type $toUser
    //  * @param type $mediaId
    //  * @return type
    //  */
    // public function createReplyMsgOfImage($fromUser, $toUser, $mediaId)
    // {
    //     $time = time();
    //     $template = 
    //         "<xml>
    //         <ToUserName><![CDATA[$toUser]]></ToUserName>
    //         <FromUserName><![CDATA[$fromUser]]></FromUserName>
    //         <CreateTime>$time</CreateTime>
    //         <MsgType><![CDATA[image]]></MsgType>
    //         <Image>
    //         <MediaId><![CDATA[$mediaId]]></MediaId>
    //         </Image>
    //         </xml>";
    //     return $template;    
    // }
}