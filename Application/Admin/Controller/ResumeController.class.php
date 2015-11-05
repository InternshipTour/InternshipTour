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

	public function edit() {
		$id = I ( 'id', 0, 'intval' );
		$isEdit = $id ? 1 : 0;
		$title = $isEdit ? "编辑简历" : "新增简历";
		$resume = D ( "CpsResume" );
		if (IS_POST) {
			// $data ['user_id'] = I ( 'post.user_id' );
			$data ['resume_display'] = I ( 'post.resume_display' );
			$data ['resume_name'] = I ( 'post.resume_name' );
			$data ['name'] = I ( 'post.name' );
			$data ['sex'] = I ( 'post.sex' );
			// $data ['current_situation'] = I ( 'post.current_situation' );
			$data ['p_trade'] = I ( 'post.p_trade' );
			$data ['p_birthdate'] = I ( 'post.p_birthdate' );
			$data ['p_heigh'] = I ( 'post.p_heigh' );
			$data ['marriage'] = I ( 'post.marriage' );
			$data ['experience'] = I ( 'post.experience' );
			$data ['district'] = I ( 'post.district' );
			$data ['wage'] = I ( 'post.wage' );
			$data ['household_addres'] = I ( 'post.household_addres' );
			$data ['per_edu'] = I ( 'post.per_edu' );
			$data ['from_year'] = I ( 'post.from_year' );
			$data ['from_month'] = I ( 'post.from_month' );
			$data ['to_year'] = I ( 'post.to_year' );
			$data ['to_month'] = I ( 'post.to_month' );
			$data ['school_name'] = I ( 'post.school_name' );
			$data ['moremajor'] = I ( 'post.moremajor' );
			$data ['edudetail'] = I ( 'post.edudetail' );
			$data ['isoverseas'] = I ( 'post.isoverseas' );
			$data ['introduction'] = I ( 'post.introduction' );
			$data ['language1'] = I ( 'post.language1' );
			$data ['master'] = I ( 'post.master' );
			$data ['rwability'] = I ( 'post.rwability' );
			$data ['lsability'] = I ( 'post.lsability' );
			$data ['gre'] = I ( 'post.gre' );
			$data ['per_mbl'] = I ( 'post.per_mbl' );
			$data ['per_eml'] = I ( 'post.per_eml' );
			$data ['qq_msn'] = I ( 'post.qq_msn' );
			$data ['address'] = I ( 'post.address' );
			$data ['wensite'] = I ( 'post.wensite' );
			$data ['subfunction'] = I ( 'post.subfunction' );
			$data ['responsiblity'] = I ( 'post.responsiblity' );
			$data ['leavereson'] = I ( 'post.leavereson' );
			$data ['recent_jobs'] = I ( 'post.recent_jobs' );
			$data ['intention_jobs'] = I ( 'post.intention_jobs' );
			$data ['specilaty'] = I ( 'post.specilaty' );
			// $data ['photo'] = I ( 'post.photo' );
			if ($isEdit) {
				$data ['id'] = $id;
				$data ['reffresh_time'] = time ();
				$result = $resume->update ( $data );
			} else {
				$data ['addtime'] = time ();
				$result = $resume->insert ( $data );
			}
			if ($result) {
				$this->success ( $title . "成功", U ( 'Resume/index' ) );
			} else {
				$error_info = $resume->getError ();
				$this->error ( $title . "失败！" . $error_info );
			}
		} else {
			$builder = new AdminConfigBuilder ();
			$builder->meta_title = $title;
			$data = $resume->find ( $id );
			$builder->title ( $title )->keyHidden ( "id", "id" )->keyRadio ( "resume_display", "是否显示：", "", 
					array (
							0 => "显示",
							1 => "隐藏" 
					) )->keyText ( "resume_name", "简历名称：" )->keyText ( "name", "姓名：" )->keyRadio ( "sex", "性别：", "", 
					array (
							0 => "男",
							1 => "女" 
					) )->keyText ( "per_mbl", "手机号：" )->keyText ( "per_eml", "邮箱：" )->keyText ( "qq_msn", "qq/msn：" )->keyText ( 
					"address", "通讯地址：" )->keyText ( "p_trade", "期望行业：" )->keyTime ( "p_birthdate", "生日：", "", "date" )->keyText ( 
					"p_heigh", "身高：" )->keyRadio ( "marriage", "婚姻状态：", "", 
					array (
							0 => "未婚",
							1 => "已婚",
							2 => "保密" 
					) )->keyText ( "experience", "工作年限：" )->keyText ( "district", "所在地区：" )->keyText ( "wage", "期望薪水：" )->keyText ( 
					"household_addres", "户口所在地：" )->keyText ( "per_edu", "学历：" )->keyTime ( "from_time", "教育开始日期：", "", 
					"date" )->keyTime ( "to_time", "教育结束日期：", "", "date" )->keyText ( "school_name", "学校名称：" )->keyText ( 
					"submajor", "专业：" )->keyTextArea ( "edudetail", "专业描述：" )->keyTextArea ( "introduction", "自我评价：" )->data ( 
					$data )->buttonSubmit ( U ( 'edit' ) )->buttonBack ()->display ();
		}
	}
}
