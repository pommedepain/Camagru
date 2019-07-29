
window.addEventListener("load", status_info);

function notification_email(state)
{
	/* console.log(state.checked); */
	let submit = "submit"
	let xhr = new XMLHttpRequest();
	xhr.open('POST', '../../controller/Cmanage_account.php', true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send(`submit=${submit}&state=${state.checked}`);
	xhr.addEventListener('readystatechange', function() {
		if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200)
		{
			/* console.log(xhr.responseText); */
			let needle_ERR = xhr.responseText.indexOf("ERROR");
			/* console.log("needle_ERR = " + needle_ERR); */
			if (needle_ERR < 0)
			{
				/* console.log("change registered"); */
			}
			else if (needle_ERR >= 0)
			{
				/* console.log("Pb with change"); */
			}
		}
		else if (xhr.readyState === XMLHttpRequest.DONE && xhr.status != 200)
    		alert('Une erreur est survenue !\n\nCode :' + xhr.status + '\nTexte : ' + xhr.statusText);
		});
}

function status_info()
{
	document.getElementById('status').style.display = "inline";
	let group = document.getElementById("group").innerHTML;

	if (group == "not_confirmed")
	{
		document.getElementById("group").innerHTML = "Account not verified. ";
		let linky = document.createElement("a");
		let send_again = document.createTextNode("Send a new confirmation email");
		linky.appendChild(send_again);
		let group = document.getElementById("group");
		group.parentNode.insertBefore(linky, group.nextSibling);
		document.getElementById("group").style.color = "red";
		document.getElementById("group").style.fontWeight = "bold";
		document.getElementById("group").style.display = "inline";
		linky.style.color = "blue";
		linky.style.textDecoration = "underline";
		linky.style.cursor = "pointer";
		linky.setAttribute("onclick", "send_it()");
	}
	else if (group == "member")
	{
		document.getElementById("group").innerHTML = "Account verified.";
		document.getElementById("group").style.color = "green";
		document.getElementById("group").style.fontWeight = "bold";
		document.getElementById("group").style.display = "inline";
	}

	let submit = "submit";
	let xhr = new XMLHttpRequest();
	xhr.open('POST', '../../controller/Csend_again_account.php', true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send(`submit=${submit}`);
	xhr.addEventListener('readystatechange', function() {
		if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200)
		{
			/* console.log(xhr.responseText); */
			let needle_ERR = xhr.responseText.indexOf("ERROR");
			/* console.log("needle_ERR = " + needle_ERR); */
			let notif = xhr.responseText.substring(xhr.responseText.indexOf("="))
			notif = notif.substring(2);
			if (needle_ERR < 0)
			{
				/* console.log(notif); */
				if (notif === "true\n")
					document.getElementsByClassName("switch_4")[0]['checked'] = true;
				else if (notif === "false\n")
					document.getElementsByClassName("switch_4")[0]['checked'] = false;
			}
			else if (needle_ERR >= 0)
			{
				/* console.log("ERROR with controller"); */
			}
		}
		else if (xhr.readyState === XMLHttpRequest.DONE && xhr.status != 200)
    		alert('Une erreur est survenue !\n\nCode :' + xhr.status + '\nTexte : ' + xhr.statusText);
		});
}

function send_it()
{
	let email_send = document.getElementById("email").value;
	let pseudo = document.getElementById("pseudo").value;
	/* console.log(pseudo); */
	let xhr = new XMLHttpRequest();
	xhr.open('POST', '../../controller/Csend_again_account.php', true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send(`email_send=${email_send}&pseudo=${pseudo}`);
	xhr.addEventListener('readystatechange', function() {
		if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200)
		{
			/* console.log(xhr.responseText); */
			/* Check if the datas have been successfully sent to the db thanks to the string created by XHR */
			let needle_ERR = xhr.responseText.indexOf("ERROR");
			let needle_ret = xhr.responseText.indexOf("Csend_again.php done and successful");
			/* console.log("needle_ERR = " + needle_ERR); */
			/* console.log("needle_ret = " + needle_ret); */
			if (needle_ERR < 0 && needle_ret >= 0)
			{
				document.getElementById("success").innerHTML = "A new confirmation email has been sent.";
			}
			else if (needle_ERR >= 0)
			{
				let succ = document.getElementById("success");
				succ.style.color = "red";
				succ.innerHTML = "ERROR<br />We couldn't send you a new confirmation email.";
			}
		}
		else if (xhr.readyState === XMLHttpRequest.DONE && xhr.status != 200)
    		alert('Une erreur est survenue !\n\nCode :' + xhr.status + '\nTexte : ' + xhr.statusText);
		});
}

function manage_account()
{
	/* console.log('manage_account triggered'); */
	let pseudo = document.getElementById("pseudo").value;
	/* console.log(pseudo); */
	let first_name = document.getElementById("first_name").value;
	/* console.log(first_name); */
	let last_name = document.getElementById("last_name").value;
	/* console.log(last_name); */
	let email = document.getElementById("email").value;
	/* console.log(email); */
	let o_passwd = document.getElementById("o_passwd").value;
	let passwd1 = document.getElementById("passwd1").value;
	let passwd2 = document.getElementById("passwd2").value;
	let submit = document.getElementById("submit").value;
	/* console.log(submit); */
	let group = document.getElementById("group").innerHTML;
	/* console.log(group); */

	if (group == "Account not verified.")
		group = "not_confirmed";
	else if (group == "Account verified.")
		group = "member";
	/* console.log(group); */

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
		xhr.open('POST', '../../controller/Cmanage_account.php', true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send(`first_name=${first_name}&last_name=${last_name}&pseudo=${pseudo}&email=${email}&o_passwd=${o_passwd}&passwd1=${passwd1}&passwd2=${passwd2}&submit=${submit}&group=${group}`);
		xhr.addEventListener('readystatechange', function() {
			if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200)
			{
				/* console.log(xhr.responseText); */
				/* Check if the datas have been successfully sent to the db thanks to the string created by XHR */
				let needle_ERR = xhr.responseText.indexOf("ERROR");
				let needle_ret = xhr.responseText.indexOf("change_user_infos OK");
				let needle_passwd = xhr.responseText.indexOf("New Password ERROR");
				let needle_syntax = xhr.responseText.indexOf("syntax");
				let needle_opasswd = xhr.responseText.indexOf("Same old and new password");

				/* console.log("needle_ERR = " + needle_ERR); */
				/* console.log("needle_ret = " + needle_ret); */
				/* console.log("needle_opasswd = " + needle_opasswd); */
				if (needle_ERR < 0 && needle_ret >= 0 && needle_opasswd < 0 && needle_passwd < 0 && needle_syntax < 0)
				{
					let succ = document.getElementById("success");
					succ.innerHTML = "The changes have been successfully saved !";
					succ.style.color = "green";
					setTimeout("window.location.href = './index.php?action=manage_account'", 3000);
				}
				else if (needle_opasswd >= 0)
				{
					let succ = document.getElementById("success");
					succ.style.color = "red";
					succ.innerHTML = "ERROR<br />Please choose a new password that differs from the current one.<br />The changes haven't been saved.";
				}
				else if (needle_passwd >= 0)
				{
					let succ = document.getElementById("success");
					succ.style.color = "red";
					succ.innerHTML = "ERROR<br />Incorrect password.";
				}
				else if (needle_syntax >= 0)
				{
					let succ = document.getElementById("success");
					succ.style.color = "red";
					succ.innerHTML = "ERROR<br />Incorrect syntax:<br />- Password must be at least 6 characters long and must contain 1 lower case letter, 1 upper case letter and 1 number.<br />- Emails must conform to the usual syntax rules.";
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
