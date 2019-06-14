<?php 

$title = "Sign In";
ob_start(); 

?>

<div id="all">
	<div class="cont">
		<div id="form">
		<h1 class="text-center" id="f_h1">Sign In</h1>
		<div class="registration-form">
			<label>
				<span class="label-text">Pseudo</span>
				<input type="text" name="pseudo" id="pseudo" >
			</label>
			<label class="password">
				<span class="label-text">Password</span>
				<button class="toggle-visibility" title="toggle password visibility" tabindex="-1">
					<span class="glyphicon glyphicon-eye-close"></span>
				</button>
				<input type="password" name="passwd1" class="form__input" required pattern=".{6,}" value="" id="passwd1">
			</label>
			<div class="text-center">
				<button class="submit" id="submit" value="submit" onclick="sign_in()">Sign In</button>
			</div>
		</div>
		<div id="success"></div>
		<p id="forgot">Forgot Password ? <a href="index.php?action=reset_passwd">Reset your password</a></p>
		</div>
	</div>
</div>
<script src="./public/js/sign_in.js"></script>

<?php 

$content = ob_get_clean();
require_once('./view/account.php');
require_once('./view/template.php'); 

?>
