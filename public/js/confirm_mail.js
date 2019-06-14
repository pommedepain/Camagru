
window.addEventListener("load", confirm_mail);

function confirm_mail()
{
	console.log("confirm mail triggered");

	let win = window.location.href;
	console.log(win);
	let url = new URL(win);
	let pseudo = url.searchParams.get("log");
	console.log(pseudo);
	let key = url.searchParams.get("key");
	console.log(key);

	let xhr = new XMLHttpRequest();
	xhr.open('POST', '../../controller/Cactivation.php', true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send(`pseudo=${pseudo}&key=${key}`);
	xhr.addEventListener('readystatechange', function() {
		if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200)
			console.log(xhr.responseText);
		else if (xhr.readyState === XMLHttpRequest.DONE && xhr.status != 200)
    		alert('Une erreur est survenue !\n\nCode :' + xhr.status + '\nTexte : ' + xhr.statusText);
		});
	// if (xhr.responseText == "Pseudo OK\nPassword OK\n")
	// {
	// 	let succ = document.getElementById("success");
	// 	succ.innerHTML = "You're currently signed-in !'";
	// }
}
