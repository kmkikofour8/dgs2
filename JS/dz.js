$(document).ready(function () {
    //var Dropzone = require("dropzone");
function deletefile(value,id)
{
var xmlhttp;
if (window.XMLHttpRequest)
 {// code for IE7+, Firefox, Chrome, Opera, Safari
 xmlhttp=new XMLHttpRequest();
 }
else
 {// code for IE6, IE5
 xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
 }
xmlhttp.onreadystatechange=function()
 {
 if (xmlhttp.readyState==4 && xmlhttp.status==200)
 {
// alert(xmlhttp.responseText);
 }
 }
xmlhttp.open("POST","/sell/delete.php?name="+value+"&iID="+id,true);
xmlhttp.send();
}
function deletefile1(value,id)
{
var xmlhttp;
if (window.XMLHttpRequest)
 {// code for IE7+, Firefox, Chrome, Opera, Safari
 xmlhttp=new XMLHttpRequest();
 }
else
 {// code for IE6, IE5
 xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
 }
xmlhttp.onreadystatechange=function()
 {
 if (xmlhttp.readyState==4 && xmlhttp.status==200)
 {
// alert(xmlhttp.responseText);
 }
 }
xmlhttp.open("POST","/sell/delete1.php?name="+value+"&iID="+id,true);
xmlhttp.send();
}

var dz1=new Dropzone('#dropzone1',
{
    url: "/sell/upload.php",
      method: "post",
      withCredentials: false,
      parallelUploads: 2,
      uploadMultiple: false,
      maxFilesize: 256,
      paramName: "file",
      createImageThumbnails: true,
      maxThumbnailFilesize: 10,
      thumbnailWidth: 120,
      thumbnailHeight: 120,
      filesizeBase: 1000,
      maxFiles: 1,
      params: {},
      clickable: true,
      ignoreHiddenFiles: true,
      acceptedFiles: null,
      acceptedMimeTypes: null,
      autoProcessQueue: true,
      autoQueue: true,
      addRemoveLinks: true,
      success:function(file){
          $("#mainImage").val(file.name);
      },
      previewsContainer: null,
      hiddenInputContainer: "body",
      capture: null,
      dictDefaultMessage: "Upload Main Image Here<br>Drop Image Here Or Click to Browse",
      dictFallbackMessage: "Your browser does not support drag'n'drop file uploads.",
      dictFallbackText: "Please use the fallback form below to upload your files like in the olden days.",
      dictFileTooBig: "File is too big ({{filesize}}MiB). Max filesize: {{maxFilesize}}MiB.",
      dictInvalidFileType: "You can't upload files of this type.",
      dictResponseError: "Server responded with {{statusCode}} code.",
      dictCancelUpload: "Cancel upload",
      dictCancelUploadConfirmation: "Are you sure you want to cancel this upload?",
      dictRemoveFile: "Remove file",
      dictRemoveFileConfirmation: null,
      dictMaxFilesExceeded: "You can not upload any more files."
});
var dz2=new Dropzone('form#dropzone2',
{
    url: "/sell/upload1.php",
      method: "post",
      withCredentials: false,
      parallelUploads: 10,
      uploadMultiple: false,
      maxFilesize: 256,
      paramName: "file",
      createImageThumbnails: true,
      maxThumbnailFilesize: 10,
      thumbnailWidth: 120,
      thumbnailHeight: 120,
      filesizeBase: 1000,
      maxFiles: 10,
      params: {},
      clickable: true,
      ignoreHiddenFiles: true,
      acceptedFiles: null,
      acceptedMimeTypes: null,
      autoProcessQueue: true,
      autoQueue: true,
      addRemoveLinks: true,
      previewsContainer: null,
      hiddenInputContainer: "body",
      capture: null,
      dictDefaultMessage: "Additional Images to Show Off Product(s)<br>Drop Images Here Or Click to Browse",
      dictFallbackMessage: "Your browser does not support drag'n'drop file uploads.",
      dictFallbackText: "Please use the fallback form below to upload your files like in the olden days.",
      dictFileTooBig: "File is too big ({{filesize}}MiB). Max filesize: {{maxFilesize}}MiB.",
      dictInvalidFileType: "You can't upload files of this type.",
      dictResponseError: "Server responded with {{statusCode}} code.",
      dictCancelUpload: "Cancel upload",
      dictCancelUploadConfirmation: "Are you sure you want to cancel this upload?",
      dictRemoveFile: "Remove file",
      dictRemoveFileConfirmation: null,
      dictMaxFilesExceeded: "You can not upload any more files."
});
 
 
$("#createPage2").click(function(){


    var iID= $("#iID").text();
                var price=$("#price").text();
    var            title=$("#title").text();
       var         brandID=$("#brandID").text();
          var      color=$("#color").text();
            var    size=$("#size").text();
              var  sellerID=$("#sellerID").text();
        var        description=$("#description").val();
        var        shipFrom=$("#shipFrom").text();
        var        shipTo=$("#shipTo").text();
        var        returns=$("#return").text();
        var        image=$("#mainImage").val()
    
    
    
    
    $.ajax({
            url: "/sell/createPage.php",
            data: {iID: $("#iID").text(), 
                price:$("#price").text(),
                title:$("#title").text(),
                brandID:$("#brandID").text(),
                color:$("#color").text(),
                size:$("#size").text(),
                sellerID:$("#sellerID").text(),
                description:$("#description").text(),
                shipFrom:$("#shipFrom").text(),
                shipTo:$("#shipTo").text(),
                returns:$("#return").text(),
                image:$("#mainImage").val(),
                paypal:$("#paypal").val()},
            type: 'POST',
            success: (function () {
                window.location.href = '/Homepage.php';
            })
        })
});

           
});
