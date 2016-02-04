<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/2/1
 * Time: 16:15
 */
namespace Home\Controller;
use Think\Controller;
class InterfaceController extends Controller{
    public function __construct(){
        parent::__construct();
        header("Content-Type: text/html; charset=UTF-8");
    }
    public function category(){

        /**所有分类菜单**/
        $category=D( 'Category' )->getCategory();

        echo json_e($category);

    }
    /**指定分类菜单**/
    public function getcategory(){
        $pid=I('get.pid',0,'intval');
        if(!($pid && is_numeric($pid))){
            echo json_e('',2);
            exit;
        }
        $category = D('Category')->info($pid);
        $child=M('Category')->where("pid='$pid'")->select();
        $category['children']=$child;
        echo json_e($category);
    }

    public function detail($id=0){
        if(!($id && is_numeric($id))){
            echo json_e('',2);
            exit;
        }
        $Document = D('Document');
        $info = $Document->detail($id);
//        多张图片预留处理
/*        if(!empty($info['pics'])){
            $pics= explode(',',$info['pics']);
        }else {
            $pics = "";
        }*/
        $pic=get_cover($info['cover_id']);
        $info['path']=$pic['path'];

        if(!$info){
            echo json_e();
            exit;
        }else{
            echo json_e($info);
            exit;
        }

    }

    public function web_view($id){
        if(!($id && is_numeric($id))){
            echo json_e('',2);
            exit;
        }
        $Document = D('Document');
        $info = $Document->detail($id);
        $this->assign('content',$info['content']);
        $this->display('web_view_goods_contents');
    }

}
/*
 *

$this->assign('category', $category);

/**购物车**/
//$cart=D( 'shopcart' )->getcart();
//$this->assign( 'usercart',$cart );

/* 热门搜索 */
//$str=M( 'config' )->where( 'id="40"' )->getField( "value" );
//$hotsearch=explode(",",$str);
//$this->assign( 'hotsearch' , $hotsearch );

/* 广告位 */
//$adData= D( 'ad' )->getlist();
