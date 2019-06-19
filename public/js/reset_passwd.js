function reset_passwd()
{
	console.log('reset_passwd triggered');
	let pseudo = document.getElementById("pseudo").value;
	let email = document.getElementById("email").value;
	let submit = document.getElementById("submit").value;
	
	if (!pseudo)
	{
		document.getElementById("pseudo").placeholder = "Please enter your pseudo.";
	}
	if (!email)
	{
		document.getElementById("email").placeholder = "Please enter your email address.";
	}

	if (pseudo && email)
	{
		let xhr = new XMLHttpRequest();
		xhr.open('POST', '../../controller/Creset_passwd.php', true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send(`pseudo=${pseudo}&email=${email}&submit=${submit}`);
		xhr.addEventListener('readystatechange', function() {
			if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200)
			{
				console.log(xhr.responseText);
				let needle = xhr.responseText.indexOf("ERROR");
				console.log("needle = " + needle);
				if (needle < 0)
				{
					let succ = document.getElementById("success");
					succ.innerHTML = "Check your mail, we've sent you a reset link !";
					succ.style.color = "green";
					//setTimeout("document.location.href='./view/Vsign_in.php'", 3000);
				}
				else
				{
					let succ = document.getElementById("success");
					succ.innerHTML = "Wrong combination Pseudo/Email.";
					succ.style.color = "red";
				}
			}
			else if (xhr.readyState === XMLHttpRequest.DONE && xhr.status != 200)
    			alert('Une erreur est survenue !\n\nCode :' + xhr.status + '\nTexte : ' + xhr.statusText);
			});
	}
}
