
window.addEventListener("load", status_info);

function status_info()
{
	let group = document.getElementById("group").innerHTML;

	if (group == "not_confirmed")
	{
		document.getElementById("group").innerHTML = "Account not verified.";
		document.getElementById("group").style.color = "red";
		document.getElementById("group").style.fontWeight = "bold";
		document.getElementById("group").style.display = "inline";
	}
	else if (group == "member")
	{
		document.getElementById("group").innerHTML = "Account verified.";
		document.getElementById("group").style.color = "green";
		document.getElementById("group").style.fontWeight = "bold";
		document.getElementById("group").style.display = "inline";
	}
}

function access_account()
{
	console.log('access_account triggered');
	let pseudo = document.getElementById("pseudo").value;
	console.log(pseudo);
	let first_name = document.getElementById("first_name").value;
	console.log(first_name);
	let last_name = document.getElementById("last_name").value;
	console.log(last_name);
	let email = document.getElementById("email").value;
	console.log(email);
	let o_passwd = document.getElementById("o_passwd").value;
	let passwd1 = document.getElementById("passwd1").value;
	let passwd2 = document.getElementById("passwd2").value;
	let submit = document.getElementById("submit").value;
	console.log(submit);
	let group = document.getElementById("group").innerHTML;
	console.log(group);

	if (group == "Account not verified.")
		group = "not_confirmed";
	else if (group == "Account verified.")
		group = "member";
	console.log(group);

	/* Connects the JS to the controller and retrieves the "echo();" */
	if (pseudo && email)
	{
		if (o_passwd && !passwd1)
			passwd1.placeholder = "Please choose a new password.";
		else if (o_passwd && !passwd2)
			passwd2.placeholder = "Please confirm your new password.";
		else if (!o_passwd && (passwd1 || passwd2))
			o_passwd.placeholder = "Please confirm your current password.";
		else if (!o_passwd && !passwd1 && !passwd2)
			passwd = "No changes";
		else if (o_passwd && passwd1 && passwd2 && passwd1 == passwd2)
			passwd = passwd1;
		else if (o_passwd && passwd1 && passwd2 && passwd1 != passwd2)
		{
			let succ = document.getElementById("success");
			succ.style.color = "red";
			succ.innerHTML = "The entries for a new password don't match."
		}
		let xhr = new XMLHttpRequest();
		xhr.open('POST', '../../controller/Caccess_account.php', true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send(`first_name=${first_name}&last_name=${last_name}&pseudo=${pseudo}&email=${email}&o_passwd=${o_passwd}&passwd1=${passwd1}&passwd2=${passwd2}&submit=${submit}&group=${group}`);
		xhr.addEventListener('readystatechange', function() {
			if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200)
			{
				console.log(xhr.responseText);
				/* Check if the datas have been successfully sent to the db thanks to the string created by XHR */
				let needle_ERR = xhr.responseText.indexOf("ERROR");
				let needle_ret = xhr.responseText.indexOf("change_user_infos OK");
				console.log("needle_ERR = " + needle_ERR);
				console.log("needle_ret = " + needle_ret);
				if (needle_ERR < 0 && needle_ret >= 0)
				{
					document.getElementById("success").innerHTML = "The changes have been successfully saved !";
					setTimeout("document.location.href='./index.php'", 3000);
				}
				else if (needle_ERR >= 0)
				{
					let succ = document.getElementById("success");
					succ.style.color = "red";
					succ.innerHTML = "ERROR<br />The changes haven't been saved.";
				}
			}
			else if (xhr.readyState === XMLHttpRequest.DONE && xhr.status != 200)
    			alert('Une erreur est survenue !\n\nCode :' + xhr.status + '\nTexte : ' + xhr.statusText);
			});
	}
}
