<?php
//用户等级组件
namespace Common\Widget;


use Think\Controller;

class UserRankWidget extends Controller{
    public function render($uid){
        $user=query_user(array('rank_link'),$uid);
        $this->assign('rank_link',$user['rank_link']);
        $this->display(T('Application://Common@Widget/userrank'));
    }
}