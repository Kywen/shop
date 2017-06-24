<?php
namespace Admin\Controller;
use Think\Controller;
class PlatformController extends Controller {

	//统计供应商和创客数量
	public function providers_chuangkes_count(){
		//供应商数量
		$provider = M('provider')->query('select *from provider');
		$show_data[0]['provider_count'] = count($provider);

		//创客数量
		$chuangke = M('chuangke_store')->query('select *from chuangke_store');
		$show_data[0]['chuangke_count'] = count($chuangke);
		//有订单供应商数
		$provider_ordered = array();
		$p_order = M('order_item')->query('select *from order_item');
		for ($i=0; $i < count($p_order); $i++) { 
			$commo_param_id = $p_order[$i]['commo_param_id'];
			$com_id = M('commo_param')->query("select fk_commodity_id from commo_param where cpid = ".$commo_param_id);
			// $com_id = $p_order[$i]['commodity_id'];
			$sql = 'select fk_provider_id from commodity where commodity_id = '.$com_id[0]['fk_commodity_id'];
			$pro_id = M('commodity')->query($sql);
			array_push($provider_ordered,$pro_id[0]['fk_provider_id']);
		}
		$show_data[0]['provider_ordered'] = count(array_unique($provider_ordered));
		//供应商订单总数
		$p_orders = M('orders')->query('select *from orders');
		$show_data[0]['provider_order_count'] = count($p_orders);

		$c_order = M('chuangke_commodity')->query('select *from chuangke_commodity');
		//统计有订单创客数
		$c_order_count = 0;
		//统计所有创客订单数量
		$c_order_counts = 0;
		for ($i=0; $i < count($c_order) ; $i++) { 
			if ($c_order['sales_volume']!=0) {
				$c_order_count++;
				$c_order_counts += $c_order[$i]['sales_volume'];
			}
		}
		$show_data[0]['chuangke_ordered'] = $c_order_count;
		$show_data[0]['chuangke_order_count'] = $c_order_counts;

		$this->assign('show_data',$show_data);
		$this->display();
	}

	//订单统计
	public function orders_count(){
		$order = M('orders')->query('select *from orders');
		$order_total = count($order);//订单总数
		$c_order = M('chuangke_commodity')->query('select *from chuangke_commodity');
		//统计所有创客订单数量
		$c_order_counts = 0;
		for ($i=0; $i < count($c_order) ; $i++) { 
			if ($c_order['sales_volume']!=0) {
				$c_order_counts += $c_order[$i]['sales_volume'];
			}
		}
		//平台==供应商完成订单数
		$p_orders = M('orders')->query('select *from orders');
		//未完成==待收货订单数
		$unfinish_order = 0;
		for ($i=0; $i < count($p_order); $i++) { 
			if ($p_order[$i]['is_finished']==0) {
				$unfinish_order++;
			}
		}
		$show_data[0]['order_total'] = $order_total;
		$show_data[0]['c_order_counts'] = $c_order_counts;
		$show_data[0]['provider_order_count'] = count($p_orders);
		$show_data[0]['unfinish_order'] = $unfinish_order;
		$show_data[0]['back_order'] = "表未定";


		$this->assign('show_data',$show_data);
		$this->display();
	}

	//订单柱状图数据
	public function orders_get(){
		// $orders = M("orders")->query("select *from orders where order_time > date_add(now(),interval -7 day)");
		for ($i=6; $i >=0; $i--) { 
			$t = time()+3600*8;//这里和标准时间相差8小时需要补足
			$tget = $t-3600*24*$i;//比如5天前的时间
			$days = date("Y-m-d",$tget);//格式按你需要选取
			$show_data[$i]["dates"] = $days;
			$count = M("orders")->query("select count(*) from orders where date(order_time) = DATE_SUB(CURDATE(),INTERVAL ".$i." DAY)");
			$show_data[$i]["count"] = $count[0]["count(*)"];
		}
		$this->ajaxReturn($show_data);
	}

	//销售明细
	// public function sale_detail(){

	// }

	// 销售排行
	public function sale_rank(){
		$commodity = M('commodity')->query('select *from commodity order by sales_volume desc limit 0,200');
		for ($i=0; $i < count($commodity); $i++) { 
			$provider_id = $commodity[$i]['fk_provider_id'];
			$provider_name = M('provider')->query('select provider_name from provider where provider_id ='.$provider_id);
			$show_data[$i]['rank_id'] = $i+1;
			$show_data[$i]['provider_name'] = $provider_name[0]['provider_name'];
			$show_data[$i]['commodity_name'] = $commodity[$i]['commodity_name'];
			$show_data[$i]['commodity_id'] = $commodity[$i]['commodity_id'];
			$show_data[$i]['sale_num'] = $commodity[$i]['sales_volume'];
			$show_data[$i]['sale_total'] = $commodity[$i]['sales_volume'] * $commodity[$i]['unitprice'];

		}
		$this->assign('show_data',$show_data);
		$this->display();
	}

	//管理员列表
	public function admins_list(){
		$admins = M('employee')->query('select *from employee');
		for ($i=0; $i < count($admins); $i++) {
			$show_data[$i]['id'] = $admins[$i]['employee_id'];
			$show_data[$i]['username'] = $admins[$i]['username'];
			$show_data[$i]['nickname'] = $admins[$i]['name'];
			$show_data[$i]['onduty_date'] = $admins[$i]['onduty_date'];
			$show_data[$i]['last_login_time'] = $admins[$i]['last_login_time'];
			// if ($admins[$i]['status'] == 1) {
			// 	$show_data[$i]['status'] = "在线中";
			// }else{
			// 	$show_data[$i]['status'] = "不在线";
			// }			
		}
		$this->assign('show_data',$show_data);
		$this->display();
	}
	//删除管理员
	public function admin_delete($id){
		$admin = M('employee');
		$res =$admin -> where('employee_id='.$id)->delete();
		if ($res > 0) {
			$this -> success('删除成功',U('platform/admins_list'));
		}else{
			$this -> error('删除失败',U('platform/admins_list'));
		}
	}
	//新增管理员
	public function add_admin(){
		$U=I('post.');
        if (strlen($U['username']) == 0) {
            $errorMsg = '帐号不能为空';
             $this->error('帐号不能为空');
        }else if(strlen($U['nickname']) == 0){
            $errorMsg = '昵称不能为空';
            $this->error('昵称不能为空');
        }else if (strlen($U['password']) < 5 || strlen($U['passwordAgain']) < 5) {
            $errorMsg = '密码为6~20位字母或者数字';
             $this->error('密码为6~20位字母或者数字');
        }else if ($U['password']!=$U['passwordAgain']) {
            $errorMsg = '两次输入的密码不一致';
             $this->error('两次输入的密码不一致');
        }else {
            $Employee = M('Employee');
            $user=$Employee->query("select *from employee");
            for($i=0;$i<count($user);$i++) {
                if ($U['username'] == $user[$i]['username']) {
                    $this->error('用户已存在');
                }
            }
            $data['username'] = $U['username'];
            $data['name'] = $U['nickname'];
            $data['password'] = MD5($U['password']);
            $data['onduty_date'] = date('Y-m-d H:i:s');
            $da_account=strtolower($data['username']);
            $da_psw=$data['password'];
            $da_nick = $data['name'];

            $result = $Employee -> add($data);

            if (!$result) {
                $this->error('注册失败');
            }else{
                $AppKey="5b505a957a80c03d44764f77949d8ac6";
                $AppScret="2f7ee01b2f58";
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
            //调用方法http实现注册
                $response=self::http($url,$params,"POST",$head_arr);
                $this->redirect('platform/admins_list');
            }
        }
         $this->redirect('platform/admin_add');
	}
	//http方法
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

    //供应商、创客地域管理
    public function provider_chuangke(){
    	$this->show();
    }

    public function chuangke_local_get(){
    	//chuangke
    	$province = M('province')->query('select *from province');
    	for ($j=0; $j < count($province); $j++) { 
    		$chuangke_count = M('chuangke_store')->query('select store_id from chuangke_store c, province p where c.`fk_province_id` = p.`province_id` and p.`province_id` = ' .$province[$j]['province_id']);
    		$count = count($chuangke_count);
    		if ($count == null) {
    			$count = 0;
    		}
    		$show_data_c[$j]['province_name'] = $province[$j]['province'];
    		$show_data_c[$j]['chuangke_count'] = $count;
    	}    	
    	$this->ajaxReturn($show_data_c);
    }
    public function provider_local_get(){
    	//provider
    	$province = M('province')->query('select *from province');
    	for ($i=0; $i < count($province) ; $i++) { 
    		$provider_count = M('provider')->query("select p.provider_id from provider p,areas a,city c,province p2 where p.`fk_areas_id` = a.`area_id` and a.`cityid` = c.`cityid` and c.`provinceid` = p2.`province_code` and p2.`province_id` = ".$province[$i]['province_id']);
    		$count = count($provider_count);
    		if ($count == null) {
    			$count = 0;
    		}
    		$show_data_p[$i]['province_name'] = $province[$i]['province'];
    		$show_data_p[$i]['provider_count'] = $count;
    	}
    	$this->ajaxReturn($show_data_p);
    }

    //供应商创客订单统计pie
    public function count_get(){
    	//供应商数量
		$provider = M('provider')->query('select *from provider');
		$show_data_count['provider_count'] = count($provider);

		//创客数量
		$chuangke = M('chuangke_store')->query('select *from chuangke_store');
		$show_data_count['chuangke_count'] = count($chuangke);
		//有订单供应商数
		$provider_ordered = array();
		$p_order = M('order_item')->query('select *from order_item');
		for ($i=0; $i < count($p_order); $i++) { 
			$commo_param_id = $p_order[$i]['commo_param_id'];
			$com_id = M('commo_param')->query("select fk_commodity_id from commo_param where cpid = ".$commo_param_id);
			// $com_id = $p_order[$i]['commodity_id'];
			$sql = 'select fk_provider_id from commodity where commodity_id = '.$com_id[0]['fk_commodity_id'];
			$pro_id = M('commodity')->query($sql);
			array_push($provider_ordered,$pro_id[0]['fk_provider_id']);
		}
		$show_data_count['provider_ordered'] = count(array_unique($provider_ordered));
		$show_data_count['provider_unordered'] = $show_data_count['provider_count'] - $show_data_count['provider_ordered'];
		
		$c_order = M('chuangke_commodity')->query('select *from chuangke_commodity');
		//统计有订单创客数
		$c_order_count = 0;
		//统计所有创客订单数量
		$c_order_counts = 0;
		for ($i=0; $i < count($c_order) ; $i++) { 
			if ($c_order['sales_volume']!=0) {
				$c_order_count++;
				$c_order_counts += $c_order[$i]['sales_volume'];
			}
		}
		$show_data_count['chuangke_ordered'] = $c_order_count;
		$show_data_count['chuangke_unordered'] = $show_data_count['chuangke_count']-$show_data_count['chuangke_ordered'];
    	$this->ajaxReturn($show_data_count);
    }

    //会员管理
    public function customers_list(){
    	// 使用M方法实例化
    	$customer = M("customer")->query("select *from customer");
    	// 循环复制给页面显示对象$show_data
    	for ($i=0; $i < count($customer); $i++) { 
    		$show_data[$i]["customer_id"] = $customer[$i]["customer_id"]; //会员id
    		$show_data[$i]["uk_username"] = $customer[$i]["uk_username"]; //会员名
    		if ($customer[$i]["gender"] == "b") { //男or女
    			$show_data[$i]["gender"] = "男";
    		}else{
    			$show_data[$i]["gender"] = "女";
    		}
    		$show_data[$i]["register_date"] = $customer[$i]["register_date"]; //注册时间
    		//消费金额
    		//会员等级：消费金额0-300：注册会员 300-1000：白银会员  1000-3000：黄金会员 3000+：钻石会员
    		$orders = M("orders")->query("select *from orders where customer_id = ".$customer[$i]["customer_id"]);
    		// dump(strlen($orders));
    		if (count($orders)==0) {
    			$show_data[$i]["rank"] = "普通会员";
				$show_data[$i]["mark"] = "http://139.199.198.151:8000/shop_img/images/putong.png";
    			$show_data[$i]["cost_money"] = 0;
    			M("customer")->where("customer_id = ".$customer[$i]["customer_id"])->save($update_data);
    		}else{
    			$cost_money = 0;
    			for ($j=0; $j < count($orders); $j++) { 
    				$cost_money =$cost_money + $orders[$j]["money"];
    				$update_data["mark"] = "http://139.199.198.151:8000/shop_img/images/putong.png";
	    			M("customer")->where("customer_id = ".$customer[$i]["customer_id"])->save($update_data);
				}
				if ($cost_money>0 && $cost_money<=300) {
					$show_data[$i]["rank"] = "普通会员";
					$show_data[$i]["mark"] = "http://139.199.198.151:8000/shop_img/images/putong.png";
	    			$show_data[$i]["cost_money"] = $cost_money;
	    			$update_data["mark"] = "http://139.199.198.151:8000/shop_img/images/putong.png";
	    			M("customer")->where("customer_id = ".$customer[$i]["customer_id"])->save($update_data);
				}elseif ($cost_money>300 && $cost_money<=1000) {
					$show_data[$i]["rank"] = "黄金会员";
					$show_data[$i]["mark"] = "http://139.199.198.151:8000/shop_img/images/huangjin.png";
	    			$show_data[$i]["cost_money"] = $cost_money;
	    			$update_data["mark"] = "http://139.199.198.151:8000/shop_img/images/huangjin.png";
	    			M("customer")->where("customer_id = ".$customer[$i]["customer_id"])->save($update_data);
				}elseif ($cost_money>1000 && $cost_money<=3000) {
					$show_data[$i]["rank"] = "白金会员";
					$show_data[$i]["mark"] = "http://139.199.198.151:8000/shop_img/images/baijin.png";
	    			$show_data[$i]["cost_money"] = $cost_money;
	    			$update_data["mark"] = "http://139.199.198.151:8000/shop_img/images/baijin.png";
	    			M("customer")->where("customer_id = ".$customer[$i]["customer_id"])->save($update_data);
				}else{
					$show_data[$i]["rank"] = "钻石会员";
					$show_data[$i]["mark"] = "http://139.199.198.151:8000/shop_img/images/zuanshi.png";
	    			$show_data[$i]["cost_money"] = $cost_money;
	    			$update_data["mark"] = "http://139.199.198.151:8000/shop_img/images/zuanshi.png";
	    			M("customer")->where("customer_id = ".$customer[$i]["customer_id"])->save($update_data);
				}
    		}    		
    	}
    	$this->assign("show_data",$show_data);
    	$this->display();
    }
    public function customer_mark_get(){
    	$customer_pt = M("customer")->query("select *from customer where mark = 'http://139.199.198.151:8000/shop_img/images/putong.png'");
	   	$customer_hj = M("customer")->query("select *from customer where mark = 'http://139.199.198.151:8000/shop_img/images/huangjin.png'");
   	   	$customer_bj = M("customer")->query("select *from customer where mark = 'http://139.199.198.151:8000/shop_img/images/baijin.png'");
   	   	$customer_zs = M("customer")->query("select *from customer where mark = 'http://139.199.198.151:8000/shop_img/images/zuanshi.png'");
    	$show_data['pt'] = count($customer_pt);
    	$show_data['hj'] = count($customer_hj);
    	$show_data['bj'] = count($customer_bj);
    	$show_data['zs'] = count($customer_zs);
    	$this->ajaxReturn($show_data);

    }


}