<?php if (!defined('THINK_PATH')) exit(); if($lists != false): ?><div class="common_block_border blog_position clearfix">

        <div class="common_block_title">
            <?php if(($category) != ""): ?>本类推荐
                <?php else: ?>
                推荐阅读<?php endif; ?>
        </div>

        <?php if(is_array($lists)): $i = 0; $__LIST__ = $lists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><div class="clearfix" style="position: relative">
                <?php if(($data["cover"]) != "0"): ?><div class="col-xs-4">
                        <a title="<?php echo (op_t($data["title"])); ?>" href="<?php echo U('News/index/detail',array('id'=>$data['id']));?>">
                            <img alt="<?php echo (op_t($data["title"])); ?>" src="<?php echo (getthumbimagebyid($data["cover"],100,70)); ?>"
                                 style="width: 100px;height: 70px">
                        </a>
                    </div>
                    <?php $col=8; ?>
                    <?php else: ?>
                    <?php $col=12; endif; ?>
                <div class="col-xs-<?php echo ($col); ?>">
                    <div>
                        <h3 class="margin-top-0 text-more" style="width: 100%">
                            <a title="<?php echo (op_t($data["title"])); ?>" href="<?php echo U('News/index/detail',array('id'=>$data['id']));?>"><?php echo ($data["title"]); ?></a>
                        </h3>
                    </div>
                    <div>
                        <span class="author">
                            <a href="<?php echo ($data["user"]["space_url"]); ?>" ucard="<?php echo ($data["uid"]); ?>"><?php echo ($data["user"]["nickname"]); ?></a>
                            &nbsp;&nbsp;<?php echo (date('Y-m-d H:i:s',$data["create_time"])); ?>
                        </span>
                    </div>
                </div>
                <span class="pull-right" style="position: absolute;right: 0;bottom: 0">
                    &nbsp;&nbsp;
                    <span>
                        <i class="icon-eye-open"></i>  <?php echo ($data["view"]); ?>
                    </span>&nbsp;&nbsp;
                </span>
            </div>
            <?php if($i == count($lists)): ?><div style="margin: 15px"></div>
                <?php else: ?>
                <div style="border-bottom: 1px dashed rgb(204, 204, 204);margin: 15px"></div><?php endif; endforeach; endif; else: echo "" ;endif; ?>
    </div><?php endif; ?>