<?php
namespace Admin\Controller;
use Think\Controller;

class TestController extends Controller{
   public function test(){
      $i=false;
      if($i>0){
         echo"成功";
      }else{
         echo"失败";
      }
   }

































}