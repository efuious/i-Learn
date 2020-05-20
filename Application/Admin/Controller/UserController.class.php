<?php
/**
 * Created by PhpStorm.
 * User: QinHsiu
 * Date: 2020/5/3
 * Time: 15:32
 */
namespace Admin\Controller;
use Think\Controller;

class UserController extends Controller{

    //查看个人信息
    public function index()
    {
        $id = session('id');
        $data = M('User')->find($id);
        $role_id = session('role_id');
        if ($data) {
            session('username', $data['username']);
            session('truename', $data['truename']);
            session('password', $data['password']);
            session('nickname', $data['nickname']);
            session('sex', $data['sex']);
            session('email', $data['email']);
            session('birthday', $data['birthday']);
            session('tel', $data['tel']);
            session('addtime', $data['addtime']);
            $this->assign('role_id',$role_id);
            $this->display();
        }
        else{
            $this->error('查询失败！');
        }
    }

    //删除账号
    public function del(){
        //接收参数
        $id = I('get.id');
        //模型实例化
        $model = M('User');
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

    //修该用户信息
    public function editU()
    {
        if(IS_POST){
            $model = M('User');
            $username=session("username");
            $data['password']=$_REQUEST["password"];
            $data['email']=$_REQUEST["email"];
            $data['tel']=$_REQUEST["tel"];
            ///保存操作
            $result=$model->create($data);
            //$result = $model -> save($post);
            //判断结果成功与否
            if($result !== false){
                $Model = $model->where(array("username"=>$username))->save($data);
                //修改成功
                $this -> success('修改成功',U('Public/login'),3);
            }else{
                //修改失败
                $this -> error('修改失败');
            }
        }else{
            //接收id
            $id = I('get.id');
            //实例化模型
            $model = M('User');
            $data = $model -> find($id);
            //变量分配
            $this -> assign('data',$data);
            //展示模版
            $this -> display();
        }
    }

    //办理VIP
    public function add(){
        if(IS_POST){
            //处理表单提交
            $model = M('User');
            $username=$_REQUEST["username"];
            //添加时间字段
            $data['addtime'] = date('Y-m-d');
            $data['role_id']=2;
            $result=$model->create($data);
            //判断结果成功与否
            if($result !== false){
                $Model = $model->where(array("username"=>$username))->save($data);
                //修改成功
                $this -> success('办理成功',U('show'),3);
            }else{
                //修改失败
                $this -> error('修改失败');
            }
        }else{
            //接收id
            $id = I('get.id');
            //实例化模型
            $model = M('User');
            $data = $model -> find($id);
            //变量分配
            $this -> assign('data',$data);
            //展示模版
            $this -> display();
        }

    }


    public function addA(){
        if(IS_POST){
            //处理表单提交
            $model = M('User');
            $username=$_REQUEST["username"];
            //添加时间字段
            $data['addtime'] = date('Y-m-d');
            $data['role_id']=1;
            $result=$model->create($data);
            //判断结果成功与否
            if($result !== false){
                $Model = $model->where(array("username"=>$username))->save($data);
                //修改成功
                $this -> success('办理成功',U('show'),3);
            }else{
                //修改失败
                $this -> error('修改失败');
            }
        }else{
            //接收id
            $id = I('get.id');
            //实例化模型
            $model = M('User');
            $data = $model -> find($id);
            //变量分配
            $this -> assign('data',$data);
            //展示模版
            $this -> display();
        }
    }


    public function addA1(){
        //没有账户
        if(IS_POST){
            //处理表单提交
            $model = M('User');
            //创建数据对象
            $data = $model -> create();
            //添加时间字段
            $data['addtime'] = date('Y-m-d');
            $data['role_id']=1;
            $data['password']='123456';
            $data['birthday']=date('Y-m-d');
            //保存数据表
            //判断是否保存成功
            if ($data['username'] != NULL && $data['sex'] != NULL &&  $data['tel'] != NULL && $data['email'] != NULL)
            {
                $result = $model->add($data);
                if ($result) {
                    //成功
                    $this->success('添加成功！', U('Index/index'), 3);
                }else
                {
                    //失败
                    $this->error('添加失败！');
                }

            }
            else{
                $this->error('添加失败！');
            }
        }else{
            //展示模版
            $this -> display();
        }

}

//show
    public function show(){
        $role_id = session('role_id');
        $username=session('username');
        $count=M('User')->count();
        $page=new \Think\Page($count,30);
        $data = M('User') -> limit($page -> firstRow,$page -> listRows) -> select();
        //传递给模版
        $this->assign('role_id',$role_id);
        $this->assign('username',$username);
        $this ->assign('data',$data);
        $this->assign('count',$count);
        $this->assign('page',$page);
        //展示模版
        $this -> display();
    }

    //修改密码
    public function edit()
    {
        $id = session('id');
        $data1 = M('User')->find($id);
        $password =$data1['password'] ;
        $email=$data1['email'];
        $tel=$data1['tel'];
        $this->assign('password',$password);
        $this->assign('email',$email);
        $this->assign('tel',$tel);
        if(IS_POST){
            $model = M('User');
            $username=session("username");
            $data['password']=$_REQUEST["password"];
            $data['email']=$_REQUEST["email"];
            $data['tel']=$_REQUEST["tel"];
            $result=$model->create($data);
            if($result !== false){
                $Model = $model->where(array("username"=>$username))->save($data);
                //修改成功
                $this -> success('修改成功',U('Public/login'),3);
            }else{
                //修改失败
                $this -> error('修改失败');
            }
        }else{
            //接收id
            $id = I('get.id');
            //实例化模型
            $model = M('User');
            $data = $model -> find($id);
            //变量分配
            $this -> assign('data',$data);
            //展示模版
            $this -> display();
        }
    }


}