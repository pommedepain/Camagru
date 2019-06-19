<?php 

$title = "Account";
ob_start(); 

?>

<div id="all">
	<div class="cont">
		<div id="form">
			<h1 class="text-center" id="f_h1">Manage your account</h1>
			<div class="registration-form">
				<label class="col-one-half">
					<span class="label-text">First Name</span>
					<input type="text" name="first_name" id="first_name" value="<?php if (isset($_SESSION['first_name'])){ echo $_SESSION['first_name']; }?>">
				</label>
				<label class="col-one-half">
					<span class="label-text">Last Name</span>
					<input type="text" name="last_name" id="last_name" value="<?php if (isset($_SESSION['last_name'])){ echo $_SESSION['last_name']; }?>">
				</label>
				<label>
					<span class="label-text">Pseudo</span>
					<input type="text" name="pseudo" id="pseudo" value="<?php if (isset($_SESSION['user'])){ echo $_SESSION['user']; }?>">
				</label>
				<label>
					<span class="label-text">Email</span>
					<input type="text" name="email" id="email" value="<?php if (isset($_SESSION['email'])){ echo $_SESSION['email']; }?>">
				</label>
				<label class="password">
					<span class="label-text">Current Password</span>
					<button class="toggle-visibility" title="toggle password visibility" tabindex="-1">
						<span class="glyphicon glyphicon-eye-close"></span>
					</button>
					<input type="password" name="passwd3" class="form__input" required pattern=".{6,}" id="o_passwd">
					<span class="icon"></span>
				</label>
				<label class="password">
					<span class="label-text">New Password</span>
					<button class="toggle-visibility" title="toggle password visibility" tabindex="-1">
						<span class="glyphicon glyphicon-eye-close"></span>
					</button>
					<input type="password" name="passwd1" class="form__input" required pattern=".{6,}" id="passwd1">
					<span class="icon"></span>
				</label>
				<label class="password">
					<span class="label-text">Confirm password</span>
					<button class="toggle-visibility" title="toggle password visibility" tabindex="-1">
						<span class="glyphicon glyphicon-eye-close"></span>
					</button>
					<input type="password" name="passwd2" class="form__input" required pattern=".{6,}" id="passwd2">
					<span class="icon"></span>
				</label>
				<div class="text-center">
					<button class="submit" id="submit" value="submit" onclick="manage_account()">Submit changes</button>
				</div>
			</div>
		</div>
		<div id="status">Status: <div id="group"><?php if (isset($_SESSION['group'])){ echo $_SESSION['group']; }?></div></div>
		<div id="success"></div>
	</div>
</div>
<script src="./public/js/manage_account.js"></script>

<?php 

$content = ob_get_clean();
require_once('./view/account.php');
require_once('./view/template.php'); 

?>
