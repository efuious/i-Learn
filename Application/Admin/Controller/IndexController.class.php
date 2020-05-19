<?php
/**
 * Created by PhpStorm.
 * User: QinHsiu
 * Date: 2020/5/7
 * Time: 20:38
 */
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller
{
    public function index(){

        session('id',session('id'));
        session('username',session('username'));
        $role_id=session('role_id');
        $this->assign('role_id',$role_id);
        $this->display();
    }

}
