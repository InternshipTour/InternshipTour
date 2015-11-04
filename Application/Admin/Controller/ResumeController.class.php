<?php

namespace Admin\Controller;

use Admin\Builder\AdminConfigBuilder;

/**
 *
 * @author LeeJun
 *        
 */
class ResumeController extends AdminController {

	public function index() {
		$name = I ( 'name', '', 'text' );
		$per_mbl = I ( 'per_mbl', '', 'per_mbl' );
		if ($name !== '') {
			$map ['name'] = array (
					'like',
					'%' . $name . '%' 
			);
		}
		if ($per_mbl !== '') {
			$map ['per_mbl'] = $per_mbl;
		}
		$list = $this->lists ( 'cps_resume', $map );
		$this->assign ( '_list', $list );
		$this->meta_title = '人才库列表';
		$this->display ();
	}
}
