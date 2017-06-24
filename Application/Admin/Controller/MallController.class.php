<?php
namespace Admin\Controller;
use Think\Controller;
class MallController extends Controller{
	// 商品
	public function goods_list(){
		$goods = M("commodity");
		//检验商品是否被删除，如果被删除，则不显示
		$goods_data = $goods ->query("select *from commodity where is_delete = 0");
		//有商品
		if ($goods_data) {
			//循环将商品信息赋值
			for ($i=0; $i <count($goods_data) ; $i++) { 
				$provider_id = $goods_data[$i]["fk_provider_id"];
				$provider = M("provider") -> query("select provider_name from provider where provider_id = ".$provider_id);

				$areas_id = $goods_data[$i]['fk_area'];
				$city_id = M('areas') -> query("select cityid from areas where area_id =" . $areas_id);
				$province_id = M('city') -> query("select provinceid from city where cityid =" . $city_id[0]['cityid']);
				$province = M('province')->query('select province from province where province_code ='.$province_id[0]['provinceid']);
				$show_data[$i]['commodity_name'] = $goods_data[$i]['commodity_name']; //商品名
				$show_data[$i]['id'] = $goods_data[$i]['commodity_id'];	//商品id		 
				$show_data[$i]['provider'] = $provider[0]['provider_name']; //商品供应商
				$show_data[$i]['province'] = $province[0]['province']; //商品产地
				$show_data[$i]['prime_cost'] = $goods_data[$i]['prime_cost']; //商品成本价
				$show_data[$i]['profit_ratio'] = $goods_data[$i]['profit_ratio']; //商品利润比
				$show_data[$i]['unitprice'] = $show_data[$i]['prime_cost'] * ($show_data[$i]['profit_ratio']+100)*0.01; //商品售出价
				$commodity_id = $goods_data[$i]['commodity_id'];
				$good_item = M('commo_param')->query("select *from commo_param where 'fk_commodity_id' = ".$commodity_id);
				$show_data[$i]['amount'] = 0; //商品库存
				for ($m=0; $m < count($good_item); $m++) { 
					$show_data[$i]['amount'] = $show_data[$i]['amount']+$good_item[$m]['num'];
				}
				$show_data[$i]['sales_volume'] = $goods_data[$i]['sales_volume']; //商品销量 
				$grounding =$goods_data[$i]["grounding_state"];
				if ($grounding == 0) { //商品审核状态
					$show_data[$i]['state'] = "审核中";
				}else if ($grounding == 1) {
					$show_data[$i]['state'] = "已上架";
				}else if($grounding == 2){
					$show_data[$i]['state'] = "审核未通过";
				}else{
					$show_data[$i]['state'] = "无需审核";
				}
			} 
		}	
		$this -> assign('show_data',$show_data);							
		$this -> display();
	}

	//修改profit
	public function changeProfit($modelname,$modelID,$unitprice){
		$update_data['commodity_id'] = $modelID;
		$update_data['profit_ratio'] = $modelname;
		$update_data['unitprice'] = $unitprice;
		$res = M('commodity')->where("commodity_id = ".$modelID)->save($update_data);
		$this->ajaxReturn($res);

	}
	//删除商品
	public function good_delete($id){
		//将commodity表内的is_delete修改为1
		$data['is_delete'] = 1;
		$res = M('commodity')->where('commodity_id = '.$id)->save($data);
		if ($res!=false) {
			$this->success('删除成功',U("Mall/goods_list"));
		}else{
			$this->error('删除失败',U("Mall/goods_list"));
		}		
	}
	//审核商品通过
	public function good_exam_ok($id){
		session_start();
		$admin_username = $_SESSION['admin_uid'];

		//审核通过，已上架：1 审核中：0 审核未通过：2 无需审核：3
		$update_data['grounding_state'] = 1;
		$update_data['fk_examinant'] = $admin_username;
		$res = M('commodity')->where('commodity_id = '.$id)->save($update_data);
		if ($res!=false) {
			$this->success('审核通过',U('mall/goods_list'));
		}else{
			$this->error('审核失败',U('mall/goods_list'));
		}
	}
	//审核商品不通过
	public function good_exam_no($id){
		session_start();
		$admin_username = $_SESSION['admin_uid'];

		//审核通过，已上架：1 审核中：0 审核未通过：2 无需审核：3
		$update_data['grounding_state'] = 2;
		$update_data['fk_examinant'] = $admin_username;
		$res = M('commodity')->where('commodity_id = '.$id)->save($update_data);
		if ($res!=false) {
			$this->success('操作成功',U('mall/goods_list'));
		}else{
			$this->error('操作失败',U('mall/goods_list'));
		}
	}
	//一键审核通过
	public function deal_all_ok($ids){
		// dump($ids);
		session_start();
		$good_ids = explode(',',$ids); 
		$admin_username = $_SESSION['admin_uid'];
		for ($i=0; $i < count($good_ids) ; $i++) { 
		//审核通过，已上架：1 审核中：0 审核未通过：2 无需审核：3
			$update_data['grounding_state'] = 1;
			$update_data['fk_examinant'] = $admin_username;
			$res = M('commodity')->where('commodity_id = '.$good_ids[$i])->save($update_data);
		}
		$this->success('批量处理成功',U('mall/goods_list'));
	}
	//一键审核不通过
	public function deal_all_no($ids){
		// dump($ids);
		session_start();
		$good_ids = explode(',',$ids); 
		$admin_username = $_SESSION['admin_uid'];
		for ($i=0; $i < count($good_ids) ; $i++) { 
		//审核通过，已上架：1 审核中：0 审核未通过：2 无需审核：3
			$update_data['grounding_state'] = 2;
			$update_data['fk_examinant'] = $admin_username;
			$res = M('commodity')->where('commodity_id = '.$good_ids[$i])->save($update_data);
		}
		$this->success('批量处理成功',U('mall/goods_list'));
	}

	// 供应商
	public function providers_list(){
		$provider_data = M('provider') ->query("select *from provider");
		if ($provider_data) {
			for ($i=0; $i < count($provider_data); $i++) { 
				$examint_id = $provider_data[$i]['fk_examint_id'];
				$examint = M('employee') -> query("select name from employee where employee_id =" . $examint_id);
				$provider_data[$i]['register_time'] = $provider_data[$i]['register_date'];

				$category_id = $provider_data[$i]['fk_category_p_id'];
				$category_p = M('category_provider') -> query("select category_p from category_provider where category_p_id =" . $category_id);

				$areas_id = $provider_data[$i]['fk_areas_id'];
				$city_id = M('areas') -> query("select cityid from areas where area_id =" . $areas_id);
				$province_id = M('city') -> query("select provinceid from city where cityid =" . $city_id[0]['cityid']);
				$province = M('province')->query('select province from province where province_code ='.$province_id[0]['provinceid']);
				$provider_data[$i]['examint'] = $examint[0]['name'];
				$provider_data[$i]['category'] = $category_p[0]['category'];
				$provider_data[$i]['province'] = $province[0]['province'];

				$state = $provider_data[$i]['exam_state'];
				if ($state == 0) {
					$provider_data[$i]['state'] = "未审核";
					$provider_data[$i]['atext'] = "审核通过";
				}else if ($state == 1) {
					$provider_data[$i]['state'] = "正常";
					$provider_data[$i]['atext'] = "关闭该商家";
				}else if($state == 2){
					$provider_data[$i]['state'] = "关闭";
					$provider_data[$i]['atext'] = "取消关闭";
				}else{
					$provider_data[$i]['state'] = "审核未通过";
					$provider_data[$i]['atext'] = "审核通过";
				}
				
			}
		}
		// dump($show_data);
		// $this->assign("show_data",$show_data);
		$this -> assign('provider_data',$provider_data);
		$this->display();		
	}
	//供应商删除
	public function provider_delete($id){
		$res = M('provider')->where('provider_id='.$id)->delete();
		if ($res > 0) {
			$this->success('删除成功',U('mall/providers_list'));
		}else{
			$this->error('删除失败',U('mall/providers_list'));
		}
	}

	//供应商审核是否通过
	public function provider_pass_or_not($id){
		session_start();
		$exam_username = $_SESSION['admin_uid'];
		$employee = M("employee")->query("select employee_id from employee where username = '".$exam_username."'");
		// dump($employee);
		$provider = M("provider")->query("select *from provider where provider_id = " .$id);
		switch ($provider[0]['exam_state']) {
			case '0':
				$update_data['exam_state'] = 1;
				$update_data['fk_examint_id'] = $employee[0]['employee_id'];
				$update_data['exam_date'] = date('Y-m-d H:i:s');
				$res = M('provider')->where('provider_id = '.$id)->save($update_data);
				if ($res!=false) {
					$this->success('审核通过',U('mall/providers_list'));
				}else{
					$this->error('审核失败',U('mall/providers_list'));
				}				
				break;
			case '1':
				$update_data['exam_state'] = 2;
				$update_data['fk_examint_id'] = $employee[0]['employee_id'];
				$update_data['exam_date'] = date('Y-m-d H:i:s');
				$res = M('provider')->where('provider_id = '.$id)->save($update_data);
				if ($res!=false) {
					$this->success('关闭该商家成功',U('mall/providers_list'));
				}else{
					$this->error('关闭该商家失败',U('mall/providers_list'));
				}
				break;
			case '2':
				$update_data['exam_state'] = 1;
				$update_data['fk_examint_id'] = $employee[0]['employee_id'];
				$update_data['exam_date'] = date('Y-m-d H:i:s');
				$res = M('provider')->where('provider_id = '.$id)->save($update_data);
				if ($res!=false) {
					$this->success('取消关闭该商家成功',U('mall/providers_list'));
				}else{
					$this->error('取消关闭该商家失败',U('mall/providers_list'));
				}
				break;		
			default:
				$update_data['exam_state'] = 1;
				$update_data['fk_examint_id'] = $employee[0]['employee_id'];
				$update_data['exam_date'] = date('Y-m-d H:i:s');
				$res = M('provider')->where('provider_id = '.$id)->save($update_data);
				if ($res!=false) {
					$this->success('审核通过',U('mall/providers_list'));
				}else{
					$this->error('审核失败',U('mall/providers_list'));
				}	
				break;
		}
	}
	//审核不通过
	public function provider_notpass($id){
		session_start();
		$exam_username = $_SESSION['admin_uid'];
		$employee = M("employee")->query("select employee_id from employee where username = '".$exam_username."'");		
		$update_data['exam_state'] = 3;
		$update_data['fk_examint_id'] = $employee[0]['employee_id'];
		$update_data['exam_date'] = date('Y-m-d H:i:s');
		$res = M('provider')->where('provider_id = '.$id)->save($update_data);
		if ($res!=false) {
			$this->success('修改成功',U('mall/providers_list'));
		}else{
			$this->error('该商铺已经处于审核未通过状态',U('mall/providers_list'));
		}
	}

	//一键审核通过
	public function deal_all_ok_p($ids){
		// dump($ids);
		session_start();
		$provider_ids = explode(',',$ids); 
		$exam_username = $_SESSION['admin_uid'];
		$employee = M("employee")->query("select employee_id from employee where username = '".$exam_username."'");
		for ($i=0; $i < count($provider_ids) ; $i++) { 
			$update_data['exam_state'] = 1;
			$update_data['fk_examint_id'] = $employee[0]['employee_id'];
			$update_data['exam_date'] = date('Y-m-d H:i:s');
			$res = M('provider')->where('provider_id = '.$provider_ids[$i])->save($update_data);
		}
		// $this->redirect("mall/providers_list");
		$this->success('批量处理成功',U('mall/providers_list'));
	}

	//一键审核不通过--供应商
	public function deal_all_no_p($ids){
		// dump($ids);
		session_start();
		$provider_ids = explode(',',$ids); 
		$exam_username = $_SESSION['admin_uid'];
		$employee = M("employee")->query("select employee_id from employee where username = '".$exam_username."'");
		for ($i=0; $i < count($provider_ids) ; $i++) { 
			$update_data['exam_state'] = 3;
			$update_data['fk_examint_id'] = $employee[0]['employee_id'];
			$update_data['exam_date'] = date('Y-m-d H:i:s');
			$res = M('provider')->where('provider_id = '.$provider_ids[$i])->save($update_data);
		}
		$this->success('批量处理成功',U('mall/providers_list'));
	}
	// 查看供应商详情
	public function provider_msg_detail($id){
		$provider = M("provider")->query("select *from provider where provider_id = ".$id);
		$show_data["real_name"] = $provider[0]["real_name"];
		$show_data["phone"] = $provider[0]["phone"];
		$show_data["email"] = $provider[0]["email"];
		$show_data["provider_username"] = $provider[0]["provider_username"];
		$show_data["idcard"] = $provider[0]["idcard"];
		$show_data["register_date"] = $provider[0]["register_date"];
		switch ($provider[0]["exam_state"]) {
			case '0':
				$show_data["state"] = "审核未通过";
				break;
			case '1':
				$show_data["state"] = "商家正常运营";
				break;
			case '2':
				$show_data["state"] = "商家已关闭";
				break;			
			default:
				$show_data["state"] = "审核未通过";
				break;
		}
		$show_data["phone"] = $provider[0]["phone"];

		$this->assign('show_data',$show_data);
		$this->display();

	}

	//修改供应商信息页面初始化
	public function provider_update($id){
		$provider = M("provider")->query("select *from provider where provider_id = ".$id);
		$show_data["real_name"] = $provider[0]["real_name"];
		$show_data["phone"] = $provider[0]["phone"];
		$show_data["email"] = $provider[0]["email"];
		$show_data["provider_username"] = $provider[0]["provider_username"];
		$show_data["idcard"] = $provider[0]["idcard"];
		$show_data["register_date"] = $provider[0]["register_date"];
		switch ($provider[0]["exam_state"]) {
			case '0':
				$show_data["state"] = "审核未通过";
				break;
			case '1':
				$show_data["state"] = "商家正常运营";
				break;
			case '2':
				$show_data["state"] = "商家已关闭";
				break;			
			default:
				$show_data["state"] = "审核未通过";
				break;
		}
		$show_data["phone"] = $provider[0]["phone"];
		$show_data["id"] = $id;
		$url = U('mall/provider_msg_detail','id='.$id);
		// dump($url);
		$this->assign('show_data',$show_data);
		$this->display();

	}

	//提交修改后的供应商信息
	public function provider_msg_update($id){
        $U = I('post.');
		$update_data['real_name'] = $U['real_name'];
		$update_data['phone'] = $U['phone'];
		$update_data['email'] = $U['email'];
		$update_data['idcard'] = $U['idcard'];
		$res = M('provider')->where('provider_id = '.$id)->save($update_data);
		if ($res!=false) {
			$this->success('修改成功',U('mall/provider_msg_detail?id='.$id));			
		}else{
			$this->error('修改失败',U('mall/provider_msg_detail?id='.$id));
		}

	}

	// 创客
	public function chuangkes_list(){
		$chuangke = M('customer') -> query('select *from customer where is_entrepreneur = 1');
		for ($i=0; $i < count($chuangke); $i++) { 
			$show_data[$i]['id'] = $chuangke[$i]['customer_id'];
			$show_data[$i]['username'] = $chuangke[$i]['uk_username'];
			$show_data[$i]['register_date'] = $chuangke[$i]['register_date'];
			//个人小店名
			$chuangke_store= M('chuangke_store')->query('select *from chuangke_store where customer_id = '. $chuangke[$i]['customer_id']);
			$chuangke_store_name = $chuangke_store[0]['store_name'];
			$show_data[$i]['store_name'] = $chuangke_store_name;
			//小店图标
			$show_data[$i]['icon'] = 'http://123.207.181.107:8080/shop'.$chuangke_store[0]['icon'];
			//所在地
			$chuangke_province_id = M("chuangke_store") -> query('select fk_province_id from chuangke_store where customer_id = ' . $chuangke[$i]['customer_id']);

			// dump($chuangke[$i]['customer_id']);
			// dump($chuangke_province_id[0]['fk_province_id']);
			// $chuangke_province_id = M('customer_address') -> query('select province_id from customer_address where customer_id = ' . $chuangke[$i]['customer_id']);
			$province_name = M('province') -> query('select province from province where province_id = ' .$chuangke_province_id[0]['fk_province_id']);
			$show_data[$i]['province_name'] = $province_name[0]['province'];
			//审核状态
			$show_data[$i]['exam_state'] = "未定";
			//评分
			$show_data[$i]['score'] = "未定";
			//审核人
			$show_data[$i]['exam_admin'] = "未定";
		}
		$this->assign('show_data',$show_data);
		$this->display();
	}
	//删除创客
	public function chuangke_delete($id){
		$chuangke_store_id = M('chuangke_store')->query('select store_id from chuangke_store where customer_id = '.$id);
		$res = M('chuangke_commodity') -> where('chuangke_store_id ='.$chuangke_store_id[0]['store_id']) -> delete();
		$res1 = M('chuangke_store')->where('customer_id = '.$id)->delete();
		$res2 = M('customer')->query('update customer set is_entrepreneur = 0 where customer_id = '.$id);
		if ($res > 0 && $res1 >0 &&$res2 > 0) {
			$this->success('删除成功',U('mall/chuangkes_list'));
		}else{
			$this->error('删除失败',U('mall/chuangkes_list'));
		}
	}

	//创客分享情况
	public function share_detail($id){
		$commodity = M("commodity")->query("select *from commodity where commodity_id = ".$id);
		//商品名
		$good_name["good_name"] = $commodity[0]["commodity_name"];

		$chuangke_commodity = M("chuangke_commodity")->query("select *from chuangke_commodity where fk_commodity_id = ".$id);
		for ($i=0; $i < count($chuangke_commodity); $i++) { 
			//销售量
			$show_data[$i]['sales_volume'] = $chuangke_commodity[$i]['sales_volume'];
			//创客个人信息--名称+icon
			$chuangke_store_id = $chuangke_commodity[$i]['chuangke_store_id'];
			$chuangke_store = M("chuangke_store")->query("select *from chuangke_store where store_id = ".$chuangke_store_id);
			//name
			$show_data[$i]['store_name'] = $chuangke_store[0]['store_name'];
			//icon
			$show_data[$i]['icon'] = $chuangke_store[0]['icon'];
			$show_data[$i]['num'] = $i+1;
			//username
			$chaungke_username = M("customer")->query("select uk_username from customer where customer_id = ".$chuangke_store[0]['customer_id']);
			$show_data[$i]['username'] = $chaungke_username[0]['uk_username'];
		}
		$this->assign("good_name",$good_name);
		$this->assign('show_data',$show_data);
		$this->display();
	}

	//商品分类-显示
	public function goods_sort(){
		//表格
		$category1 = M('commo_category1') -> query('select *from commo_category1');
		$this -> assign('categorys',$category1);
		for ($i=0; $i < count($category1); $i++) { 
			$show_data1[$i]['category'] = $category1[$i]['category'];
			$id = $category1[$i]['id'];
			//查询分类类别下的商品数量PS:但这里还没查到呢
			$goods_sort = M('commo_category3')->query("select DISTINCT (c3.fk_commodity_id) from commo_category3 c3,commo_category2 c2,commo_category1 c1 where c2.`id`= c3.`parent_category_id` and c2.`parent_category_id` =   " . $id[0]['id']);
			// dump($goods_sort);
			$goods_count = count($goods_sort);
			$show_data1[$i]['count'] = $goods_count;
			$show_data1[$i]['id'] = $id;			
		}
		$this ->assign('show_data1',$show_data1);
		$this->display();
	}

	//添加分类
	public function category_add(){
		$U=I("post.");
        $data["parent_category_id"]=$U["id"];
        // dump($data);
        if ($U["id"] == 0) {
        	$data["category"]=$U["category"];
        	$category1 = M('commo_category1')->add($data);
        	if ($category1){
	            $this->success('顶级分类添加成功！');
	        }else{
				$this->error('数据插入失败！');
	        }
        }else{
        	$data["parent_category_id"]=$U["id"];
        	$data["category"]=$U["category"];
	        $category2=M("commo_category2")->add($data);
	        if ($category2){
	            $this->success('数据添加成功！');
	        }else{
			$this->error('数据插入失败！');
	        }
        }       
        
	}
	public function goods_sort2($id){
		$category2 = M('commo_category2')->query('select *from commo_category2 where parent_category_id = '.$id);
		for ($i=0; $i < count($category2); $i++) { 
			$show_data2[$i]['category'] = $category2[$i]['category'];
			$id2 = $category2[$i]['id'];
			//查询分类类别下的商品数量PS:但这里还没查到呢
			$goods_sort = M('commo_category3')->query("select distinct(c3.fk_commodity_id) from commo_category3 c3 where c3.`parent_category_id` = " . $id2[0]['id']);
			// dump($goods_sort);
			$goods_count = count($goods_sort);
			$show_data2[$i]['count'] = $goods_count;
			$show_data2[$i]['id'] = $id2;
			$show_data2[$i]['parent_id'] = $id;

		}
		$this->assign('first_id',$id);
		$this ->assign('show_data2',$show_data2);
		$this->display();
	}
	public function goods_sort3($id,$first_id){
		// dump($first_id);
		$category2 = M('commo_category2')->query('select category from commo_category2 where id = '.$id);
		$category1 = M('commo_category1')->query('select category from commo_category1 where id = '.$first_id);
		// $category3 = M('commo_category3')->query("select *from commo_category3 where 'parent_category_id' = ".$id);
		// dump($category3);
		$category3 = M('commo_category3')->where('parent_category_id = '.$id)->select();
		for ($i=0; $i < count($category3); $i++) { 
			$commodity_id = $category3[$i]['fk_commodity_id'];
			$commodity_name = M('commodity') -> query('select commodity_name from commodity where commodity_id = '.$commodity_id);
			//单位
			$commodity_item = M('commo_param')->query('select item from commo_param where `fk_commodity_id` = '.$commodity_id);
			$show_data[$i]['id'] = $commodity_id;
			$show_data[$i]['category2'] = $category2[0]['category'];
			$show_data[$i]['category1'] = $category1[0]['category'];
			$show_data[$i]['commodity_name'] = $commodity_name[0]['commodity_name'];
			$show_data[$i]['commodity_item'] = $commodity_item[0]['item'];
		}
		$this ->assign('id',$first_id);
		$this ->assign('show_data',$show_data);
		$this->display();
	}

	//删除顶级分类
	public function category_delete($id,$count){
		if ($count != 0 ) {
			$this->error("删除分类失败，该分类下还有商品存在",U("Mall/goods_sort"));
		}else{
			$res1 = M("commo_category1")->where("id = ".$id)->delete();
			$res2 = M("commo_category2")->where("`parent_category_id` = ".$id)->delete();
			if ($res1!=false || $res2!=false) {
				$this->error("删除分类成功",U("Mall/goods_sort"));
			}
		}
	}

	//删除二级分类
	public function category_delete2($id,$count){
		if ($count != 0 ) {
			$this->error("删除分类失败，该分类下还有商品存在",U("Mall/goods_sort"));
		}else{
			$res2 = M("commo_category2")->where("id = ".$id)->delete();
			if ($res1!=false || $res2!=false) {
				$this->error("删除分类成功",U("Mall/goods_sort"));
			}
		}
	}
	
	// 修改分类
	

	//订单
	//所有订单
	public function orders_list(){
		//全部
		$orders = M('orders')->query('select *from orders');
		// dump($orders);
		for ($i=0; $i < count($orders); $i++) {
			$provider_id = $orders[$i]['fk_provider_id'];
			$provider = M('provider')->query("select provider_name from provider where provider_id = ".$provider_id);
			$customer_id = $orders[$i]['customer_id'];
			$customer_name = M('customer')->query("select uk_username from customer where customer_id = ".$customer_id);
			$state = $orders[$i]['is_finished'];
			switch ($state) {
				case '-1':
					$show_data_all[$i]['state'] = "待发货";
					break;
				case '0':
					$show_data_all[$i]['state'] = "待发货";
					break;
				case '1':
					$show_data_all[$i]['state'] = "待发货";
					break;
				case '2':
					$show_data_all[$i]['state'] = "在途中";
					break;
				case '3':
					$show_data_all[$i]['state'] = "派送中";
					break;
				case '4':
					$show_data_all[$i]['state'] = "已签收";
					break;
				case '5':
					$show_data_all[$i]['state'] = "拒收、用户拒签";
					break;
				case '6':
					$show_data_all[$i]['state'] = "疑难件、因为某些原因无法进行派送";
					break;
				case '7':
					$show_data_all[$i]['state'] = "无效单";
					break;
				case '8':
					$show_data_all[$i]['state'] = "超时单";
					break;
				case '9':
					$show_data_all[$i]['state'] = "签收失败";
					break;				
				default:
					$show_data_all[$i]['state'] = "退回";
					break;
			}
			$show_data_all[$i]['order_id'] = $orders[$i]['order_id'];//id
			$show_data_all[$i]['order_num'] = $orders[$i]['mail_order'];//订单号
			$show_data_all[$i]['provider_name'] = $provider[0]['provider_name'];//商家名
			$show_data_all[$i]['order_time'] = $orders[$i]['order_time'];//下单时间
			$show_data_all[$i]['customer_name'] = $customer_name[0]['uk_username'];//下单用户名
			$mailname = M("customer_address")->where("customer_address_id = ".$orders[$i]["fk_customer_address_id"])->select();
			$show_data_all[$i]['mailname'] = $mailname[0]["mailname"];//收货人.
			$show_data_all[$i]['money'] = $orders[$i]['money'] + $orders[$i]['postage'];//金额			
		}

		//未完成
		$orders = M('orders')->query('select *from orders where `is_finished` !=4');
		// dump($orders);
		for ($i=0; $i < count($orders); $i++) {
			$provider_id = $orders[$i]['fk_provider_id'];
			$provider = M('provider')->query("select provider_name from provider where provider_id = ".$provider_id);
			$customer_id = $orders[$i]['customer_id'];
			$customer_name = M('customer')->query("select uk_username from customer where customer_id = ".$customer_id);
			$state = $orders[$i]['is_finished'];
			switch ($state) {
				case '-1':
					$show_data_unfinished[$i]['state'] = "待发货";
					break;
				case '0':
					$show_data_unfinished[$i]['state'] = "待发货";
					break;
				case '1':
					$show_data_unfinished[$i]['state'] = "待发货";
					break;
				case '2':
					$show_data_unfinished[$i]['state'] = "在途中";
					break;
				case '3':
					$show_data_unfinished[$i]['state'] = "派送中";
					break;
				case '4':
					$show_data_unfinished[$i]['state'] = "已签收";
					break;
				case '5':
					$show_data_unfinished[$i]['state'] = "拒收、用户拒签";
					break;
				case '6':
					$show_data_unfinished[$i]['state'] = "疑难件、因为某些原因无法进行派送";
					break;
				case '7':
					$show_data_unfinished[$i]['state'] = "无效单";
					break;
				case '8':
					$show_data_unfinished[$i]['state'] = "超时单";
					break;
				case '9':
					$show_data_unfinished[$i]['state'] = "签收失败";
					break;				
				default:
					$show_data_unfinished[$i]['state'] = "退回";
					break;
			}
			$show_data_unfinished[$i]['order_id'] = $orders[$i]['order_id'];//id
			$show_data_unfinished[$i]['order_num'] = $orders[$i]['mail_order'];//订单号
			$show_data_unfinished[$i]['provider_name'] = $provider[0]['provider_name'];//商家名
			$show_data_unfinished[$i]['order_time'] = $orders[$i]['order_time'];//下单时间
			$show_data_unfinished[$i]['customer_name'] = $customer_name[0]['uk_username'];//下单人
			$mailname = M("customer_address")->where("customer_address_id = ".$orders[$i]["fk_customer_address_id"])->select();
			$show_data_unfinished[$i]['mailname'] = $mailname[0]["mailname"];//收货人
			$show_data_unfinished[$i]['money'] = $orders[$i]['money'] + $orders[$i]['postage'];//金额			
		}

		//已完成
		$orders = M('orders')->query('select *from orders where `is_finished` = 4');
		// dump($orders);
		for ($i=0; $i < count($orders); $i++) {
			$provider_id = $orders[$i]['fk_provider_id'];
			$provider = M('provider')->query("select provider_name from provider where provider_id = ".$provider_id);
			$customer_id = $orders[$i]['customer_id'];
			$customer_name = M('customer')->query("select uk_username from customer where customer_id = ".$customer_id);
			// $state = $orders[$i]['is_finished'];
			// switch ($state) {
			// 	case '1':
			// 		$show_data_all[$i]['state'] = "暂无跟踪记录";
			// 		break;
			// 	case '2':
			// 		$show_data_all[$i]['state'] = "在途中";
			// 		break;
			// 	case '3':
			// 		$show_data_all[$i]['state'] = "派送中";
			// 		break;
			// 	case '4':
			// 		$show_data_all[$i]['state'] = "已签收";
			// 		break;
			// 	case '5':
			// 		$show_data_all[$i]['state'] = "拒收、用户拒签";
			// 		break;
			// 	case '9':
			// 		$show_data_all[$i]['state'] = "签收失败";
			// 		break;				
			// 	default:
			// 		$show_data_all[$i]['state'] = "签收异常";
			// 		break;
			// }
			$show_data_finished[$i]['order_id'] = $orders[$i]['order_id'];//id
			$show_data_finished[$i]['order_num'] = $orders[$i]['mail_order'];//订单号
			$show_data_finished[$i]['provider_name'] = $provider[0]['provider_name'];//商家名
			$show_data_finished[$i]['order_time'] = $orders[$i]['order_time'];//下单时间
			$show_data_finished[$i]['customer_name'] = $customer_name[0]['uk_username'];//下单人
			$mailname = M("customer_address")->where("customer_address_id = ".$orders[$i]["fk_customer_address_id"])->select();
			$show_data_finished[$i]['mailname'] = $mailname[0]["mailname"];//收货人.
			$show_data_finished[$i]['money'] = $orders[$i]['money'] + $orders[$i]['postage'];//金额
			$show_data_finished[$i]['state'] = "已签收";
			
		}



		// dump($show_data_all);
		$this->assign('show_data_all',$show_data_all);
		$this->assign('show_data_unfinished',$show_data_unfinished);
		$this->assign('show_data_finished',$show_data_finished);

		$this->display();
	}

	//订单
	public function invoice($id){
		$order = M('orders')->query("select *from orders where order_id = ".$id);
		//customer
		$customer_id = $order[0]['customer_id'];
		// $customer_address_id = $order[0]['fk_customer_address_id'];

		$customer = M('customer')->query("select *from customer where customer_id =".$customer_id);
		$customer_name = $customer[0]['uk_username'];
		$customer_phone = $customer[0]['uk_phone'];
		$customer_address = M('customer_address')->query("select *from customer_address where `customer_id` = ".$customer_id);
		$province = M('province')->query("select province from province where province_id = ".$customer_address[0]['province_id']);
		$city = M('city')->query("select city from city where city_id = ".$customer_address[0]['city_id']);
		$area = M('areas')->query("select area from areas where area_id = ".$customer_address[0]['area_id']);
		$customer_address = $province[0]['province'].$city[0]['city'].$area[0]['area'].$customer_address[0]['detail'];

		//provider detail
		$provider_id = $order[0]['fk_provider_id'];
		$provider = M('provider')->query("select *from provider where provider_id = ".$provider_id);
		$provider_name = $provider[0]['provider_name'];
		$provider_phone = $provider[0]['phone'];

		$show_data['order_id'] = $id;

		$show_data['customer_name'] = $customer_name;
		$show_data['customer_address'] = $customer_address;
		$show_data['customer_phone'] = $customer_phone;

		$show_data['order_id'] = $order[0]['order_id'];
		$show_data['proivder_name'] = $provider_name;
		$show_data['provider_phone'] = $provider_phone;		
		$show_data['order_time'] = $order[0]['order_time'];
		$show_data['postage'] = $order[0]['postage'];
		$show_data['total_money'] = 0;

		$order_item = M('order_item')->query("select *from order_item where `order_id` = ".$id);
		for ($i=0; $i < count($order_item); $i++) { 
			$commo_param_id = $order_item[$i]['commo_param_id'];
			$commo_param = M('commo_param')->query("select *from commo_param where cpid = ".$commo_param_id);
			$commodity_id = $commo_param[0]['fk_commodity_id'];
			$commodity_name = M('commodity')->query("select commodity_name from commodity where commodity_id = ".$commodity_id);
			if ($order_item[$i]["fromchuangke"] == '0'){
				$show_item[$i]['store_name'] = "商品直接从平台售出";
			}else{
				$chuangke_store_id = $order_item[$i]['fk_ckstoreid'];
				$chuangkestore = M('chuangke_store')->query("select store_name from chuangke_store where store_id = ".$chuangke_store_id);
				$show_item[$i]['store_name'] = $chuangkestore[0]['store_name'];
			}
			// $chuangke_store_id = $order_item[$i]['fk_ckstoreid'];
			// $chuangkestore = M('chuangke_store')->query("select store_name from chuangke_store where store_id = ".$chuangke_store_id);

			$show_item[$i]['item_name'] = $commodity_name[0]['commodity_name'];
			$show_item[$i]['item_num'] = $order_item[$i]['item_number'];
			$show_item[$i]['item_cost'] = $order_item[$i]['unitprice'];
			// $show_item[$i]['store_name'] = $chuangkestore[0]['store_name'];
			$show_item[$i]['total_cost'] = $show_item[$i]['item_num'] * $show_item[$i]['item_cost'];
			$show_data['total_money'] = $show_data['total_money'] + $show_item[$i]['total_cost'];
		}
		$show_data['total_money'] = $show_data['total_money'] + $show_data['postage'];
		$this->assign('id',$id);
		$this->assign('show_data',$show_data);
		$this->assign('show_item',$show_item);
		$this->display();
	}


	//订单——创客分享情况
	public function order_share_detail($id){
		$order_item = M("order_item")->query("select *from order_item where `order_id` = ".$id);
		for ($i=0; $i < count($order_item); $i++) { 
			$commo_param_id = $order_item[$i]['commo_param_id'];
			$commo_param = M("commo_param")->query("select *from commo_param where cpid = ".$commo_param_id);
			$commodity_id = $commo_param[0]["fk_commodity_id"];
			$commodity = M("commodity")->query("select *from commodity where commodity_id = ".$commodity_id);

			$show_data[$i]["id"] = $i + 1;//编号
			$show_data[$i]["commodity_name"] = $commodity[0]["commodity_name"];//商品名
			$show_data[$i]["img"] = $commo_param[0]["img"];//商品图片
			$show_data[$i]["item_number"] = $order_item[$i]["item_number"];//数量
			$show_data[$i]["item"] = $commo_param[0]["item"];//规格
			$show_data[$i]["unitprice"] = $order_item[$i]["unitprice"];//单价
			$show_data[$i]["total_cost"] = $order_item[$i]["item_number"] * $order_item[$i]["unitprice"];//总价
			if ($order_item[$i]["fromchuangke"]== 0) {
				// $show_data[$i]["chuangke_username"] = "该商品直接从平台售出";//创客名
				$show_data[$i]["store_name"] = "该商品直接从平台售出";//创客小店名
			}else{
				$chuangke_store = M("chuangke_store")->query("select *from chuangke_store where store_id = ".$order_item[$i]["fk_ckstoreid"]);
				//name
				$show_data[$i]['store_name'] = $chuangke_store[0]['store_name'];
			}

		}
		// $this->assign("good_name",$good_name);
		$this->assign('show_data',$show_data);
		$this->display();
	}
	
	//订单佣金结算
	public function order_commission(){
		$orders = M("orders")->query("select *from orders");
		for ($i=0; $i < count($orders); $i++) {
			//供应商信息
			$provider = M("provider")->query("select *from provider where provider_id = ".$orders[$i]["fk_provider_id"]);

			//供应商应得==成本价 
			$order_item = M("order_item")->query("select *from order_item where order_id = ".$orders[$i]["order_id"]);			
			$show_data[$i]["prime_total_cost"] = $orders[$i]["postage"];
			for ($j=0; $j < count($order_item); $j++) { 
				$commodity_prime_cost = M("commodity")->query("select c.prime_cost from commodity c,commo_param p where p.fk_commodity_id = c.commodity_id and p.cpid = ".$order_item[$j]["commo_param_id"]);
				// dump($commodity_prime_cost);
				$show_data[$i]["prime_total_cost"] = $show_data[$i]["prime_total_cost"] + $commodity_prime_cost[0]["prime_cost"] * $order_item[$j]["item_number"];//商家应得
			}
 
			//支付状态
			if($orders[$i]["pay_state_provider"] == 0){
				$show_data[$i]["pay_state_provider"] = "未结算";//未结算
				$show_data[$i]["buttons"] = "结算";//结算button
				$show_data[$i]["urls"] = "order_pay_yes/id/".$orders[$i]["order_id"];//结算跳转url
			}elseif ($orders[$i]["pay_state_provider"] == 1) {
				$show_data[$i]["pay_state_provider"] = "已结算";//已结算
				$show_data[$i]["buttons"] = "查看";//结算button
				$show_data[$i]["urls"] = "invoice/id/".$orders[$i]["order_id"];//查看跳转url
			}


			$show_data[$i]["order_id"] = $orders[$i]["order_id"];//订单id
			$show_data[$i]["show_id"] = $i + 1;//显示编号
			$show_data[$i]["provider_username"] = $provider[0]["provider_username"];//供应商会员名
			$show_data[$i]["provider_name"] = $provider[0]["provider_name"];//供应商名
			$show_data[$i]["money"] = $orders[$i]["money"] + $orders[$i]["postage"];//平台售价
		}

		//表2
		$order_item2 = M("order_item")->query("select *from order_item where fromchuangke != 0");

		//供应商信息
		// $provider = M("provider")->query("select *from provider where provider_id = ".$orders[$m]["fk_provider_id"]);

		for ($n=0; $n < count($order_item2); $n++) { //供应商信息
			$provider_id = M("orders")->query("select fk_provider_id from orders where order_id = ".$order_item2[$n]["order_id"]);
			$provider2 = M("provider")->query("select *from provider where provider_id = ".$provider_id[0]["fk_provider_id"]);
			
			//创客信息
			$chuangke_store = M("chuangke_store")->query("select *from chuangke_store where store_id = ".$order_item2[$n]["fk_ckstoreid"]);
			// dump("STORE  " . $chuangke_store);
			$chuangke = M("customer")->query("select *from customer where customer_id = ".$chuangke_store[0]["customer_id"]);
			// dump("ck  " . $chuangke);


			//商品信息
			$commo_param = M("commo_param")->query("select *from commo_param where cpid = ".$order_item2[$n]["commo_param_id"]);

			$commodity = M("commodity")->query("select *from commodity where commodity_id = " .$commo_param[0]["fk_commodity_id"]);

			$show_data2[$n]["commodity_name"] = $commodity[0]["commodity_name"];//商品名
			$show_data2[$n]["unitprice"] = $commodity[0]["unitprice"];//平台单价
			$show_data2[$n]["item_number"] = $order_item2[$n]["item_number"];//数量
			// $show_data2[$n]["postage"] = $orders[$m]["postage"];//邮费
			$show_data2[$n]["item"] = $commo_param[0]["item"];//规格

			$show_data2[$n]["platform_money"] = $show_data2[$n]["item_number"]*$show_data2[$n]["unitprice"];//平台售价

			$show_data2[$n]["prime_total_cost"] = $show_data2[$n]["item_number"] * $commodity[0]["prime_cost"];//商家应得

			$show_data2[$n]["profit_ratio_ck"] = $chuangke_store[0]["profit_ratio_ck"];//分润利息计算-创客，默认90%

			$show_data2[$n]["platform_real_get"] = ($show_data2[$n]["platform_money"] - $show_data2[$n]["prime_total_cost"]) * (1-($show_data2[$n]["profit_ratio_ck"]*0.01));//平台分润
			$show_data2[$n]["chuangke_real_get"] = $show_data2[$n]["platform_money"] - $show_data2[$n]["prime_total_cost"] -$show_data2[$n]["platform_real_get"] ;//创客分润
			// dump($order_item2[$n]["pay_state_chuangke"]);

			if ($order_item2[$n]["pay_state_chuangke"] == 0) {
				$show_data2[$n]["pay_state_chuangke"] = "未结算";//未结算
				$show_data2[$n]["buttons"] = "结算";//结算button
				$show_data2[$n]["urls"] = "ckorder_pay_yes/id/".$order_item2[$n]["itemid"];//结算跳转url
			}elseif ($order_item2[$n]["pay_state_chuangke"] == 1) {
				$show_data2[$n]["pay_state_chuangke"] = "已结算";//已结算
				$show_data2[$n]["buttons"] = "已结算";
				$show_data2[$n]["urls"] = "#";//结算跳转url
			}

			$show_data2[$n]["show_id"] = $n + 1;//显示编号
			$show_data2[$n]["provider_username"] = $provider2[0]["provider_username"];//供应商会员名
			$show_data2[$n]["provider_name"] = $provider2[0]["provider_name"];//供应商名
			$show_data2[$n]["uk_username"] = $chuangke[0]["uk_username"];//创客会员名
			$show_data2[$n]["store_name"] = $chuangke_store[0]["store_name"];//创客小店名
		}

		$this->assign("show_data",$show_data);
		$this->assign("show_data2",$show_data2);
		$this->display();
	}

	//结算
	public function order_pay_yes($id){
		$update_data["pay_state_provider"] = 1;
		$res = M("orders")->where("order_id = ".$id)->save($update_data);
		if ($res) {
			$this->success('结算成功',U("Mall/order_commission"));
		}else{
			$this->error('结算失败',U("Mall/order_commission"));
		}
	}

	public function ckorder_pay_yes($id){
		$update_data["pay_state_chuangke"] = 1;
		$res = M("order_item")->where("itemid = ".$id)->save($update_data);
		if ($res) {
			$this->success('结算成功',U("Mall/order_commission"));
		}else{
			$this->error('结算失败',U("Mall/order_commission"));
		}
	}

	public function changeCkProfit($modelname,$model_ck_name){
		$ckid = M("customer")->query("select customer_id from customer where uk_username = '" . $model_ck_name ."'");
		$update_data["profit_ratio_ck"] = $modelname;
		$res = M("chuangke_store")->where("customer_id = ".$ckid[0]["customer_id"]) -> save($update_data);
		$this->ajaxReturn($res);
	}
	

}


