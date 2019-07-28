<?php 

$title = "Gallery";
$stylesheet = '<link rel="stylesheet" type="text/css" href="./public/css/gallery.css">';

ob_start();
?>

<div id="capsule">
	<div class="alert" id="alert">
  		<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>  
  		<strong>Oops!</strong> You need to be logged in to like or comment a photo
	</div>
</div>
<div id="content">
	<ul id="stylish">
	</ul>
</div>
<script src="./public/js/gallery.js"></script>

<?php
$content = ob_get_clean();

require_once('account.php');
require_once('template.php');

?>
