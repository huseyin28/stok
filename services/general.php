<?php
class general{
   private $conn;
   private $res;
   function __construct(){
      require_once 'conn.php';
      $this->conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");
      $this->res = new stdClass();
       $this->res->success = false;
      if(!$this->conn){
          $this->res->message = "Veritabanına bağlanılamadı";
      }
   }
   function login($p){
      $qString = "SELECT * FROM kullanicilar WHERE eposta='{$p['mail']}' AND sifre='{$p['pass']}' AND pasif=0";
      $result = pg_query($qString);
      if(pg_num_rows($result) == 1){
         session_start();
         $this->res->success = true;
         $ins = pg_fetch_object($result);
         $_SESSION['userid'] = $ins->id;
         $_SESSION['user_per'] = $ins->yetki;
         if($p['rememberme'] == "true"){
            setcookie("mail", $p['mail'], time() + (86400 * 30), "/");
            setcookie("password", $p['pass'], time() + (86400 * 30), "/");
         }else{
            setcookie("mail", $p['mail'], time(), "/");
            setcookie("password", $p['pass'], time(), "/");
         }
      }else
         $this->res->message = "Lütfen bilgilerinizi kontrol ediniz";
         
      return $this->res;
   } 
   function load($params){
      $wheres = array();
      if($params['stext'] != null) $wheres[] = "search ilike '%{$params['stext']}%'";
      if($params['isdel'] == "false") $wheres[] = "pasif = 0";
      $wheres[] = "yetki != 1";
      
      $seacrh = "concat_ws(' ', isim, soyisim, ceptel, sirkettel, eposta) as search";
      $queryString = "SELECT * FROM (SELECT {$seacrh},id, isim, soyisim, eposta, sirket, yetki, pasif, ceptel, sirkettel FROM kullanicilar ) tbl";
      
      if(count($params) > 0){
         $queryString .=  " WHERE ". join(' and ', $wheres);
      }
      $queryString .=  " ORDER BY id desc";
      
      $result = pg_query($queryString);
      if(!$result)return;
      $this->res->count = pg_num_rows($result);
      if($this->res->count > 0){
         $rows = pg_fetch_all($result);
         if($this->res->count < $params['limit']){
            $this->res->pcount = 1;
            $this->res->page = 1;
            $this->res->data = $rows;
         }else{
            $this->res->pcount = ceil(count($rows) / $params['limit']);
            if($this->res->pcount < $params['page'])
               $this->res->page = $this->res->pcount;
            else
               $this->res->page = $params['page'];
            $this->res->data = array();
            for($i = ($this->res->page-1) * $params['limit']; $i < $this->res->page * $params['limit']; $i++){
               if(isset($rows[$i])){
                  $this->res->data[] = $rows[$i];
               }
            }
         }
      }
      $this->res->success = true;
      return $this->res;
   }
   function UserAdd($params){
      $character_control = $this->character_control($params);
      $exits_control = $this->exits_control($params);
      if($character_control !== true) {
        $this->res->message = $character_control;
      }elseif($exits_control !== true){
        $this->res->message = $exits_control;
      }else{
          $queryString = "INSERT INTO kullanicilar (isim,soyisim,eposta,sirket,sifre,ceptel,sirkettel,yetki) VALUES ($1,$2,$3,$4,$5,$6,$7,$8)";
          $queryParams = array($params['firstname'],$params['lastname'],$params['mail'],$params['company'],$params['password'],$params['phone'],$params['phone_company'],$params['permission']);
          $result = pg_query_params($queryString,$queryParams);
          if($result){
            $this->res->success = true;
          }else{
            $this->res->message = "Ekleme işlemi başarısız.";
          }
      }
      return $this->res; 
   }
   function character_control($params){
      if(strlen($params['firstname']) < 2 || strlen($params['firstname']) > 25)
         return "İsim alanı 2-25 harf aralığında olmalı";
      elseif(strlen($params['lastname']) < 2 || strlen($params['lastname']) > 25)
         return "Soyisim alanı 2-25 harf aralığında olmalı";
      elseif(!filter_var($params['mail'], FILTER_VALIDATE_EMAIL))
         return "Geçersiz bir mail adresi girdiniz";
      elseif(strlen($params['password']) < 8 || strlen($params['password']) > 25)
         return "Şifre alanı 8-25 harf aralığında olmalı";
      elseif($params['password'] != $params['again'])
         return "Şifreler eşleşmiyor";
      elseif(strlen($params['phone']) < 10)
         return "Geçersiz bir telefon numarası girdiniz";
      else return true;
   }
   function exits_control($params, $id = null){
        if($id == null)
            $getUser = pg_query("SELECT * FROM kullanicilar WHERE eposta ilike '{$params['mail']}'");
        else
            $getUser = pg_query("SELECT * FROM kullanicilar WHERE eposta ilike '{$params['mail']}' AND id != {$id}");

        if(pg_num_rows($getUser) != 0)
            return "Bu mail adresi başka kullanıcı tarafından kullanılmaktadır.";
        else
            return true;
   }

   function __destruct(){
      pg_close($this->conn);
   }
}

?>