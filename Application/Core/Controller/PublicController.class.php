<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------

namespace Core\Controller;

use Think\Controller;

/**
 * Class PublicController  公共控制器
 * @package Core\Controller
 */
class PublicController extends Controller
{

    /**关注某人
     * @param int $uid
     */
    public function follow()
    {
        $aUid=I('post.uid',0,'intval');
        if (!is_login()) {
            $this->ajaxReturn(array('status' => 0, 'info' => L("please")." ".L("log_in")));
        }

        if (D('Follow')->follow($aUid)) {
            $this->ajaxReturn(array('status' => 1, 'info' => L("followers")." ".L('success')));
        } else {
            $this->ajaxReturn(array('status' => 0, 'info' => L("followers")." ".L("fail")));
        }
    }

    /**取消对某人的关注
     * @param int $uid
     */
    public function unfollow()
    {
        $aUid=I('post.uid',0,'intval');
        if (!is_login()) {
            $this->ajaxReturn(array('status' => 0, 'info' => L("please")." ".L("log_in")));
        }

        if (D('Follow')->unfollow($aUid)) {
            $this->ajaxReturn(array('status' => 1, 'info' =>  L("cancel")." ".L("followers")." ".L("success")));
        } else {
            $this->ajaxReturn(array('status' => 0, 'info' =>  L("cancel")." ".L("followers")." ".L("fail")));
        }
    }


    /**
     * atWhoJson
     */
    public function atWhoJson()
    {
        exit(json_encode($this->getAtWhoUsersCached()));
    }

    private function getAtWhoUsersCached()
    {
        $cacheKey = 'weibo_at_who_users';
        $atusers = S($cacheKey);
        if (empty($atusers[get_uid()])) {
            $atusers[get_uid()] = $this->getAtWhoUsers();
            S($cacheKey, $atusers, 600);
        }
        return $atusers[get_uid()];
    }

    /**
     * getAtWhoUsers  获取@列表
     * @return array
     */
    private function getAtWhoUsers()
    {
        //获取能AT的人，UID列表
        $uid = get_uid();
        $follows = D('Follow')->where(array('who_follow' => $uid, 'follow_who' => $uid, '_logic' => 'or'))->select();
        $uids = array();
        foreach ($follows as &$e) {
            $uids[] = $e['who_follow'];
            $uids[] = $e['follow_who'];
        }
        unset($e);
        $uids = array_unique($uids);

        //加入拼音检索
        $users = array();
        foreach ($uids as $uid) {
            $user = query_user(array('nickname', 'id', 'avatar32'), $uid);
            $user['search_key'] = $user['nickname'] . D('PinYin')->Pinyin($user['nickname']);
            $users[] = $user;
        }

        //返回at用户列表
        return $users;
    }


    public function getVideo(){
        $aLink = I('post.link');
        $this->ajaxReturn(array('data'=>D('ContentHandler')->getVideoInfo($aLink)));
    }

}
