<?php 

$title = "Email Confirmed";
ob_start(); 

?>

<div id="all">
	<div class="cont">
		<div id="form">
			<h1 class="text-center" id="f_h1">Thank you !</h1>
			<div class="text-center">
				<p id="para">Your account has been verified and is now active.</p>
			</div>
			</div>
			<div id="success"></div>
				<p id="wanna">Want to <a href="index.php?action=sign_in">Sign In</a> ?</p>
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
