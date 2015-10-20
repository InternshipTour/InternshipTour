<?php
/**
 *
 */
namespace Weibo\Controller;


use Think\Controller;

class ShareController extends  Controller{

    public function shareBox(){
        $query = urldecode(I('get.query','','text'));
        parse_str($query,$array);
        $this->assign('query',$query);
        $this->assign('parse_array',$array);
        $this->display(T('Weibo@default/Widget/share/sharebox'));
    }

    public function doSendShare(){
        $aContent = I('post.content','','text');
        $aQuery = I('post.query','','text');
        parse_str($aQuery,$feed_data);

        if(empty($aContent)){
            $this->error(L('error_content_cannot_empty'));
        }
        if(!is_login()){
            $this->error(L('error_share_please_first_login'));
        }

        $new_id = send_weibo($aContent, 'share', $feed_data,$feed_data['from']);

        $user = query_user(array('nickname'), is_login());
        $info =  D('Weibo/Share')->getInfo($feed_data);
        $toUid = $info['uid'];
        D('Common/Message')->sendMessage($toUid, L('prompt_share'),$user['nickname'] . L('share_content_shared').L('exclamation'),  'Weibo/Index/weiboDetail', array('id' => $new_id), is_login(), 1);


        $result['url'] ='';
        //返回成功结果
        $result['status'] = 1;
        $result['info'] = L('success_share').L('exclamation') . cookie('score_tip');;
        $this->ajaxReturn($result);

    }
}