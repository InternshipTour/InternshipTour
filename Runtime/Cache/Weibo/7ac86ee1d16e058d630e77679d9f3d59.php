<?php if (!defined('THINK_PATH')) exit();?><div id="sub_nav">
    <nav class="navbar navbar-default" role="navigation">
        <div class="container" style="width:1180px;">
            <a href="<?php echo U($MODULE_INFO['entry']);?>" class="navbar-brand logo"><i class="icon-<?php echo ($brand["icon"]); ?>"></i>

                <?php if(empty($menu_list["first"]["title"])): echo ($brand["title"]); ?>
                    <?php else: ?>
                    <?php echo ($menu_list["first"]["title"]); endif; ?>

            </a>

            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-7">
                    <ul class="nav navbar-nav">
                        <?php if(is_array($menu_list["left"])): $i = 0; $__LIST__ = $menu_list["left"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i; if($menu['children']): ?><!--二级菜单-->
                                <li id="tab_<?php echo ($menu["tab"]); ?>" class="dropdown <?php echo ($class); ?>">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <?php if(($menu["icon"]) != ""): ?><i class="icon-<?php echo ($menu["icon"]); ?>"></i><?php endif; ?>
                                        <?php echo ($menu["title"]); ?> <i class="icon-caret-down"></i>
                                        <ul class="dropdown-menu" role="menu">
                                            <?php if(is_array($menu["children"])): $i = 0; $__LIST__ = $menu["children"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$child): $mod = ($i % 2 );++$i;?><li><a href="<?php echo ($child["href"]); ?>" class="<?php echo ($child["class"]); ?>">
                                                    <?php if(($child["icon"]) != ""): ?><i
                                                            class="glyphicon glyphicon-<?php echo ($child["icon"]); ?>"></i><?php endif; ?>
                                                    <?php echo ($child["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>

                                        </ul>
                                </li>
                                <?php else: ?>
                                <!--一级菜单-->
                                <li id="tab_<?php echo ($menu["tab"]); ?>" class="<?php echo ($menu["li_class"]); ?>"
                                        ><a href="<?php echo ($menu["href"]); ?>" class="<?php echo ($menu["a_class"]); ?>">
                                    <?php if(($menu["icon"]) != ""): ?><i class="glyphicon glyphicon-<?php echo ($menu["icon"]); ?>"></i><?php endif; ?>
                                    <?php echo ($menu["title"]); ?></a></li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                    <?php if($menu_list['right'] != null): ?><ul class="nav navbar-nav navbar-right">
                            <?php if(is_array($menu_list["right"])): $i = 0; $__LIST__ = $menu_list["right"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i; $class=($current==$menu['tab']?'active':''); ?>
                                <?php switch($menu["type"]): case "button": ?><a href="<?php echo ($menu["href"]); ?>" class="<?php echo ($menu["a_class"]); ?>"><i class="icon-<?php echo ($menu["icon"]); ?>"></i><?php echo ($menu["html"]); ?></a><?php break;?>
                                    <?php case "search": ?><form class="navbar-form navbar-right" action="<?php echo ($menu["action"]); ?>"
                                              method="<?php echo ($menu["from_method"]); ?>" role="search">
                                            <div class="search-input-group">
                                                <button type="submit" class="input-btn"
                                                        style="border-color: transparent;background: transparent;padding: 0 10px 0 10px;">
                                                    <i class="icon-search"></i></button>
                                                <input type="text" class="input" placeholder="<?php echo ($menu["input_title"]); ?>"
                                                       name="<?php echo ($menu["input_name"]); ?>" value="<?php echo ($search_keywords); ?>">
                                            </div>
                                            </span>
                                        </form><?php break;?>
                                    <?php default: ?>
                                    <?php if($menu['children']): ?><!--二级菜单-->
                                        <li id="tab_<?php echo ($menu["tab"]); ?>" class="dropdown <?php echo ($menu["class"]); ?>">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                <?php if(($menu["icon"]) != ""): ?><i class="icon-<?php echo ($menu["icon"]); ?>"></i><?php endif; ?>
                                                <?php echo ($menu["title"]); ?> <i class="icon-caret-down"></i>
                                                <ul class="dropdown-menu" role="menu">
                                                    <?php if(is_array($menu["children"])): $i = 0; $__LIST__ = $menu["children"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$child): $mod = ($i % 2 );++$i;?><li><a href="<?php echo ($child["href"]); ?>" class="<?php echo ($child["class"]); ?>">
                                                            <?php if(($child["icon"]) != ""): ?><i
                                                                    class="glyphicon glyphicon-<?php echo ($child["icon"]); ?>"></i><?php endif; ?>
                                                            <?php echo ($child["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>

                                                </ul>
                                        </li>
                                        <?php else: ?>
                                        <!--一级菜单-->
                                        <li id="tab_<?php echo ($menu["tab"]); ?>" class="<?php echo ($menu["li_class"]); ?>">
                                            <a href="<?php echo ($menu["href"]); ?>" class="<?php echo ($menu["a_class"]); ?>">
                                                <?php if(($menu["icon"]) != ""): ?><i
                                                        class="glyphicon glyphicon-<?php echo ($menu["icon"]); ?>"></i><?php endif; ?>
                                                <?php echo ($menu["title"]); ?></a></li><?php endif; endswitch; endforeach; endif; else: echo "" ;endif; ?>
                        </ul><?php endif; ?>
                </div>
                <!-- /.navbar-collapse -->
            </div>
        </div>
    </nav>
</div>

<script>
    $('#sub_nav #tab_<?php echo ($current); ?>').addClass('active');
    adjust_navbar();
</script>