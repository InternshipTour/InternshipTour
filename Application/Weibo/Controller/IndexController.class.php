<?php
namespace Weibo\Controller;
use Think\Controller;
use Think\Hook;

class IndexController extends BaseController
{
    /**
     * index   微博首页
     */
    public function index()
    {
        $this->assign('tab', 'index');

        $tab_config = get_kanban_config('WEIBO_DEFAULT_TAB', 'enable', array('all', 'concerned', 'hot'));

        if (!is_login()) {
            $_key = array_search('concerned', $tab_config);
            unset($tab_config[$_key]);
        }

        //获取参数
        $aType = I('get.type', reset($tab_config), 'op_t');
        $aUid = I('get.uid', 0, 'intval');
        $aPage = I('get.page', 1, 'intval');
        if (!in_array($aType, $tab_config)) {
            $this->error(L('error_param'));
        }
        $param = array();
        //查询条件
        $weiboModel = D('Weibo');
        $param['field'] = 'id';
        if ($aPage == 1) {
            $param['limit'] = 10;
        } else {
            $param['page'] = $aPage;
            $param['count'] = 30;
        }
        $param = $this->filterWeibo($aType, $param);
        $param['where']['status'] = 1;
        $param['where']['is_top'] = 0;
        //查询
        $list = $weiboModel->getWeiboList($param);
        $this->assign('list', $list);

        // 获取置顶微博
        $top_list = $weiboModel->getWeiboList(array('where' => array('status' => 1, 'is_top' => 1)));
        $this->assign('top_list', $top_list);
        $this->assign('total_count', $weiboModel->getWeiboCount($param['where']));
        $this->assign('page', $aPage);
        $this->assign('loadMoreUrl', U('loadweibo', array('uid' => $aUid)));
        $this->assign('type', $aType);
        $this->assign('tab_config', $tab_config);
        if ($aType == 'concerned') {
            $this->assign('title', L('my_follow'));
            $this->assign('filter_tab', 'concerned');
        } else if ($aType == 'hot') {
            $this->assign('title', L('hot_weibo'));
            $this->assign('filter_tab', 'hot');
        } else {
            $this->assign('title',L('all_website_follow'));
            $this->assign('filter_tab', 'all');
        }
        $this->setTitle('{$title}'.L('line_line').L('module'));
        $this->assignSelf();
        if (is_login() && check_auth('Weibo/Index/doSend')) {
            $this->assign('show_post', true);
        }
        $this->display();
    }


    private function filterWeibo($aType, $param)
    {
        if ($aType == 'concerned') {
            $followList = D('Follow')->getFollowList();
            $param['where']['uid'] = array('in', $followList);
        }
        if ($aType == 'hot') {
            $hot_left = modC('HOT_LEFT', 3);
            $time_left = get_some_day($hot_left);
            $param['where']['create_time'] = array('gt', $time_left);
            $param['order'] = 'comment_count desc';
            $this->assign('tab', 'hot');
        }
        return $param;
    }

    /**
     * loadweibo   滚动载入
     */
    public function loadweibo()
    {

        $expect_type = array('hot');
        $aType = I('get.type', '', 'text');
        $aPage = I('get.page', 1, 'intval');
        $aLastId = I('get.lastId', 0, 'intval');
        $aLoadCount = I('get.loadCount', 0, 'intval');

        $weiboModel = D('Weibo');
        $param['where'] = array(
            'status' => 1,
            'is_top' => 0,
        );
        $param = $this->filterWeibo($aType, $param);


        $param['field'] = 'id';
        if ($aPage == 1) {
            if (!in_array($aType, $expect_type)) {
                $param['limit'] = 10;
                $param['where']['id'] = array('lt', $aLastId);
            } else {
                $param['page'] = $aLoadCount;
                $param['count'] = 10;
            }
        } else {
            $param['page'] = $aPage;
            $param['count'] = 30;
        }
        $list = $weiboModel->getWeiboList($param);
        $this->assign('list', $list);
        $this->assign('lastId', end($list));
        $this->display();
    }

    /**
     * doSend   发布微博
     */
    public function doSend()
    {
        $aContent = I('post.content', '', 'op_t');
        $aType = I('post.type', 'feed', 'op_t');
        $aAttachIds = I('post.attach_ids', '', 'op_t');
        $aExtra = I('post.extra', array(), 'convert_url_query');

        $types = array('repost', 'feed', 'image', 'share');
        if (!in_array($aType, $types)) {
            $class_str = 'Addons\\Insert' . ucfirst($aType) . '\\Insert' . ucfirst($aType) . 'Addon';
            $class_exists = class_exists($class_str);
            if (!$class_exists) {
                $this->error(L('error_cannot_send_this'));
            } else {
                $class = new $class_str();
                if (method_exists($class, 'parseExtra')) {
                    $res = $class->parseExtra($aExtra);
                    if (!$res) {
                        $this->error($class->error);
                    }
                }

            }
        }

        //权限判断
        $this->checkIsLogin();
        $this->checkAuth(null, -1, L('info_authority_lack'));
        $return = check_action_limit('add_weibo', 'weibo', 0, is_login(), true);
        if ($return && !$return['state']) {
            $this->error($return['info']);
        }

        $feed_data = array();
        if (!empty($aAttachIds)) {
            $feed_data['attach_ids'] = $aAttachIds;
        }else{
            if($aType == 'image'){
                $this->error(L('error_at_least_one'));
            }
        }

        if (!empty($aExtra)) $feed_data = array_merge($feed_data, $aExtra);

        // 执行发布，写入数据库
        $weibo_id = send_weibo($aContent, $aType, $feed_data);
        if (!$weibo_id) {
            $this->error(L('fail_publish'));
        }
        $result['html'] = R('WeiboDetail/weibo_html', array('weibo_id' => $weibo_id), 'Widget');

        $result['status'] = 1;
        $result['info'] = L('success_publish').L('exclamation') . cookie('score_tip');
        //返回成功结果
        $this->ajaxReturn($result);
    }

    /**
     * sendrepost  发布转发页面
     */
    public function sendrepost()
    {
        $aSourceId = I('get.sourceId', 0, 'intval');
        $aWeiboId = I('get.weiboId', 0, 'intval');

        $weiboModel = D('Weibo');
        $result = $weiboModel->getWeiboDetail($aSourceId);

        $this->assign('sourceWeibo', $result);
        $weiboContent = '';
        if ($aSourceId != $aWeiboId) {
            $weibo1 = $weiboModel->getWeiboDetail($aWeiboId);
            $weiboContent = '//@' . $weibo1['user']['nickname'] . ' ：' . $weibo1['content'];

        }
        $this->assign('weiboId', $aWeiboId);
        $this->assign('weiboContent', $weiboContent);
        $this->assign('sourceId', $aSourceId);

        $this->display();
    }

    /**
     * doSendRepost   执行转发
     */
    public function doSendRepost()
    {
        $this->checkIsLogin();
        $aContent = I('post.content', '', 'op_t');

        $aType = I('post.type', '', 'op_t');

        $aSourceId = I('post.sourceId', 0, 'intval');

        $aWeiboId = I('post.weiboId', 0, 'intval');

        $aBeComment = I('post.becomment', 'false', 'op_t');


        $this->checkAuth(null, -1, L('info_authority_transmit_lack'));

        $return = check_action_limit('add_weibo', 'weibo', 0, is_login(), true);
        if ($return && !$return['state']) {
            $this->error($return['info']);
        }

        if (empty($aContent)) {
            $this->error(L('error_content_cannot_empty'));
        }


        $weiboModel = D('Weibo');
        $feed_data = '';
        $source = $weiboModel->getWeiboDetail($aSourceId);
        $sourceweibo = $source['weibo'];
        $feed_data['source'] = $sourceweibo;
        $feed_data['sourceId'] = $aSourceId;
        //发布微博
        $new_id = send_weibo($aContent, $aType, $feed_data);

        if ($new_id) {
            D('weibo')->where('id=' . $aSourceId)->setInc('repost_count');
            $aWeiboId != $aSourceId && D('weibo')->where('id=' . $aWeiboId)->setInc('repost_count');
            S('weibo_' . $aWeiboId, null);
            S('weibo_' . $aSourceId, null);
        }
// 发送消息
        $user = query_user(array('nickname'), is_login());
        $toUid = D('weibo')->where(array('id' => $aWeiboId))->getField('uid');
        D('Common/Message')->sendMessage($toUid, L('prompt_transmit'), $user['nickname'] .L('tip_transmitted').L('exclamation'), 'Weibo/Index/weiboDetail', array('id' => $new_id), is_login(), 1);

        // 发布评论
        //  dump($aBeComment);exit;
        if ($aBeComment == 'true') {
            send_comment($aWeiboId, $aContent);

        }

        $result['html'] = R('WeiboDetail/weibo_html', array('weibo_id' => $new_id), 'Widget');
        //返回成功结果

        $result['status'] = 1;
        $result['info'] = '转发成功！' . cookie('score_tip');;
        $this->ajaxReturn($result);
    }


    /**
     * doComment  发布评论
     */
    public function doComment()
    {
        $this->checkIsLogin();
        $aWeiboId = I('post.weibo_id', 0, 'intval');
        $aContent = I('post.content', 0, 'op_t');
        $aCommentId = I('post.comment_id', 0, 'intval');

        $this->checkAuth(null, -1, L('info_authority_comment_lack').L('period'));
        $return = check_action_limit('add_weibo_comment', 'weibo_comment', 0, is_login(), true);
        if ($return && !$return['state']) {
            $this->error($return['info']);
        }


        if (empty($aContent)) {
            $this->error(L('error_content_cannot_empty'));
        }
        //发送评论
        $result['data'] = send_comment($aWeiboId, $aContent, $aCommentId);

        $result['html'] = R('Comment/comment_html', array('comment_id' => $result['data']), 'Widget');

        $result['status'] = 1;
        $result['info'] = L('success_comment').L('exclamation') . cookie('score_tip');
        //返回成功结果
        $this->ajaxReturn($result);
    }

    /**
     * checkIsLogin  判断是否登录
     */
    private function  checkIsLogin()
    {
        if (!is_login()) {
            $this->error(L('error_please_first_login'));
        }
    }

    /**
     * commentlist  评论列表
     */
    public function commentlist()
    {
        $aWeiboId = I('post.weibo_id', 0, 'intval');
        $aPage = I('post.page', 1, 'intval');
        $aShowMore = I('post.show_more', 0, 'intval');
        $list = D('WeiboComment')->getCommentList($aWeiboId, $aPage, $aShowMore);
        $this->assign('list', $list);
        $this->assign('page', $aPage);
        $this->assign('weiboId', $aWeiboId);
        $weobo = D('Weibo')->getWeiboDetail($aWeiboId);
        $this->assign('weiboCommentTotalCount', $weobo['comment_count']);
        $this->assign('show_more', $aShowMore);
        $html = $this->fetch('commentlist');
        $this->ajaxReturn($html);

    }

    /**
     * doDelComment  删除评论
     */
    public function doDelComment()
    {

        $aCommentId = I('post.comment_id', 0, 'intval');
        $this->checkIsLogin();
        $comment = D('Weibo/WeiboComment')->getComment($aCommentId);
        $this->checkAuth(null, $comment['uid'], L('info_authority_comment_delete_lack').L('period'));


        //删除评论
        $result = D('Weibo/WeiboComment')->deleteComment($aCommentId);
        action_log('del_weibo_comment', 'weibo_comment', $aCommentId, is_login());
        if ($result) {
            $return['status'] = 1;
            $return['info'] = L('success_delete');
        } else {
            $return['status'] = 0;
            $return['info'] = L('fail_delete');
        }
        //返回成功信息
        $this->ajaxReturn($return);
    }

    /**
     * doDelWeibo  删除微博
     */
    public function doDelWeibo()
    {
        $aWeiboId = I('post.weibo_id', 0, 'intval');
        $weiboModel = D('Weibo');

        $weibo = $weiboModel->getWeiboDetail($aWeiboId);

        $this->checkAuth(null, $weibo['uid'],  L('info_authority_comment_delete_lack').L('period'));

        //删除微博
        $result = $weiboModel->deleteWeibo($aWeiboId);
        action_log('del_weibo', 'weibo', $aWeiboId, is_login());
        if (!$result) {
            $return['status'] = 0;
            $return['status'] = L('error_inset_db');
        } else {
            $return['status'] = 1;
            $return['status'] = L('success_delete');
        }
        //返回成功信息
        $this->ajaxReturn($return);
    }

    /**
     * setTop  置顶
     */
    public function setTop()
    {
        $aWeiboId = I('post.weibo_id', 0, 'intval');

        $this->checkAuth(null, -1, L('info_fail_stick_authority_lack').L('period'));
        $weiboModel = D('Weibo');
        $weibo = $weiboModel->find($aWeiboId);
        if (!$weibo) {
            $this->error(L('info_fail_stick_weibo_cannot_exist').L('period'));
        }
        if ($weibo['is_top'] == 0) {
            if ($weiboModel->where(array('id' => $aWeiboId))->setField('is_top', 1)) {
                action_log('set_weibo_top', 'weibo', $aWeiboId, is_login());
                S('weibo_' . $aWeiboId, null);
                $this->success(L('success_stick').L('period'));
            } else {
                $this->error(L('fail_stick').L('period'));
            };
        } else {
            if ($weiboModel->where(array('id' => $aWeiboId))->setField('is_top', 0)) {
                action_log('set_weibo_down', 'weibo', $aWeiboId, is_login());
                S('weibo_' . $aWeiboId, null);
                $this->success(L('success_stick_cancel').L('period'));
            } else {
                $this->error(L('fail_stick_cancel').L('period'));
            };
        }

    }

    /**
     * assignSelf  输出当前登录用户信息
     */
    private function assignSelf()
    {
        $self = query_user(array('title', 'avatar128', 'nickname', 'uid', 'space_url', 'score', 'title', 'fans', 'following', 'weibocount', 'rank_link'));
        //获取用户封面id
        $map = getUserConfigMap('user_cover');
        $map['role_id'] = 0;
        $model = D('Ucenter/UserConfig');
        $cover = $model->findData($map);
        $self['cover_id'] = $cover['value'];
        $self['cover_path'] = getThumbImageById($cover['value'], 273, 80);

        $this->assign('self', $self);
    }

    /**
     * weiboDetail  微博详情页
     * @param $id
     */
    public function weiboDetail($id)
    {
        //读取微博详情

        $weibo = D('Weibo')->getWeiboDetail($id);
        if ($weibo === null) {
            $this->error(L('inexistent_404'));
        }
        $weibo['user'] = query_user(array('space_url', 'avatar128', 'nickname', 'title'), $weibo['uid']);
        //显示页面

        $this->assign('weibo', $weibo);

        $this->userInfo($weibo['uid']);

        $this->userInfo($weibo['uid']);

        $supported = D('Weibo')->getSupportedPeople($weibo['id'], array('nickname', 'space_url', 'avatar128', 'space_link'), 12);
        $this->assign('supported', $supported);
        $this->setTitle('{$weibo.content|op_t}'.L('line_line').L('weibo_detail'));

        $this->assign('tab', 'index');
        $this->display();
    }


    private function userInfo($uid = null)
    {
        $user_info = query_user(array('avatar128', 'nickname', 'uid', 'space_url', 'score', 'title', 'fans', 'following', 'weibocount', 'rank_link', 'signature'), $uid);
        //获取用户封面id
        $map = getUserConfigMap('user_cover', '', $uid);
        $map['role_id'] = 0;
        $model = D('Ucenter/UserConfig');
        $cover = $model->findData($map);
        $user_info['cover_id'] = $cover['value'];
        $user_info['cover_path'] = getThumbImageById($cover['value'], 1140, 230);

        $user_info['tags'] = D('Ucenter/UserTagLink')->getUserTag($uid);
        $this->assign('user_info', $user_info);
        return $user_info;
    }

    public function loadComment()
    {
        $aWeiboId = I('post.weibo_id', 0, 'intval');
        $return['html'] = R('Comment/someCommentHtml', array('weibo_id' => $aWeiboId), 'Widget');
        $return['status'] = 1;
        //返回成功信息
        $this->ajaxReturn($return);
    }


    public function search()
    {

        $aKeywords = $this->parseSearchKey('keywords');
        $aKeywords = text($aKeywords);
        $aPage = I('get.page', 1, 'intval');
        $r = 30;
        $param['where']['content'] = array('like', "%{$aKeywords}%");
        $param['where']['status'] = 1;
        $param['order'] = 'create_time desc';
        $param['page'] = $aPage;
        $param['count'] = $r;
        //查询
        $list = D('Weibo')->getWeiboList($param);
        $totalCount = D('Weibo')->where($param['where'])->count();
        $this->assign('totalCount', $totalCount);
        $this->assign('r', $r);
        $this->assign('list', $list);
        $this->assign('search_keywords', $aKeywords);
        $this->assignSelf();
        $this->display();
    }


    protected function parseSearchKey($key = null)
    {
        $action = MODULE_NAME . '_' . CONTROLLER_NAME . '_' . ACTION_NAME;
        $post = I('post.');
        if (empty($post)) {
            $keywords = cookie($action);
        } else {
            $keywords = $post;
            cookie($action, $post);
            $_GET['page'] = 1;
        }

        if (!$_GET['page']) {
            cookie($action, null);
            $keywords = null;
        }
        return $key ? $keywords[$key] : $keywords;
    }


}