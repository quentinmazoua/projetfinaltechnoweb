$(document).ready(function() {
  var bodyHeight = $("body").height();
  var vwptHeight = $(window).height();
  if (vwptHeight > bodyHeight) {
    console.log("test");
    $("footer").css("position","relative").css("bottom",0);
  }
});

blockFotoramaData = true;