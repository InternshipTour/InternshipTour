<?php
namespace Weibo\Model;
use Think\Model;

class TopWeiboModel extends Model
{
    protected $tableName='weibo_top';
    /**获取置顶微博列表
     * @param int $limit
     * @return mixed
     */
  /*  public function getTopWeibo($limit = 10)
    {
        $list = $this->limit($limit)->select();
        foreach ($list as $key=>&$li) {
            if(D('Weibo/Weibo')->where(array('id'=>$li['weibo_id'],'status'=>1))->count()==0)
            {
                unset($list[$key]);
                continue;
            }
            $li['weibo'] = D('Weibo/Weibo')->find($li['weibo_id']);
            $li['weibo']['user']=query_user(array('avatar64','username','rank_link','space_link','space_url','uid'),$li['weibo']['uid']);
        }
        unset($li);
        return ($list);
    }*/
} 