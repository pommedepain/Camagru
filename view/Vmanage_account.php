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
		<div class="wrapper">
			<div class="switch_box box_4">
				<div class="input_wrapper">
					<input type="checkbox" class="switch_4" onclick="notification_email(this);">
					<svg class="is_checked" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 426.67 426.67">
		 				<path d="M153.504 366.84c-8.657 0-17.323-3.303-23.927-9.912L9.914 237.265c-13.218-13.218-13.218-34.645 0-47.863 13.218-13.218 34.645-13.218 47.863 0l95.727 95.727 215.39-215.387c13.218-13.214 34.65-13.218 47.86 0 13.22 13.218 13.22 34.65 0 47.863L177.435 356.928c-6.61 6.605-15.27 9.91-23.932 9.91z"/>
					</svg>
					<svg class="is_unchecked" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 212.982 212.982">
					  <path d="M131.804 106.49l75.936-75.935c6.99-6.99 6.99-18.323 0-25.312-6.99-6.99-18.322-6.99-25.312 0L106.49 81.18 30.555 5.242c-6.99-6.99-18.322-6.99-25.312 0-6.99 6.99-6.99 18.323 0 25.312L81.18 106.49 5.24 182.427c-6.99 6.99-6.99 18.323 0 25.312 6.99 6.99 18.322 6.99 25.312 0L106.49 131.8l75.938 75.937c6.99 6.99 18.322 6.99 25.312 0 6.99-6.99 6.99-18.323 0-25.313l-75.936-75.936z" fill-rule="evenodd" clip-rule="evenodd"/>
					</svg>
		  		</div>
			</div>
			<h3 id="notifs_email">Enable email notifications for likes and comments</h3>
		</div>
		<div id="success"></div>
	</div>
</div>
<script src="./public/js/manage_account.js"></script>

<?php 

$content = ob_get_clean();
require_once('./view/account.php');
require_once('./view/template.php'); 

?>
