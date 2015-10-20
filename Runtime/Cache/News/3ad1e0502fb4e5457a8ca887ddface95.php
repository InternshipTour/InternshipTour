<?php if (!defined('THINK_PATH')) exit(); $cMod = strtoupper($mod); ?>
<div class="comments"
     data-del-url="<?php echo tox_addons_url('LocalComment/Index/deleteComment', array('count_model'=>$count_model,'count_field'=>$count_field));?>">
    <header>
        <h3><i class="icon-comments icon-border-circle"></i> <span class="total_count"><?php echo ($total_count); ?></span>条评论</h3>
    </header>
    <footer>

        <div class="reply-form">
            <?php if(is_login()){ ?>
            <a href="<?php echo ($myInfo["space_url"]); ?>" class="avatar"><img src="<?php echo ($myInfo["avatar32"]); ?>" ucard="<?php echo ($myInfo["uid"]); ?>"
                                                              class="avatar-img"/></a>
            <?php }elseif($can_guest){ ?>
            <a href="javascript:" title="游客" class="avatar"><i class="icon-user icon-border icon-2x icon-muted"
                                                               style="color:#999;width: 32px;text-align:center;display:block;"></i></a>
            <?php } ?>

            <?php if($can_guest || is_login()){ ?>
            <div class="form">
                <div class="form-group">
                    <textarea class="form-control new-comment-text " id="local_comment_textarea" rows="2" placeholder=""></textarea>
                </div>
                <div class="pull-right">
                    <a href="javascript:" data-role="send_local_comment" data-path="<?php echo ($path); ?>"  data-this-url="<?php echo ($this_url); ?>"  data-extra="<?php echo ($extra); ?>"
                       data-url="<?php echo tox_addons_url('LocalComment/Index/addComment', array('uid'=>$uid,'count_model'=>$count_model,'count_field'=>$count_field));?>"
                       class="btn btn-primary">
                        <i class="icon-comment-alt"></i> 发表评论
                    </a>
                </div>
            </div>
            <?php } ?>
        </div>


    </footer>

    <section class="comments-list clearfix">
        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$comment): $mod = ($i % 2 );++$i;?><div class="comment">


    <?php if($comment['uid']){ ?>
    <a href="<?php echo ($comment["user"]["space_url"]); ?>" class="avatar "><img src="<?php echo ($comment["user"]["avatar32"]); ?>" ucard="<?php echo ($comment["user"]["uid"]); ?>"
                                                             class="avatar-img"/>
        <?php }else{ ?>
        <a href="javascript:" title="游客" class="avatar"><i class="icon-user icon-border icon-2x icon-muted"
                                                           style="color: #999;width:32px;text-align:center;display: block;"></i></a>
        <?php } ?>
    </a>

    <div class="content">
        <div class="pull-right"><span class="text-muted" title="<?php echo (friendlydate($comment["create_time"])); ?>"><?php echo (friendlydate($comment["create_time"])); ?></span>
            &nbsp;<!--<strong>#5</strong>--></div>
                <span class="author">

                       <?php if($comment['uid']){ ?>

                  <a href="<?php echo ($comment["user"]["space_url"]); ?>"  ucard="<?php echo ($comment["user"]["uid"]); ?>"><strong><?php echo ($comment["user"]["nickname"]); ?></strong></a> <?php echo W('Common/UserRank/render',array($comment['uid']));?>
                         <?php }else{ ?>

                     <a href="javascript:" ><strong>游客</strong></a><?php if($comment['area']): ?>（<?php echo ($comment["area"]); ?>）<?php endif; ?>
                          <?php } ?>
                </span>

        <div class="text">
            <?php echo (parse_comment_content($comment["content"])); ?>
        </div>
        <div class="actions">
            <?php if($comment['uid']){ ?>
            <a href="javascript:" data-role="reply_local_comment" data-nickname="<?php echo ($comment["user"]["real_nickname"]); ?>">回复</a>

            <?php if(check_auth('deleteLocalComment',$comment['uid'])){ ?>
            <a href="javascript:" data-role="delete_local_comment" data-id="<?php echo ($comment["id"]); ?>">删除</a>
            <?php } ?>
            <?php } ?>

        </div>
    </div>
</div><?php endforeach; endif; else: echo "" ;endif; ?>
        <div class="pager">
            <?php echo ($pageHtml); ?>
        </div>
    </section>
</div>

<script>
    var local_comment_order = "<?php echo modC($cMod.'_LOCAL_COMMENT_ORDER',0);?>";
    var local_comment_count = "<?php echo modC($cMod.'_LOCAL_COMMENT_COUNT',10);?>";
    var local_comment_page = function (app, mod, row_id, page) {
        $.post("<?php echo tox_addons_url('LocalComment/Index/getCommentList');?>", {app: app, mod: mod, row_id: row_id, page: page}, function (res) {
            $('.comments').find('section').html(res.html);
            bind_local_comment();
        }, 'json');
    }


    $(function () {
        $('#local_comment_textarea').keypress(function (e) {
            if (e.ctrlKey && e.which == 13 || e.which == 10) {
                $(this).closest('.form').find("[data-role='send_local_comment']").click();
            }
        });
    })


</script>
<script type="text/javascript" src="<?php echo getRootUrl();?>Addons/LocalComment/_static/js/comment.js"></script>