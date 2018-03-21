<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends CommonController {
    public function index(){
         $booknumber=M('book')->where(array('book_isdel'=>0,'book_state'=>0))->count();
        if($booknumber>12){
            $book=M('book')->where(array('book_isdel'=>0,'book_state'=>0))->limit($booknumber-12,$booknumber)->select();
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
        //留言新的6条
        $message=M('message')->count();
        if($message>=6){
            $msg=M('message')->limit($message-6,$message)->select();
        }else{
            $msg=M('message')->select();
        }
        $i=0;
        foreach ($msg as $key => $value) {
        	$i++;
        }
        for($j=0;$j<$i;$j++){
        	$user=M('user')->where(array('user_id'=>$msg[$j]['user_id']))->field('user_name,user_photo')->find();
        	$msg[$j]['user_name']=$user['user_name'];
        	$msg[$j]['user_photo']=$user['user_photo'];
        	$msg[$j]['message_time']="20".date("y-m-d", $msg[$j]['message_time']);
        }
        $msg=$this->change($msg);
        $book=$this->change($book);
        $this->assign('message',$msg);
        $this->assign('book',$book);
        // $this->assign('user',$user);
        // dump($book);差一个留言的数量
    	$this->display();
    }
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
    public function findsercet(){
    	$this->display();
    }
    public function login(){
    	$this->display();
    }
      public function personal1(){
        if(IS_POST){
            $name=I('post.name');
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
            }

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
            $type_id=M('type')->select();
            $this->assign('type_id',$type_id);
        }
        $user_phone=cookie('user_phone');
        $user=M('user')->where(array('user_phone'=>$user_phone))->find();
        $nowbook=M('book')->where(array(
            'user_id'=>$user['user_id'],
            'book_state'=>0,
            'book_isdel'=>0
            ))->count();
        $solebook=M('book')->where(array(
            'user_id'=>$user['user_id'],
            'book_state'=>2,
            'book_isdel'=>0
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
        $phone=$_COOKIE['user_phone'];
        $user=M('user')->where(array('user_phone'=>$phone))->find();
        $book=M('book')->where(array('user_id'=>$user['user_id'],'book_isdel'=>0,'book_state'=>0))->select();
        // dump($book);
        // die;
        $this->assign('book',$book);
        $type=M('type')->select();
        $this->assign('type',$type);
        $this->assign('user',$user);
        $this->assign('nowbook',$nowbook);
        $this->assign('solebook',$solebook);
        $this->assign('ordernum',$ordernum);
        $this->assign('messagenum',$messagenum);
        $this->display();
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
        $i=0;
        foreach ($message as $key => $value) {
            # code...
            $i++;
        }
        // dump($book_detal);
        // die;
        $this->assign('user',$user);
        $this->assign('message',$message);
        $this->assign('count',$i);
        $this->assign('book_detal',$book_detal);
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
            // dump($book);
            // dump($user);
            // die;
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
    }
    public function loginout(){
        cookie(null);
        $this->redirect('Home/Login/index');
    }
}