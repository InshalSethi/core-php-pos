(function($) {
  'use strict';

  if ($(".js-example-basic-single").length) {
    $(".js-example-basic-single").select2({
    	closeOnSelect: false
    });

    $(".js-example-basic-single").select2("open");
$(".js-example-basic-single").on("select2-closing", function(e) {
    e.preventDefault();
});
$(".js-example-basic-single").on("select2-closed", function(e) {
    $(".js-example-basic-single").select2("open");
});
  }
  if ($(".js-example-basic-multiple").length) {
    $(".js-example-basic-multiple").select2();
  }
})(jQuery);