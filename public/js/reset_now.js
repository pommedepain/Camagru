function reset_now()
{
	/* console.log('reset_now triggered'); */
	let passwd1 = document.getElementById("passwd1").value;
	let passwd2 = document.getElementById("passwd2").value;
	let submit = document.getElementById("submit").value;
	let win = window.location.href;
	/* console.log(win); */
	let url = new URL(win);
	let rand_str = url.searchParams.get("log");
	/* console.log(rand_str); */
	
	if (!passwd1)
	{
		document.getElementById("passwd1").placeholder = "Please choose a new password.";
	}
	if (!passwd2)
	{
		document.getElementById("passwd2").placeholder = "Please confirm your password.";
	}
	if (passwd1 !== passwd2)
	{
		let succ = document.getElementById("success");
		succ.innerHTML = "The entries don't match";
		succ.style.color = "red";
	}

	if (passwd1 && passwd2 && rand_str)
	{
		let xhr = new XMLHttpRequest();
		xhr.open('POST', '../../controller/Creset_now.php', true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send(`passwd1=${passwd1}&passwd2=${passwd2}&submit=${submit}&rand_str=${rand_str}`);
		xhr.addEventListener('readystatechange', function() {
			if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200)
			{
				/* console.log(xhr.responseText); */
				let needle_ERR = xhr.responseText.indexOf("ERROR");
				let needle_ret = xhr.responseText.indexOf("change_passwd_user() OK");
				let needle_passwd = xhr.responseText.indexOf("syntax");
				let needle_combi = xhr.responseText.indexOf("Combination ERROR");
				/* console.log("needle = " + needle_ERR); */
				/* console.log("needle = " + needle_ret); */
				if (needle_ERR < 0 && needle_ret >= 0 && needle_passwd < 0 && needle_combi < 0)
				{
					let succ = document.getElementById("success");
					succ.innerHTML = "Your password has been successfully changed !";
					succ.style.color = "green";
					// setTimeout("window.location.href = './index.php?action=sign_in'", 3000);
				}
				else if (needle_passwd >= 0)
				{
					let succ = document.getElementById("success");
					succ.innerHTML = "ERROR<br />Incorrect syntax:<br />Password must be at least 6 characters long and must contain 1 lower case letter, 1 upper case letter and 1 number.";
					succ.style.color = "red";
				}
				else if (needle_combi >= 0)
				{
					let succ = document.getElementById("success");
					succ.innerHTML = "ERROR<br />The passwords don't match !";
					succ.style.color = "red";
				}
				else
				{
					let succ = document.getElementById("success");
					succ.innerHTML = "ERROR: we couldn't change your password.";
					succ.style.color = "red";
				}
			}
			else if (xhr.readyState === XMLHttpRequest.DONE && xhr.status != 200)
    			alert('Une erreur est survenue !\n\nCode :' + xhr.status + '\nTexte : ' + xhr.statusText);
			});
	}
}
