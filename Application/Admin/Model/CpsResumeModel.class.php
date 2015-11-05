<?php

namespace Admin\Model;

use Think\Model;

/**
 * 路线模型
 * Class TravelRouteModel
 *
 * @package Admin\Model
 */
class CpsResumeModel extends Model {
	protected $_validate = array ();

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