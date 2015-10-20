<?php if (!defined('THINK_PATH')) exit();?><div style="padding-left:20px;">
    <style>
        .weibo_icon{
            border: 1px solid #f0f0f0;
            border-right: none;
        }
    </style>
    <div class="common_block_border">
        <div style="padding:0 20px">
                <?php if(!empty($news_list)): if(is_array($news_list)): $i = 0; $__LIST__ = $news_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><div class="row" style="position: relative">
    <?php if($data['cover'] != 0): ?><div class="col-xs-4">
            <a title="<?php echo (op_t($data["title"])); ?>" href="<?php echo U('News/index/detail',array('id'=>$data['id']));?>" target="_blank">
                <img alt="<?php echo (op_t($data["title"])); ?>" src="<?php echo (getthumbimagebyid($data["cover"],200,146)); ?>" style="width: 200px;height: 146px">
            </a>
        </div>
        <div class="col-xs-8">
            <div>
                <h3 class="title text-more" style="width: 100%">
                    <a title="<?php echo (op_t($data["title"])); ?>" href="<?php echo U('News/index/detail',array('id'=>$data['id']));?>" target="_blank"><?php echo ($data["title"]); ?></a>
                </h3>
            </div>
            <div>
                <span class="author"><?php echo (date('Y-m-d H:i:s',$data["create_time"])); ?>&nbsp;&nbsp;<?php echo ($data['audit_status']); ?></span>

                <p><?php echo ($data["description"]); ?></p>
            </div>
            <div>

            </div>
        </div>
        <?php else: ?>
        <div class="col-xs-12">
            <div>
                <h3 class="title text-more" style="width: 100%">
                    <a title="<?php echo (op_t($data["title"])); ?>" href="<?php echo U('News/index/detail',array('id'=>$data['id']));?>" target="_blank"><?php echo ($data["title"]); ?></a>
                </h3>
            </div>
            <div>
                <span class="author"><?php echo (date('Y-m-d H:i:s',$data["create_time"])); ?>&nbsp;&nbsp;<?php echo ($data['audit_status']); ?></span>
                <?php if($data['status'] == -1): ?><br/>
                    <span class="reason">审核失败原因：<?php echo ((isset($data['reason']) && ($data['reason'] !== ""))?($data['reason']):'无'); ?></span><?php endif; ?>

                <p><?php echo ($data["description"]); ?></p>
            </div>
            <div>

            </div>
        </div><?php endif; ?>

    <span class="pull-right" style="position: absolute;right: 0;bottom: 0">
        &nbsp;&nbsp;
        <span>
            <i class="icon-eye-open"></i>  <?php echo ($data["view"]); ?>
        </span>
        &nbsp;&nbsp;
    </span>
</div>
<hr/><?php endforeach; endif; else: echo "" ;endif; ?>
                    <?php else: ?>
                    <div style="font-size:3em;padding:2em 0;color: #ccc;text-align: center">没有可显示资讯吆~</div><?php endif; ?>
            <div class="text-right">
                <?php echo getPagination($totalCount,10);?>
            </div>
        </div>
    </div>
</div>