<?php 

$title = "Reset Password";
ob_start(); 

?>

<div id="all">
	<div class="cont">
		<div id="form">
		<h1 class="text-center" id="f_h1">Reset your password</h1>
			<div class="registration-form">
				<label>
					<span class="label-text">Pseudo</span>
					<input type="text" name="pseudo" id="pseudo" >
				</label>
				<label>
					<span class="label-text">Email</span>
					<input type="text" name="email" id="email">
				</label>
				<div class="text-center">
					<button class="submit" id="submit" value="submit" onclick="reset_passwd()">Reset</button>
				</div>
			</div>
			<div id="success"></div>
		</div>
	</div>
</div>
<script src="./public/js/reset_passwd.js"></script>

<?php 

$content = ob_get_clean();
require_once('./view/account.php');
require_once('./view/template.php'); 

?>
