<?php

namespace Admin\Model;

use Think\Model;

/**
 * 行业分类模型
 * Class IndustryclassifyModel
 *
 * @package Admin\Model
 */
class IndustryclassifyModel extends Model {
	protected $_validate = array (
			array (
					'name',
					'require',
					'不能为空。',
					self::EXISTS_VALIDATE,
					self::MODEL_BOTH 
			),
			array (
					'name',
					'',
					'此分类已经存在。',
					self::VALUE_VALIDATE,
					'unique',
					self::MODEL_BOTH 
			) 
	);
	/**
	 * 插入数据
	 *
	 * @param
	 *        	$data
	 * @return mixed
	 */
	public function insert($data = array()) {
		$data = $this->create ( $data );
		if ($data) {
			$result = $this->add ( $data );
		} else {
			$result = false;
		}
		return $result;
	}
	
	/**
	 * 修改数据
	 *
	 * @param
	 *        	$data
	 * @return mixed
	 */
	public function update($data = array()) {
		$data = $this->create ( $data );
		if ($data) {
			$result = $this->save ( $data );
		} else {
			$result = false;
		}
		return $result;
	}
} 