<?php
namespace Home\Controller;
use Think\Controller;
class MobController extends PublicController{
	function __construct(){   //构造方法   
        parent::__construct();
    }
    public function personal(){
        $mobile = parent::isMobile(); //实例化该方法 
        if($mobile=="true"){
            redirect(U('/Home/Login/index'));
        }else{
            header("Location: http://dear-wl.com.cn/bookstore/admin.php"); 
        }
       
    }
}