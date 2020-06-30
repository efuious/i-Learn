<?php

namespace Home\Controller;
use Think\Controller;
class NoticeController extends CommonController{
    //浏览通知信息
    public function index(){
        $count=M('Notice')->count();
        $page=new \Think\Page($count,30);
        $page -> rollPage = 5;
        $page -> lastSuffix = false;
        $page -> setConfig('prev','上一页');
        $page -> setConfig('next','下一页');
        $page -> setConfig('last','末页');
        $page -> setConfig('first','首页');
        //分页第四步：使用show方法生成url
        $show = $page -> show();
        //分页第五步：展示数据
        $data = M('Notice') -> limit($page -> firstRow,$page -> listRows) -> select();
        //传递给模版
        //$this->assign('role_id',$role_id);
        //$this->assign('username',$username);
        $this -> assign('data',$data);
        $this->assign('count',$count);
        $this->assign('show',$show);
        //展示模版
        $this -> display();
    }

    public function download(){
        //接收id
        $id = I('get.id');
        //查询数据
        $data = M('Notice') -> find($id);
        //下载代码
        $file = WORKING_PATH . $data['filepath'];
        //输出文件
        header("Content-type: application/octet-stream");
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header("Content-Length: ". filesize($file));
        //输出缓冲区
        readfile($file);
    }

}