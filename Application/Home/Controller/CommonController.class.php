<?php
namespace Home\Controller;
use Think\Controller;
Class CommonController extends Controller {
	Public function  _initialize(){
		if(!isset($_COOKIE['user_phone'])&&!isset($_COOKIE['user_cookie'])){
       		redirect(U('/Home/Login/index'));
       }
	}
}
