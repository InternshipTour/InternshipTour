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
<!--Style-->
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
    <link type="text/css" rel="stylesheet" href="/internship-tour/Application/Forum/Static/css/forum.css"/>
    <script type="text/javascript" src="/internship-tour/Application/Forum/Static/js/common.js"></script>
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


<div id="sub_nav">
    <?php $logo = get_cover(modC('LOGO',0,'Config'),'path'); $logo = $logo?$logo:'/internship-tour/Public/images/logo.png'; ?>

    <nav class="navbar navbar-default" >
        <div class="container"  style="width:1180px;">
            <a class="navbar-brand logo" href="<?php echo U('Forum/Index/index');?>"><i class="icon-comments"></i> <?php echo L('module');?></a>
            <ul class="nav navbar-nav navbar-left">
                <li id="tab_index">
                    <a href="<?php echo U('Forum/Index/index');?>"><?php echo L('home');?></a>
                </li>
                <li id="tab_lists"><a href="<?php echo U('forum/index/lists');?>"><?php echo L('belonged_section');?></a></li>
                <li id="tab_look"><a href="<?php echo U('forum/index/look');?>"><?php echo L('having_a_look');?></a></li>
                <!--<li><a>我的版块</a></li>-->
            </ul>
            <script>
                $('#tab_<?php echo ($tab); ?>').addClass('active');
            </script>
            <form class="navbar-form navbar-right" action="<?php echo U('Forum/Index/search');?>" method="post"
                  role="search">
                <div class="search-input-group">
                    <a type="submit" class="input-btn"><i class="icon-search"></i> </a>
                    <input type="text" name="keywords" class="input" placeholder="<?php echo L('search');?>">
                </div>
                </span>
            </form>
        </div>
    </nav>
</div>
<!-- /头部 -->

<!-- 主体 -->
<div id="main-container" class="">
    <div id="body-container" class="container  common-block">
        <link type="text/css" rel="stylesheet" href="/internship-tour/Application/Forum/Static/css/forum.css"/>
<?php if(ACTION_NAME != 'edit'): endif; ?>
<?php if($forum_id == 0): else: ?>
    <div class="forum-header row ">
        <div class=" cover-header"><img class="cover" src="<?php echo ($forum["background"]); ?>"/>
            <img class="logo" src="<?php echo ($forum["logo"]); ?>"/>
        </div>
        <div class="content-block">
            <div class="title">
                <a href="<?php echo U('forum/index/forum',array('id'=>$forum['id']));?>" class=""><?php echo (op_t($forum["title"])); ?></a>

            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="summary"><?php echo ($forum["description"]); ?></div>
                    <div class="count">
                        <?php echo L('subject_count'); echo L('colon'); echo ($forum["topic_count"]); ?> &nbsp;&nbsp;&nbsp;
                        <?php echo L('post_count'); echo L('colon'); echo ($forum["total_count"]); ?>
                    </div>
                </div>
                <div class="col-xs-3  text-right">
                    <?php if(($hasFollowed) == "0"): ?><button class="btn btn-primary btn-lg" onclick="forum.following(this)" data-id="<?php echo ($forum["id"]); ?>"><i class="icon-heart-empty"></i> <span><?php echo L('followers');?></span></button>
                        <?php else: ?>
                        <button class="btn btn-default btn-lg" onclick="forum.following(this)" data-id="<?php echo ($forum["id"]); ?>" ><i class="icon-heart"></i> <span><?php echo L('followed');?></span></button><?php endif; ?>

                </div>
            </div>

        </div>

    </div><?php endif; ?>

        <div class="col-xs-9">

            <div class="container-fluid">
                
                    <div class="common-block-lg">
                        <header><?php echo L('recommend_post');?></header>

                        <div class="suggestion clearfix">
                            <div class="col-xs-6">
                                <div>
                                    <div>
                                        <a target="_blank" href="<?php echo U('detail',array('id'=>$suggestionPosts[0][id]));?>"><img
                                                class="first-cover" src="<?php echo ($suggestionPosts["0"]["cover"]); ?>"/></a>
                                    </div>
                                    <div>
                                        <h3>
                                            <a target="_blank" href="<?php echo U('detail',array('id'=>$suggestionPosts[0][id]));?>"><?php echo (text($suggestionPosts["0"]["title"])); ?></a>
                                        </h3>

                                        <p class="text-muted">
                                            <?php echo ($suggestionPosts["0"]["summary"]); ?>
                                        </p>

                                        <p><i class="text-muted icon-time"></i>
                                            <?php echo (friendlydate($suggestionPosts["0"]["create_time"])); ?> &nbsp;&nbsp;<i
                                                    class="text-muted icon-eye-open"></i> <?php echo ($suggestionPosts["0"]["view_count"]); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <ul class="topics">
                                    <?php for($i=1;$i<5;$i++){ $post=$suggestionPosts[$i]; ?>
                                    <li>
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <a target="_blank" href="<?php echo U('detail',array('id'=>$post[id]));?>"><img
                                                        class="small_cover"
                                                        src="<?php echo ($post["cover"]); ?>"/></a>
                                            </div>
                                            <div class="col-xs-9">
                                                <div>
                                                    <h3 class="title text-ellipsis">
                                                        <a target="_blank"
                                                           href="<?php echo U('detail',array('id'=>$post[id]));?>"><?php echo (text($post["title"])); ?></a>
                                                    </h3>

                                                    <p class="text-muted summary">
                                                        <?php echo (text($post["summary"])); ?>
                                                    </p>

                                                    <p class="">
                                                        <i class="text-muted icon-time"></i>
                                                        <?php echo (friendlydate($post["create_time"])); ?> &nbsp;&nbsp;<i
                                                            class="text-muted icon-eye-open"></i> <?php echo ($post["view_count"]); ?>
                                                    </p>
                                                </div>

                                            </div>
                                        </div>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </div>

                        </div>

                    </div>

                    <div>
                        <?php if($list_top): ?><div class=" fourm-posts common_block_border">
                                <div class="row common_block_title">
                                    <?php echo L('top_post');?>
                                </div>
                                <div class="col-xs-12">
                                    <section id="contents">
                                        <?php if(is_array($list_top)): $i = 0; $__LIST__ = $list_top;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; $user = query_user(array('avatar128','avatar64','nickname','uid','space_url'), $vo['uid']); ?>
<div class="clearfix">
    <div class="col-xs-2 text-center">
        <p>
            <a href="<?php echo ($user["space_url"]); ?>">
                <img src="<?php echo ($user["avatar64"]); ?>" ucard="<?php echo ($user["uid"]); ?>" class="avatar-img"/>
            </a>
        </p>
    </div>
    <div class="col-xs-10">
        <p>
            <a class="forum_forum_name" href="<?php echo U('Forum/Index/forum',array('id'=>$vo['forum_id']));?>">[<?php echo (text($vo["forum"]["title"])); ?>]</a>
            <a class="forum-list-title-link" title="<?php echo (text($vo["title"])); ?>"
               href="<?php echo U('Index/detail',array('id'=>$vo['id']));?>"><?php echo (mb_substr(htmlspecialchars($vo["title"]),0,30,'utf-8')); ?>
            </a>
            <?php if(($document["is_top"]) == "2"): ?><span class="label label-badge label-danger"><?php echo L('all_site');?></span>
                <?php else: ?>
                <?php if(($document["is_top"]) == "1"): ?><span class="label label-badge label-info"><?php echo L('section');?></span><?php endif; endif; ?>
        </p>

        <p class="pull-right text-muted">
            <span><?php echo L('read');?>（<?php echo ($vo["view_count"]); ?>）</span>
            <span style="width: 1em; display: inline-block;">&nbsp;</span>
            <span><?php echo L('reply');?>（<?php echo ($vo["reply_count"]); ?>）</span>
        </p>

        <p class="text-muted author">
            <a href="<?php echo ($user["space_url"]); ?>" ucard="<?php echo ($user["uid"]); ?>"><?php echo (op_t($user["nickname"])); ?></a>
            <?php echo L('publish');?>：<?php echo (friendlydate($vo["create_time"])); ?> |
            <?php echo L('reply');?>：<?php echo (friendlydate($vo["last_reply_time"])); ?>
        </p>
    </div>
</div>


                                            <?php if($i != count($list_top)): ?><hr class="forum-list-hr"/>
                                                <?php else: ?>
                                                <div class="forum-list-no-hr"></div><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                                    </section>
                                </div>
                            </div><?php endif; ?>
                        <div class="clearfix fourm-posts common_block_border">

                            <div class="clearfix  margin-bottom-15">
                                <div class="col-xs-6">
                                    <ul class="nav nav-secondary">
                                        <li class="active"><a href="<?php echo U('index');?>"><?php echo L('all_post');?></a></li>
                                        <!--<li><a href="<?php echo U('my');?>">我的版块</a></li>-->
                                    </ul>
                                </div>
                                <div class="col-xs-6">
                                    <div class="pull-right text-right" style="margin-right: 15px">
                                        <div class="margin-bottom-10"></div>
                                        <div class="btn-group forum_order">
                                            <button type="button" class="btn btn-primary dropdown-toggle"
                                                    data-toggle="dropdown">
                                                <?php if(($order) == "0"): echo L('reply_time');?>
                                                    <?php else: ?>
                                                    <?php echo L('publish_time'); endif; ?>
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu text-left" role="menu">
                                                <li>
                                                    <a href="<?php echo U('forum',array('id'=>$forum_id,'order'=>'ctime'));?>"><?php echo L('publish_time');?></a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo U('forum',array('id'=>$forum_id,'order'=>'reply'));?>"><?php echo L('reply_time');?></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>


                            </div>


                            <div class="col-xs-12">
                                <section id="contents">
                                    <?php if(!$list): ?><div class="row">
                                            <div class="col-xs-12">
                                                <p class="text-muted" style="text-align: center; font-size: 3em;">
                                                    <br/><br/>
                                                    <?php echo L('not_found');?>
                                                    <br/><br/><br/>
                                                </p>
                                            </div>
                                        </div><?php endif; ?>
                                    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; $user = query_user(array('avatar128','avatar64','nickname','uid','space_url'), $vo['uid']); ?>
<div class="clearfix">
    <div class="col-xs-2 text-center">
        <p>
            <a href="<?php echo ($user["space_url"]); ?>">
                <img src="<?php echo ($user["avatar64"]); ?>" ucard="<?php echo ($user["uid"]); ?>" class="avatar-img"/>
            </a>
        </p>
    </div>
    <div class="col-xs-10">
        <p>
            <a class="forum_forum_name" href="<?php echo U('Forum/Index/forum',array('id'=>$vo['forum_id']));?>">[<?php echo (text($vo["forum"]["title"])); ?>]</a>
            <a class="forum-list-title-link" title="<?php echo (text($vo["title"])); ?>"
               href="<?php echo U('Index/detail',array('id'=>$vo['id']));?>"><?php echo (mb_substr(htmlspecialchars($vo["title"]),0,30,'utf-8')); ?>
            </a>
            <?php if(($document["is_top"]) == "2"): ?><span class="label label-badge label-danger"><?php echo L('all_site');?></span>
                <?php else: ?>
                <?php if(($document["is_top"]) == "1"): ?><span class="label label-badge label-info"><?php echo L('section');?></span><?php endif; endif; ?>
        </p>

        <p class="pull-right text-muted">
            <span><?php echo L('read');?>（<?php echo ($vo["view_count"]); ?>）</span>
            <span style="width: 1em; display: inline-block;">&nbsp;</span>
            <span><?php echo L('reply');?>（<?php echo ($vo["reply_count"]); ?>）</span>
        </p>

        <p class="text-muted author">
            <a href="<?php echo ($user["space_url"]); ?>" ucard="<?php echo ($user["uid"]); ?>"><?php echo (op_t($user["nickname"])); ?></a>
            <?php echo L('publish');?>：<?php echo (friendlydate($vo["create_time"])); ?> |
            <?php echo L('reply');?>：<?php echo (friendlydate($vo["last_reply_time"])); ?>
        </p>
    </div>
</div>


                                        <?php if($i != count($list)): ?><hr class="forum-list-hr"/>
                                            <?php else: ?>
                                            <div class="forum-list-no-hr"></div><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                                    <div class="pull-right">
                                        <?php echo getPagination($totalCount,modC('FORM_POST_SHOW_NUM_INDEX',5,'Forum'));?>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>

                    <!--  板块幻灯片-->
                    <!--    <div class="bankuaippt row  fourm-posts forum_block_border">
                            <div class="col-xs-12">tg</div>
                        </div>-->


                
            </div>
        </div>
        <div class="col-xs-3">
            <div>
                <h2 class="article-title"><?php echo L('hot_section');?></h2>

                <div class="clearfix position-forums">
                    <?php if(is_array($forums_hot)): $i = 0; $__LIST__ = $forums_hot;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="clearfix">
                            <div class="col-xs-4 ">
                                <a href="<?php echo U('Index/forum',array('id'=>$vo['id']));?>"><img
                                        src="<?php echo (getthumbimagebyid($vo["logo"],128,128)); ?>"> </a>
                            </div>
                            <div class="col-xs-4 text-ellipsis">
                                <a class="title" href="<?php echo U('Index/forum',array('id'=>$vo['id']));?>">
                                    <?php echo (text($vo["title"])); ?>
                                </a>

                                <div class="text-muted">
                                    <?php echo L('post');?>：<?php echo ($vo["post_count"]); ?>
                                </div>

                            </div>
                            <div class="col-xs-4">
                                <?php if(($vo["hasFollowed"]) == "1"): ?><a class="follow-simple" data-role="followingSimple"
                                       onclick="forum.following_simple(this)"
                                       data-id="<?php echo ($vo["id"]); ?>"><span>- <?php echo L('followed');?></span> </a>
                                    <?php else: ?>
                                    <a class="follow-simple" data-role="followingSimple"
                                       data-id="<?php echo ($vo["id"]); ?>"><span>+ <?php echo L('followers');?></span> </a><?php endif; ?>
                            </div>
                        </div><?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
            </div>
            <div>
                <h2 class="article-title"><?php echo L('recommend_section');?></h2>

                <div class="clearfix position-forums">
                    <?php if(is_array($forums_recommand)): $i = 0; $__LIST__ = $forums_recommand;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="clearfix">
                            <div class="col-xs-4 ">
                                <a href="<?php echo U('Index/forum',array('id'=>$vo['id']));?>"><img
                                        src="<?php echo (getthumbimagebyid($vo["logo"],128,128)); ?>"> </a>
                            </div>
                            <div class="col-xs-4 text-ellipsis">
                                <a class="title" href="<?php echo U('Index/forum',array('id'=>$vo['id']));?>">
                                    <?php echo (text($vo["title"])); ?>
                                </a>

                                <div class="text-muted">
                                    <?php echo L('post');?>：<?php echo ($vo["post_count"]); ?>
                                </div>

                            </div>
                            <div class="col-xs-4">
                                <?php if(($vo["hasFollowed"]) == "1"): ?><a class="follow-simple" data-role="followingSimple"
                                       data-id="<?php echo ($vo["id"]); ?>"><span>- <?php echo L('followed');?></span> </a>
                                    <?php else: ?>
                                    <a class="follow-simple" data-role="followingSimple"
                                       data-id="<?php echo ($vo["id"]); ?>"><span>+ <?php echo L('followers');?></span> </a><?php endif; ?>
                            </div>
                        </div><?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
            </div>
            <div>
                <h2 class="article-title"><?php echo L('active_user');?></h2>

                <div class="clearfix position-users">
                    <?php if(is_array($active_user)): $i = 0; $__LIST__ = $active_user;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="text-ellipsis text-center col-xs-4"><a target="_blank" ucard="<?php echo ($vo["uid"]); ?>"
                                                                           href="<?php echo ($vo["user"]["space_url"]); ?>"><img
                                class="avatar-img" src="<?php echo ($vo["user"]["avatar64"]); ?>" style="width: 64px ;height: 64px"> </a>
                            <br/>
                            <a target="_blank" href="<?php echo ($vo["user"]["space_url"]); ?>">
                                <?php echo ($vo["user"]["nickname"]); ?>
                            </a>
                        </div><?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
            </div>
        </div>

    </div>
</div>
<script type="text/javascript">
    $(function () {
        $(window).resize(function () {
            $("#main-container").css("min-height", $(window).height() - 343);
        }).resize();
    });
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