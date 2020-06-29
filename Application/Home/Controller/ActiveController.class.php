<?php

namespace Home\Controller;

class ActiveController extends CommonController{
    //动态首页
    public function index(){
        $role_id = session('role_id');
        $username=session('username');
        $count=M('Active')->count();
        $page=new \Think\Page($count,10);
        $page -> rollPage = 5;
        $page -> lastSuffix = false;
        $page -> setConfig('prev','上一页');
        $page -> setConfig('next','下一页');
        $page -> setConfig('last','末页');
        $page -> setConfig('first','首页');
        //分页第四步：使用show方法生成url
        $show = $page -> show();
        //分页第五步：展示数据
        $data = M('Active') -> limit($page -> firstRow,$page -> listRows) -> select();
        //传递给模版
        $this->assign('role_id',$role_id);
        $this->assign('username',$username);
        $this -> assign('data',$data);
        $this->assign('count',$count);
        //$this->assign('page',$page);
        $this->assign('show',$show);
        //展示模版
        $this -> display();
    }

    //发布动态
    public function deliver(){
        //请求类型判断
        if(IS_POST){
            //如果是post 则处理请求
            $post = I('post.');
            //实例化自定义模型
            $model = D('Active');
            //数据保存方法
            $result = $model -> addData($post,$_FILES['thumb']);
            //判断结果
            if($result){
                //成功
                $this -> success('发布成功！',U('index'),3);
            }else{
                //失败
                $this -> error('发布失败！');
            }
        }else{
            //展示模版
            $this -> display();
        }
    }
    //删除动态
    public function del()
    {
        //接收参数
        $id = I('get.id');
        //模型实例化
        $model = M('Active');
        //删除
        $result = $model -> delete($id);
        //判断结果
        if($result){
            //删除成功
            $this -> success('删除成功！');
        }else{
            //删除失败
            $this -> error('删除失败！');
        }
    }

    public function download(){
        //获取id
        $id = I("get.id");
        //查询数据信息
        $data = M('Active') -> find($id);
        //下载代码
        $file = WORKING_PATH . $data['picture'];
        header("Content-type: application/octet-stream");
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header("Content-Length: ". filesize($file));
        readfile($file);
    }


}