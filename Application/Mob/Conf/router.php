<?php
return array(

    /**
     * 路由的key必须写全称,且必须全小写. 比如: 使用'wap/index/index', 而非'wap'.
     */
    'router' => array(

        //消息
        /*微博*/
        'Weibo/Index/weiboDetail'               =>'Mob/Weibo/weiboDetail',

        /*专辑*/
        'Issue/Index/issueContentDetail'        =>'/mob/issue/issuedetail',

        //入口
        /*专辑*/
        'Issue/index/index'                 =>'mob/issue/index',

        /*会员*/
        'People/index/index'               =>'mob/people/index',

        /*微博*/
        'Weibo/index/index'                =>'mob/weibo/index',
        /*用户中心*/
        'Ucenter/index/index'              =>'mob/user/index',


    ),

);