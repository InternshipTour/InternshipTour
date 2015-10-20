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
    <link href="/internship-tour/Application/Ucenter/Static/css/center.css" type="text/css" rel="stylesheet">
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

    <div id="main-container" class="container user-config">
        <div class="row">
            <div class=" col-xs-3" style="width: 220px">
                <div>
                    <div class="user-info-panel bg-primary text-center margin_bottom_10">
                        <div>
                            <img class="avatar-img" src="<?php echo ($self["avatar128"]); ?>">
                        </div>
                        <div>
                            <a class="nickname" href="<?php echo ($self["space_url"]); ?>"><?php echo ($self["nickname"]); ?></a>
                        </div>

                    </div>
                </div>
                <div>
                    <nav class="menu" data-toggle="menu">
                        <a class="btn btn-success btn-lg" href="<?php echo ($self["space_url"]); ?>"><i class="icon-user"></i> 个人主页</a>
                        <ul class="nav nav-primary side-menu">
                            <li id="info" ><a href="<?php echo U('index');?>"><i class="icon-th"></i> 资料设置</a></li>
                            <li id="tag"><a href="<?php echo U('tag');?>"><i class="icon-tag"></i> 用户标签</a></li>
                            <li id="avatar"><a href="<?php echo U('avatar');?>"><i class="icon-user"></i> 头像修改</a></li>
                            <li id="password"><a href="<?php echo U('password');?>"><i class="icon-lock"></i> 密码修改</a></li>
                            <?php if(($can_show_role) == "1"): ?><li id="role"><a href="<?php echo U('role');?>"><i class="icon-group"></i> 身份设置</a></li><?php endif; ?>
                            <li id="score"><a href="<?php echo U('score');?>"><i class="icon-bar-chart"></i> 我的积分</a></li>
                            <li id="other"><a href="<?php echo U('other');?>"><i class="icon-list-ul"></i> 其他</a></li>
                        </ul>
                    </nav>
                    <script>
                        $("#<?php echo ($tab); ?>").addClass('active');
                    </script>
                </div>
            </div>
            <div class="col-xs-9 ">
                <div id="usercenter-content-td ">
                    <div class="container-fluid common_block_border" style="min-height: 600px">
                        
<script>
    function center_toggle(name) {
        var show = $('#' + name + '_panel').css('display');
        $('.center_panel').hide();
        $('.center_arrow_right').show();
        $('.center_arrow_bottom').hide()
        if (show == 'none') {
            $('#' + name + '_panel').show();
            $('#' + name + '_toggle_right').hide();
            $('#' + name + '_toggle_bottom').show()
        } else {
            $('#' + name + '_toggle_right').show();
            $('#' + name + '_toggle_bottom').hide()
        }

    }
</script>
<div id="center">
<div id="center_base">
<div>


<div id="center_account">
    <div class="row">
        <div class="col-xs-12">
            <ul class="nav nav-secondary">
                <li class="active"><a href="#base" data-toggle="tab">基本资料</a></li>
                <?php if(is_array($profile_group_list)): $i = 0; $__LIST__ = $profile_group_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vl): $mod = ($i % 2 );++$i;?><li>
                        <a href="#expand_tab_<?php echo ($vl["id"]); ?>" data-toggle="tab"><?php echo ($vl["profile_name"]); ?></a>
                    </li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>

        </div>
    </div>
    <div class="tab-content">
        <div class="tab-pane active" id="base">
            <div class="with-padding" style="padding: 20px">
                <div class="row">
                    <div class="col-xs-8 center_info form-horizontal">
                        <?php if(check_reg_type('username')){ ?>
                        <div class="form-group">
                            <label for="aUsername" class="col-xs-2 control-label">用户名</label>

                            <div class="col-xs-10">
                                <?php if($accountInfo['username']){ ?>
                                <span class="lh32"><?php echo ($accountInfo['username']); ?></span>
                                <?php }else{ ?>
                                <input type="text" class="form-control pull-left" id="aUsername" value=""
                                       placeholder="还未设置用户名，赶快来设置吧~">
                                <a class="pull-left lh32 saveUsername" style="margin-left: 10px">设置</a>
                                <script>
                                    $(function () {
                                        $('.saveUsername').click(function () {
                                            var username = $(this).prev().val();
                                            if (!username) {
                                                toast.error('用户名不能为空！');
                                                return false;
                                            }
                                            if (confirm('用户名一经设置就不能修改，确定要设置么？')) {
                                                $.post("<?php echo U('ucenter/config/saveUsername');?>", {username: username}, function (res) {
                                                    handleAjax(res);
                                                })
                                            }
                                        })
                                    })
                                </script>
                                <?php } ?>
                            </div>
                        </div>

                        <?php } ?>

                        <?php if(check_reg_type('email')){ ?>
                        <div class="form-group">
                            <label for="aEmail" class="col-xs-2 control-label">邮箱</label>

                            <div class="col-xs-10">

                                <?php echo ((isset($accountInfo["email"]) && ($accountInfo["email"] !== ""))?($accountInfo["email"]):'未设置'); ?>
                                <a class=" lh32 " style="margin-left: 10px"
                                   data-remote="<?php echo U('ucenter/config/changeaccount',array('tag'=>'email'));?>"
                                   data-toggle="modal">修改邮箱</a>
                            </div>
                        </div>
                        <?php } ?>

                        <?php if(check_reg_type('mobile')){ ?>

                        <div class="form-group">
                            <label for="aMobile" class="col-xs-2 control-label">手机</label>

                            <div class="col-xs-10">
                                <?php echo ((isset($accountInfo["mobile"]) && ($accountInfo["mobile"] !== ""))?($accountInfo["mobile"]):'未设置'); ?>

                                <a class=" lh32 " style="margin-left: 10px"
                                   data-remote="<?php echo U('ucenter/config/changeaccount',array('tag'=>'mobile'));?>"
                                   data-toggle="modal">修改手机</a>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        <form class="form-horizontal center_info ajax-form" role="form"
                              action="<?php echo U('Ucenter/Config/index');?>" method="post">
                            <div class="form-group">
                                <label for="nickname" class="col-xs-2 control-label">昵称</label>

                                <div class="col-xs-10">
                                    <input type="text" class="form-control" id="nickname" name="nickname"
                                           value="<?php echo (op_t($user["nickname"])); ?>"
                                           placeholder="昵称">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-2 control-label">性别</label>

                                <div class="col-xs-10">
                                    <label class="radio-inline">
                                        <input name="sex" type="radio" value="1"
                                        <?php if(($user["sex"]) == "1"): ?>checked<?php endif; ?>
                                        > 男
                                    </label>
                                    <label class="radio-inline">
                                        <input name="sex" type="radio" value="2"
                                        <?php if(($user["sex"]) == "2"): ?>checked<?php endif; ?>
                                        > 女
                                    </label>
                                    <label class="radio-inline">
                                        <input name="sex" type="radio" value="0"
                                        <?php if(($user["sex"]) == "0"): ?>checked<?php endif; ?>
                                        > 保密
                                    </label>
                                </div>
                            </div>


                            <div class="form-group position">
                                <label for="email" class="col-xs-2 control-label">所在地</label>

                                <div class="col-xs-10">
                                    <?php echo hook('J_China_City',array('province'=>$user['pos_province'],'city'=>$user['pos_city'],'district'=>$user['pos_district'],'community'=>$user['pos_community']));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="signature" class="col-xs-2 control-label">个性签名</label>

                                <div class="col-xs-10">
                                    <textarea id="signature" name="signature" class="form-control"
                                              style="width: 100%; height: 6em;resize: none"><?php echo (htmlspecialchars($user["signature"])); ?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-xs-10">
                                    <button type="submit" class="btn btn-primary">保存</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>

            </div>
        </div>



            <?php if(is_array($profile_group_list)): $i = 0; $__LIST__ = $profile_group_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="tab-pane" id="expand_tab_<?php echo ($vo["id"]); ?>">
                    <form action="<?php echo U('Config/edit_expandinfo');?>" method="post" class="ajax-form">
                    <div class="with-padding">
                        <div class="row">
                            <div class="col-xs-8">
                                <input type="hidden" name="profile_group_id" value="<?php echo ($vo["id"]); ?>">
                                <div>
                                    <?php if(is_array($vo["fields"])): $i = 0; $__LIST__ = $vo["fields"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vl): $mod = ($i % 2 );++$i;?><dl>
                                            <?php echo W('InputRender/inputRender',array($vl,'personal'));?>
                                        </dl><?php endforeach; endif; else: echo "" ;endif; ?>
                                </div>
                                <?php if(count($vo['fields']) != 0): ?><input type="submit" value="保存" id="submit_btn"
                                           class="btn btn-primary expandinfo-sumbit">
                                    <?php else: ?>
                                    <span class="expandinfo-noticeinfo">该扩展信息分组没有信息！</span><?php endif; ?>
                            </div>
                        </div>
                    </div>
                </form>
                </div><?php endforeach; endif; else: echo "" ;endif; ?>

    </div>


</div>
</div>


</div>
</div>


</div>
<script type="text/javascript" src="/internship-tour/Application/Ucenter/Static/js/expandinfo-form.js"></script>

                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
    <script type="text/javascript">
        $(function () {
            $(window).resize(function () {
                $("#main-container").css("min-height", $(window).height() - 343);
            }).resize();
        })
    </script>

<!-- /主体 -->

<!-- 底部 -->
</div>
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

<script>
    $(function () {
        var $sidebar = $('#usercenter-sidebar-td');
        var $sidebar_xs = $('#usercenter-sidebar-xs');
        var $sidebar_sm = $('#usercenter-sidebar-sm');
        var $content = $('#usercenter-content-td');

        function trigger_resp() {
            var width = $(window).width();
            if (width < 768) {
                on_xs();
            } else {
                on_sm();
            }
        }

        function on_xs() {
            $sidebar_xs.append($sidebar);
            $content.css({'padding-left': 0, 'padding-right': 0});
        }

        function on_sm() {
            $sidebar_sm.prepend($sidebar);
        }

        trigger_resp();

        $(window).resize(function () {
            trigger_resp();
        })
    })
</script>

</body>
</html>