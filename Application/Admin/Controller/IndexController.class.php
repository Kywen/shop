<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {
	//默认跳转至login界面
	public function index(){
        $this->redirect("Index/login");
    }
    //登录验证
    public function login_confirm(){
    	//启动session
        session_start();
        //接收form表单提交信息
        $U = I('post.');
        //表单验证，若不符合验证要求，则跳至error界面，并显示相应错误信息
        if (strlen($U['username']) == 0) {
            $errorMsg = '帐号不能为空';
             $this->error('帐号不能为空');
        }else if (strlen($U['password']) < 5) {
            $errorMsg = '密码为6~20位字母或者数字';
             $this->error('密码为6~20位字母或者数字');
        }else {
            $username = strtolower($U['username']);
            $password = MD5($U['password']);
            //使用M方法实例化
            $user = M("Employee")->query("select *from employee");
            //循环验证输入用户登录条件是否满足
            for ($i=0; $i < count($user); $i++) { 
               if ($username == $user[$i]['username'] && $password == $user[$i]['password']) {
                // setcookie('uid',$username);
                // setcookie('sdktoken',$password);
                	//如果验证通过，则将单签时间作为登陆时间计入 数据库中
                    $post_data['last_login_time'] = date('Y-m-d H:i:s');
                    $result = M('Employee') -> where('employee_id = '.$user[$i]['employee_id'])->save($post_data);
                    if ($result) {
                    	//设置全局变量
                        $_SESSION['admin_uid'] = $username;
                        $_SESSION['admin_sdktoken'] = $password;
                        // $this->success('登录成功',U("index/main"));
                        $this->redirect("Index/main"); 
                    }else{
                        $this->error('登录失败，请稍后再试',U("index/login"));
                    }
               }
            }
            $this->error('登录失败,请输入正确的账号和密码');        
        }
    }


    public function registe(){
    	//接收表单提交的数据
        $U=I('post.');
        //使用M方法实例化
        $Employee = M('Employee');
        //获取所有的管理员信息
        $user=$Employee->query("select *from employee");
        // 循环验证注册用户的username是否已存在
        for($i=0;$i<count($user);$i++) {
        	// 如果存在，则跳至error页面，提示相应错误信息，然后返回注册页面
            if ($U['username'] == $user[$i]['username']) {
                $this->error('用户已存在');
            }
        }
        //如果不存在，则向数据库中加入一条数据
        $data['username'] = $U['username'];
        $data['name'] = $U['nickname'];
        $data['password'] = MD5($U['password']);
        // $data['onduty_date'] = time();
        $da_account=strtolower($data['username']);
        $da_psw=$data['password'];
        $da_nick = $data['name'];

        $result = $Employee -> add($data);
        //对插入数据返回值进行验证
        if (!$result) {
            $this->error('注册失败');
        }else{
        	// 注册成功，则继续进行双重注册，注册至网易云信后台
            $AppKey="7d2b0281a7969701ae6ea2e812edddb1";
            $AppScret="01005530b078";
            $Nonce="".rand(0,10000);
            $CurTime="".time();
            $str=$AppScret.$Nonce.$CurTime;
            $CheckSum=strtolower(sha1($str));
            //请求体
            $head_arr=array();
            $head_arr[] = 'Content-Type: application/x-www-form-urlencoded';
            $head_arr[] = 'charset: utf-8';
            $head_arr[] = 'AppKey:'.$AppKey;
            $head_arr[] = 'Nonce:'.$Nonce;
            $head_arr[] = 'CurTime:'.$CurTime;
            $head_arr[] = 'CheckSum:'.$CheckSum;

            $params=array(
                "accid"=>"$da_account",
                "name"=>"$da_nick",
                "token"=>"$da_psw",
            );
            $url="https://api.netease.im/nimserver/user/create.action";
	        // 调用方法http实现注册
            $response=self::http($url,$params,"POST",$head_arr);
            $this->redirect('Index/login');
        }      
        $this->redirect('Index/register');
    }
    //将信息注册至网易云信代码实现
    public function http($url,$params,$metod,$header,$multi=false){
        $opts=array(
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_HTTPHEADER     => $header
        );
        switch (strtoupper($metod)){
            case "GET":
                $opts[CURLOPT_URL] = $url . '?' . http_build_query($params);
                break;
            case 'POST':
                //判断是否传输文件
                $params = $multi ? $params : http_build_query($params);
                $opts[CURLOPT_URL] = $url;
                $opts[CURLOPT_POST] = 1;
                $opts[CURLOPT_POSTFIELDS] = $params;
                break;
            default:
                throw new Exception('不支持的请求方式！');
        }
        $ch = curl_init();
        curl_setopt_array($ch, $opts);
        $data  = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        if($error) throw new Exception('请求发生错误：' . $error);
        return  $data;
    }

    public function main(){
        session_start();
        $employee_name = $_SESSION['admin_uid'];
        $employee_sdktoken = $_SESSION['admin_sdktoken'];
        if (strlen($employee_name) == 0) {
            $this->redirect("Index/login");
        }else{
            $main_data['employee_name'] = $employee_name;
            $main_data['employee_sdktoken'] = $employee_sdktoken;
            $this -> assign('main_data',$main_data);
            // dump($main_data);
            $this -> display();            
        }
    }

    //homepage首页信息
    // public function homepage(){        
    //     $t = time()+3600*8;//这里和标准时间相差8小时需要补足           
    //     $days = date("Y-m-d",$t);//格式按你需要选取
    //     $orders = M("orders")->query("select *from orders where date(order_time) = ".$days);
    //     $show_data["today_money"] = 0;//今日销售总额
    //     for ($i=0; $i < count($orders); $i++) { 
    //         $show_data["today_money"] = $show_data["today_money"] + $orders[$i]["money"] + $orders[$i]["postage"];
    //     }
    //     $show_data["today_order"] = count($orders);//今日订单总数
    //     //供应商
    //     $provider = M("provider")->query("select *from provider where date(register_date) = ".$days);
    //     $show_data["today_provider"] = count($provider);//今日新增
    //     $tget = $t-3600*24*1;//比如5天前的时间
    //     $yesterday = date("Y-m-d",$tget);//格式按你需要选取
    //     $provider_yesterday = M("provider")->query("select *from provider where date(register_date) = ".$yesterday);
    //     $show_data["yesterday_provider"] = count($provider_yesterday);//昨日新增
    //     $tget = $t-3600*24*30;//比如5天前的时间
    //     $month = date("Y-m-d",$tget);//格式按你需要选取
    //     $provider_month = M("provider")->query("select *from provider where date(register_date) >= ".$month);
    //     $show_data["month_provider"] = count($provider_month);//本月新增
    //     $count_p = M("provider")->query("select count(*) from provider");
    //     $show_data["total_provider"]  = $count_p[0]["count(*)"];//  供应商总数

    //     //创客
    //     $chuangke = M("customer")->query("select *from customer where is_entrepreneur = 1 and date(register_date) = ".$days);
    //     $show_data["today_chuangke"] = count($chuangke);//今日新增
    //     $tget = $t-3600*24*1;//比如5天前的时间
    //     $yesterday = date("Y-m-d",$tget);//格式按你需要选取
    //     $chuangke_yesterday = M("customer")->query("select *from customer where  is_entrepreneur = 1 and date(register_date) = ".$yesterday);
    //     $show_data["yesterday_chuangke"] = count($chuangke_yesterday);//昨日新增
    //     $tget = $t-3600*24*30;//比如5天前的时间
    //     $month = date("Y-m-d",$tget);//格式按你需要选取
    //     $chuangke_month = M("customer")->query("select *from customer where is_entrepreneur = 1 and date(register_date) >= ".$month);
    //     $show_data["month_chuangke"] = count($chuangke_month);//本月新增
        
    //     $count_c= M("customer")->query("select count(*) from customer where  is_entrepreneur = 1");
    //     $show_data["total_chuangke"]  = $count_c[0]["count(*)"];//  创客总数
    //     $this->assign("show_data",$show_data);
    //     $this->display();      

    // }

    // //订单柱状图数据
    // public function orders_get(){
    //     // $orders = M("orders")->query("select *from orders where order_time > date_add(now(),interval -7 day)");
    //     for ($i=6; $i >=0; $i--) { 
    //         $t = time()+3600*8;//这里和标准时间相差8小时需要补足
    //         $tget = $t-3600*24*$i;//比如5天前的时间
    //         $days = date("Y-m-d",$tget);//格式按你需要选取
    //         $show_data[$i]["dates"] = $days;
    //         $count = M("orders")->query("select count(*) from orders where date(order_time) = DATE_SUB(CURDATE(),INTERVAL ".$i." DAY)");
    //         $show_data[$i]["count"] = $count[0]["count(*)"];
    //     }
    //     $this->ajaxReturn($show_data);
    // }
}