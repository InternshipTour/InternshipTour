<?php
namespace Ucenter\Widget;
use Think\Action;

/**input类型输入渲染
 * Class InputWidget
 * @package Usercenter\Widget
 */
class FocusButtonWidget extends Action
{

    public function  display($uid)
    {
        $this->assign($uid);
        $this->display(T('Ucenter@Widget/focusbutton'));
    }

} 