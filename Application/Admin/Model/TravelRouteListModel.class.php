<?php

namespace Admin\Model;

use Think\Model;

/**
 * 行程模型
 * Class TravelRouteListModel
 *
 * @package Admin\Model
 */
class TravelRouteListModel extends Model {
	protected $_validate = array (
			array (
					'uid',
					'require',
					'不能为空。',
					self::EXISTS_VALIDATE,
					self::MODEL_BOTH 
			),
			array (
					'road_id',
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