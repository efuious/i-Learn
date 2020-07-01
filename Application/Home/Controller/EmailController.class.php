<?php

namespace Home\Controller;
use Think\Controller;
class EmailController extends CommonController{

    public function send(){
        if(IS_POST){
            $post = I('post.');
            $model = D('Email');
            $result = $model -> addData($post,$_FILES['file']);
            if($result){
                $this -> success('邮件发送成功！',U('sendBox'),3);
            }else{
                $this -> error('邮件发送失败！');
            }
        }else{
            $data = M('User') -> field('id,truename') -> where("id != " . session('id')) ->select();
            $this -> assign('data',$data);
            $this -> display();
        }
    }

    public function recBox(){
        $count=M('Email')->count();
        $page = new \Think\Page($count,30);	//每页显示1个
        $page -> rollPage = 5;
        $page -> lastSuffix = false;
        $page -> setConfig('prev','上一页');
        $page -> setConfig('next','下一页');
        $page -> setConfig('last','末页');
        $page -> setConfig('first','首页');
        $show = $page -> show();
        $data = M('Email') -> field('t1.*,t2.truename as truename') -> alias('t1') -> join('left join il_user as t2 on t1.from_id = t2.id') -> where('t1.to_id = ' . session('id')) -> select();
        $this -> assign('data',$data);
        $this->assign('count',$count);
        $this->assign('show',$show);
        $this -> display();
    }

    public function sendBox(){
        $count=M('Email')->count();
        $page = new \Think\Page($count,10);	//每页显示1个
        $page -> rollPage = 5;
        $page -> lastSuffix = false;
        $page -> setConfig('prev','上一页');
        $page -> setConfig('next','下一页');
        $page -> setConfig('last','末页');
        $page -> setConfig('first','首页');
        $show = $page -> show();
        $data = M("Email") -> field('t1.*,t2.truename as truename') -> alias('t1') -> join('left join il_user as t2 on t1.to_id = t2.id') -> where('t1.from_id = ' . session('id')) -> select();
        $this -> assign('data',$data);
        $this->assign('show',$show);
        $this->assign('count',$count);
        $this -> display();
    }

    public function download(){
        $id = I('get.id');
        $data = M('Email') -> find($id);
        $file = WORKING_PATH . $data['file'];
        header("Content-type: application/octet-stream");
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header("Content-Length: ". filesize($file));
        readfile($file);
    }

    public function _empty(){
        $this -> display('Empty/error');
    }

    public function getContent1(){
        $id = I('get.id');
        $data = M('Email') -> where("id = $id and from_id = " . session('id')) -> find();
        if($data['isread'] == '0'){
            M('Email') -> save(array('id' => $id,'isread' => 1));
        }
    }

    public function getContent(){
        $id = I('get.id');
        $data = M('Email') -> where("id = $id and to_id = " . session('id')) -> find();
        if($data['isread'] == '0'){
            M('Email') -> save(array('id' => $id,'isread' => 1));
        }
    }

    public function getCount(){
        if(IS_AJAX){
            $model = M('Email');
            $count = $model -> where("isread = 0 and to_id = " . session('id')) -> count();
            echo $count;
        }
    }

    public function del(){
        $id = I('get.id');
        $model = M('Email');
        $result = $model -> delete($id);
        if($result){
            $this -> success('删除成功！');
        }else{
            $this -> error('删除失败！');
        }
    }
}