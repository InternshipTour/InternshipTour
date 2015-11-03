<?php

namespace Admin\Model;

use Think\Model;

/**
 * 路线模型
 * Class TravelRouteModel
 *
 * @package Admin\Model
 */
class TravelRouteModel extends Model {
	protected $_validate = array (
			array (
					'start',
					'require',
					'不能为空。',
					self::EXISTS_VALIDATE,
					self::MODEL_BOTH 
			),
			array (
					'end',
					'require',
					'不能为空。',
					self::EXISTS_VALIDATE,
					self::MODEL_BOTH 
			),
			array (
					'road_name',
					'require',
					'不能为空。',
					self::EXISTS_VALIDATE,
					self::MODEL_BOTH 
			),
			array('road_name', '', '此路线名已存在', self::VALUE_VALIDATE, 'unique', self::MODEL_BOTH),
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