<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
namespace Admin\Controller;

use Admin\Builder\AdminConfigBuilder;

/**
 * 行业分类控制器
 */
class IndustryClassifyController extends AdminController {
	protected $industryModel;
	public function _initialize() {
		parent::_initialize ();
		$this->industryModel = D ( "IndustryClassify" );
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
		$list = $this->lists ( 'Industry_classify', $map, 'id desc' );
		// 记录当前列表页的cookie
		Cookie ( '__forward__', $_SERVER ['REQUEST_URI'] );
		$this->assign ( 'list', $list );
		$this->meta_title = '行业分类列表';
		$this->display ();
	}
	
	/**
	 * 编辑分类
	 */
	public function edit() {
		$aId = I ( 'id', 0, 'intval' );
		$is_edit = $aId ? 1 : 0;
		$title = $is_edit ? "编辑行业分类" : "新增行业分类";
		if (IS_POST) {
			$data ['name'] = I ( 'post.name', '', 'op_t' );
			$data ['description'] = I ( 'post.description', '', 'op_t' );
			if ($is_edit) {
				$data ['id'] = $aId;
				$result = $this->industryModel->update ( $data );
			} else {
				$result = $this->industryModel->insert ( $data );
			}
			if ($result) {
				$this->success ( $title . "成功", U ( 'IndustryClassify/index' ) );
			} else {
				$error_info = $this->industryModel->getError ();
				$this->error ( $title . "失败！" . $error_info );
			}
		} else {
			$builder = new AdminConfigBuilder ();
			$builder->meta_title = $title;
			if ($is_edit) {
				$data = $this->industryModel->find ( $aId );
			}
			$builder->title ( $title )->keyId ()->keyText ( 'name', '分类名称', '不能为空' )->keyTextArea ( 'description', '描述' )->data ( $data )->buttonSubmit ( U ( 'edit' ) )->buttonBack ()->display ();
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
