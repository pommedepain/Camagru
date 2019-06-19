<?php 

$title = "Choose a new password";
ob_start(); 

?>

<div id="all">
	<div class="cont">
		<div id="form">
		<h1 class="text-center" id="f_h1">Choose a new password</h1>
			<div class="registration-form">
				<label class="password">
					<span class="label-text">New Password</span>
					<button class="toggle-visibility" title="toggle password visibility" tabindex="-1">
						<span class="glyphicon glyphicon-eye-close"></span>
					</button>
					<input type="password" name="passwd1" class="form__input" required pattern=".{6,}" value="" id="passwd1">
					<span class="icon"></span>
				</label>
				<label class="password">
					<span class="label-text">Confirm Password</span>
					<button class="toggle-visibility" title="toggle password visibility" tabindex="-1">
						<span class="glyphicon glyphicon-eye-close"></span>
					</button>
					<input type="password" name="passwd2" class="form__input" required pattern=".{6,}" id="passwd2">
					<span class="icon"></span>
				</label>
				<div class="text-center">
					<button class="submit" id="submit" value="submit" onclick="reset_now()">Confirm</button>
				</div>
			</div>
			<div id="success"></div>
		</div>
	</div>
</div>
<script src="./public/js/reset_now.js"></script>

<?php 

$content = ob_get_clean();
require_once('./view/account.php');
require_once('./view/template.php'); 

?>
