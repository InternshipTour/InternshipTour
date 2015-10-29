<?php

namespace Admin\Model;

use Think\Model;

/**
 * 实习秀模型
 * Class ShixixiuModel
 *
 * @package Admin\Model
 */
class ShixixiuModel extends Model {
	protected $_validate = array (
			array (
					'title',
					'require',
					'不能为空。',
					self::EXISTS_VALIDATE,
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