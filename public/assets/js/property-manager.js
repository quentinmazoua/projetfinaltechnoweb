$(document).ready(function() 
{
  var bodyHeight = $("body").height();
  var vwptHeight = $(window).height();
  if (vwptHeight > bodyHeight) 
  {
    $("footer").css("position","relative").css("bottom",0);
  }

  $(".note").raty({ 
    readOnly  : true,
    half      : true,
    starHalf  : 'http://projetfinal/assets/img/star-half.png',
    starOff   : 'http://projetfinal/assets/img/star-off.png',
    starOn    : 'http://projetfinal/assets/img/star-on.png' ,
    score     : function() {
      return $(this).attr('data-score');
    }
  });
});

blockFotoramaData = true;