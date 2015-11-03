<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
namespace Admin\Controller;

use Admin\Builder\AdminConfigBuilder;

/**
 * 行程控制器
 */
class TravelController extends AdminController {
	/**
	 * 查看所有行程
	 */
	public function index() {
		/* 查询条件初始化 */
		$map = array ();
		if (isset ( $_GET ['uid'] )) {
			$map ['uid'] = array (
					'like',
					'%' . ( string ) I ( 'uid' ) . '%' 
			);
		}
		// $map=
		$list = $this->lists ( 'TravelRouteList', $map, 'id desc' );
		// 因为用到了通用的分页方法，查询其他表的数据暂时用以下方式（常态应用：join）
		$travelRoute=M("travel_route");
		$member=M("member");
		for($i = 0; $i < count ( $list ); $i ++) {
			$q = $travelRoute->find($list[$i]['road_id']);

			$w = $member->field("nickname")->find($list[$i]['uid']);
			$list [$i] ['username'] = $w;
			$list [$i] ['travelRoute'] = $q;
		}
		//header("content-type:text/html;charset=utf-8");
		//var_dump($list);die;
		// 记录当前列表页的cookie
		Cookie ( '__forward__', $_SERVER ['REQUEST_URI'] );
		$this->assign ( 'list', $list );
		$this->meta_title = '行程列表';
		$this->display ();
	}
	
	/**
	 * 删除指定实习秀（包括里面的图片、视频资源）
	 */
	public function del() {
		$id = array_unique ( ( array ) I ( 'id', 0 ) );
		if (empty ( $id )) {
			$this->error ( '请选择要操作的数据!' );
		}
		$map = array (
				'id' => array (
						'in',
						$id 
				) 
		);
		$data['status']=0;
		if (M ( 'Shixixiu' )->where ( $map )->save ($data)) {
			$this->success ( '删除成功' );
		} else {
			$this->error ( '删除失败！' );
		}
	}

	/**
	 * 删除指定路线
	 */
	public function del_road() {
		$id = array_unique ( ( array ) I ( 'id', 0 ) );
		if (empty ( $id )) {
			$this->error ( '请选择要操作的数据!' );
		}
		$map = array (
				'id' => array (
						'in',
						$id 
				) 
		);
		$data['status']=0;
		if (M ( 'TravelRoute' )->where ( $map )->save ($data)) {
			$this->success ( '删除成功' );
		} else {
			$this->error ( '删除失败！' );
		}
	}

	/**
	 * 启用指定路线
	 */
	public function ok_road() {
		$id=I("get.id");
		$status=I("get.status");
		if(empty($id)){
			$this->error("参数有误");
		}
		$data['status']=$status;
		if (M ( 'TravelRoute' )->where ("id={$id}")->save ($data)) {
			if($status){
				$this->success ( '启用成功' );
			}else{
				$this->success ( '禁用成功！' );
			}
		} else {
			if($status){
				$this->error ( '启用成功' );
			}else{
				$this->error ( '禁用成功！' );
			}
		}
	}


	/**
	 * 查看所有路线
	 */
	public function road() {
		/* 查询条件初始化 */
		$map = array ();
		if (isset ( $_GET ['start'] )) {
			$map ['start'] = array (
					'like',
					'%' . ( string ) I ( 'start' ) . '%' 
			);
		}
		// $map=
		$list = $this->lists ( 'travel_route', $map, 'id desc' );
		// 因为用到了通用的分页方法，查询其他表的数据暂时用以下方式（常态应用：join）
		// 记录当前列表页的cookie
		Cookie ( '__forward__', $_SERVER ['REQUEST_URI'] );
		$this->assign ( 'list', $list );
		$this->meta_title = '路线列表';
		$this->display ();
	}


	/**
	 * 编辑路线（添加/修改）
	 */
	public function edit_road() {
		$aId = I ( 'id', 0, 'intval' );
		$is_edit = $aId ? 1 : 0;
		$title = $is_edit ? "编辑路线" : "新增路线";
		$road=D("TravelRoute");
		if (IS_POST) {
			$data ['start'] = I ( 'post.start' );
			$data ['end'] = I ( 'post.end' );
			$data ['road_name'] = I ( 'post.road_name' );
			$data ['content'] = I ( 'post.content' );
			$data ['status'] = I ( 'post.status' );
			$data ['flush_time'] = time ();
			$data ['add_time'] = time ();
			if ($is_edit) {
				$data ['id'] = $aId;
				$result = $road->update ( $data );
			} else {
				$result = $road->insert ( $data );
			}
			if ($result) {
				$this->success ( $title . "成功", U ( 'Travel/road' ) );
			} else {
				$error_info = $road->getError ();
				$this->error ( $title . "失败！" . $error_info );
			}
		} else {
			$builder = new AdminConfigBuilder ();
			$builder->meta_title = $title;
			$data = $road->find ( $aId );
				
			$builder->title ( $title )->keyId ()
			->keyText ( 'road_name', '路线名称', '不能为空' )
			->keyText ( 'start', '起点', '不能为空' )
			->keyText ( 'end', '终点', '不能为空' )
			->keyTextArea ( 'content', '路线简要描述' )
			->keyRadio("status","路线状态",'',array("1"=>"启用","0"=>"禁用"))
			->data ( $data )->buttonSubmit ( U ( 'edit_road' ) )->buttonBack ()->display ();
		}
	}


}
