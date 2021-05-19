<?php

session_start();
require_once('../../conexion.php');

if(isset($_GET["envidprimaria"])!="")
$_SESSION["varestaticmyid"]=$_GET["envidprimaria"];	
	
	
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>image viewer</title>
<link href="scriptobt_vistaimg/imageviewer.css"  rel="stylesheet" type="text/css" />
<script src="scriptobt_vistaimg/demo/lib/jquery-1.11.3.min.js"></script>
<script src="scriptobt_vistaimg/imageviewer.js"></script>
 
<style>
    #image-gallery {
      width: 100%;
      position: relative;
      height: 650px;
      background: #000;
    }
    #image-gallery .image-container {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 50px;
    }
    #image-gallery .prev,
    #image-gallery .next {
      position: absolute;
      height: 32px;
      margin-top: -66px;
      top: 50%;
    }
    #image-gallery .prev {
      left: 20px;
    }
    #image-gallery .next {
      right: 20px;
      cursor: pointer;
    }
    #image-gallery .footer-info {
      position: absolute;
      height: 50px;
      width: 100%;
      left: 0;
      bottom: 0;
      line-height: 50px;
      font-size: 24px;
      text-align: center;
      color: white;
      border-top: 1px solid #FFF;
    }
</style>
</head>

<body>
<div id="image-gallery">
    <div class="image-container"></div>
     <img src="scriptobt_vistaimg/demo/images/left.svg" class="prev"/>
    <img src="scriptobt_vistaimg/demo/images/right.svg"  class="next"/>
    <div class="footer-info">
        <span class="current"></span>/<span class="total"></span>
    </div>
</div>   
<script type="text/javascript">
$(function () {
    var images = [
	<?php
	
	if(isset($_GET["envidprimaria"])!="")
    {


 $sqlconsitem="SELECT url_anexo_local  FROM public.tbl_archivos_scanimgs where ref_archprocesados='".$_GET["envidprimaria"]."' order by nombrearch ;";
$resultcitem=pg_query($conn, $sqlconsitem);

for($im=0;$im<pg_num_rows($resultcitem);$im++)
 {
	 $dat_varitemimg=pg_fetch_result($resultcitem,$im,0);
	?>
	{
        small : '<?php echo $dat_varitemimg;?>',
        big : '<?php echo $dat_varitemimg;?>'
    },
	
	<?php
 }
	 }    ?>
	
	];
 
    var curImageIdx = 1,
        total = images.length;
    var wrapper = $('#image-gallery'),
        curSpan = wrapper.find('.current');
    var viewer = ImageViewer(wrapper.find('.image-container'));
 
    //display total count
    wrapper.find('.total').html(total);
 
    function showImage(){
        var imgObj = images[curImageIdx - 1];
        viewer.load(imgObj.small, imgObj.big);
        curSpan.html(curImageIdx);
    }
 
    wrapper.find('.next').click(function(){
         curImageIdx++;
        if(curImageIdx > total) curImageIdx = 1;
        showImage();
    });
 
    wrapper.find('.prev').click(function(){
         curImageIdx--;
        if(curImageIdx < 0) curImageIdx = total;
        showImage();
    });
 
    //initially show image
    showImage();
});
</script>

 </body>
</html>
