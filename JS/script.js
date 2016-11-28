$(document).ready(function () {

/*
    $("#ImageUpload").on('click', function () {
        var x=$("#fileToUpload").val();
        alert(x.substring(12));
        var formData=new FormData($('#form1'));
        $.ajax({
            url: "/sell/ImageUpload.php",
            data: formData,//{ID: $("#imageID").val(), submit: "Upload Image", fileToUpload: x.substring(12),enctype:"multipart/form-data"},
            type: 'POST',
            success: (function (data) {
                $("#targetImage").append(data);
            })
        });
    });

$("#MImageUploadB").on('click', function () {

        $.ajax({
            url: "/sell/ImageUpload.php",
            data: {ID: $("#MimageID").val(), submit: "Upload Image", fileToUpload: $("#MfileToUpload").val()},
            type: 'POST',
            success: (function () {
                window.location.href = '/sell/ci.php';
            })
        });
    });
*/

/*if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
 // some code..
   lightbox.option({
       'maxHeight': screen.height-100,
       'maxWidth': screen.width-100,
      'resizeDuration': 200,
      'wrapAround': true
    })
 
}
else{
   lightbox.option({
       'maxHeight': 500,
       'maxWidth': 500,
      'resizeDuration': 200,
      'wrapAround': true
    })
}*/
        $("#submit22").click(function(){
            var email=$("#email").val();
            var fname=$("#fname").val();
            $.ajax({
                url:"/login/verifyStatus.php",
                data:{
                    fname:$("#fname").val(),
                    lname:$("#lname").val(),
                    email:$("#email").val()
                },
                type: "POST",
                success:function(data){
                    alert(data);
                    if(data==="Success")
                    window.location.href='/login/index.php?ppemail='+email;
                else
                    alert("Not a valid paypal address or Information is incorrect");
                }
        });
        });
        
    

    $('#sellform').validate({ // initialize the plugin
        rules: {
           quantity:{required: true,number:true},
           title:{required: true,minlength: 5,maxlength:40},
           description:{required: true,minlength: 10},
           brandID:{required: true,maxlength:40},
           color:{required: true,maxlength:40},
           size:{required: true,maxlength:40},
           shipFrom:{required: true},
           shipTo:{required: true},
           return:{required: true},
     
           askPrice:{required: true,digits:true,number:true}
       }
           
        
    });
 $('#paypal').change(function () {
   var e=$("#paypal").val();
     $("#paypal").attr('value',e);
 });


    $('input[name=ask_price]').change(function () {
        var ask_price = parseFloat($('#id_ask_price').val());
 if ((ask_price === NaN) || (validDecimal($('#id_ask_price').val()) === 0)) {
            alert("Please Enter a Valid Dollar Amount");
          
        }else{
        if (ask_price < 10)
            var sale_fee = 1;
        else if(ask_price>=10&&ask_price<=30)
            var sale_fee=2;
        else
            var sale_fee = parseFloat(Math.round((ask_price) * .08)+1);
        //var sale_fee=parseFloat(z.toFixed(2));
        var total_price = parseFloat(ask_price.toFixed(2)) + parseFloat(sale_fee.toFixed(2));
        var currency = "$";
       
        $('#id_sale_fee').html(currency + sale_fee);
        $('#id_total_price').html(currency + total_price);
        $('#phidden').val(total_price);
        $('#sfhidden').val(sale_fee);
    }
    });
    function validDecimal(str) {
        if (str.indexOf('.') === -1)
          str += ".";
        var decNum = str.substring(str.indexOf('.') + 1, str.length);
        if (decNum.length > 2)//here is the key u can just change from 2 to 3,45 etc to restict no of digits aftre decimal
        {
            return 0;
        }
        else {
            return 1;
        }
    }
    
    $("#boughtItems").click(function(){
        $("#allbought").slideToggle("slow");
    });
    $("#soldItems").click(function(){
        $("#allsold").slideToggle("slow");
    });
    $("#activeItems").click(function(){
        $("#allactive").slideToggle("slow");
    });

    
    
});
