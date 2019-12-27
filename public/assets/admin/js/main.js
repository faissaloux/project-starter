
// Go back button in admin pages header
$(document).ready(function(){
	$('.goback').click(function(){
		parent.history.back();
		return false;
	});
});


function go_full_screen(){
  var elem = document.documentElement;
  if (elem.requestFullscreen) {
    elem.requestFullscreen();
  } else if (elem.msRequestFullscreen) {
    elem.msRequestFullscreen();
  } else if (elem.mozRequestFullScreen) {
    elem.mozRequestFullScreen();
  } else if (elem.webkitRequestFullscreen) {
    elem.webkitRequestFullscreen();
  }
}



if($.cookie("colapse") == 'ok') {
    $('body').addClass('sidebar-xs');
}
$('.sidebar-main-toggle').on('click', function(){

    if($.cookie("colapse") == 'ok') {
        $.removeCookie('colapse', { path: '/' });
        return false;
    } else {
        $.cookie('colapse', 'ok' ,{ expires: 7, path : '/'});
    }
});