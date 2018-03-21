<?php
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller {
    public function index(){
    	if(IS_AJAX){
    		$account=I('post.account');
	    	$password=I('post.password');
	    	$password=md5($password);
	    	$user=M('user')->where(array('user_phone'=>$account,'user_password'=>$password))->find();
	    	if($user){
	    		cookie('user_phone',$user['user_phone'],3600);
		        $user_cookie=md5($user['user_phone'].time());
		        cookie('user_cookie',$user_cookie,3600); //指定cookie保存时间
		        $re=M('user')->where(array('user_id'=>$user['user_id']))->save(array('user_cookie'=>$user_cookie));
		        echo 1;
	    	}
	    	else{
	    		echo 0;
	    	}
			return;
    	}
    	$this->display();
    }
    public function register(){
    	if(IS_POST){
    		$phone=I('post.phone');
    		$re=M('user')->where(array('user_phone'=>$phone))->find();
    		if($re){
    			echo -1;//该用户已经注册
    		}else{
    			$co=M('code')->where(array('code_phone'=>$phone))->find();
    			if($co){//验证码存在，看是否超过60*10s
    				if(($co['code_time']+600)>time()){//有效期内
    					$code=$co['code_code'];
    					$this->sendcode($phone,$code);
    				}else{//过期重新获取
    					$code=rand(100000, 999999);
    					M('code')->where(array('code_id'=>$co['code_id']))->save(array('code_code'=>$code,'code_time'=>time()));
    					$this->sendcode($phone,$code);

    				}
    			}else{//验证码不存在
    				$code=rand(100000, 999999);
    				M('code')->add(array('code_phone'=>$phone,'code_time'=>time(),'code_code'=>$code));
    					$this->sendcode($phone,$code);
    			}
    		}
    		return;
    	}
    	$this->display();
    }
    public function check(){
    	 if(IS_AJAX){
    		$phone=I('post.phone');
    		$code=I('post.code');
    		$password=I('post.password');
    		//防止重复
    		$re=M('user')->where(array('user_phone'=>$phone))->find();
    		$check=M('code')->where(array('code_phone'=>$phone))->find();
    		// dump($check.$phone);
    		if($re){//用户已经存在
    			echo -1;
    		}else{
    			if(($code==$check['code_code'])&&($check['code_time']+600>time())){
    				cookie('user_phone',$phone,3600);
			        $user_cookie=md5($phone.time());
			        cookie('user_cookie',$user_cookie,3600); //
	    			$re=M('user')->add(array(
	    				'user_name'=>"Ybook",
	    				'user_phone'=>$phone,
	    				'user_password'=>md5($password),
	    				'user_photo'=>'isname.jpg',
	    				'user_cookie'=>$user_cookie,
	    				'user_time'=>time()
	    				));
	    			echo 1;
    		}else{
    			echo -2;//验证码不正确或过期
    		}
    		}
    	}
    }
    private function sendcode($phone,$code){
		$url="http://dear-wl.com.cn/bookstore/index.php/home/Msg/msg?code=".$code."&phone=".$phone;
		$ch=curl_init(); 
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);//如果成功将结果返回,如果失败返回false
		curl_setopt($ch,CURLOPT_USERAGENT,"jb51.net's CURL Example beta");
		$data=curl_exec($ch);//行当前curl句柄的子连接
		curl_close($ch);//关闭一个curl会话
		return $data;
	}
	//找回密码
    public function findsecret(){
    	if(IS_POST){
    		$phone=I('post.phone');
    		$user=M('user')->where(array('user_phone'=>$phone))->find();
    		if($user){//用户存在
    			$refind=M('findcode')->where(array('findcode_phone'=>$phone))->find();
    			if($refind){//验证码手机存在
    				if(($refind['findcode_time']+600)>time()){//有效期内
    					$code=$refind['findcode_code'];
    					$this->sendfind($phone,$code);
    				}else{//过期重新获取
    					$code=rand(100000, 999999);
    					M('findcode')->where(array('findcode_id'=>$refind['findcode_id']))->save(array('findcode_code'=>$code,'findcode_time'=>time()));
    					$this->sendfind($phone,$code);

    				}
    			}else{//验证码手机不存在
    				$code=rand(100000, 999999);
    				M('findcode')->add(array('findcode_phone'=>$phone,'findcode_time'=>time(),'findcode_code'=>$code));
    				$this->sendfind($phone,$code);
    			}
    			echo 1;
    		}else{//用户不存在
    			echo -1;
    		}
    		return;
    	}
    	$this->display();
    }
    private function sendfind($phone,$code){
		$url="http://dear-wl.com.cn/bookstore/index.php/home/Msg/findcode?code=".$code."&phone=".$phone;
		$ch=curl_init(); 
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);//如果成功将结果返回,如果失败返回false
		curl_setopt($ch,CURLOPT_USERAGENT,"jb51.net's CURL Example beta");
		$data=curl_exec($ch);//行当前curl句柄的子连接
		curl_close($ch);//关闭一个curl会话
		return $data;
	}
	public function findcheck(){
		if(IS_AJAX){
			$phone=I('post.phone');
			$code=I('post.code');
			$password=I('post.password');
			$user=M('user')->where(array('user_phone'=>$phone))->find();
			if($user){//用户存在
				$check=M('findcode')->where(array('findecode_phone'=>$phone))->find();
				if(($code==$check['findcode_code'])&&($check['findcode_time']+600>time())){//验证码存在且没有过期
					$re=M('user')->where(array('user_phone'=>$phone))->save(array(
						'user_password'=>md5($password)
						));
				}else{//验证码不存在
					echo -2;
				}
			}else{//用户不存在
				echo -1;
			}
			return;
		}
	}
}