<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<?php echo hook('syncMeta');?>

<?php $oneplus_seo_meta = get_seo_meta($vars,$seo); ?>
<?php if($oneplus_seo_meta['title']): ?><title><?php echo ($oneplus_seo_meta['title']); ?></title>
    <?php else: ?>
    <title><?php echo modC('WEB_SITE_NAME',L('open_sns'),'Config');?></title><?php endif; ?>
<?php if($oneplus_seo_meta['keywords']): ?><meta name="keywords" content="<?php echo ($oneplus_seo_meta['keywords']); ?>"/><?php endif; ?>
<?php if($oneplus_seo_meta['description']): ?><meta name="description" content="<?php echo ($oneplus_seo_meta['description']); ?>"/><?php endif; ?>

<!-- zui -->
<link href="/internship-tour/Public/zui/css/zui.css" rel="stylesheet">

<link href="/internship-tour/Public/zui/css/zui-theme.css" rel="stylesheet">
<link href="/internship-tour/Public/css/core.css" rel="stylesheet"/>
<link type="text/css" rel="stylesheet" href="/internship-tour/Public/js/ext/magnific/magnific-popup.css"/>
<!--<script src="/internship-tour/Public/js/jquery-2.0.3.min.js"></script>
<script type="text/javascript" src="/internship-tour/Public/js/com/com.functions.js"></script>

<script type="text/javascript" src="/internship-tour/Public/js/core.js"></script>-->
<script src="/internship-tour/Public/js.php?f=js/jquery-2.0.3.min.js,js/com/com.functions.js,js/core.js,js/com/com.toast.class.js,js/com/com.ucard.js"></script>

    <link href="/internship-tour/Application/People/Static/css/people.css" rel="stylesheet" type="text/css"/>

<!--合并前的js-->
<?php $config = api('Config/lists'); C($config); $count_code=C('COUNT_CODE'); ?>
<script type="text/javascript">
    var ThinkPHP = window.Think = {
        "ROOT": "/internship-tour", //当前网站地址
        "APP": "/internship-tour/index.php?s=", //当前项目地址
        "PUBLIC": "/internship-tour/Public", //项目公共目录地址
        "DEEP": "<?php echo C('URL_PATHINFO_DEPR');?>", //PATHINFO分割符
        "MODEL": ["<?php echo C('URL_MODEL');?>", "<?php echo C('URL_CASE_INSENSITIVE');?>", "<?php echo C('URL_HTML_SUFFIX');?>"],
        "VAR": ["<?php echo C('VAR_MODULE');?>", "<?php echo C('VAR_CONTROLLER');?>", "<?php echo C('VAR_ACTION');?>"],
        'URL_MODEL': "<?php echo C('URL_MODEL');?>",
        'WEIBO_ID': "<?php echo C('SHARE_WEIBO_ID');?>"
    }
    var cookie_config={
        "prefix":"<?php echo C('COOKIE_PREFIX');?>"
    }
    var Config={
        'GET_INFORMATION':<?php echo modC('GET_INFORMATION',1,'Config');?>,
        'GET_INFORMATION_INTERNAL':<?php echo modC('GET_INFORMATION_INTERNAL',10,'Config');?>*1000
    }

    var weibo_comment_order = "<?php echo modC('COMMENT_ORDER',0,'WEIBO');?>";
</script>

<!-- Bootstrap库 -->
<!--
<?php $js[]=urlencode('/static/bootstrap/js/bootstrap.min.js'); ?>

&lt;!&ndash; 其他库 &ndash;&gt;
<script src="/internship-tour/Public/static/qtip/jquery.qtip.js"></script>
<script type="text/javascript" src="/internship-tour/Public/Core/js/ext/slimscroll/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="/internship-tour/Public/static/jquery.iframe-transport.js"></script>
-->
<!--CNZZ广告管家，可自行更改-->
<!--<script type='text/javascript' src='http://js.adm.cnzz.net/js/abase.js'></script>-->
<!--CNZZ广告管家，可自行更改end-->
<!-- 自定义js -->
<!--<script src="/internship-tour/Public/js.php?get=<?php echo implode(',',$js);?>"></script>-->


<script>
    //全局内容的定义
    var _ROOT_ = "/internship-tour";
    var MID = "<?php echo is_login();?>";
    var MODULE_NAME="<?php echo MODULE_NAME; ?>";
    var ACTION_NAME="<?php echo ACTION_NAME; ?>";
    var CONTROLLER_NAME ="<?php echo CONTROLLER_NAME; ?>";
    var initNum = "<?php echo modC('WEIBO_NUM',140,'WEIBO');?>";
    function adjust_navbar(){
        $('#sub_nav').css('top',$('#nav_bar').height());
        $('#main-container').css('padding-top',$('#nav_bar').height()+$('#sub_nav').height()+20)
    }
</script>

<audio id="music" src="" autoplay="autoplay"></audio>
<!-- 页面header钩子，一般用于加载插件CSS文件和代码 -->
<?php echo hook('pageHeader');?>
</head>
<body>
	<!-- 头部 -->
	<script src="/internship-tour/Public/js/com/com.talker.class.js"></script>
<?php if((is_login()) ): ?><div id="talker">

    </div><?php endif; ?>

<?php D('Common/Member')->need_login(); ?>
<!--[if lt IE 8]>
<div class="alert alert-danger" style="margin-bottom: 0"><?php echo L('tip_browser_deprecated_1');?> <strong><?php echo L('tip_browser_deprecated_2');?></strong> <?php echo L('tip_browser_deprecated_3');?> <a target="_blank"
                                                                                                href="http://browsehappy.com/"><?php echo L('tip_browser_deprecated_4');?></a>
    <?php echo L('tip_browser_deprecated_5');?>
</div>
<![endif]-->

<?php $unreadMessage=D('Common/Message')->getHaventReadMeassageAndToasted(is_login()); ?>

<div id="nav_bar" class="nav_bar">

    <div class="container">

        <nav class="" id="nav_bar_container">
            <?php $logo = get_cover(modC('LOGO',0,'Config'),'path'); $logo = $logo?$logo:'/internship-tour/Public/images/logo.png'; ?>

            <a class="navbar-brand logo" href="<?php echo U('Home/Index/index');?>"><img src="<?php echo ($logo); ?>"/></a>
            <div class="" id="nav_bar_main">

                <ul class="nav navbar-nav navbar-left">
                    <?php $__NAV__ = D('Channel')->lists(true);$__NAV__ = list_to_tree($__NAV__, "id", "pid", "_"); if(is_array($__NAV__)): $i = 0; $__LIST__ = $__NAV__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$nav): $mod = ($i % 2 );++$i; if(($nav['_']) != ""): ?><li class="dropdown">
                                <a title="<?php echo ($nav["title"]); ?>" class="dropdown-toggle nav_item" data-toggle="dropdown"
                                   href="#"><i
                                        class="icon-<?php echo ($nav["icon"]); ?> app-icon"></i> <?php echo ($nav["title"]); ?> <i
                                        class="icon-caret-down"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <?php if(is_array($nav["_"])): $i = 0; $__LIST__ = $nav["_"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$subnav): $mod = ($i % 2 );++$i;?><li role="presentation"><a role="menuitem" tabindex="-1"
                                                                   style="color:<?php echo ($subnav["color"]); ?>"
                                                                   href="<?php echo (get_nav_url($subnav["url"])); ?>"
                                                                   target="<?php if(($subnav["target"]) == "1"): ?>_blank<?php else: ?>_self<?php endif; ?>"><i
                                                class="icon-<?php echo ($subnav["icon"]); ?>"></i> <?php echo ($subnav["title"]); ?>
                                        </a>
                                        </li><?php endforeach; endif; else: echo "" ;endif; ?>
                                </ul>
                            </li>
                            <?php else: ?>
                            <li class="<?php if((get_nav_active($nav["url"])) == "1"): ?>active<?php else: endif; ?>">
                                <a title="<?php echo ($nav["title"]); ?>" href="<?php echo (get_nav_url($nav["url"])); ?>"
                                   target="<?php if(($nav["target"]) == "1"): ?>_blank<?php else: ?>_self<?php endif; ?>"><i
                                        class="icon-<?php echo ($nav["icon"]); ?> app-icon "></i>
                                    <span style="color:<?php echo ($nav["color"]); ?>"><?php echo ($nav["title"]); ?></span>
                                    <span class="label label-badge rank-label" title="<?php echo ($nav["band_text"]); ?>" style="background: <?php echo ($nav["band_color"]); ?> !important;color:white !important;"><?php echo ($nav["band_text"]); ?></span>
                                </a>
                            </li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                    <?php if(is_login()): ?><a class="" onclick="talker.show()"><i class="icon-chat-dot"> </i>
                                <i id="friend_has_new"
                                <?php $map_mid=is_login(); $modelTP=D('talk_push'); $has_talk_push=$modelTP->where("(uid = ".$map_mid." and status = 1) or (uid = ".$map_mid." and status =
                                    0)")->count(); $has_message_push=D('talk_message_push')->where("uid= ".$map_mid." and (status=1 or status=0)")->count(); if($has_talk_push || $has_message_push){ ?>
                                style="display: inline-block"
                                <?php } ?>
                                ></i>
                            </a>
                    <?php else: ?>
                        <a onclick="toast.error(<?php echo L('panel_limit');?>)"> <i class="icon-chat-dot"> </i>
                        </a><?php endif; ?>
                    </li>

                    <!--登陆面板-->
                    <?php if(is_login()): ?><li class="dropdown">
                            <div></div>
                            <a id="nav_info" class="dropdown-toggle text-left" data-toggle="dropdown">
                                <span class="icon-bell"></span><span id="nav_bandage_count"
                                <?php if(count($unreadMessage) == 0): ?>style="display: none"<?php endif; ?>
                                class="label label-badge label-success"><?php echo count($unreadMessage);?></span>
                            </a>
                            <ul class="dropdown-menu extended notification">
                                <li>
                                    <div class="clearfix header">
                                        <div class="col-xs-6 nav_align_left"><span
                                                id="nav_hint_count"><?php echo count($unreadMessage);?></span> <?php echo L('unread');?>
                                        </div>
                                    </div>
                                </li>
                                <li class="info-list">
                                    <div class="list-wrap">
                                        <ul id="nav_message" class="dropdown-menu-list scroller  list-data"
                                            style="width: auto;">
                                            <?php if(count($unreadMessage) == 0): ?><div style="font-size: 18px;color: #ccc;font-weight: normal;text-align: center;line-height: 150px">
                                                    <?php echo L('no_message');?>
                                                </div>
                                                <?php else: ?>
                                                <?php if(is_array($unreadMessage)): $i = 0; $__LIST__ = $unreadMessage;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$message): $mod = ($i % 2 );++$i;?><li>
                                                        <a data-url="<?php echo ($message["content"]["web_url"]); ?>"
                                                           onclick="Notify.readMessage(this,<?php echo ($message["id"]); ?>)">
                                                           <h3 class="margin-top-0"> <i class="icon-bell"></i>
                                                            <?php echo ($message["content"]["title"]); ?></h3>
                                                            <p> <?php echo ($message["content"]["content"]); ?></p>
                                                        <span class="time">

                                                         <?php echo ($message["ctime"]); ?>

                                                        </span>
                                                        </a>
                                                    </li><?php endforeach; endif; else: echo "" ;endif; endif; ?>

                                        </ul>
                                    </div>
                                </li>
                                <li class="footer text-right">
                                    <div class="btn-group">
                                        <button onclick="Notify.setAllReaded()" class="btn btn-sm  "><i
                                                class="icon-check"></i> <?php echo L('all_has_read');?>
                                        </button>
                                        <a class="btn  btn-sm  " href="<?php echo U('ucenter/Message/message');?>">
                                            <?php echo L('view_news');?>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a title="<?php echo L('edit_info');?>" href="<?php echo U('ucenter/Config/index');?>"><i
                                    class="icon-cog"></i></a>
                        </li>
                        <li class="top_spliter"></li>
                        <li class="dropdown">
                            <?php $common_header_user = query_user(array('nickname')); ?>
                            <a role="button" class="dropdown-toggle dropdown-toggle-avatar" data-toggle="dropdown">
                                <?php echo ($common_header_user["nickname"]); ?>&nbsp;<i style="font-size: 12px"
                                                                       class="icon-chevron-down"></i>
                            </a>
                            <ul class="dropdown-menu text-left" role="menu">
                                <li><a href="<?php echo U('ucenter/Index/index');?>"><span
                                        class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;<?php echo L('home_page');?></a>
                                </li>
                                <li><a href="<?php echo U('ucenter/message/message');?>"><span
                                        class="glyphicon glyphicon-star"></span>&nbsp;&nbsp;<?php echo L('message_center');?></a>
                                </li>
                                <li><a href="<?php echo U('ucenter/Collection/index');?>"><span
                                        class="glyphicon glyphicon-star"></span>&nbsp;&nbsp;<?php echo L('my_favorites');?></a>
                                </li>

                                <li><a href="<?php echo U('ucenter/Index/rank');?>"><span
                                        class="glyphicon glyphicon-star"></span>&nbsp;&nbsp;<?php echo L('my_title');?></a>
                                </li>
                                <?php $register_type=modC('REGISTER_TYPE','normal','Invite'); $register_type=explode(',',$register_type); if(in_array('invite',$register_type)){ ?>
                                <li><a href="<?php echo U('ucenter/Invite/invite');?>"><span
                                        class="glyphicon glyphicon-star"></span>&nbsp;&nbsp;<?php echo L('invite_friends');?></a>
                                </li>
                                <?php } ?>

                                <?php echo hook('personalMenus');?>
                                <?php if(check_auth('Admin/Index/index')): ?><li><a href="<?php echo U('Admin/Index/index');?>" target="_blank"><span
                                            class="glyphicon glyphicon-dashboard"></span>&nbsp;&nbsp;<?php echo L('manage_background');?></a></li><?php endif; ?>
                                <li><a event-node="logout"><span
                                        class="glyphicon glyphicon-off"></span>&nbsp;&nbsp;<?php echo L('logout');?></a>
                                </li>
                            </ul>
                        </li>
                        <li class="top_spliter "></li>
                        <?php else: ?>


                        <li class="top_spliter "></li>
                        <?php $open_quick_login=modC('OPEN_QUICK_LOGIN', 0, 'USERCONFIG'); $register_type=modC('REGISTER_TYPE','normal','Invite'); $register_type=explode(',',$register_type); $only_open_register=0; if(in_array('invite',$register_type)&&!in_array('normal',$register_type)){ $only_open_register=1; } ?>
                        <script>
                            var OPEN_QUICK_LOGIN = "<?php echo ($open_quick_login); ?>";
                            var ONLY_OPEN_REGISTER = "<?php echo ($only_open_register); ?>";
                        </script>
                        <li class="">
                            <a data-login="do_login"><?php echo L('login');?></a>
                        </li>
                        <li class="">
                            <a data-role="do_register" data-url="<?php echo U('Ucenter/Member/register');?>"><?php echo L('register');?></a>
                        </li>
                        <li class="spliter "></li><?php endif; ?>
                </ul>

            </div>
            <!--导航栏菜单项-->

        </nav>
    </div>
</div>

<!--换肤插件钩子-->
<?php echo hook('setSkin');?>
<!--换肤插件钩子 end-->
<a id="goTopBtn"></a>
<?php if(is_login()&&(get_login_role_audit()==2||get_login_role_audit()==0)){ ?>
<div id="top-role-tip" class="alert alert-danger" style="margin-top: 65px;margin-bottom: -50px;"><?php echo L('tip_role_not_audited1');?> <strong><?php echo L('tip_role_not_audited2');?></strong><?php echo L('tip_role_not_audited3');?>
    <a target="_blank" href="<?php echo U('ucenter/config/role');?>"><?php echo L('tip_role_not_audited4');?></a>
</div>
<script>
    $(function(){
        $('#top-role-tip').css('margin-top',$('#nav_bar').height()+$('#sub_nav').height()+15);
        $('#top-role-tip').css('margin-bottom',-($('#nav_bar').height()+$('#sub_nav').height()));
    });
</script>
<?php } ?>
<!--顶部导航之后的钩子，调用公告等-->
<?php echo hook('afterTop');?>
<!--顶部导航之后的钩子，调用公告等 end-->


	<!-- /头部 -->
	
	<!-- 主体 -->
	
    <div id="sub_nav">
    <?php $logo = get_cover(modC('LOGO',0,'Config'),'path'); $logo = $logo?$logo:'/internship-tour/Public/images/logo.png'; ?>

    <nav class="navbar navbar-default" >
        <div class="container"  style="width:1180px;">
            <a class="navbar-brand logo" href="<?php echo U('index');?>"><i class="icon-group"></i> <?php echo L('fp');?></a>
            <ul class="nav navbar-nav navbar-left">
                <li id="tab_index">
                    <a href="<?php echo U('index');?>"><?php echo L('fp_by_tag');?></a>
                </li>
            </ul>
            <script>
                $('#tab_<?php echo ($tab); ?>').addClass('active');
                var follower = {
                    'bind_follow': function () {
                        $('[data-role="follow"]').unbind('click')
                        $('[data-role="follow"]').click(function () {
                            var $this = $(this);
                            var uid = $this.attr('data-follow-who');
                            $.post(U('Core/Public/follow'), {uid: uid}, function (msg) {
                                if (msg.status) {

                                    $this.attr('class', $this.attr('data-before'));
                                    $this.attr('data-role', 'unfollow');
                                    $this.html('<?php echo L("already");?> <?php echo L("followers");?>');
                                    follower.bind_follow();
                                    toast.success(msg.info, <?php echo L('prompt');?>);
                                } else {
                                    toast.error(msg.info,<?php echo L('prompt');?>);
                                }
                            }, 'json');
                        })

                        $('[data-role="unfollow"]').unbind('click')
                        $('[data-role="unfollow"]').click(function () {
                            var $this = $(this);
                            var uid = $this.attr('data-follow-who');
                            $.post(U('Core/Public/unfollow'), {uid: uid}, function (msg) {
                                if (msg.status) {
                                    $this.attr('class', $this.attr('data-after'));
                                    $this.attr('data-role', 'follow');
                                    $this.html('<?php echo L("followers");?>');
                                    follower.bind_follow();
                                    toast.success(msg.info,<?php echo L('prompt');?>);
                                } else {
                                    toast.error(msg.info, <?php echo L('prompt');?>);
                                }
                            }, 'json');
                        })
                    }
                }
            </script>
            <form class="navbar-form navbar-right" action="<?php echo U('People/Index/index');?>"  method="post" role="search">
                <input  type="hidden" name="tag" value="<?php echo ($tag_id); ?>">
                <input  type="hidden" name="role" value="<?php echo ($role_id); ?>">
                <div class="search-input-group">
                    <a href="javascript:void(0);" onclick="$(this).parents('form').submit();" class="input-btn"><i class="icon-search"></i></a>
                    <input type="text" class="input" placeholder="<?php echo L('nickname');?>" name="keywords" value="<?php echo ($nickname); ?>">
                </div>
                </span>
            </form>
        </div>
    </nav>
</div>

<div id="main-container" class="container">
    <script>
        adjust_navbar();
    </script>
    <div class="row" >
        

    <div class="container">
        

    <div class="row">

        <?php if(!empty($tag_list)||!empty($role_list)): ?><div class="col-xs-12">
                <form id="tag-select" class="form-horizontal" action="<?php echo U('People/Index/index');?>" method="post">
                    <input type="hidden" name="role" data-role="role-id" value="<?php echo ($role_id); ?>">
                    <input type="hidden" name="tag" data-role="tag-id" value="<?php echo ($tag_id); ?>">
                    <input type="hidden" name="keywords" data-role="keywords" value="<?php echo ($nickname); ?>">
                    <div class="common-block margin-bottom-15" style="padding-bottom: 10px;border: 1px solid #ddd;">
                        <?php if(!empty($role_list)): ?><ul class="nav nav-tabs" style="margin-left: -1px;">
                                <li id="role_tab_">
                                    <a data-role="select_role" data-id="0" style="border-top: none;padding-top: 9px;"><?php echo L('all');?></a>
                                </li>
                                <?php if(is_array($role_list)): $i = 0; $__LIST__ = $role_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$role): $mod = ($i % 2 );++$i;?><li id="role_tab_<?php echo ($role["id"]); ?>">
                                        <a data-role="select_role" data-id="<?php echo ($role["id"]); ?>" style="border-top: none;padding-top: 9px;"><?php echo ($role["title"]); ?></a>
                                    </li><?php endforeach; endif; else: echo "" ;endif; ?>
                            </ul>
                            <script>
                                var now_role_id="<?php echo ($role_id); ?>";
                                $('#role_tab_'+now_role_id).addClass('active');
                            </script><?php endif; ?>
                        <div id="tag_list_block" style="overflow: hidden;">
                            <?php if(!empty($tag_list)): if(is_array($tag_list)): $i = 0; $__LIST__ = $tag_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tag_group): $mod = ($i % 2 );++$i;?><div class="tag-select-block clearfix" style="padding-top:10px;">
                                        <div class="select-cate"><?php echo ($tag_group["title"]); ?>：</div>
                                        <div class="select-option">
                                            <?php if(is_array($tag_group['tag_list'])): $i = 0; $__LIST__ = $tag_group['tag_list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tag): $mod = ($i % 2 );++$i;?><div class="one_tag"><a data-role="select_tag" data-id="<?php echo ($tag["id"]); ?>"
                                                    <?php if($tag_id == $tag['id']): ?>class="tag active"
                                                        <?php else: ?>
                                                        class="tag"<?php endif; ?>
                                                    ><?php echo ($tag["title"]); ?></a></div><?php endforeach; endif; else: echo "" ;endif; ?>
                                        </div>
                                    </div><?php endforeach; endif; else: echo "" ;endif; endif; ?>
                        </div>
                        <div id="show_more_button_block" class="tag-select-block clearfix" style="padding-top:10px;text-align: center;border-top: 1px dashed #CDCDCD;display: none;">
                            <a href="javascript:void(0);" data-role="show_more_button" act-type="down" style="display: inline-block;width: 100%;">
                                <?php echo L("unfold"); echo L("all");?><i class="icon-double-angle-down" style="font-size: 16px;margin-left: 5px;"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div><?php endif; ?>
        <?php if(!empty($tag_list)||!empty($role_list)): ?><script>
                var show_height="<?php echo modC('MAX_SHOW_HEIGHT','160','People');?>";
                var tag_list_block_height=$('#tag_list_block').height();
                $(function () {
                    if(tag_list_block_height>show_height){
                        set_tag_list();
                        $('[data-role="show_more_button"]').click(function(){
                            var click_type=$(this).attr('act-type');
                            if(click_type=='down'){
                                $(this).attr('act-type','up');
                                $(this).html('<?php echo L("temp_fold");?><i class="icon-double-angle-up" style="font-size: 16px;margin-left: 5px;"></i>');
                                $('#tag_list_block').animate({"height":tag_list_block_height});
                            }else{
                                $(this).attr('act-type','down');
                                $(this).html('<?php echo L("unfold"); echo L("all");?><i class="icon-double-angle-down" style="font-size: 16px;margin-left: 5px;"></i>');
                                $('#tag_list_block').animate({"height":show_height});
                            }
                        });
                    }

                    $('[data-role="select_tag"]').click(function () {
                        var id = $(this).attr('data-id');
                        $('[data-role="tag-id"]').val(id);
                        $('#tag-select').submit();
                    });
                    $('[data-role="select_role"]').click(function () {
                        var id = $(this).attr('data-id');
                        $('[data-role="role-id"]').val(id);
                        $('[data-role="tag-id"]').val('');
                        $('#tag-select').submit();
                    });
                });
                var set_tag_list=function(){
                    $('#tag_list_block').css("height",show_height);
                    $('#show_more_button_block').show();
                }

            </script><?php endif; ?>

    </div>



        <div class="row">
            <?php if(is_array($lists["data"])): $i = 0; $__LIST__ = $lists["data"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="col-xs-3 ">
    <div class="user-card">
        <div style="position: absolute;top: 5px;right:15px">
            <?php echo W('Common/UserRank/render',array($vo['uid']));?>
        </div>
        <div class="top_self" style="background: white;height: 70px;border-radius: 3px">

        </div>
        <div class="user_info" style="padding: 0;background-color: #ffffff;">

            <div class="avatar-bg">
                <div class="headpic ">
                    <a href="<?php echo ($vo["space_url"]); ?>" ucard="<?php echo ($vo["uid"]); ?>">
                        <img src="<?php echo ($vo["avatar128"]); ?>" class="avatar-img" style="width:80px;"/>
                    </a>
                </div>
                <div class="clearfix " style="margin-bottom:8px">
                    <div class="clearfix text-ellipsis">
                        <div class="col-xs-12 nickname" style="text-align: center">
                        <span class="">
                            <?php echo ($vo["title"]); ?>
                        <a ucard="<?php echo ($vo["uid"]); ?>" href="<?php echo ($vo["space_url"]); ?>"
                           class="user_name "><?php echo (htmlspecialchars($vo["nickname"])); ?></a>

                            </span>
                        </div>
                    </div>
                    <script>
                        $(function () {
                            $('#upgrade_' + '<?php echo ($vo["uid"]); ?>').tooltip({
                                        html: true,
                                        title: '<?php echo L("current_stage");?>：<?php echo ($vo["title"]); ?> <br/><?php echo L("next_stage");?>：<?php echo ($vo["level"]["next"]); ?><br/><?php echo L("now");?>：<?php echo ($vo["score"]); ?><br/><?php echo L("need");?>：<?php echo ($vo["level"]["upgrade_require"]); ?><br/><?php echo ("remain"); echo ("need");?>： <?php echo ($vo["level"]["left"]); ?><br/><?php echo ("lv_up_progress");?>：<?php echo ($vo["level"]["percent"]); ?>% <br/> '
                                    }
                            );
                        })
                    </script>

                </div>

                <div id="upgrade_<?php echo ($vo["uid"]); ?>" data-toggle="tooltip" data-placement="bottom" title=""
                     style="padding-bottom: 10px;padding-top: 10px">
                    <div style="border-top:1px solid #eee;"></div>
                    <div style="border-top: 1px solid rgb(3, 199, 3);margin-top: -1px;width: <?php echo ($vo["level"]["percent"]); ?>%;z-index: 9999;">

                    </div>
                </div>
                <div class="clearfix user-data">

                    <div class="col-xs-4 text-center">
                        <a href="<?php echo U('Ucenter/index/fans',array('uid'=>$vo['uid']));?>" title="<?php echo L('fans'); echo L('number');?>"><?php echo ($vo["fans"]); ?></a><br><?php echo L('fans');?>
                    </div>
                    <div class="col-xs-4 text-center">
                        <a href="<?php echo U('Ucenter/index/following',array('uid'=>$vo['uid']));?>"
                           title="<?php echo L('followers'); echo L('number');?>"><?php echo ($vo["following"]); ?></a><br><?php echo L('followers');?>
                    </div>
                    <div class="col-xs-4 text-center">
                        <?php if(is_login() && $vo['uid'] != get_uid()): ?><p class="text-center">
                                <?php echo W('Common/Follow/follow',array('follow_who'=>$vo['uid'],'btn-before','btn-after'));?>
                            </p>
                            <?php else: ?>
                            <?php if($vo['uid'] == get_uid()): ?><p class="text-center">
                                    <a class="" disabled="disabled" style="  line-height: 40px;">
                                        <?php echo L('self');?>
                                    </a>
                                </p><?php endif; endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>


<script>

</script><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
    </div>
    <?php if($lists['count'] == 0): ?><div style="font-size:3em;padding:2em 0;color: #ccc;text-align: center"><?php echo L('no_one');?></div><?php endif; ?>

    <div class="pull-right">
        <?php echo ($lists["html"]); ?>
    </div>

    </div>


    </div>
</div>

<script type="text/javascript">
    $(function(){
        $(window).resize(function(){
            $("#main-container").css("min-height", $(window).height() - 343);
        }).resize();
    })
</script>
	<!-- /主体 -->

	<!-- 底部 -->
	<div class="footer-bar ">

    <div class="container">
        <div class="row">
            <div class="col-xs-4">

                <h2>
                    <i class="icon-location-arrow"></i> <?php echo L('about_us');?>
                </h2>
                <p>
                    <?php echo modC('ABOUT_US',L('not_set_now'),'Config');?>
                </p>
            </div>
            <div class="col-xs-4">
                <h2>
                    <i class="icon-star-empty"></i> <?php echo L('follow_us');?>
                </h2>
                <p>
                    <?php echo modC('SUBSCRIB_US',L('not_set_now'),'Config');?>
                </p>
            </div>
            <div class="col-xs-4">
                <h2>
                    <i class="icon-link"></i> <?php echo L('friendly_link');?>
                </h2>

                <ul class="friend-link">
                    <?php echo Hook('friendLink');?>
                </ul>

            </div>
        </div>

        <div class="row text-center">
            <hr>

                <h4> <?php echo modC('COPY_RIGHT',L('not_set_now'),'Config');?></h4>
                <div class="col-xs-12"><?php echo L('Record_n');?><a href="http://www.miitbeian.gov.cn/" target="_blank">
                    <?php echo modC('ICP',L('not_set_now'),'Config');?> </a>
                </div>

            <?php echo ($count_code); ?>
            <div>
                Powered by <a href="http://www.opensns.cn">OpenSNS</a>
            </div>

        </div>
    </div>

</div>
<div>
    <?php echo C('COUNT_CODE');?>
</div>
<!-- jQuery (ZUI中的Javascript组件依赖于jQuery) -->

<script>
    $(window).resize(adjust_navbar).resize()

</script>
<!-- 为了让html5shiv生效，请将所有的CSS都添加到此处 -->
<link type="text/css" rel="stylesheet" href="/internship-tour/Public/static/qtip/jquery.qtip.css"/>



<!--<script type="text/javascript" src="/internship-tour/Public/js/com/com.notify.class.js"></script>-->

<!-- 其他库-->
<!--<script src="/internship-tour/Public/static/qtip/jquery.qtip.js"></script>
<script type="text/javascript" src="/internship-tour/Public/js/ext/slimscroll/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="/internship-tour/Public/static/jquery.iframe-transport.js"></script>

<script type="text/javascript" src="/internship-tour/Public/js/ext/magnific/jquery.magnific-popup.min.js"></script>-->
<!--CNZZ广告管家，可自行更改-->
<!--<script type='text/javascript' src='http://js.adm.cnzz.net/js/abase.js'></script>-->
<!--CNZZ广告管家，可自行更改end
 自定义js-->

<!--<script type="text/javascript" src="/internship-tour/Public/js/ext/placeholder/placeholder.js"></script>
<script type="text/javascript" src="/internship-tour/Public/js/ext/atwho/atwho.js"></script>
<script type="text/javascript" src="/internship-tour/Public/zui/js/zui.js"></script>-->
<link type="text/css" rel="stylesheet" href="/internship-tour/Public/js/ext/atwho/atwho.css"/>

<script src="/internship-tour/Public/js.php?t=js&f=js/com/com.notify.class.js,static/qtip/jquery.qtip.js,js/ext/slimscroll/jquery.slimscroll.min.js,js/ext/magnific/jquery.magnific-popup.min.js,js/ext/placeholder/placeholder.js,js/ext/atwho/atwho.js,zui/js/zui.js&v=<?php echo ($site["sys_version"]); ?>.js"></script>
<script type="text/javascript" src="/internship-tour/Public/static/jquery.iframe-transport.js"></script>

<script src="/internship-tour/Public/js/ext/lazyload/lazyload.js"></script>



<!-- 用于加载js代码 -->

<!-- 页面footer钩子，一般用于加载插件JS文件和JS代码 -->
<?php echo hook('pageFooter', 'widget');?>
<div class="hidden"><!-- 用于加载统计代码等隐藏元素 -->
    
</div>

	<!-- /底部 -->
</body>
</html>