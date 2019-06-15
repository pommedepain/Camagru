
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

	let xhr = new XMLHttpRequest();
	xhr.open('POST', '../../controller/Cactivation.php', true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send(`anonym_id=${anonym_id}&key=${key}`);
	xhr.addEventListener('readystatechange', function() {
		if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200)
			console.log(xhr.responseText);
		else if (xhr.readyState === XMLHttpRequest.DONE && xhr.status != 200)
    		alert('Une erreur est survenue !\n\nCode :' + xhr.status + '\nTexte : ' + xhr.statusText);
		});
	
	let needle = xhr.responseText.indexOf("ERROR");
	console.log("needle = " + needle);
	if (needle < 0 && xhr.responseText == "It's a match !")
	{
		console.log("Account's now officially a member.")
	}
}
