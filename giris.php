<!DOCTYPE html> 
<html>

<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title>Giriş Yap | X A.Ş. | Stok Yönetim Uygulaması</title>
   <meta name="description" content="">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="robots" content="all,follow">
   <link rel="stylesheet" href="dist/vendor/bootstrap/css/bootstrap.min.css">
   <link rel="stylesheet" href="dist/vendor/font-awesome/css/font-awesome.min.css">
   <link rel="stylesheet" href="dist/css/font.css">
   <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,700">
   <link rel="stylesheet" href="dist/css/style.default.css" id="theme-stylesheet">
   <link rel="stylesheet" href="dist/css/custom.css">
   <link rel="shortcut icon" href="dist/img/icon.png">
   <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
</head>

<body>
   <div class="login-page">
      <div class="container d-flex align-items-center">
         <div class="form-holder has-shadow">
            <div class="row">
               <div class="col-lg-6">
                  <div class="info d-flex align-items-center">
                     <div class="content">
                        <div class="logo">
                           <h1>Stok Yönetimi</h1>
                        </div>
                        <p>Şirketinizi, çalışan, müşteri ve stok kayıtlarınızı tutun.</p>
                     </div>
                  </div>
               </div>
               <div class="col-lg-6 bg-white">
                  <div class="form d-flex align-items-center">
                     <div class="content">
                        <div class="form-validate">
                           <div class="form-group">
                              <?php 
                              if(!empty($_COOKIE['mail'])){
                                 echo '
                              <input id="login-mail" type="mail" class="input-material" value="'.$_COOKIE['mail'].'">
                              <label for="login-mail" class="label-material active">E-posta</label>';
                              }else{
                                 echo '
                                 <input id="login-mail" type="text" class="input-material">
                                 <label for="login-mail" class="label-material">E-posta</label>';
                              }?>
                              
                           </div>
                           <div class="form-group">
                               <?php 
                              if(!empty($_COOKIE['password']))
                                 echo '
                              <input id="login-password" type="password" class="input-material" value="'.$_COOKIE['password'].'">
                              <label for="login-password" class="label-material active">Şifre</label>';
                              else
                                 echo '
                              <input id="login-password" type="password" class="input-material">
                              <label for="login-password" class="label-material">Şifre</label>';
                              ?>
                              
                           </div>
                           <button id="btnLogin" onclick="fnLogin()" class="btn btn-primary">Giriş Yap</button>
                           <div class="i-checks" style="padding-left: 3px; padding-top: 10px;">
                            <input id="rememberme" type="checkbox" value="" <?php if(!empty($_COOKIE['password'])) echo 'checked'; ?> class="checkbox-template">
                            <label for="rememberme">Beni Hatırla</label>
                          </div>
                        </div>
                        <a href="#" class="forgot-pass">Şifreni unuttun mu?</a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="copyrights text-center">
         <p>Design by <a href="https://instagram.com/huseyin.yilmaz.28" target="_blank" class="external">Hüseyin Yılmaz</a></p>
      </div>
   </div>
   <script src="dist/vendor/jquery/jquery.min.js"></script>
   <script src="dist/vendor/bootstrap/js/bootstrap.min.js"></script>
   <script src="dist/vendor/jquery-validation/jquery.validate.min.js"></script>
   <script src="dist/vendor/jquery.cookie/jquery.cookie.js"> </script>
   <script src="dist/js/front.js"></script>
   <script src="dist/js/hy.js"></script>
   <script>
      $(document).ready(ready);
      var d = 1;

      function ready() {
         $('#btnLogin').on('click', fnLogin);
         $('#login-password, #login-mail').keyup(function(e){
             if(e.keyCode == 13){
                fnLogin();
             }
         });
      }

      function fnLogin() {
         var data = {
            mail: $('#login-mail').val().trim(),
            pass: $('#login-password').val().trim(),
            rememberme: $('#rememberme').prop('checked')
         };
         $.ajax({
            url: 'services/service.php',
            dataType : "json",
            data: {
               s: 'general',
               f: 'login',
               p: data
            },
            success: function(res) {
               if (res.success) {
                  window.location.assign("./");
               } else {
                  alert(res.message);
               }
            }
         });
      }

   </script>
</body>

</html>
