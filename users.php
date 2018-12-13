<?php  
    include 'includes/top.php';
    include 'services/conn.php';
    pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");
?> 
<div class="page-header">
   <div class="container-fluid">
      <h2 class="h5">
         Kullanıcılar
      </h2>
   </div>
   <section class="">
      <div class="container-fluid">
         <div class="row">
            <div class="col-md-12 no-padding">
               <div class="form-group pull-left" style="max-width: 250px; margin: 0;">
                  <div class="input-group">
                     <input id="text" type="text" class="form-control" placeholder="ara : isim, mail, telefon">
                  </div>
               </div>
               <button class="btn btn-primary pull-right no-radius" data-toggle="modal" data-target="#mdlAddUser"><i class="fa fa-plus fa-fw"></i> Ekle</button>
               <table class="table table-hover table-striped table-bordered" id="tblUsers" style="margin-bottom:20px;">
                  <thead>
                     <tr>
                        <td>#</td>
                        <td>İsim</td>
                        <td class="hidden-xs">Mail</td>
                        <td class="hidden-xs">Şirket</td>
                        <td class="hidden-xs">Pozisyon</td>
                        <td class="hidden-xs">Telefon</td>
                        <td>Telefon (Şirket)</td>
                     </tr>
                  </thead>
                  <tbody></tbody>
               </table>
               <label id="tblInfo"></label>
               <nav aria-label="Page navigation example" style="width:min-content; user-select: none;">
                  <ul class="pagination pull-left" id="pnav" style="width:min-content"></ul>
               </nav>
               <span class="pull-left" style="line-height : 38px; margin-left:20px; margin-right:10px;">Limit : </span>
               <select class="form-control pull-left" style="width: 100px;" id="slcLimit">
                  <option value="10">10</option>
                  <option value="15">15</option>
                  <option value="25">25</option>
                  <option value="50">50</option>
               </select>
            </div>
         </div>
      </div>
   </section>
</div>

<div id="mdlAddUser" tabindex="-1" role="dialog" class="modal fade text-left show">
   <div role="document" class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header"><strong id="exampleModalLabel" class="modal-title">Yeni Kullanıcı Ekle</strong>
            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
         </div>
         <div class="modal-body">
            <div class="row">
               <div class="form-group col-md-6">
                  <label>İsim *</label>
                  <input type="text" class="form-control" id="firstname">
               </div>
               <div class="form-group col-md-6">
                  <label>Soyisim *</label>
                  <input type="text" class="form-control" id="lastname">
               </div>
            </div>
            <div class="row">
               <div class="form-group col-md-6">
                  <label>Mail *</label>
                  <input type="text" class="form-control" id="mail">
               </div>
               <div class="form-group col-md-6">
                  <label>Şirket *</label>
                  <select class="form-control" id="company">
                     <option value="1">Çelsan Çelik A.Ş.</option>
                     <option value="2">Güneş A.Ş.</option>
                  </select>
               </div>
            </div>
            <div class="row">
               <div class="form-group col-md-6">
                  <label>Şifre *</label>
                  <input type="password" class="form-control" id="password">
               </div>
               <div class="form-group col-md-6">
                  <label>Şifre Tekrar *</label>
                  <input type="password" class="form-control" id="again">
               </div>
            </div>
            <div class="row">
               <div class="form-group col-md-6">
                  <label>Telefon *</label>
                  <input type="text" class="form-control" maxlength="14" id="phone">
               </div>
               <div class="form-group col-md-6">
                  <label>Şirket Telefonu</label>
                  <input type="text" class="form-control" id="phone_company">
               </div>
            </div>
            <div class="row">
               <div class="form-group col-md-6">
                  <label>Yetki *</label>
                  <select class="form-control" id="permission">
                  <option value="0" style="font-style:italic;">Seçiniz</option>
                  <?php 
                  $resYetki = pg_query("select * from yetki where id != 1");
                  while($row = pg_fetch_object($resYetki)){
                      echo '<option value="'.$row->id.'">'.$row->isim.'</option>';
                  }
                  ?>
                  </select>
               </div>
            </div>
            <label>* ile işaretli olanlar doldurulması zorunlu alanlardır.</label>
         </div>
         <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-secondary">Vazgeç</button>
            <button type="button" class="btn btn-primary" onclick="user.add();">Kaydet</button>
         </div>
      </div>
   </div>
</div>

<footer class="footer">
   <div class="footer__block block no-margin-bottom">
      <div class="container-fluid text-center">
         <p>Design by <a href="https://instagram.com/huseyin.yilmaz.28" target="_blank" class="external">Hüseyin Yılmaz</a></p>
      </div>
   </div>
</footer>


</div>
</div>
<script src="dist/vendor/jquery/jquery.min.js"></script>
<script src="dist/vendor/popper.js/umd/popper.min.js"> </script>
<script src="dist/vendor/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript">
   $('.list-unstyled a[href="./users"]').parent().addClass('active');

</script>
<script src="scripts/users.js"></script>
</body>

</html>
