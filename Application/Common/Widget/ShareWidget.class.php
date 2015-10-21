<?php
/**
 * 分享
 */

namespace Common\Widget;


use Think\Controller;

class ShareWidget extends Controller{

    public function detailShare($data)
    {
        //支持参数“share_text”设置分享的文本内容
        $this->assign($data);
        $this->display(T('Application://Common@Widget/share'));
    }

} 