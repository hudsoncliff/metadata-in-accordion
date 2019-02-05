/*オリジナルjavascriptファイル*/

jQuery(function($){
  //jqueryはこの中に書く
  console.log("meta-in-accordion is active");

  var openBtn = $(".openaccordion_btn"),
  accordionTxt = $(".accordion_txt");

  if(openBtn && accordionTxt){
    openBtn.click(function(){
      accordionTxt.slideToggle();
      accordionTxt.toggleClass("active");
      $(this).toggleClass("active");
    });
  }
});
