<?php
/**
 * Created by PhpStorm.
 * User: QinHsiu
 * Date: 2020/5/7
 * Time: 20:44
 */

namespace Admin\Model;
//引入父类
use Think\Model;
class ActiveModel extends Model{

    public function addData($post,$file){

        //判断是否有文件需要处理
        //要求size大于0，或者是error等于0
        if($file['error'] == '0'){
            //有文件
            $cfg = array('rootPath' => WORKING_PATH . UPLOAD_ROOT_PATH);
            //实例化上传类
            $upload = new \Think\Upload($cfg);
            ///上传
            $info = $upload -> uploadOne($file);
            //dump($info);die;
            if($info){
                //成功之后补全字段
                $post['picture'] = UPLOAD_ROOT_PATH . $info['savepath'] . $info['savename'];
                //制作缩略图
                //1、实例化类
                $image = new \Think\Image();
                //2、打开图片，传递图片的路径
                $image -> open(WORKING_PATH . $post['picture']);
                //3、制作缩略图，等比缩放
                $image -> thumb(400,400);
                //4、保存图片，传递保存完整路径（目录+文件名）
                $image -> save(WORKING_PATH . UPLOAD_ROOT_PATH . $info['savepath'] . 'thumb_' . $info['savename']);
                //补全thumb字段
                $post['thumb'] = $info['savepath'] . 'thumb_' . $info['savename'];
            }
        }
        //补全字段addtime
        $post['addtime'] = date('Y-m-d');
        $post['author']=session('username');
        //dump($post);die;
        //添加操作
        return $this -> add($post);
    }

    //saveData
    public function saveData($post,$file){
        //处理提交
        //dump($file);die;
        //先判断是否有文件需要处理
        if(!$file['error']){
            //定义配置
            $cfg = array(
                //配置上传路径
                'rootPath'	=>	WORKING_PATH . UPLOAD_ROOT_PATH
            );
            //处理上传
            $upload = new \Think\Upload($cfg);
            //开始上传
            $info = $upload -> uploadOne($file);
            //dump($upload -> getError());die;
            //dump($info);die;
            //判断是否上传成功
            if($info){
                //补全剩余的三个字段
                $post['filepath'] = UPLOAD_ROOT_PATH . $info['savepath'] . $info['savename'];
                $post['filename'] = $info['name'];//文件的原始名
                $post['hasfile'] = 1;
            }else{
                //A方法实例化控制器
                A('Active') -> error($upload -> getError());exit;
            }
        }
        //补全addtime字段
        $post['addtime'] =date('Y-m-d');
        //添加操作
        return $this -> add($post);
    }

    //更新数据保存
    public function updateData($post,$file){
        //如果有文件则处理文件
        if($file['error'] == '0'){
            //有文件
            //配置数组
            $cfg = array('rootPath' => WORKING_PATH . UPLOAD_ROOT_PATH);
            //实例化上传类
            $upload = new \Think\Upload($cfg);
            //上传
            $info = $upload -> uploadOne($file);
            //dump($info);die;
            //判断上传结果
            if($info){
                //成功
                $post['filepath'] = UPLOAD_ROOT_PATH . $info['savepath'] . $info['savename'];
                $post['filename'] = $info['name'];
                $post['hasfile'] = 1;
            }
        }
        //dump($post);die;
        //写入数据
        return $this -> save($post);
    }

}