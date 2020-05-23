<?php
/**
 * Created by PhpStorm.
 * User: QinHsiu
 * Date: 2020/5/3
 * Time: 15:58
 */
namespace Admin\Controller;
use Think\Controller;
class NoticeController extends CommonController{
    //浏览通知信息
    public function index(){
        $username=session('username');
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
        $this->assign('username',$username);
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

    public function deliver(){
        //请求类型判断
        if(IS_POST){
            //数据保存方法
            $post = I('post.');
            //实例化模型
            $model = D('Notice');
            //数据保存
            $result = $model -> saveData($post,$_FILES['file']);
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

    //删除账号
    public function del(){
        //接收参数
        $id = I('get.id');
        //模型实例化
        $model = M('Notice');
        //删除
        $result = $model -> delete($id);
        //判断结果
        if($result){
            //删除成功
            $this -> success('删除成功！',U('Index/index'),'3');
        }else{
            //删除失败
            $this -> error('删除失败！');
        }
    }
}