<?php if (!defined('THINK_PATH')) exit(); if($announcement_num > 0): ?><link type="text/css" rel="stylesheet" href="<?php echo getRootUrl();?>Addons/Announcement/Static/css/announcement.css"/>
    <div id="announcement" class="alert <?php echo ($announcement_alert_type); ?> announcement">
        <div class="announcement_list">
            <?php if(is_array($announcement_list)): $i = 0; $__LIST__ = $announcement_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vl): $mod = ($i % 2 );++$i;?><div class="one_announcement">
                    <div style="display: table;">
                        <i class="<?php echo ($vl["icon"]); ?>"></i>
                        <span class="content">
                            <?php if($vl['link'] != ''): ?><a target="_blank" href="<?php echo ($vl["link"]); ?>" class="alert-link" style="font-weight: 400;">
                                    <span class="title">【<?php echo ($vl["title"]); ?>】</span>
                                    <span class="content"><?php echo ($vl["content"]); ?></span>
                                </a>
                                <?php else: ?>
                                <span class="title">【<?php echo ($vl["title"]); ?>】</span>
                                <span class="content"><?php echo ($vl["content"]); ?></span><?php endif; ?>
                            <a data-role="unshow" class="unshow_button" data-id="<?php echo ($vl["id"]); ?>"><span class="word">×</span></a>
                        </span>
                    </div>
                </div>
                <div class="clearfix"></div><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
    </div>
    <script>
        var announcement_num="<?php echo ($announcement_num); ?>";
    </script>
    <script type="text/javascript" src="<?php echo getRootUrl();?>Addons/Announcement/Static/js/announcement.js"></script><?php endif; ?>