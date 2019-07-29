function formControl()
{
	/* console.log('formControl triggered'); */
	let pseudo = document.getElementById("pseudo").value;
	let first_name = document.getElementById("first_name").value;
	let last_name = document.getElementById("last_name").value;
	let email = document.getElementById("email").value;
	let passwd1 = document.getElementById("passwd1").value;
	let passwd2 = document.getElementById("passwd2").value;
	let submit = document.getElementById("submit").value;
	
	if (!pseudo)
	{
		document.getElementById("pseudo").placeholder = "Please choose a pseudo.";
	}
	if (!email) 
	{
		document.getElementById("email").placeholder = "Please enter your e-mail adress.";
	}
	if (!passwd1)
	{
		document.getElementById("passwd1").placeholder = "Please enter a password.";
	} 
	if (!passwd2)
	{
		document.getElementById("passwd2").placeholder = "Please confirm your password.";
	}

	/* Connects the JS to the controller and retrieves the "echo();" */
	if (pseudo && email && passwd1 && passwd2)
	{
		if (!first_name)
			first_name = "";
		if (!last_name)
			last_name = "";
		let xhr = new XMLHttpRequest();
		xhr.open('POST', '../../controller/Cregister.php', true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send(`first_name=${first_name}&last_name=${last_name}&pseudo=${pseudo}&email=${email}&passwd1=${passwd1}&passwd2=${passwd2}&submit=${submit}`);
		xhr.addEventListener('readystatechange', function() {
			if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200)
			{
				/*console.log(xhr.responseText);*/
				/* Check if the datas have been successfully sent to the db thanks to the string created by XHR */
				let needle = xhr.responseText.indexOf("ERROR");
				let needle_pseudo = xhr.responseText.indexOf("Pseudo already taken");
				let needle_passwd = xhr.responseText.indexOf("Passwords don't match");
				let needle_syntax = xhr.responseText.indexOf("syntax ERROR");
				/*console.log("needle = " + needle);
				console.log("needle_pseudo = " + needle_pseudo);
				console.log("needle_passwd = " + needle_passwd);*/
				if (needle < 0 && needle_pseudo < 0 && needle_passwd < 0 && needle_syntax < 0)
				{
					let succ = document.getElementById("success");
					succ.innerHTML = "Your account has been successfully created !";
					succ.style.color = "green";
					// setTimeout("window.location.href = './index.php?action=sign_in'", 3000);
				}
				else if (needle_pseudo >= 0)
				{
					let succ = document.getElementById("success");
					succ.innerHTML = "Pseudo already taken, please choose another.";
					succ.style.color = "red";
				}
				else if (needle_passwd >= 0)
				{
					let succ = document.getElementById("success");
					succ.innerHTML = "Passwords don't match !";
					succ.style.color = "red";
				}
				else if (needle_syntax >= 0)
				{
					let succ = document.getElementById("success");
					succ.innerHTML = "ERROR<br />Incorrect syntax:<br />- Password must be at least 6 characters long and must contain 1 lower case letter, 1 upper case letter and 1 number.<br />- Email must conform to the usual syntax rules.";
					succ.style.color = "red";
				}
				else if (needle >= 0)
				{
					let succ = document.getElementById("success");
					succ.innerHTML = "ERROR<br />We couldn't register your infos for some reason... Please try again !";
					succ.style.color = "red";
				}
			}
			else if (xhr.readyState === XMLHttpRequest.DONE && xhr.status != 200)
    			alert('Une erreur est survenue !\n\nCode :' + xhr.status + '\nTexte : ' + xhr.statusText);
			});
	}
}
