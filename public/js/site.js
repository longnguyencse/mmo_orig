$(document).ready( function() {

  $('.dropdown').on('click', function(e) {
    if($(this).hasClass('open')) {
      $(this).removeClass('open')
    } else {
      $(this).addClass('open')
    }
  })

});