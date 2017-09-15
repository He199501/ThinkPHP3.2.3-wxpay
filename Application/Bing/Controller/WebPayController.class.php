<?php

namespace Bing\Controller;

use Think\Controller;

class WebPayController extends Controller
{
    public function index()
    {
        ini_set('date.timezone', 'Asia/Shanghai');
        Vendor('weixin.WxPayApi');
        Vendor('weixin.JsApiPay');

        //①、获取用户openid
        $tools = new \JsApiPay();
        $SceneAttr = array(
            "h5_info" => "h5_info",
            "type" => "Wap",
            "wap_url" => "http://www.eshenghuo365.com",
            "wap_name" => "e生活"
        );
        $client_ip = get_client_ip();
        $scene = json_encode($SceneAttr);
        //②、统一下单
        $input = new \WxPayUnifiedOrder();
        $input->SetBody("腾讯充值中心-QQ会员充值");
        $input->SetAttach("test");
        $input->SetOut_trade_no(\WxPayConfig::MCHID . date("YmdHis"));
        $input->SetTotal_fee("10");
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag("test");
        $input->SetNotify_url("http://paysdk.weixin.qq.com/example/notify.php");
        $input->SetTrade_type("MWEB");
        $input->SetClient_ip($client_ip);
        $input->SetScene_info($scene);
        $order = \WxPayApi::unifiedOrder($input);
        dump($order);//这边返回成功可以下一步操作
//        $jsApiParameters = $tools->GetJsApiParameters($order);
//        dump($jsApiParameters);
    }
}