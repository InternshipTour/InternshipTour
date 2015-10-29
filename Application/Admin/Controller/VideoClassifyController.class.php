<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
namespace Admin\Controller;

use Admin\Builder\AdminConfigBuilder;

/**
 * 视频分类控制器
 */
class VideoClassifyController extends AdminController {
	protected $videoModel;
	public function _initialize() {
		parent::_initialize ();
		$this->videoModel = D ( "VideoClassify" );
	}
	/**
	 * 查看所有分类
	 */
	public function index() {
		/* 查询条件初始化 */
		$map = array ();
		if (isset ( $_GET ['name'] )) {
			$map ['name'] = array (
					'like',
					'%' . ( string ) I ( 'name' ) . '%' 
			);
		}
		// $map=
		$list = $this->lists ( 'Video_classify', $map, 'id desc' );
		// 记录当前列表页的cookie
		Cookie ( '__forward__', $_SERVER ['REQUEST_URI'] );
		$this->assign ( 'list', $list );
		$this->meta_title = '视频分类列表';
		$this->display ();
	}
	
	/**
	 * 编辑分类
	 */
	public function edit() {
		$aId = I ( 'id', 0, 'intval' );
		$is_edit = $aId ? 1 : 0;
		$title = $is_edit ? "编辑视频分类" : "新增视频分类";
		if (IS_POST) {
			$data ['name'] = I ( 'post.name', '', 'op_t' );
			$data ['description'] = I ( 'post.description', '', 'op_t' );
			if ($is_edit) {
				$data ['id'] = $aId;
				$result = $this->videoModel->update ( $data );
			} else {
				$result = $this->videoModel->insert ( $data );
			}
			if ($result) {
				$this->success ( $title . "成功", U ( 'VideoClassify/index' ) );
			} else {
				$error_info = $this->videoModel->getError ();
				$this->error ( $title . "失败！" . $error_info );
			}
		} else {
			$builder = new AdminConfigBuilder ();
			$builder->meta_title = $title;
			if ($is_edit) {
				$data = $this->videoModel->find ( $aId );
			}
			$builder->title ( $title )->keyId ()->keyText ( 'name', '分类名称', '不能为空', "aaa" )->keyTextArea ( 'description', '描述' )->data ( $data )->buttonSubmit ( U ( 'edit' ) )->buttonBack ()->display ();
		}
	}
	
	/**
	 * 删除指定分类
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
		if (M ( 'Video_classify' )->where ( $map )->delete ()) {
			$this->success ( '删除成功' );
		} else {
			$this->error ( '删除失败！' );
		}
	}
}
