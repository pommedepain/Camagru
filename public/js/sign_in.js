window.addEventListener("load", function (){
	document.getElementById("submit").addEventListener("click", status_info);
})

function sign_in()
{
	/* console.log('sign_in triggered'); */
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

	if (pseudo && passwd1)
	{
		let xhr = new XMLHttpRequest();
		xhr.open('POST', '../../controller/Csign_in.php', true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send(`pseudo=${pseudo}&passwd1=${passwd1}&submit=${submit}`);
		xhr.addEventListener('readystatechange', function() {
			if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200)
			{
				/* console.log(xhr.responseText); */
				let needle = xhr.responseText.indexOf("ERROR");
				/* console.log("needle = " + needle); */
				let needle_GROUP = xhr.responseText.indexOf("not_confirmed");
				/* console.log("needle_GROUP = " + needle_GROUP); */
				if (needle < 0 && needle_GROUP < 0)
				{
					let succ = document.getElementById("success");
					succ.innerHTML = "You're currently signed-in !";
					succ.style.color = "green";
					setTimeout("document.location.href='./index.php'", 3000);
				}
				else if (needle_GROUP >= 0)
				{
					let succ = document.getElementById("success");
					succ.innerHTML = "You need to confirm your account first in order to sign-in !";
					succ.style.color = "red";
					let status = document.getElementById('status');
					status.style.display = "inline";
				}
				else
				{
					let succ = document.getElementById("success");
					succ.innerHTML = "Wrong combination Pseudo/Password.";
					succ.style.color = "red";
				}
			}
			else if (xhr.readyState === XMLHttpRequest.DONE && xhr.status != 200)
    			alert('Une erreur est survenue !\n\nCode :' + xhr.status + '\nTexte : ' + xhr.statusText);
			});
	}
}

function status_info()
{
	let group = document.getElementById("group").innerHTML;
	/* console.log(group); */

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
}

function send_it()
{
	let send = "send";
	let xhr = new XMLHttpRequest();
	xhr.open('POST', '../../controller/Csend_again.php', true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send(`send=${send}`);
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
				document.getElementById("success").style.color = "green";
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
