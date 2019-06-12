<?php $title = "Create an account"; ?>

<?php ob_start(); ?>

<div class="formu">
    <div class="create">
        <h2>Create an account:</h2><br/>
    </div>
        <form method="post">
			Pseudo: <input type="text" name="pseudo" id="pseudo" class="input"/>
			<div id="pseudo_d"></div><br /><br />
			First name: <input type="text" name="firstname" id="firstname" class="input"/><br /><br />
			Last name: <input type="text" name="lastname" id="lastname" class="input"/><br /><br />
			Email: <input type="text" name="email" id="email" class="input"/>
			<div id="email_d"></div><br /><br />
			Password: <input type="password" name="passwd1" id="passwd1" class="input"/>
			<div id="passwd1_d"></div><br /><br />
			Confirm password: <input type="password" name="passwd2" id="passwd2" class="input"/>
			<div id="passwd2_d"></div><br /><br />
			<input type="submit" name="submit" value="Create" class="myButton" onclick="formControl()" /><br />
			<div id="success"></div>
        </form>
	</div>
	<script src='./public/js/form.js'></script>

<?php $content = ob_get_clean(); ?>

<?php require('./view/template.php'); ?>
