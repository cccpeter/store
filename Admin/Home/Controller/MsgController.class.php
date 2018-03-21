<?php
namespace Home\Controller;
use Think\Controller;
/*
短信接口
 */
class MsgController extends Controller {
   public function msg(){
        $code=I('get.code');
        $phone=I('get.phone');
        import('Org.Alidayu.top.TopClient');
        import('Org.Alidayu.top.ResultSet');
        import('Org.Alidayu.top.RequestCheckUtil');
        import('Org.Alidayu.top.TopLogger');
        import('Org.Alidayu.top.request.AlibabaAliqinFcSmsNumSendRequest');
        $c = new \TopClient;
        // $c->appkey = '23533574';//我的  
        $c->appkey = '23738944';  
        // $c->secretKey = '6b83f50be2c729481802a688e8152a14';//我的
        $c->secretKey = '6498f05cea7f37e816a3331c8f2a29fd';
        $req = new \AlibabaAliqinFcSmsNumSendRequest;
        $req ->setExtend( "" );
        $req ->setSmsType( "normal" );
        $req ->setSmsFreeSignName( "书store" ); 
        //来源于配置短信签名 下面列表中有签名名称
        $req ->setSmsParam("{code:'$code'}"); //变量来源于 配置短信模板 点击列表中的详情 模板内容的变量
        // $req ->setSmsParam( "{user_name:'$user_name',hotel_name:'$hotel_name',room_type:'$room_type',count:'$count'}"); //变量来源于 配置短信模板 我的点击列表中的详情 模板内容的变量
        $req ->setRecNum( $phone ); //手机号
        // $req ->setSmsTemplateCode("SMS_26315002"); //配置短信模板 列表中有模板id我的
        $req ->setSmsTemplateCode( "SMS_60380404" ); //配置短信模板 列表中有模板id
        $resp = $c ->execute( $req );
    }
    public function findcode(){//找回密码
        $code=I('get.code');
        $phone=I('get.phone');
        import('Org.Alidayu.top.TopClient');
        import('Org.Alidayu.top.ResultSet');
        import('Org.Alidayu.top.RequestCheckUtil');
        import('Org.Alidayu.top.TopLogger');
        import('Org.Alidayu.top.request.AlibabaAliqinFcSmsNumSendRequest');
        $c = new \TopClient; 
        $c->appkey = '23756236';  
        // $c->secretKey = '6b83f50be2c729481802a688e8152a14';//我的
        $c->secretKey = '1dd23682aa78a630211bce2cc80196a0';
        $req = new \AlibabaAliqinFcSmsNumSendRequest;
        $req ->setExtend( "" );
        $req ->setSmsType( "normal" );
        $req ->setSmsFreeSignName( "书store" ); 
        //来源于配置短信签名 下面列表中有签名名称
        $req ->setSmsParam("{code:'$code'}"); //变量来源于 配置短信模板 点击列表中的详情 模板内容的变量
        // $req ->setSmsParam( "{user_name:'$user_name',hotel_name:'$hotel_name',room_type:'$room_type',count:'$count'}"); //变量来源于 配置短信模板 我的点击列表中的详情 模板内容的变量
        $req ->setRecNum( $phone ); //手机号
        $req ->setSmsTemplateCode( "SMS_62255204" ); //配置短信模板 列表中有模板id
        $resp = $c ->execute( $req );
    }
    public function saleorder(){
        $name=I('get.name');
        $buyphone=I('get.phone');
        $goods=I('get.goods');
        $salephone=I('get.salephone');
        import('Org.Alidayu.top.TopClient');
        import('Org.Alidayu.top.ResultSet');
        import('Org.Alidayu.top.RequestCheckUtil');
        import('Org.Alidayu.top.TopLogger');
        import('Org.Alidayu.top.request.AlibabaAliqinFcSmsNumSendRequest');
        $c = new \TopClient;
        $c ->appkey ="23738350";
        $c ->secretKey ="c678a195c69d9b5af603f18c723c4827";
        $req = new \AlibabaAliqinFcSmsNumSendRequest;
        $req ->setExtend( "" );
        $req ->setSmsType( "normal" );
        $req ->setSmsFreeSignName( "书store" );
        $req ->setSmsParam( "{name:'$name',phone:'$buyphone',goods:'$goods'}" );
        $req ->setRecNum( $salephone );
        $req ->setSmsTemplateCode( "SMS_60275179" ); 
        $resp = $c ->execute( $req );
    }
    //买家订单通知
     public function buyorder(){
        $name=I('get.name');
        $buyphone=I('get.phone');
        $goods=I('get.goods');
        $salephone=I('get.salephone');
        import('Org.Alidayu.top.TopClient');
        import('Org.Alidayu.top.ResultSet');
        import('Org.Alidayu.top.RequestCheckUtil');
        import('Org.Alidayu.top.TopLogger');
        import('Org.Alidayu.top.request.AlibabaAliqinFcSmsNumSendRequest');
        $c = new \TopClient;
        $c ->appkey ="23755510";
        $c ->secretKey ="7b79a7aa0b38f93cf6e21cb69d5d27ae";
        $req = new \AlibabaAliqinFcSmsNumSendRequest;
        $req ->setExtend( "" );
        $req ->setSmsType( "normal" );
        $req ->setSmsFreeSignName( "书store" );
        $req ->setSmsParam( "{name:'$name',goods:'$goods',phone:'$salephone'}" ); 
        $req ->setRecNum($buyphone);//买家订单通知
        $req ->setSmsTemplateCode( "SMS_61025156" );
        $resp = $c ->execute( $req );
    }
}