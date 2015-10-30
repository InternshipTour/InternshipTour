<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
namespace Admin\Controller;

use Admin\Builder\AdminConfigBuilder;

/**
 * 实习秀控制器
 */
class ShixixiuController extends AdminController {
	protected $shixixiuModel;
	public function _initialize() {
		parent::_initialize ();
		$this->shixixiuModel = D ( "Shixixiu" );
	}
	/**
	 * 查看所有实习秀
	 */
	public function index() {
		/* 查询条件初始化 */
		$map = array ();
		if (isset ( $_GET ['title'] )) {
			$map ['title'] = array (
					'like',
					'%' . ( string ) I ( 'title' ) . '%' 
			);
		}
		// $map=
		$list = $this->lists ( 'Shixixiu', $map, 'id desc' );
		$video = M ( "video_classify" );
		$industry = M ( "industry_classify" );
		
		// 因为用到了通用的分页方法，查询其他表的数据暂时用以下方式（常态应用：join）
		for($i = 0; $i < count ( $list ); $i ++) {
			$q = $video->field ( "name" )->find ( $list [$i] ['video_classify'] );
			$w = $industry->field ( "name" )->find ( $list [$i] ['industry_classify'] );
			$list [$i] ['v_class'] = (! empty ( $q )) ? $q ['name'] : "暂未分类";
			$list [$i] ['i_class'] = (! empty ( $w )) ? $w ['name'] : "暂未分类";
		}
		// 记录当前列表页的cookie
		Cookie ( '__forward__', $_SERVER ['REQUEST_URI'] );
		$this->assign ( 'list', $list );
		$this->meta_title = '实习秀列表';
		$this->display ();
	}
	
	/**
	 * 编辑实习秀（添加/修改）
	 */
	public function edit() {
		$aId = I ( 'id', 0, 'intval' );
		$is_edit = $aId ? 1 : 0;
		$title = $is_edit ? "编辑实习秀" : "新增实习秀";
		if (IS_POST) {
			$data ['title'] = I ( 'post.title' );
			$data ['industry_classify'] = I ( 'post.industry_classify' );
			$data ['video_classify'] = I ( 'post.video_classify' );
			$data ['uid'] = I ( 'post.uid' );
			$data ['keyword'] = I ( 'post.keyword' );
			$data ['description'] = I ( 'post.description' );
			$data ['detail'] = I ( 'post.detail' );
			$data ['author'] = get_uid ();
			$data ['origin'] = I ( 'post.origin' );
			$data ['is_company'] = I ( 'post.is_company' );
			$data ['recommend'] = I ( 'post.recommend' );
			$data ['update_time'] = time ();
			if ($is_edit) {
				$data ['id'] = $aId;
				$result = $this->shixixiuModel->update ( $data );
			} else {
				$result = $this->shixixiuModel->insert ( $data );
			}
			if ($result) {
				$this->success ( $title . "成功", U ( 'Shixixiu/index' ) );
			} else {
				$error_info = $this->shixixiuModel->getError ();
				$this->error ( $title . "失败！" . $error_info );
			}
		} else {
			$builder = new AdminConfigBuilder ();
			$builder->meta_title = $title;
				$data = $this->shixixiuModel->find ( $aId );
				$industry=M("industry_classify");
				$inOptions=$industry->field('id,name')->select();
				if(!empty($inOptions)){
					$tem=array();
					for ($i=0;$i<count($inOptions);$i++){
						$tem[$inOptions[$i]['id']]=$inOptions[$i]['name'];
					}
				}
				$video=M("video_classify");
				$videoOptions=$video->field('id,name')->select();
				if(!empty($videoOptions)){
					$tem1=array();
					for ($i=0;$i<count($videoOptions);$i++){
						$tem1[$videoOptions[$i]['id']]=$videoOptions[$i]['name'];
					}
				}
				$mem=M("ucenter_member");
				$memOptions=$mem->field('id,username')->where('status','neq 0')->order('username')->select();
				if(!empty($memOptions)){
					$tem2=array();
					for ($i=0;$i<count($memOptions);$i++){
						$tem2[$memOptions[$i]['id']]=$memOptions[$i]['username'];
					}
				}
			$builder->title ( $title )->keyId ()
			->keyText ( 'title', '实习秀标题', '不能为空' )
			->keyTextArea ( 'description', '描述' )
			->keyStatus()
			->keySelect('industry_classify', '行业分类','',$tem )
			->keySelect('video_classify', '视频分类','',$tem1)
			->keySelect('uid', '实习秀所属人','',$tem2)
			->keyRadio("is_company","个人/企业微视频",'',array("1"=>"企业","0"=>"实习生"))
			->keyText('keyword', '标签','各标签用【,】分隔')
			->keyTextArea('description', '实习秀简介')
			->keyEditor('detail','实习秀详细描述','','all',array('width' => '700px', 'height' => '400px'))
			->keyText('origin', '视频来源')
			->keySelect('recommend', '推荐级别','推荐级别，数字越大，级别越高',array('1'=>'级别1','2'=>'级别2','3'=>'级别3','4'=>'级别4','5'=>'级别5','6'=>'级别6'))
			->data ( $data )->buttonSubmit ( U ( 'edit' ) )->buttonBack ()->display ();
		}
	}
	
	/**
	 * 禁用/启用实习秀（审核功能）
	 * 参数p=0，禁用       p=1，启用
	 */
	public function forbidden(){
		$id=I('get.id');
		$p=I('get.p');
		if(empty($id)){
			$this->error("参数有误");
		}
		$shixi=D("shixixiu");
		if($p==0){
			$data['status']=0;
			if($shixi->where("id=$id")->save($data)){
				$this->success("该实习秀禁用成功！");
			}else{
				$this->error("禁用失败");
			}
		}else if($p==1){
			$data['status']=1;
			if($shixi->where("id=$id")->save($data)){
				$this->success("该实习秀启用成功！");
			}else{
				$this->error("启用失败");
			}
		}
	}
	
	/**
	 * 实习秀的封面和视频
	 */
	public function media(){
		$media=M("Shixixiu");
		$id=I("get.id");
		$data=$media->where("id=$id")->field("pic,url")->find();
		$this->assign("data",$data);
		$this->assign("id",$id);
		$this->meta_title="实习秀封面/视频--编辑";
		$this->display();
	}
	
	/**
	 * 
	 */
	public function mediaDb(){
		import('ORG.Net.UploadFile');
		//导入上传类
		$upload = new \UploadFile();
		//删除原文件
		$upload->thumbRemoveOrigin = true;
		$media=M("shixixiu");
		$aid=intval($_POST['aid']);
		if(!empty($_FILES['pic']["name"])){
			//设置上传文件大小
			$upload->maxSize = 1024*1024*2;
			//设置上传文件类型
			$upload->allowExts = array('jpg','gif','png','jpeg');
			//设置附件上传目录
			$upload->savePath = './Uploads/shixixiu/pic/';
			$mydata=$upload->uploadOne($_FILES['pic']);
			if (!empty($mydata[0]["savename"])) {
			$tem["pic"]=$mydata[0]["savename"];
				//得到之前的文件名，如果再次上传成功，则删除之前的
				$tem1=$media->where("id=$aid")->field("pic")->find();
				if($media->where("id=$aid")->save($tem)){
					unlink("Uploads/shixixiu/pic/".$tem1["pic"]);
				}
			}
		}
		
		if(!empty($_FILES['url']["name"])){
			//设置上传文件大小
			$upload->maxSize = 1024*1024*200;
			//设置上传文件类型
			$upload->allowExts = array('mp4');
			//设置附件上传目录
			$upload->savePath = './Uploads/shixixiu/video/';
			$mydata=$upload->uploadOne($_FILES['url']);
			if (!empty($mydata[0]["savename"])) {
			$tem["url"]=$mydata[0]["savename"];
				//得到之前的文件名，如果再次上传成功，则删除之前的
				$tem1=$media->where("id=$aid")->field("url")->find();
				if($media->where("id=$aid")->save($tem)){
					unlink("Uploads/shixixiu/video/".$tem1["url"]);
				}
			}
		}
		$this->redirect("admin/shixixiu/media/id/$aid");
	}
	
	/**
	 * 播放实习秀
	 */
	public function play(){
		$url=I("get.u");
		$this->assign("data",$url);
		$this->display();
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
}
