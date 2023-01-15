$(document).ready(function(){
    $(document).on('click','#btn_update_img',function(e){
        e.preventDefault();
        if(!$('#photo').length){
            $('#btn_update_img').hide();
            $('#btn_cancle_update_img').show();
            $('#div_img').html('<input type="file" onchange="readURL(this)" name="photo" id="photo">')
        }
        return false;
    })

    $(document).on('click','#btn_cancle_update_img',function(e){
        e.preventDefault();
            $('#btn_update_img').show();
            $('#btn_cancle_update_img').hide();
            $('#div_img').html('')
        return false;
    })

    $(document).on('click','.are_you_shue',function(e){
        var res =confirm("هل انت متأكد ؟");
        if(!res)
        {
          return false;
        }
        });
        
        

})


function readURL(input) {/// لما كاانت جويت الداكيومنت د,ت رادي مشتغلتش فخليناها برى اشتغلت
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#uploadedimg').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}