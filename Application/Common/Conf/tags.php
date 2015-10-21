<?php
return array(
	//检查语言的切换
    'app_begin' => array('Behavior\CheckLangBehavior'),
    //初始化钩子
    'app_init' => array('Common\Behavior\InitHookBehavior'),
    'action_begin' => array('Common\Behavior\InitModuleInfoBehavior'),
    // 添加下面一行定义即可
);