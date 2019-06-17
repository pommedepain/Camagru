function formControl()
{
	console.log('formControl triggered');
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
		xhr.open('POST', '../../controller/Ccreate_account.php', true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send(`first_name=${first_name}&last_name=${last_name}&pseudo=${pseudo}&email=${email}&passwd1=${passwd1}&passwd2=${passwd2}&submit=${submit}`);
		xhr.addEventListener('readystatechange', function() {
			if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200)
			{
				console.log(xhr.responseText);
				/* Check if the datas have been successfully sent to the db thanks to the string created by XHR */
				let needle = xhr.responseText.indexOf("ERROR");
				console.log("needle = " + needle);
				if (needle < 0)
				{
					document.getElementById("success").innerHTML = "Your account has been successfully created !";
					setTimeout("document.location.href='./index.php'", 3000);
				}
			}
			else if (xhr.readyState === XMLHttpRequest.DONE && xhr.status != 200)
    			alert('Une erreur est survenue !\n\nCode :' + xhr.status + '\nTexte : ' + xhr.statusText);
			});
	}
}
