<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
<title><?php echo ($mob_seo['title']); ?> | <?php echo modC('WEBSITE_NAME','OpenSNS','Mob');?></title>
<meta name="keywords" content="<?php echo ($mob_seo['keywords']); ?>">
<meta name="description" content="<?php echo ($mob_seo['description']); ?>">

<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="format-detection" content="telephone=no">
<meta name="renderer" content="webkit">
<meta http-equiv="Cache-Control" content="no-siteapp"/>

<script src="/internship-tour/Application/Mob/Static/js/jquery.min.js"></script>
<script src="/internship-tour/Application/Mob/Static/js/amazeui.min.js"></script>
<script src="/internship-tour/Public/js/com/com.functions.js"></script>
<script src="/internship-tour/Application/Mob/Static/js/toast.js"></script>
<script src="/internship-tour/Application/Mob/Static/js/apps/base.js"></script>


<script src="/internship-tour/Public/js/ext/magnific/jquery.magnific-popup.min.js"></script>
<script src="/internship-tour/Application/Mob/Static/js/toastr/toastr.min.js"></script>
<script src="/internship-tour/Application/Mob/Static/js/toast.js"></script>
<script src="/internship-tour/Application/Mob/Static/js/dist/lrz.mobile.min.js"></script>

<link rel="stylesheet" href="/internship-tour/Application/Mob/Static/css/amazeui.min.css"/>




<link rel="stylesheet" href="/internship-tour/Application/Mob/Static/css/app.css"/>
<link rel="stylesheet" href="/internship-tour/Application/Mob/Static/js/toastr/toastr.min.css" />
<link rel="stylesheet" href="/internship-tour/Application/Mob/Static/js/diyUpload.css"/>
<link rel="stylesheet" href="/internship-tour/Application/Mob/Static/css/apps/core.css"/>
<link rel="stylesheet" href="/internship-tour/Public/js/ext/magnific/magnific-popup.css"/>
<link rel="alternate icon" type="image/png" href="assets/i/favicon.png">
<!--用于加载顶部css和js-->
<?php $config = api('Config/lists'); C($config); $count_code=C('_MOB_STATISTICALCODE'); if(empty($count_code)){ $count_code=C('COUNT_CODE'); } ?>

<script type="text/javascript">
    //全局内容的定义
    var _ROOT_ = "/internship-tour";
    var MID = "<?php echo is_login();?>";
    var MODULE_NAME="<?php echo MODULE_NAME; ?>";
    var ACTION_NAME="<?php echo ACTION_NAME; ?>";
    var CONTROLLER_NAME ="<?php echo CONTROLLER_NAME; ?>";
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

    var weibo_comment_order = "<?php echo modC('COMMENT_ORDER',0,'WEIBO');?>";
</script>

<script>
    //全局内容的定义
    var _LOADING_ = "/internship-tour/Application/Mob/Static/images/loading.jpg";
</script>
    </head>
    <body>
        <!-- 头部 -->
        <?php D('Member')->need_login(); ?>
<style>
    .header {
        text-align: center;
    }

    .header h1 {
        font-size: 200%;
        color: #333;
        margin-top: 30px;
    }

    .header p {
        font-size: 14px;
    }
</style>
<div data-am-widget="header" class="am-header am-header-default am-header-fixed am-cf">
    <?php if(!empty($top_menu_list["left"])): ?><div class="am-header-left am-header-nav">
            <?php if(is_array($top_menu_list["left"])): $i = 0; $__LIST__ = $top_menu_list["left"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i; switch($menu["type"]): case "home": ?><a href="<?php echo ($menu["href"]); ?>" class="am-fl <?php echo ($menu["a_class"]); ?>">
                            <i class="am-header-icon am-icon-home <?php echo ($menu["i_class"]); ?>"></i><?php echo ($menu["html"]); ?>
                        </a><?php break;?>
                    <?php case "back": ?><a id="goback" need-confirm="<?php echo ($menu["need_confirm"]); ?>" confirm-info="<?php echo ($menu["confirm_info"]); ?>"
                           class="<?php echo ($menu["a_class"]); ?>">
                            <span class="am-icon-chevron-left <?php echo ($menu["span_class"]); ?>"></span>
                        </a><?php break;?>
                    <?php case "message": if (is_login()) { ?>
                        <?php echo W('Mob/Message/index');?>
                        <?php } break; endswitch; endforeach; endif; else: echo "" ;endif; ?>
        </div><?php endif; ?>

    <h1 class="am-header-title <?php echo ($top_menu_list["center"]["h1_class"]); ?>">
        <i class="<?php echo ($top_menu_list["center"]["i_class"]); ?>"></i>
        <?php echo ((isset($top_menu_list["center"]["title"]) && ($top_menu_list["center"]["title"] !== ""))?($top_menu_list["center"]["title"]):"首页"); ?>
    </h1>
    <?php if(!empty($top_menu_list["right"])): ?><div class="am-header-right am-header-nav">
            <?php if(is_array($top_menu_list["right"])): $i = 0; $__LIST__ = $top_menu_list["right"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$right): $mod = ($i % 2 );++$i; switch($right["type"]): case "edit": if(isset($right['href'])): ?><a href="<?php echo ($right['href']); ?>" class="am-fl <?php echo ($right["a_class"]); ?>">
                                <i class="am-header-icon am-icon-pencil <?php echo ($right["i_class"]); ?>"></i>
                            </a>
                            <?php else: ?>
                            <script>
                                var tip_info="<?php echo ($right['info']); ?>";
                            </script>
                            <a class="am-fl <?php echo ($right['a_class']); ?>" href="javascript:void(0);" onclick="toast.error(tip_info)">
                                <i class="am-header-icon am-icon-pencil <?php echo ($right["i_class"]); ?>"></i>
                            </a><?php endif; break; endswitch; endforeach; endif; else: echo "" ;endif; ?>
            <a href="#" class="">
            </a>
        </div><?php endif; ?>
</div>
<?php if(CONTROLLER_NAME != 'Index'): ?><link href="/internship-tour/Application/Mob/Static/js/toastr/toastr.min.css" rel="stylesheet"/>

<div id="demo-view" class="" data-backend-compiled="" style="z-index: 1040">
    <nav data-am-widget="menu" class="am-menu am-menu-offcanvas1 am-no-layout" data-am-menu-offcanvas=""><a
            href="javascript: void(0)" class="am-menu-toggle"><i class="am-menu-toggle-icon am-icon-bars"></i></a>

        <div class="am-offcanvas "
             style="touch-action: pan-y; -webkit-user-select: none; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
            <div class="am-offcanvas-bar am-offcanvas-bar-flip">
                <div class="am-text-center" id="user" style="display: none">
                    <?php $user=query_user(array('nickname','avatar64')); ?>
                    <?php $map = array('status' => array('gt', -1), 'pid' => 0,'url'=>array('eq','mob/user/index')); $list=D('MobChannel')->where($map)->find(); if($list){ ?>
                    <a style="text-indent: 0px;" href="<?php echo U('mob/user/index');?>">
                        <img class="avatar-img" style="border-radius: 100%;width:64px;margin-top:20px "
                             src="<?php echo ($user["avatar64"]); ?>">
                    </a><?php }else{ ?>
                    <a style="text-indent: 0px;" >
                        <img class="avatar-img" style="border-radius: 100%;width:64px;margin-top:20px "
                             src="<?php echo ($user["avatar64"]); ?>">
                    </a>
                    <?php } ?>

                    <div class="am-text-center">
                        <a class="am-text-truncate" style="color: #fff; width: 81px;
  display: block;
  margin: 0 auto;"><?php echo ($user["nickname"]); ?></a>
                    </div>
                </div>
                <div class="am-text-center" id="signin"
                     style="display: block;font-size: 18px ; height: 44px;line-height: 44px;">
                    <a href="<?php echo U('mob/Member/index');?>">
                        <i class="am-icon-sign-in"></i>
                        &nbsp;&nbsp;&nbsp;登录
                    </a>
                </div>
                <ul class="am-menu-nav am-avg-sm-1 am-text-center">

                    <?php $map = array('status' => array('gt', -1), 'pid' => 0,'url'=>array('neq','mob/user/index')); $list=D('MobChannel')->where($map)->select(); foreach($list as &$v ){ $v['url']=U($v['url']); } ?>
                    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                            <a style="text-indent: 0px;" href="<?php echo ($vo["url"]); ?>">
                                <i class="<?php echo ($vo["icon"]); ?>"></i>
                                &nbsp;&nbsp;&nbsp;<?php echo ($vo["title"]); ?>
                            </a>
                        </li><?php endforeach; endif; else: echo "" ;endif; ?>



                    <?php if (is_login()) { ?>

                    <li>
                        <a style="text-indent: 0px;" href="<?php echo U('message/index');?>" class="am-icon-bell-o">
                            <i ></i>
                            &nbsp;&nbsp;&nbsp;消息
                        </a>
                    </li>

                    <?php } ?>
                </ul>
                <div class="am-text-center" id="signout" style="display: none;padding: 5px 0px">
                    <a>
                        <i class="am-icon-sign-out"></i>
                        &nbsp;&nbsp;&nbsp;退出
                    </a>
                </div>
            </div>
        </div>
    </nav>
</div>
<script src="/internship-tour/Application/Mob/Static/js/toastr/toastr.min.js"></script>
<script src="/internship-tour/Application/Mob/Static/js/toast.js"></script>
<script>
    var uid = '<?php echo is_login();?>';
    $(document).ready(function () {
        signout();
        if (uid > 0) {
            $('#user').show()
            $('#signin').hide()
            $('#signout').show()
        } else {
            $('#user').hide()
            $('#signin').show()
            $('#signout').hide()
        }

    });

    var signout = function () {
        $('#signout').click(function () {
            $.post("<?php echo U('Mob/Member/logout');?>", {}, function (msg) {
                if (msg.status == 1) {
                    setTimeout(function () {
                        window.location.reload();
                    }, 2000);
                    toast.success('退出成功!');
                } else {
                    toast.error(msg.info);
                }
            }, 'json')
        });
    }
</script><?php endif; ?>



        <!-- /头部 -->

        <!-- 主体 -->
        

    <div class="header">
        <div class="am-g">
            <h1><?php echo modC('WEBSITE_NAME','OpenSNS','Mob');?></h1>

            <p><?php echo modC('SUMMARY','');?></p>
        </div>
        <hr/>
    </div>

<div id="mob-main-container" class="container">
   
    <div class="am-g">
        <div class="am-u-lg-6 am-u-md-8 am-u-sm-centered">
            <form method="post" class="am-form" data-url="<?php echo U('Mob/Member/login');?>"><!--<?php echo U('Ucenter/Member/login');?>-->
                <input class="am-radius" placeholder="<?php echo ($ph); ?>" type="text" name="username" id="text" value="">
                <br>
                <input class="am-radius" placeholder="<?php echo L('password');?>" type="password" name="password" id="password"
                       value="">
                <br>
                <!--验证码-->
                <?php if (check_verify_open('login')) { ?>
                <div class="form-group">
                    <label for="verifyCode" class=".sr-only col-xs-12"
                           style="display: none"></label>

                    <div class="col-xs-5 col-sm-offset-1">
                        <input type="text" id="verifyCode" class="form-control" placeholder="验证码"
                               errormsg="请填写验证码" nullmsg="请填写验证码" datatype="*5-5" name="verify">
                    </div>
                    <div class="col-xs-6 lg_lf_fm_verify" style="margin-top: 10px;">
                        <img class="verifyimg reloadverify  " alt="点击切换" src="<?php echo U('verify');?>"
                             style="cursor:pointer;max-width: 100%">
                    </div>
                    <div class="col-xs-11 Validform_checktip text-warning lg_lf_fm_tip col-sm-offset-1"></div>
                    <div class="clearfix"></div>
                </div>
                <?php } ?>
                <!--验证码END-->
                <div class="am-checkbox" style="margin-top: 0px">

                    <input type="checkbox" value="1" name="remember" checked>记住登录

                </div>

                <div class="am-cf">
                    <button id="conf" type="button" name="" value="<?php echo L('login');?>"
                            class="am-btn am-radius am-btn-primary am-btn-sm am-fl am-btn-block">登录
                    </button>
                </div>
                <br>


                <div class="am-g" style="font-size: 12px">
                    <div class="am-u-sm-6"><a href="<?php echo U('mob/Member/foundpassword');?>"><?php echo L('forget_password');?></a></div>

                    <div class="am-u-sm-6 am-text-right">
                        <?php $register_type = modC('REGISTER_TYPE', 'normal', 'Invite'); $register_type = explode(',', $register_type); if ((!modC('REG_SWITCH', '', 'USERCONFIG'))|| (!in_array('invite', $register_type) && !in_array('normal', $register_type))) { ?>
                        <a href="javascript:void(0);" onclick="toast.error('注册已经关闭！');" style="color: #999999"><?php echo L('quick_login');?></a>
                        <?php }else if(!in_array('normal', $register_type)){ ?>
                        <a class="invitation_code" href="<?php echo U('Mob/Member/inCode');?>" data-title="输入邀请码" data-toggle="modal"><?php echo L('quick_login');?></a>
                        <?php }else{ ?>
                        <a href="<?php echo U('mob/Member/register');?>"><?php echo L('quick_login');?></a>
                        <?php } ?>

                    </div>
                </div>
                <?php session('login_http_referer',$_SERVER['HTTP_REFERER']); ?>
                <div style="margin-top: 20px;">
                    <?php echo hook('syncLogin');?>
                </div>

            </form>
        </div>
    </div>

    <script>
        invitation_code();
        //邀请码的弹窗
        function invitation_code() {
            $('.invitation_code').magnificPopup({
                type: 'ajax',
                overflowY: 'scroll',
                modal: true,
                callbacks: {
                    ajaxContentAdded: function () {
                        console.log(this.content);
                    }
                }
            })
        }
        var verifyimg = $(".verifyimg").attr("src");
        $(".reloadverify").click(function () {
            if (verifyimg.indexOf('?') > 0) {
                $(".verifyimg").attr("src", verifyimg + '&random=' + Math.random());
            } else {
                $(".verifyimg").attr("src", verifyimg.replace(/\?.*$/, '') + '?' + Math.random());
            }
        });


        $('#conf').click(function () {
            var data = $(".am-form").serialize();
            var url = $(".am-form").attr('data-url');
            $.post(url, data, function (msg) {
                if (msg.status == 1) {
                    toast.success(msg.info);
                    setTimeout(function () {
                        location.href = "<?php echo U('weibo/index');?>";
                    }, 200);
                } else {
                    toast.error(msg.info);
                }
            }, 'json');
        })
    </script>

</div>



        <!-- /主体 -->

        <!-- 底部 -->
        <div class="hide-foot am-text-center" style="display: none"><!-- 用于加载统计代码等隐藏元素 -->
    <?php echo ($count_code); ?>
    
</div>
        <!-- /底部 -->
    </body>
</html>