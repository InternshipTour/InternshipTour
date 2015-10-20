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

    <link href="/internship-tour/Application/Event/Static/css/event.css" rel="stylesheet" type="text/css"/>

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
	
    <?php echo W('Common/SubMenu/render',array($sub_menu,$current,array('icon'=>'map-marker'),''));?>


<div id="main-container" class="container">
    <script>
        adjust_navbar();
    </script>
    <div class="row" >
        
<!--导航-->







    <div class="col-xs-9">



        <div class="forum_module" style="width: 100%;min-height: 800px;">

            <div class="row" style="padding: 10px 10px 0 0 ">
                <div class="col-xs-12">
                    <div class="event_header_title">
                        <div class="pull-left">活动首页</div>
                        <div class="btn-group btn-group-sm pull-right" style="margin-bottom:5px;">
                            <a href="<?php echo U('index',array('norh'=>'new','type_id'=>$type_id));?>"
                               class="btn btn-default <?php if($norh == 'new'): ?>active<?php endif; ?>">最新</a>
                            <a href="<?php echo U('index',array('norh'=>'hot','type_id'=>$type_id));?>"
                               class="btn btn-default <?php if($norh == 'hot'): ?>active<?php endif; ?>">最热</a>
                        </div>
                    </div>

                </div>

            </div>
            <?php if(is_array($contents)): $i = 0; $__LIST__ = $contents;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="clearfix event_list">
                    <div class="col-xs-5" style="padding: 0">
                        <?php if(time() < $vo['eTime']): ?><div class="event_state" style="background: #d61f39">
                                正在进行
                            </div>
                            <?php else: ?>
                            <div class="event_state" style="background: #000;">
                                已结束
                            </div><?php endif; ?>

                        <a class="pull-left" href="<?php echo U('Event/Index/detail',array('id'=>$vo['id']));?>"> <img
                                class=""
                                src="<?php echo (getthumbimagebyid($vo["cover_id"],320,210)); ?>" style="width: 320px;height: 210px;"/></a>
                    </div>
                    <div class="pull-left col-xs-7">
                        <div class="mgl20 event_title"><a href="<?php echo U('Event/Index/detail',array('id'=>$vo['id']));?>"
                                                          class="text-more" style="width: 100%"><?php echo ($vo["title"]); ?></a></div>
                        <div class="event_fq_count pull-left">
                            <div class="pull-left mgb10 col-xs-12">
                                <div class="pull-left col-xs-6 " style="padding-left: 5px;">by&nbsp; <a class=""
                                                                                                        href="<?php echo ($vo["user"]["space_url"]); ?>">
                                    <span class="event_count"><?php echo ($vo["user"]["nickname"]); ?></span></a></div>
                                <div title="报名人数" class="pull-left col-xs-3">
                                    <div class="event_logo" style=""></div>
                                    <span class="event_count">&nbsp;<?php echo ($vo["signCount"]); ?>人</span></div>
                                <div class="pull-left col-xs-3">
                                    <div class="event_logo" style="background-position: -20px 0px;"></div>
                                    <span class="event_count">&nbsp;<?php echo ($vo["view_count"]); ?></span></div>
                            </div>
                            <div class="pull-left mgb10">
                                <div class="pull-left mgl20 " style="font-size: 14px;">时间：
                                    <?php echo date('Y-m-d',$vo['sTime']);?>--<?php echo date('Y-m-d',$vo['eTime']);?> &nbsp;&nbsp;
                                    <?php echo ($vo["type"]["title"]); ?>
                                </div>
                            </div>

                            <div class="pull-left mgb10">
                                <div class="pull-left mgl20 " style="font-size: 14px;">报名截止时间：
                                    <?php echo date('Y-m-d',$vo['deadline']);?> &nbsp;&nbsp;

                                </div>
                            </div>
                            <div class="word-wrap pull-left mgl20 event_short_explain" style="width: 80%">简介：
                                <?php echo (getshortsp(op_t($vo["explain"]),30)); ?>
                            </div>
                            <div class="pull-left mgl20 mgt10" style=" ">
                                <div class="btn-group">
                                    <?php if(($vo['uid'] == is_login()) OR is_administrator(is_login())): if(time() < $vo['eTime']): ?><a class="btn btn-default endEvent" data-eventID="<?php echo ($vo["id"]); ?>">提前结束</a><?php endif; ?>

                                        <a href="<?php echo U('edit',array('id'=>$vo['id']));?>" class="btn btn-default">编辑活动</a>
                                        <a class="btn btn-default delEvent" data-eventID="<?php echo ($vo["id"]); ?>">删除活动</a><?php endif; ?>
                                    <?php if(($vo['uid'] != is_login())): if(!$vo['check_isSign']){ ?>

                                        <?php if($vo['deadline'] < time()){ ?>
                                        <a class="btn btn-default  " href="javascript:"
                                           onclick="toast.error('报名已截止')">报名已截止 </a>
                                        <?php }else{ ?>
                                        <?php if(is_login() == 0): ?><a class="btn btn-info  " href="javascript:" style="color: #fff"
                                               onclick="toast.error('请登陆后再报名')">报名参加 </a>
                                            <?php else: ?>
                                            <?php if(check_auth('Event/Index/doSign')): ?><a class="btn btn-primary event_sign " style="color: #fff"
                                               href="<?php echo U('ajax_sign',array('event_id'=>$vo['id']));?>">报名参加 </a><?php endif; endif; ?>
                                        <?php } ?>
                                        <?php }else{ ?>
                                        &nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-default unSign"
                                                                   data-eventID="<?php echo ($vo["id"]); ?>" href="javascript:"
                                                                   id="unSign">取消报名 </a>

                                        <span style="line-height: 34px;"> 已报名&nbsp;&nbsp;&nbsp;&nbsp;<?php if($vo['check_isSign'][0]['status'] == 1): ?>已审核
                                            <?php else: ?>
                                            未审核<?php endif; ?></span>

                                        <?php } endif; ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div><?php endforeach; endif; else: echo "" ;endif; ?>
            <div class="row issue_list">


                <?php if(count($contents) == 0): ?><div style="font-size:3em;padding:2em 0;color: #ccc;text-align: center">此分类下暂无内容哦。O(∩_∩)O~</div><?php endif; ?>

            </div>
        </div>

        <div>
            <div class="pull-right">

                <?php echo getPagination($totalPageCount,10);?>
            </div>
        </div>
    </div>
    <div class="col-xs-3" style="z-index: 99">
        <div style="margin-bottom: 12px">
    <?php if(is_login() == 0): ?><button class="btn btn-primary btn-large event_btn" onclick="toast.error('请登陆后再发布。','温馨提示')">发起活动
        </button>
        <?php else: ?>
        <a class="btn btn-primary btn-large event_btn " href="<?php echo U('Event/Index/add');?>">发起活动
        </a><?php endif; ?>
</div>
<div class="common_block_border event_right">
    <div class="common_block_title_right">活动分类</div>

    <div class="event_type clearfix" style="padding: 0 5px;margin-bottom: 5px">
        <a style="float: left" href="<?php echo U('index',array('norh'=>$norh));?>"
        <?php if(($type_id) == ""): ?>class="cur"<?php endif; ?>
        >全部分类</a>
        <?php if(is_array($tree)): $i = 0; $__LIST__ = $tree;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$top): $mod = ($i % 2 );++$i;?><a style="float: left"
            <?php if(($type_id) == $top['id']): ?>class="cur"<?php endif; ?>
            href="<?php echo U('index',array('type_id'=>$top['id'],'norh'=>$norh));?>" data="<?php echo ($top["id"]); ?>"><?php echo ($top["title"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
</div>




<?php if(ACTION_NAME == 'detail' ){ ?>
<div class="forum_module " style="width:100%;float: left;">
    <h2 class="event_type_name">参与活动的人 (<?php echo ($content["attentionCount"]); ?>人) <a class="pull-right"
                                                                       href="<?php echo U('member',array('id'=>$content['id']));?>"
                                                                       style="font-size: 14px;margin-right: 10px;color: #848484">全部</a>
    </h2>

    <div style="width: 100%">
        <?php if(is_array($content['member'])): $i = 0; $__LIST__ = array_slice($content['member'],0,20,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="" style="text-align: center;width:75px;float: left;height: 75px;line-height: 80px;">
                <a href="<?php echo ($vo["space_url"]); ?>">
                    <img ucard="<?php echo ($vo["id"]); ?>" src="<?php echo ($vo["avatar64"]); ?>" class="avatar-img" style="width: 64px"/>
                </a>
            </div><?php endforeach; endif; else: echo "" ;endif; ?>
    </div>

</div>
<?php } ?>

<?php echo W('RecommendEvent/recommendEvent');?>
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




    <script type="text/javascript" src="/internship-tour/Public/static/uploadify/jquery.uploadify.min.js"></script>
    <script type="text/javascript" src="/internship-tour/Application/Event/Static/js/event.js"></script>
    <script>
        $(function () {
            $('#top_nav >li >a ').mouseenter(function () {
                $('.children_nav').hide();
                $('#children_' + $(this).attr('data')).show();
            });



        })
    </script>

    <script type="text/javascript">
        var SUPPORT_URL = "<?php echo addons_url('Support://Support/doSupport');?>";

    </script>


<!-- 页面footer钩子，一般用于加载插件JS文件和JS代码 -->
<?php echo hook('pageFooter', 'widget');?>
<div class="hidden"><!-- 用于加载统计代码等隐藏元素 -->
    
</div>

	<!-- /底部 -->
</body>
</html>