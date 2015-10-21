<?php
namespace Admin\Controller;
use Admin\Builder\AdminListBuilder;
use Admin\Builder\AdminConfigBuilder;
use Admin\Builder\AdminSortBuilder;
use Admin\Builder\AdminTreeListBuilder;

class ForumController extends AdminController
{

    public function index()
    {
        redirect(U('forum'));
    }

    public function config()
    {
        $admin_config = new AdminConfigBuilder();
        if (IS_POST) {
            S('forum_recommand_forum', null);
            S('forum_hot_forum', null);
            S('forum_suggestion_posts', null);
        }
        $data = $admin_config->handleConfig();

        if (!$data) {
            $data['LIMIT_IMAGE'] = 10;
            $data['FORUM_BLOCK_SIZE'] = 4;
            $data['CACHE_TIME'] = 300;
        }

        $admin_config->title(L('forum_settings'))
            ->data($data)
            ->keyInteger('LIMIT_IMAGE', L('post_parse_number'), L('post_parse_number_vice'))
            //->keyInteger('FORUM_BLOCK_SIZE', '论坛板块列表板块所占尺寸', '默认为4,，值可填1到12,共12块，数值代表每个板块所占块数，一行放3个板块则为4，一行放4个板块则为3')
            ->keyInteger('CACHE_TIME', L('block_data_cache_time'), L('block_data_cache_time_default'))
            ->keyText('SUGGESTION_POSTS', L('home_recommend_post'))
            ->keyText('HOT_FORUM', L('block_hot'), L('divide_comma'))->keyDefault('HOT_FORUM', '1,2,3')
            ->keyText('RECOMMAND_FORUM', L('block_recommend'), L('divide_comma'))->keyDefault('RECOMMAND_FORUM', '1,2,3')
            ->keyInteger('FORM_POST_SHOW_NUM_INDEX', L('forum_home_per_page_count'), '')->keyDefault('FORM_POST_SHOW_NUM_INDEX', '5')
            ->keyInteger('FORM_POST_SHOW_NUM_PAGE', L('per_page_count'), L('per_page_count_vice').L('comma'))->keyDefault('FORM_POST_SHOW_NUM_PAGE', '10')

            ->keyText('FORUM_SHOW_TITLE', L('title_name'), L('home_block_title'))->keyDefault('FORUM_SHOW_TITLE',L('block_forum'))
            ->keyText('FORUM_SHOW',L('block_show'),L('block_show_tip'))
            ->keyText('FORUM_SHOW_CACHE_TIME', L('cache_time'), L('cache_time_tip'))->keyDefault('FORUM_SHOW_CACHE_TIME','600')

            ->keyText('FORUM_POST_SHOW_TITLE', L('title_name'), L('home_block_title'))->keyDefault('FORUM_POST_SHOW_TITLE',L('post_hot'))
            ->keyText('FORUM_POST_SHOW_NUM',L('post_shows'))->keyDefault('FORUM_POST_SHOW_NUM',5)
            ->keyRadio('FORUM_POST_ORDER',L('post_sort_field'),'',array('update_time'=>L('update_time'),'last_reply_time'=>L('last_reply_time'),'view_count'=>L('views'),'reply_count'=>L('replies')))->keyDefault('FORUM_POST_ORDER','last_reply_time')
            ->keyRadio('FORUM_POST_TYPE',L('post_sort_mode'),'',array('asc'=>L('asc'),'desc'=>L('desc')))->keyDefault('FORUM_POST_TYPE','desc')
            ->keyText('FORUM_POST_CACHE_TIME', L('block_show'),L('block_show_tip'))->keyDefault('FORUM_POST_CACHE_TIME','600')

            ->group(L('settings_basic'), 'LIMIT_IMAGE,FORUM_BLOCK_SIZE,CACHE_TIME,SUGGESTION_POSTS,HOT_FORUM,RECOMMAND_FORUM,FORM_POST_SHOW_NUM_INDEX,FORM_POST_SHOW_NUM_PAGE')
            ->group(L('home_display_board_setting'), 'FORUM_SHOW_TITLE,FORUM_SHOW,FORUM_SHOW_CACHE_TIME')
            ->group(L('home_display_post_settings'), 'FORUM_POST_SHOW_TITLE,FORUM_POST_SHOW_NUM,FORUM_POST_ORDER,FORUM_POST_TYPE,NEWS_SHOW_CACHE_TIME');

        $admin_config->buttonSubmit('', L('save'))->display();
    }

    public function forum($page = 1, $r = 20)
    {
        //读取数据
        $map = array('status' => array('GT', -1));
        $model = M('Forum');
        $list = $model->where($map)->page($page, $r)->order('sort asc')->select();
        $totalCount = $model->where($map)->count();

        foreach ($list as &$v) {
            $v['post_count'] = D('ForumPost')->where(array('forum_id' => $v['id']))->count();
        }

        //显示页面
        $builder = new AdminListBuilder();
        $builder
            ->title(L('block_manage'))
            ->buttonNew(U('Forum/editForum'))
            ->setStatusUrl(U('Forum/setForumStatus'))->buttonEnable()->buttonDisable()->buttonDelete()
            ->buttonSort(U('Forum/sortForum'))
            ->keyId()->keyLink('title', L('title'), 'Forum/post?forum_id=###')
            ->keyCreateTime()->keyText('post_count', L('theme_count'))->keyStatus()->keyDoActionEdit('editForum?id=###')
            ->data($list)
            ->pagination($totalCount, $r)
            ->display();
    }

    public function type()
    {
        $list = D('Forum/ForumType')->getTree();
        $map = array('status' => array('GT', -1),'type_id'=>array('gt',0));
        $forums = M('Forum')->where($map)->order('sort asc')->field('id as forum_id,title,sort,type_id as pid,status')->select();
        $list=array_merge($list,$forums);
        $list=list_to_tree($list,'id','pid','child',0);
        $this->assign('list',$list);
        $this->display(T('Application://Forum@Forum/type'));
    }

    public function setTypeStatus($ids = array(), $status = 1)
    {
        if (is_array($ids)) {
            $map['id'] = array('in', implode(',', $ids));
        } else {
            $map['id'] = $ids;
        }
        $result = D('Forum/ForumType')->where($map)->setField('status', $status);
        $this->success(L('success_setting').L('period') . L('success_effect') . $result . L('success_record').L('period'));
    }


    public function addType()
    {
        $aId = I('id', 0, 'intval');
        if (IS_POST) {
            $aPid = I('pid', 0, 'intval');
            $aSort = I('sort', 0, 'intval');
            $aStatus = I('status', -2, 'intval');
            $aTitle = I('title', '', 'op_t');
            if ($aId != 0)
                $type['id'] = $aId;

            $type['sort'] = $aSort;
            $type['pid'] = $aPid;
            if ($aStatus != -2)
                $type['status'] = $aStatus;
            $type['title'] = $aTitle;
            if ($aId != 0) {
                $result = M('ForumType')->save($type);
            } else {
                $result = M('ForumType')->add($type);
            }
            if ($result) {
                $this->success(L('success_operate').L('exclamation'));
            } else {
                $this->error(L('fail_operate').L('exclamation'));
            }


        }


        $type = M('ForumType')->find($aId);
        if (!$type) {
            $type['status'] = 1;
            $type['sort'] = 1;
        }
        $configBuilder = new AdminConfigBuilder();
        $configBuilder->title(L('category_edit'));
        $configBuilder->keyId()
            ->keyText('title', L('category_name'))
            ->keyInteger('sort', L('sort'))
            ->keyStatus()
            ->buttonSubmit()
            ->buttonBack();


        $configBuilder->data($type);
        $configBuilder->display();

    }

    public function forumTrash($page = 1, $r = 20, $model = '')
    {
        $builder = new AdminListBuilder();
        $builder->clearTrash($model);
        //读取回收站中的数据
        $map = array('status' => '-1');
        $model = M('Forum');
        $list = $model->where($map)->page($page, $r)->order('sort asc')->select();
        $totalCount = $model->where($map)->count();

        //显示页面

        $builder
            ->title(L('block_trash'))
            ->setStatusUrl(U('Forum/setForumStatus'))->buttonRestore()->buttonClear('forum')
            ->keyId()->keyLink('title', L('title'), 'Forum/post?forum_id=###')
            ->keyCreateTime()->keyText('post_count', L('post_number'))
            ->data($list)
            ->pagination($totalCount, $r)
            ->display();
    }

    public function sortForum()
    {
        //读取贴吧列表
        $list = M('Forum')->where(array('status' => array('EGT', 0)))->order('sort asc')->select();

        //显示页面
        $builder = new AdminSortBuilder();
        $builder->title(L('post_bar_sort'))
            ->data($list)
            ->buttonSubmit(U('doSortForum'))->buttonBack()
            ->display();
    }

    public function setForumStatus($ids, $status)
    {
        $builder = new AdminListBuilder();
        $builder->doSetStatus('Forum', $ids, $status);
        D('Forum/Forum')->cleanAllForumsCache();

    }

    public function doSortForum($ids)
    {
        $builder = new AdminSortBuilder();
        $builder->doSort('Forum', $ids);
        D('Forum/Forum')->cleanAllForumsCache();
    }

    public function editForum($id = null, $title = '', $create_time = 0, $status = 1, $allow_user_group = 0, $logo = 0,$type_id=0)
    {
        if (IS_POST) {
            //判断是否为编辑模式
            $isEdit = $id ? true : false;
            $model = M('Forum');
            if(I('quick_edit',0,'intval')){
                //生成数据
                $data = array('title' => $title,  'sort' => I('sort',0, 'intval'));
                //写入数据库
                $result = $model->where(array('id' => $id))->save($data);
                if ($result===false) {
                    $this->error(L('fail_edit'));
                }
            }else{
                //生成数据
                $data = array('title' => $title, 'create_time' => $create_time, 'status' => $status, 'allow_user_group' => $allow_user_group, 'logo' => $logo, 'admin' => I('admin', 1, 'text')
                , 'type_id' => I('type_id', 1, 'intval'), 'background' => I('background', 0, 'intval'), 'description' => I('description', '', 'op_t'));

                //写入数据库
                if ($isEdit) {
                    $data['id'] = $id;
                    $data = $model->create($data);
                    $result = $model->where(array('id' => $id))->save($data);
                    if ($result===false) {
                        $this->error(L('fail_edit'));
                    }
                } else {
                    $data = $model->create($data);
                    $result = $model->add($data);
                    if (!$result) {
                        $this->error(L('error_create_fail'));
                    }
                }
            }
            S('forum_list', null);
            D('Forum/Forum')->cleanAllForumsCache();
            //返回成功信息
            $this->success($isEdit ? L('success_edit') : L('success_save'));
        } else {
            //判断是否为编辑模式
            $isEdit = $id ? true : false;

            //如果是编辑模式，读取贴吧的属性
            if ($isEdit) {
                $forum = M('Forum')->where(array('id' => $id))->find();
            } else {
                $forum = array('create_time' => time(), 'post_count' => 0, 'status' => 1,'type_id'=>$type_id);
            }
            $types = M('ForumType')->where(array('status' => 1))->select();
            $type_id_array[0]=L('no_category');
            foreach ($types as $t) {
                $type_id_array[$t['id']] = $t['title'];
            }
            //显示页面
            $builder = new AdminConfigBuilder();
            $builder
                ->title($isEdit ? L('post_bar_edit') : L('post_bar_add'))
                ->data($forum)
                ->keyId()->keyTitle()
                ->keyText('admin', L('board_master'), L('board_master_vice'))
                ->keyTextArea('description', L('board_desc'), L('board_desc_vice'))
                ->keySelect('type_id', L('board_category'), L('board_category_vice'), $type_id_array)
                ->keyMultiUserGroup('allow_user_group', L('user_group_to_post'))
                ->keySingleImage('logo', L('board_icon'), L('board_icon_vice'))
                ->keySingleImage('background', L('board_bg'), L('board_bg_vice'))
                ->keyStatus()
                ->keyCreateTime()
                ->buttonSubmit(U('editForum'))->buttonBack()
                ->display();
        }

    }


    public function post($page = 1, $forum_id = null, $r = 20, $title = '', $content = '')
    {
        //读取帖子数据
        $map = array('status' => array('EGT', 0));
        if ($title != '') {
            $map['title'] = array('like', '%' . $title . '%');
        }
        if ($content != '') {
            $map['content'] = array('like', '%' . $content . '%');
        }
        if ($forum_id) $map['forum_id'] = $forum_id;
        $model = M('ForumPost');
        $list = $model->where($map)->order('last_reply_time desc')->page($page, $r)->select();
        $totalCount = $model->where($map)->count();

        foreach ($list as &$v) {
            if ($v['is_top'] == 1) {
                $v['top'] = L('stick_in_block');
            } else if ($v['is_top'] == 2) {
                $v['top'] = L('stick_global');
            } else {
                $v['top'] = L('stick_not');
            }
        }
        //读取板块基本信息
        if ($forum_id) {
            $forum = M('Forum')->where(array('id' => $forum_id))->find();
            $forumTitle = ' - ' . $forum['title'];
        } else {
            $forumTitle = '';
        }

        //显示页面
        $builder = new AdminListBuilder();
        $builder->title(L('post_manage') . $forumTitle)
            ->setStatusUrl(U('Forum/setPostStatus'))->buttonEnable()->buttonDisable()->buttonDelete()
            ->keyId()->keyLink('title', L('title'), 'Forum/reply?post_id=###')
            ->keyCreateTime()->keyUpdateTime()->keyTime('last_reply_time', L('last_reply_time'))->key('top', L('stick_yes_or_not'), 'text')->keyStatus()->keyDoActionEdit('editPost?id=###')
            ->setSearchPostUrl(U('Admin/Forum/post'))->search(L('title'), 'title')->search(L('content'), 'content')
            ->data($list)
            ->pagination($totalCount, $r)
            ->display();
    }

    public function postTrash($page = 1, $r = 20)
    {
        //显示页面
        $builder = new AdminListBuilder();
        $builder->clearTrash('ForumPost');
        //读取帖子数据
        $map = array('status' => -1);
        $model = M('ForumPost');
        $list = $model->where($map)->order('last_reply_time desc')->page($page, $r)->select();
        $totalCount = $model->where($map)->count();


        $builder->title(L('reply_view_more'))
            ->setStatusUrl(U('Forum/setPostStatus'))->buttonRestore()->buttonClear('ForumPost')
            ->keyId()->keyLink('title', L('title'), 'Forum/reply?post_id=###')
            ->keyCreateTime()->keyUpdateTime()->keyTime('last_reply_time', L('last_reply_time'))->keyBool('is_top', L('stick_yes_or_not'))
            ->data($list)
            ->pagination($totalCount, $r)
            ->display();
    }

    public function editPost($id = null, $id = null, $title = '', $content = '', $create_time = 0, $update_time = 0, $last_reply_time = 0, $is_top = 0)
    {
        if (IS_POST) {
            //判断是否为编辑模式
            $isEdit = $id ? true : false;

            //写入数据库
            $model = M('ForumPost');
            $data = array('title' => $title, 'content' => filter_content($content), 'create_time' => $create_time, 'update_time' => $update_time, 'last_reply_time' => $last_reply_time, 'is_top' => $is_top);
            if ($isEdit) {
                $result = $model->where(array('id' => $id))->save($data);
            } else {
                $result = $model->keyDoActionEdit($data);
            }
            //如果写入不成功，则报错
            if ($result===false) {
                $this->error($isEdit ? L('fail_edit') : L('tip_create_success'));
            }
            //返回成功信息
            $this->success($isEdit ? L('success_edit') : L('tip_create_success'));
        } else {
            //判断是否在编辑模式
            $isEdit = $id ? true : false;

            //读取帖子内容
            if ($isEdit) {
                $post = M('ForumPost')->where(array('id' => $id))->find();
            } else {
                $post = array();
            }

            //显示页面
            $builder = new AdminConfigBuilder();
            $builder->title($isEdit ? L('post_edit') : L('post_add'))
                ->keyId()->keyTitle()->keyEditor('content', L('content'))->keyRadio('is_top', L('stick'), L('stick_style_select'), array(0 => L('stick_not'), 1 => L('stick_in_block'), 2 => L('stick_global')))->keyCreateTime()->keyUpdateTime()
                ->keyTime('last_reply_time', L('last_reply_time'))
                ->buttonSubmit(U('editPost'))->buttonBack()
                ->data($post)
                ->display();
        }

    }

    public function setPostStatus($ids, $status)
    {
        $builder = new AdminListBuilder();
        $builder->doSetStatus('ForumPost', $ids, $status);
    }

    public function reply($page = 1, $post_id = null, $r = 20)
    {
        $builder = new AdminListBuilder();

        //读取回复列表
        $map = array('status' => array('EGT', 0));
        if ($post_id) $map['post_id'] = $post_id;
        $model = M('ForumPostReply');
        $list = $model->where($map)->order('create_time asc')->page($page, $r)->select();
        $totalCount = $model->where($map)->count();

        foreach ($list as &$reply) {
            $reply['content'] = op_t($reply['content']);
        }
        unset($reply);
        //显示页面

        $builder->title(L('reply_manager'))
            ->setStatusUrl(U('setReplyStatus'))->buttonEnable()->buttonDisable()->buttonDelete()
            ->keyId()->keyTruncText('content', L('content'), 50)->keyCreateTime()->keyUpdateTime()->keyStatus()->keyDoActionEdit('editReply?id=###')
            ->data($list)
            ->pagination($totalCount, $r)
            ->display();
    }

    public function replyTrash($page = 1, $r = 20, $model = '')
    {
        $builder = new AdminListBuilder();
        $builder->clearTrash($model);
        //读取回复列表
        $map = array('status' => -1);
        $model = M('ForumPostReply');
        $list = $model->where($map)->order('create_time asc')->page($page, $r)->select();
        foreach ($list as &$reply) {
            $reply['content'] = op_t($reply['content']);
        }
        unset($reply);
        $totalCount = $model->where($map)->count();

        //显示页面

        $builder->title(L('reply_trash'))
            ->setStatusUrl(U('setReplyStatus'))->buttonRestore()->buttonClear('ForumPostReply')
            ->keyId()->keyTruncText('content', L('content'), 50)->keyCreateTime()->keyUpdateTime()->keyStatus()
            ->data($list)
            ->pagination($totalCount, $r)
            ->display();
    }

    public function setReplyStatus($ids, $status)
    {
        $builder = new AdminListBuilder();
        $builder->doSetStatus('ForumPostReply', $ids, $status);
    }

    public function editReply($id = null, $content = '', $create_time = 0, $update_time = 0, $status = 1)
    {
        if (IS_POST) {
            //判断是否为编辑模式
            $isEdit = $id ? true : false;

            //写入数据库
            $data = array('content' => filter_content($content), 'create_time' => $create_time, 'update_time' => $update_time, 'status' => $status);
            $model = M('ForumPostReply');
            if ($isEdit) {
                $result = $model->where(array('id' => $id))->save($data);
            } else {
                $result = $model->add($data);
            }

            //如果写入出错，则显示错误消息
            if ($result===false) {
                $this->error($isEdit ? L('fail_edit') : L('tip_create_success'));
            }
            //返回成功信息
            $this->success($isEdit ? L('success_edit') : L('tip_create_success'), U('reply'));

        } else {
            //判断是否为编辑模式
            $isEdit = $id ? true : false;

            //读取回复内容
            if ($isEdit) {
                $model = M('ForumPostReply');
                $reply = $model->where(array('id' => $id))->find();
            } else {
                $reply = array('status' => 1);
            }

            //显示页面
            $builder = new AdminConfigBuilder();
            $builder->title($isEdit ? L('reply_edit') : L('reply_create'))
                ->keyId()->keyEditor('content', L('content'))->keyCreateTime()->keyUpdateTime()->keyStatus()
                ->data($reply)
                ->buttonSubmit(U('editReply'))->buttonBack()
                ->display();
        }

    }


}
