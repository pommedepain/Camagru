<?php 

$title = "Email Confirmed";
ob_start(); 

?>

<div id="all">
	<div class="cont">
		<div id="form">
			<h1 class="text-center" id="f_h1">Thank you !</h1>
			<div class="text-center">
				<p>Your account has been verified and is now active.</p>
			</div>
			<div class="text-center" id="linky">
				<a class="submit" id="clicked" value="clicked" href="index.php?action=sign_in">Sign In</a>
			</div>
		</div>
	</div>
</div>
<script src="./public/js/confirm_mail.js"></script>

<?php 

$content = ob_get_clean();
require_once('./view/account.php');
require_once('./view/template.php'); 

?>
