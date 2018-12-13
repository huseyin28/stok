<?php

$res = new stdClass();
$res->success = false;
if(!isset($_REQUEST['s']) || !isset($_REQUEST['f']) || !isset($_REQUEST['p'])){
   $res->message = "!Hata : Eksik parametre girdiniz";
}elseif(empty($_REQUEST['s']) || empty($_REQUEST['f'])){
   $res->message = "!Hata : Geçersiz parametre girdiniz";
}elseif(!file_exists($_REQUEST['s'].".php")){
   $res->message = "!Hata : Servis bulunamadı";
}else{
   include $_REQUEST['s'].".php";
   if(!method_exists($_REQUEST['s'], $_REQUEST['f'])){
       $res->message = "!Hata : Fonksiyon bulunamadı";
   }else{
      $ser = new $_REQUEST['s']();
      $res = $ser->$_REQUEST['f']($_REQUEST['p']);
   }
}

echo json_encode($res,JSON_UNESCAPED_UNICODE);

?>