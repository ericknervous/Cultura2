JavaScript
$("#navbarSupportedContent").on("click", "li", function (e) {
  $('#navbarSupportedContent ul li').removeClass("active");
  $(this).addClass('active');

  // Ajuste a posição do seletor
  var itemPosNewAnimTop = $(this).position().top;
  var itemPosNewAnimLeft = $(this).position().left;
  $(".hori-selector").css({
    "top": itemPosNewAnimTop + "px",
    "left": itemPosNewAnimLeft + "px"
  });
});