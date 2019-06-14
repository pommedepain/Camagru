<?php 

$title = "Home"; 

ob_start();
$content = ob_get_clean();

require_once('account.php');
require_once('template.php');

?>
