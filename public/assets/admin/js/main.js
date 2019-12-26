



/*
***************************************************************************************
*       Main js
*       
***************************************************************************************
*/
$('#LoginForm').submit(function() {
     var res = true;
     $(".frequired",this).each(function() {
         if($(this).val().trim() == "") {
             res = false; 
             $(this).addClass('errorFiled');
         }else{
             $(this).removeClass('errorFiled');
         }
     })
     if(res == false){
         $('#result').html("<div class='alert alert-danger'>المرجوا ادخال المعلومات لتسجيل الدخول</div>");
     }
     return res; 
});



$('#createuser').submit(function() {
     var res = true;
     $(".frequired",this).each(function() {
         if($(this).val().trim() == "") {
             res = false; 
             $(this).addClass('errorFiled');
         }else{
             $(this).removeClass('errorFiled');
         }
     })
     if(res == false){
         $('#result').html("<div class='alert alert-danger'>المرجوا ادخال المعلومات المطلوبة</div>");
     }
     return res; 
});
    


$('#passwordRecoverForm').submit(function() {
     var res = true;
     $(".frequired",this).each(function() {
         if($(this).val().trim() == "") {
             res = false; 
             $(this).addClass('errorFiled');
         }else{
             $(this).removeClass('errorFiled');
         }
     })
     if(res == false){
         $('#resultRecover').html("<div class='alert alert-danger'>المرجوا ادخال بريدك الإلكتروني</div>");
     }
     return res; 
});


$('#AdminGeneralInfo').submit(function() {
     var res = true;
     $(".frequired",this).each(function() {
         if($(this).val().trim() == "") {
             res = false; 
             $(this).addClass('errorFiled');
         }else{
             $(this).removeClass('errorFiled');
         }
     })
     if(res == false){
         $('#result').html("<div class='alert alert-danger'>لا يمكن ترك الحقول فارغة</div>");
     }
     return res; 
});




$('#AdminPasswords').submit(function() {
     var res = true;
     var eempty = false;
     $(".frequired",this).each(function() {
         if($(this).val().trim() == "") {
             eempty =true;
             res = false; 
             $(this).addClass('errorFiled');
         }else{
             $(this).removeClass('errorFiled');
         }
     })
     if(eempty == true){
         $('#resultpassword').html("<div class='alert alert-danger'>لا يمكن ترك الحقول فارغة</div>");
     }
     
    var new_pass = $('#new_pass').val();
    var new_pass_re = $('#new_pass_re').val();
    
    if(new_pass != new_pass_re) {
        res = false; 
       $('#resultpassword').html("<div class='alert alert-danger'>كلمتا المرور غير متطابقتين</div>");
    }
     return res; 
});




$('#ResetPasswordsForm').submit(function() {
     var res = true;
     var eempty = false;
     $(".frequired",this).each(function() {
         if($(this).val().trim() == "") {
             eempty =true;
             res = false; 
             $(this).addClass('errorFiled');
         }else{
             $(this).removeClass('errorFiled');
         }
     })
     if(eempty == true){
         $('#resultpassword').html("<div class='alert alert-danger'>لا يمكن ترك الحقول فارغة</div>");
     }
     
    var new_pass = $('#password').val();
    var new_pass_re = $('#confirmPassword').val();
    
    if(new_pass != new_pass_re) {
        res = false; 
       $('#resultpassword').html("<div class='alert alert-danger'>كلمتا المرور غير متطابقتين</div>");
    }
     return res; 
});










$('#CreateMenu').submit(function() {
     var res = true;
     $(".frequired",this).each(function() {
         if($(this).val().trim() == "") {
             res = false; 
             $(this).addClass('errorFiled');
         }else{
             $(this).removeClass('errorFiled');
         }
     })
     if(res == false){
         $('#result').html("<div class='alert alert-danger'>المرجوا اضافة اسم القائمة</div>");
     }
     return res; 
});







$('#createPostCategory').submit(function() {
     var res = true;
     $(".frequired",this).each(function() {
         if($(this).val().trim() == "") {
             res = false; 
             $(this).addClass('errorFiled');
         }else{
             $(this).removeClass('errorFiled');
         }
     })
     if(res == false){
         $('#result').html("<div class='alert alert-danger'>المرجوا اضافة اسم التصنيف ورابط التصنيف</div>");
     }
     return res; 
});



$('#generalSettings').submit(function() {
     var res = true;
     $(".frequired",this).each(function() {
         if($(this).val().trim() == "") {
             res = false; 
             $(this).addClass('errorFiled');
         }else{
             $(this).removeClass('errorFiled');
         }
     })
     if(res == false){
         $('#result').html("<div class='alert alert-danger'>المرجوا ملأ الحقول المطلوبة</div>");
     }
     return res; 
});




$('#ShowLoginForm').click(function() {
    $('#passwordRecoverForm').hide();
    $('#LoginForm').show();
});

$('#ShowforgetForm').click(function() {
    $('#LoginForm').hide();
    $('#passwordRecoverForm').show();
});




$('#createProductCategory').submit(function() {
     var res = true;
     $(".frequired",this).each(function() {
         if($(this).val().trim() == "") {
             res = false; 
             $(this).addClass('errorFiled');
         }else{
             $(this).removeClass('errorFiled');
         }
     })
     if(res == false){
         $('#result').html("<div class='alert alert-danger'>المرجوا اضافة اسم التصنيف ورابط التصنيف</div>");
     }
     return res; 
});
    






$('#user_form').submit(function() {
     var res = true;
     $(".frequired",this).each(function() {
         if($(this).val().trim() == "") {
             res = false; 
             $(this).addClass('errorFiled');
         }else{
             $(this).removeClass('errorFiled');
         }
     })
     if(res == false){
         $('#result').html("<div class='alert alert-danger'>لا يمكن ترك الحقول المطلوبة فارغة</div>");
     }
     return res; 
});
    



$('#sendemail').submit(function() {
     var res = true;
     $(".frequired",this).each(function() {
         if($(this).val().trim() == "") {
             res = false; 
             $(this).addClass('errorFiled');
         }else{
             $(this).removeClass('errorFiled');
         }
     })
     if(res == false){
         $('#result').html("<div class='alert alert-danger'>لا يمكن ترك الحقول المطلوبة فارغة</div>");
     }
     return res; 
});
    













// check all for in permissions page
$( document ).ready(function() {
    $(".checkallpermissions").change(function() {
            if(this.checked) {
                $('.permcheck').prop('checked', true);
            }else{
                 $('.permcheck').prop('checked', false);
            }
        });
    
 });










// check all in tables 
$( document ).ready(function() {
    $(".checkboxall input").change(function() {
            if(this.checked) {
                $('.checkit input').prop('checked', true);

                $(".datatable tbody tr").each(function(){
                   $(this).addClass('removeRow');
                });

            }else{
                 $('.checkit input').prop('checked', false);
                $(".datatable tbody tr").each(function(){
                   $(this).removeClass('removeRow');
                });

            }
        });

    $(".checkit input").change(function() {
        if(this.checked) {

            $(this).closest('tr').addClass('removeRow');

        }else{
            $(this).closest('tr').removeClass('removeRow');
        }    
    });
    
 });



function clean () {
document.getElementById("avatarUploadPreview").value = "";
document.getElementById("ads-show").style.display = 'none';    
}
$("#deleteoldad").click(function(){
    $("#isAdChanged").val("true");
    $("#ads-show").hide();
    $("#deleteoldad").remove();

});


function readURL(input) {

if (input.files && input.files[0]) {
var reader = new FileReader();

reader.onload = function (e) {
$('#profile_avatar').attr('src', e.target.result);
}

reader.readAsDataURL(input.files[0]);
}
}
$("#avatarUploadPreview").change(function(){
readURL(this);
    $("#isAdChanged").val("true");
    $("#ads-show").show();
    $("#delete-ad").show();
});  




function tooglePassword() {
    var x = document.getElementById("password");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}





function password_generator( len ) {
    var length = (len)?(len):(10);
    var string = "abcdefghijklmnopqrstuvwxyz"; //to upper 
    var numeric = '0123456789';
    var punctuation = '!@#$%^&*()_+~`|}{[]\:;?><,./-=';
    var password = "";
    var character = "";
    var crunch = true;
    while( password.length<length ) {
        entity1 = Math.ceil(string.length * Math.random()*Math.random());
        entity2 = Math.ceil(numeric.length * Math.random()*Math.random());
        entity3 = Math.ceil(punctuation.length * Math.random()*Math.random());
        hold = string.charAt( entity1 );
        hold = (password.length%2==0)?(hold.toUpperCase()):(hold);
        character += hold;
        character += numeric.charAt( entity2 );
        character += punctuation.charAt( entity3 );
        password = character;
    }
    password=password.split('').sort(function(){return 0.5-Math.random()}).join('');
    $("#password").val(password.substr(0,len));
}


$("#avatarUploadPreview").change(function(){    
    $("#avatarChanged").val("true");          
}); 




function readURL(input) {

if (input.files && input.files[0]) {
var reader = new FileReader();

reader.onload = function (e) {
$('#profile_avatar').attr('src', e.target.result);
}

reader.readAsDataURL(input.files[0]);
}
}
$("#avatarUploadPreview").change(function(){
readURL(this);
$("#isAvatarChanged").val("true");
}); 



// simple uploder
$('#uploader').submit(function(evt) {
        evt.preventDefault();
        var formData = new FormData(this);
        $.ajax({
        type: 'POST',
        url: '/dashboard/media/upload/',
        data:formData,
        cache:false,
        contentType: false,
        processData: false,
         beforeSend: function(data) {
            $("#submitResult").html('جاري رفع الملف المرجوا الإنتظار رجاءً');
        },
        success: function(data) {
           $("#submitResult").html('تم رفع الملف بنجاح');
           $(".media-table tbody").prepend(data)
        },
        error: function(data) {
            $("#submitResult").html("حصل خطأ ما ، المرجوا المحاولة من جديد");
        }
        });
});  



    
// show the uploader
$(".showUploader").click(function() {
    $(".uploader_sec").show();
});
$(".showUploader2").click(function() {
    $(".empty_state").remove();
    $(".uploader_sec").show();
});
$("#medialibrary").click(function() {
           $(".mediauploder .modal-footer").css("visibility", "visible");
});




// Delete The Media
$(".media-table #DeleteMedia").click(function() {
    var id = $(this).data("id");
    $.ajax({
        type: "POST",
        url: "/dashboard/media/delete/",
        data: { 
            id: $(this).data("id"), // < note use of 'this' here
        },
        success: function(result) {
            $("#"+id+"").remove();
        },
        error: function(result) {
            alert('error');
        }
    });
    
});





  var menuarea = $('#menuarea').val();
        $("[name='area'][value='"+menuarea+"']").prop('checked', true);
     
     
      $('.dd.nestable').nestable({
        maxDepth: 2
      })
        .on('change', updateOutput);
     
     
     $(function () {
        $("[rel='tooltip']").tooltip();
    });







// set the dropdown of ads
$('.areaUndetected').select2({ placeholder: 'تحديد مكان الإعلان',});


// change the value of selected ads area
var adsarea = $('#adsarea').val();
$(document).ready(function() { $(".areaUndetected").select2().val(adsarea).trigger("change") });		
	


// Show the search box
$("#show_search_box").click(function() {
    $('#search_box').show();
    
});

// hide the search box
$("#hide_search_box").click(function() {
    $('#search_box').hide();
});



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
































