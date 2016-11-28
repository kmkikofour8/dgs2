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
           quantity:{required: true},
           title:{required: true,minlength: 5},
           description:{required: true,minlength: 15},
           brandID:{required: true},
           color:{required: true},
           size:{required: true},
           shipFrom:{required: true},
           shipTo:{required: true},
           return:{required: true},
           paypal:{required:true,email:true},
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
        else if(ask_price>=10&&ask_price<=19)
            var sale_fee=2;
        else
            var sale_fee = parseFloat(Math.round((ask_price) * .10)+1);
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
});
