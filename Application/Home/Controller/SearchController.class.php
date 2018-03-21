<?php
namespace Home\Controller;
use Think\Controller;
class SearchController extends CommonController {
    public function index(){
        //处理搜索框
        if(IS_POST){
        	$search=I('post.search');
            // dump($search);
            // if($search==""){
            //     $time=array(array('time_id'=>1,'time'=>"时间从先到后"),array('time_id'=>2,'time'=>"价格从低到高"));
            //     $type=M('type')->select();
            //     $this->assign('time',$time);
            //     $this->assign('type',$type); 
            //     $this->display();
            //     return;
            // }
        	$where['book_name']=array('like','%'.$search.'%');//模糊查询
        	// $where['book_content']=array('like','%'.$search.'%');
        	$where['book_isdel']=array('like',0);
        	$where['book_state']=array('like',0);
        	$booksearch=M('book')->where($where)->select();
        	$i=0;
        	foreach ($booksearch as $key => $value) {
        		$i++;
        	}
        	for($j=0;$j<$i;$j++){
        		$saleuser=M('user')->where(array(
                    'user_id'=>$booksearch[$j]['user_id']
                    ))->field('user_id','user_name','user_photo')->find();
                if($booksearch[$j]['book_isname']==1){
                    $booksearch[$j]['sale_name']="匿名";
                    $booksearch[$j]['sale_photo']="isname.jpg";
                }else{
                    $booksearch[$j]['sale_name']=$saleuser['user_name'];
                    $booksearch[$j]['sale_photo']=$saleuser['user_photo'];
                }
                $booksearch[$j]['book_time']="20".date("y-m-d", $booksearch[$j]['book_time']);
                $booksearch[$j]['message_number']=M('message')->where(array('book_id'=>$booksearch[$j]['book_id']))->count();
        	}
        	$i=0;
            foreach ($booksearch as $key => $value) {
                 $i++;
             } 
             $n=$i-1;
             for($j=0;$j<$i;$j++){
                $bs[$j]=$booksearch[$n]; 
                $n--;
             }
            $type=M('type')->select();
            $time[0]=array('time_id'=>1,'time'=>"时间从先到后");
            $time[1]=array('time_id'=>2,'time'=>"价格从低到高");
            $this->assign('search',$search);
            $this->assign('time',$time);
            $this->assign('type',$type); 
        	$this->assign('book_search',$bs);
        	$this->display();
            return;
        }
        $time=array(array('time_id'=>1,'time'=>"时间从先到后"),array('time_id'=>2,'time'=>"价格从低到高"));
        $type=M('type')->select();
        $this->assign('time',$time);
        $this->assign('type',$type); 
        $this->display();
    }
    //处理组合查询
    public function search(){
        if(IS_POST){
            $search=I('post.content');
            $type_id=I('post.type_id');
            $time_id=I('post.time_id');
            // if($search==""){
            //     $time=array(array('time_id'=>1,'time'=>"时间从先到后"),array('time_id'=>2,'time'=>"价格从低到高"));
            //     $type=M('type')->select();
            //     $this->assign('time',$time);
            //     $this->assign('type',$type); 
            //     $this->display('index');
            //     return;
            // }
            $where['book_name']=array('like','%'.$search.'%');//模糊查询
            // $where['book_content']=array('like','%'.$search.'%');
            $where['book_isdel']=array('like',0);
            $where['book_state']=array('like',0);
            $booksearch=M('book')->where($where)->select();
            $i=0;
            foreach ($booksearch as $key => $value) {
                $i++;
            }
            for($j=0;$j<$i;$j++){
                $saleuser=M('user')->where(array(
                    'user_id'=>$booksearch[$j]['user_id']
                    ))->field('user_id','user_name','user_photo')->find();
                if($booksearch[$j]['book_isname']==1){
                    $booksearch[$j]['sale_name']="匿名";
                    $booksearch[$j]['sale_photo']="isname.jpg";
                }else{
                    $booksearch[$j]['sale_name']=$saleuser['user_name'];
                    $booksearch[$j]['sale_photo']=$saleuser['user_photo'];
                }
                $booksearch[$j]['book_time']="20".date("y-m-d", $booksearch[$j]['book_time']);
                $booksearch[$j]['message_number']=M('message')->where(array('book_id'=>$booksearch[$j]['book_id']))->count();
            }
            //最新更新书籍
            $time[0]=array('time_id'=>1,'time'=>"时间从先到后");
            $time[1]=array('time_id'=>2,'time'=>"价格从低到高");
            $type=M('type')->select();
            $i=0;
            foreach ($booksearch as $key => $value) {
                 $i++;
             } 
             $n=$i-1;
             for($j=0;$j<$i;$j++){
                $bs[$j]=$booksearch[$n]; 
                $n--;
             }
            if($time_id=="2"){
                for($j=1;$j<$i;$j++){
                    for($n=$i-1;$n>=$j;$n--){
                        if($bs[$n]['book_price']<$bs[$n-1]['book_price']){
                            $x=$bs[$n];
                            $bs[$n]=$bs[$n-1];
                            $bs[$n-1]=$x;
                        }
                    }
                }
                $time[0]=array('time_id'=>2,'time'=>"价格从低到高");
                $time[1]=array('time_id'=>1,'time'=>"时间从先到后");
            }
            $n=0;
            if($type_id!="1"){
                for($j=0;$j<$i;$j++){
                    if($bs[$j]['type_id']==$type_id){
                        $bstype[$n]=$bs[$j];
                        $n++;
                    }
                }
                $bs=$bstype;
                $typename=M('type')->where(array('type_id'=>$type_id))->find();
                $typeall=M('type')->select();
                $type[0]['type_id']=$type_id;
                $type[0]['type_name']=$typename['type_name'];
                $i=0;
                $n=1;
                foreach ($typeall as $key => $value) {
                    $i++;
                }
                for($j=0;$j<$i;$j++){
                    if($typeall[$j]['type_id']==$type_id){
                        ;
                    }else{
                        $type[$n]=$typeall[$j];
                        $n++;
                    }
                }
            }
            // dump($bs);
            $this->assign('search',$search);
            $this->assign('time',$time);
            $this->assign('type',$type); 
            $this->assign('book_search',$bs);
            $this->display('index');
            }
    }
    public function booktype(){
        if(IS_GET){
            $search="";
            $type_id=I('get.type_id');
            $where=array('book_isdel'=>0,'book_state'=>0);
            $booksearch=M('book')->where($where)->select();
            $i=0;
            foreach ($booksearch as $key => $value) {
                $i++;
            }
            for($j=0;$j<$i;$j++){
                $saleuser=M('user')->where(array(
                    'user_id'=>$booksearch[$j]['user_id']
                    ))->field('user_id','user_name','user_photo')->find();
                if($booksearch[$j]['book_isname']==1){
                    $booksearch[$j]['sale_name']="匿名";
                    $booksearch[$j]['sale_photo']="isname.jpg";
                }else{
                    $booksearch[$j]['sale_name']=$saleuser['user_name'];
                    $booksearch[$j]['sale_photo']=$saleuser['user_photo'];
                }
                $booksearch[$j]['book_time']="20".date("y-m-d", $booksearch[$j]['book_time']);
                $booksearch[$j]['message_number']=M('message')->where(array('book_id'=>$booksearch[$j]['book_id']))->count();
            }
            //最新更新书籍
            $time[0]=array('time_id'=>1,'time'=>"时间从先到后");
            $time[1]=array('time_id'=>2,'time'=>"价格从低到高");
            $type=M('type')->select();
            $i=0;
            foreach ($booksearch as $key => $value) {
                 $i++;
             } 
             $n=$i-1;
             for($j=0;$j<$i;$j++){
                $bs[$j]=$booksearch[$n]; 
                $n--;
             }
            $n=0;
            if($type_id!="1"){
                for($j=0;$j<$i;$j++){
                    if($bs[$j]['type_id']==$type_id){
                        $bstype[$n]=$bs[$j];
                        $n++;
                    }
                }
                $bs=$bstype;
                $typename=M('type')->where(array('type_id'=>$type_id))->find();
                $typeall=M('type')->select();
                $type[0]['type_id']=$type_id;
                $type[0]['type_name']=$typename['type_name'];
                $i=0;
                $n=1;
                foreach ($typeall as $key => $value) {
                    $i++;
                }
                for($j=0;$j<$i;$j++){
                    if($typeall[$j]['type_id']==$type_id){
                        ;
                    }else{
                        $type[$n]=$typeall[$j];
                        $n++;
                    }
                }
            }
            // dump($bs);
            $this->assign('search',$search);
            $this->assign('time',$time);
            $this->assign('type',$type); 
            $this->assign('book_search',$bs);
            $this->display('index');
            }
    }
}