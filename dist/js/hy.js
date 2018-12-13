var hy = {
   width: 600,
   space: 15,
   position: "bottom-right",
   type : "danger",
   timeout : 5000,
   setPosition: function (position) {
      if(["top-left","top-center","top-right","bottom-left","bottom-center","bottom-right"].indexOf(position) != -1)
         this.position = position
      else
         console.log("geçersiz posizyon girdiniz")
   },
   setSpace : function(space){
      if(Number.isInteger(space) == true && space >= 5 && space <= 50)
         this.space = space
      else
         console.log("geçersiz boşluk girdiniz")
   },
   show : function(message="İşlem başarısız",type = this.type,timeout=this.timeout){
      var alert = '<div class="alert shadow alert-' + type + ' alert-dismissible" style="display:none;">' + '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+message+'</div>';
      if(this.position.split("-")[0] == "top"){
         $(alert).prependTo('#hy-conteiner-'+this.position).fadeIn(400).delay(timeout).fadeOut(400).queue(function () {
            $(this).remove();
         });
      }else{
           $(alert).appendTo('#hy-conteiner-'+this.position).fadeIn(400).delay(timeout).fadeOut(400).queue(function () {
            $(this).remove();
         });
      }
   }
};

$(document).ready(function () {
   $('body').append(
      '<div id="hy-conteiner-top-center" style="z-index: 10000; text-align:center; width:fit-content; position:fixed; top:' + hy.space + 'px; left:50%; transform: translateX(-50%);"></div>' +
      '<div id="hy-conteiner-top-left" style="z-index: 10000; text-align:left; width:fit-content; position:fixed; top:' + hy.space + 'px; left:' + hy.space + 'px;"></div>' +
      '<div id="hy-conteiner-top-right" style="z-index: 10000; text-align:right; width:fit-content; position:fixed; top:' + hy.space + 'px; right:' + hy.space + 'px;"></div>' +
      '<div id="hy-conteiner-bottom-center" style="z-index: 10000; text-align:center; width:fit-content; position:fixed; bottom:' + hy.space + 'px; left:50%; transform: translateX(-50%);"></div>' +
      '<div id="hy-conteiner-bottom-left" style="z-index: 10000; text-align:left; width:fit-content; position:fixed; bottom:' + hy.space + 'px; left:' + hy.space + 'px;"></div>' +
      '<div id="hy-conteiner-bottom-right" style="z-index: 10000; text-align:right; width:fit-content; position:fixed; bottom:' + hy.space + 'px; right:' + hy.space + 'px;"></div>'
   );
})
