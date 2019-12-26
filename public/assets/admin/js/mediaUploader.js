/*
*       Media uploader inspired from wordpress
*       made by takiddine soulaimane 
*       PHP+AJAX
*       www.TakiDDine.com
*/
    
// Uploading the image
 $(document).on('change', '#file', function(){
  var name = document.getElementById("file").files[0].name;
  var form_data = new FormData();
  var ext = name.split('.').pop().toLowerCase();
   var imgurl = window.URL.createObjectURL(document.getElementById('file').files[0]);
   form_data.append("file", document.getElementById('file').files[0]);
   $.ajax({
    url:'/dashboard/media/uploader/',
    method:"POST",
    data: form_data,
    contentType: false,
    cache: false,
    processData: false,
    beforeSend:function(){
        
        // create a random number ( to use it as an image id)
        var min = 40;
        var max = 100;
        var randomNumber = Math.floor(Math.random()*(max-min+1)+min);
        
        // show the gallery
        $('a[href="#basic-tab2"]').trigger('click');
        
        // show the image uploading 
        $('.simpleUplader2').prepend("<div class='thumbnail'><div class='loader'><img  class='loaderimg' src='/uploads/index.svg' /></div><div class='thumb'><input type='checkbox' class='mediacheckbox' value='' id='img"+randomNumber+"'><label for='img"+randomNumber+"'><img src='"+imgurl+"' class='preee' /></label></div></div>");
    },   
       

    success:function(data) {
        
        // remove the loader
        $('.thumbnail:first-child .loader').remove();
        
        // add the link
        var imglink = "/uploads/media/"+data;
        
        // get the image
        $('.thumbnail:first-child .preee').attr('src', imglink); 
        
        // show chose image button
        $(".mediauploder .modal-footer").css("visibility", "visible");
        
       
        $(".thumbnail:first-child .mediacheckbox").val(imglink);
       
    }
   });
 });
   