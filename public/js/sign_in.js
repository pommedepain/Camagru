function sign_in()
{
	console.log('sign_in triggered');
	let pseudo = document.getElementById("pseudo").value;
	let passwd1 = document.getElementById("passwd1").value;
	let submit = document.getElementById("submit").value;
	
	if (!pseudo)
	{
		document.getElementById("pseudo").placeholder = "Please enter your pseudo.";
	}
	if (!passwd1)
	{
		document.getElementById("passwd1").placeholder = "Please enter your password.";
	}

	let xhr = new XMLHttpRequest();
	xhr.open('POST', '../../controller/Csign_in.php', true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send(`pseudo=${pseudo}&passwd1=${passwd1}&submit=${submit}`);
	xhr.addEventListener('readystatechange', function() {
		if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200)
			console.log(xhr.responseText);
		else if (xhr.readyState === XMLHttpRequest.DONE && xhr.status != 200)
    		alert('Une erreur est survenue !\n\nCode :' + xhr.status + '\nTexte : ' + xhr.statusText);
		});
	if (xhr.responseText == "Pseudo OK\nPassword OK\n")
	{
		let succ = document.getElementById("success");
		succ.innerHTML = "You're currently signed-in !'";
	}
}
