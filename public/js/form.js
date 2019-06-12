function formControl()
{
	let pseudo = document.getElementById("pseudo").value;
	let email = document.getElementById("email").value;
	let passwd1 = document.getElementById("passwd1").value;
	let passwd2 = document.getElementById("passwd2").value;
	
	if (!pseudo)
	{
		let pseudo_d = document.getElementById("pseudo_d");
		pseudo_d.innerHTML = "Please choose a pseudo.";
	}
	if (!email) 
	{
		let email_d = document.getElementById("email_d");
		email_d.innerHTML = "Please enter your e-mail adress.";
	}
	if (!passwd1)
	{
		let passwd1_d = document.getElementById("passwd1_d");
		passwd1_d.innerHTML = "Please enter a password.";
	} 
	if (!passwd2)
	{
		let passwd2_d = document.getElementById("passwd2_d");
		passwd2_d.innerHTML = "Please confirm your password.";
	}
	else
	{
		let succ = document.getElementById("success");
		succ.innerHTML = "Your account has been successfully created !";
	}

	let xhr = new XMLHttpRequest('POST', '../../controller/create_account.php', true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send(`pseudo=${pseudo}&email=${email}&passwd1=${passwd1}&passwd2=${passwd2}`);
	xhr.addEventListener('readystatechange', function() {
		if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200)
			let ret = JSON.parse(xhr.responseText);
		else if (xhr.readyState === XMLHttpRequest.DONE && xhr.status != 200)
    		alert('Une erreur est survenue !\n\nCode :' + xhr.status + '\nTexte : ' + xhr.statusText);
		});
}
