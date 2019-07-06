<?php 

$title = "Gallery";
$stylesheet = '<link rel="stylesheet" type="text/css" href="./public/css/gallery.css">';

ob_start();
?>

<div>
</div>
<script src="./public/js/gallery.js"></script>

<?php
$content = ob_get_clean();

require_once('account.php');
require_once('template.php');

?>
