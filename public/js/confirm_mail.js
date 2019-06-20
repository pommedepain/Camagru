
window.addEventListener("load", confirm_mail);

function confirm_mail()
{
	console.log("confirm mail triggered");

	let win = window.location.href;
	console.log(win);
	let url = new URL(win);
	let anonym_id = url.searchParams.get("log");
	console.log(anonym_id);
	let key = url.searchParams.get("key");
	console.log(key);

	if (anonym_id && key)
	{
		let xhr = new XMLHttpRequest();
		xhr.open('POST', '../../controller/Cactivation.php', true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send(`anonym_id=${anonym_id}&key=${key}`);
		xhr.addEventListener('readystatechange', function() {
			if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200)
			{
				console.log(xhr.responseText);
				let needle = xhr.responseText.indexOf("ERROR");
				console.log("needle = " + needle);
				if (needle < 0)
				{
					console.log("Account's now officially a member.")
					setTimeout("window.location.href = './index.php'", 3000);
				}
				else
				{
					let pb = document.getElementById("f_h1");
					pb.innerHTML = "Oops...";
					let pb2 = document.getElementById("para");
					pb2.innerHTML = "There seems to be a problem with this link.<br /> Maybe your account has already been verified !";
				}
			}
			else if (xhr.readyState === XMLHttpRequest.DONE && xhr.status != 200)
    			alert('Une erreur est survenue !\n\nCode :' + xhr.status + '\nTexte : ' + xhr.statusText);
			});
	}
}
