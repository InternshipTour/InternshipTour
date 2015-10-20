<?php if (!defined('THINK_PATH')) exit();?><script type="text/javascript" src="/internship-tour/Public/js/jquery-2.0.3.min.js"></script>

<div>
    <style>
        .modal-dialog {
            width: 600px;
        }

        .select_box_this {
            margin: 10px 0 20px;
            width: 100%;
            text-align: right;
            font-size: 16px;
        }

        .select_box_this .form-group {
            margin-top: 5px;;
        }
    </style>
    <form id="migration" action="/internship-tour/index.php?s=/admin/message/sendmessage.html&user_group=0&role=0&" method="post" class="ajax-form">

        <?php if(empty($users)){ ?>
        <div>
            用户组：
            <?php if(is_array($groups)): $i = 0; $__LIST__ = $groups;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$one_group): $mod = ($i % 2 );++$i;?><label style="margin-right: 5px">
                    <input type="checkbox" name="user_group[]" value="<?php echo ($one_group['id']); ?>"
                    <?php if($aUserGroup == $one_group['id'] or $aUserGroup == 0): ?>checked<?php endif; ?>
                    style="cursor:pointer;">
                    <?php echo ($one_group['value']); ?>
                </label><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
        <div>
            用户身份：
            <?php if(is_array($roles)): $i = 0; $__LIST__ = $roles;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$one_role): $mod = ($i % 2 );++$i;?><label style="margin-right: 5px">
                    <input type="checkbox" name="user_role[]" value="<?php echo ($one_role['id']); ?>"
                    <?php if($aRole == $one_role['id'] or $aRole == 0 ): ?>checked<?php endif; ?>
                    style="cursor:pointer;">
                    <?php echo ($one_role['value']); ?>
                </label><?php endforeach; endif; else: echo "" ;endif; ?>

        </div>
        <?php }else{ ?>

        <div>
            用户：
            <?php if(is_array($users)): $i = 0; $__LIST__ = $users;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$one_user): $mod = ($i % 2 );++$i;?><label style="margin-right: 10px">
                       [<?php echo ($one_user['uid']); ?>]<?php echo ($one_user['nickname']); ?>
                </label><?php endforeach; endif; else: echo "" ;endif; ?>
        <input type="hidden" name="uids" value="<?php echo ($uids); ?>">
        </div>

        <?php } ?>
        <div class="form-group clearfix">
            <input type="text" name="title" class="form-control" placeholder="输入消息的标题">
        </div>

        <div class="form-group clearfix">
                <input type="text" name="url" class="form-control " placeholder="输入消息的URL链接">
        </div>


        <div class="form-group">
            <?php echo W('Common/Ueditor/editor',array('content','content','','100%','200px','','',array('is_load_script'=>1,'zIndex'=>1050)));?>

        </div>


        <div style="width: 100%;text-align: center;">
            <a class="btn btn-primary" data-role="submit">发送</a>
            <a onclick="$('.close').click();" class="btn btn-default">取消</a>
        </div>
    </form>
</div>
<script>
    $(function () {
        $('[data-role="submit"]').click(function () {
            var query = $('#migration').serialize();
            var url = $('#migration').attr('action');
            $.post(url, query, function (msg) {
                if (msg.status) {
                    toast.success('消息发送成功！');
                    setTimeout(function () {
                        location.reload()
                       // window.location.href = msg.url;
                    }, 1500);
                } else {
                    handleAjax(msg);
                }
            }, 'json');
        });
    });
</script>
<script type="text/javascript" src="/internship-tour/Application/Admin/Static/js/common.js"></script>
<script type="text/javascript" src="/internship-tour/Application/Admin/Static/js/com/com.toast.class.js"></script>
<script type="text/javascript" src="/internship-tour/Application/Admin/Static/zui/js/zui.js"></script>
<script type="text/javascript" charset="utf-8" src="/internship-tour/Public/static/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/internship-tour/Public/static/ueditor/ueditor.all.min.js"></script>