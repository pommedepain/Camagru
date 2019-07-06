(function () {

	function display_history()
	{
		let div = document.getElementById('stylish');

		let xhr = new XMLHttpRequest();
		xhr.open('POST', '../../controller/Cgallery.php', true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send(`div=${div}`);
		xhr.addEventListener('readystatechange', function() {
			if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200)
			{	
				console.log(xhr.responseText)
				let needle = xhr.responseText.indexOf("ERROR");
				console.log("needle = " + needle);
				if (needle < 0 && !xhr.responseText !== "" && xhr.responseText)
				{
					console.log("SUCCESS");
					let tab = JSON.parse(xhr.responseText);
					console.log(tab);
					for (let i = 0; i < tab['photo'].length; i++) 
					{
						let sub_div = document.createElement("div");
						sub_div.display = "flex";
						sub_div.flexDirection = "column";
						sub_div.style.border = "1px solid whitesmoke";
						sub_div.style.margin = "0 auto";
						sub_div.style.marginTop = "2%";
						sub_div.style.marginBottom = "2%";
						sub_div.style.borderRadius = "0.5em";
						sub_div.style.width = "50%";

						let img = document.createElement("img");
						img.style.position = "relative";
						img.src = tab['photo'][i];
						img.style.width = "50%";
						img.style.height = "auto";
						img.style.marginTop = "2%";
						img.style.marginBottom = "2%";
						img.style.marginLeft = "2%";

						let counter = document.createElement("label");
						let btn = document.createElement("input");
						btn.classList.add('heart');
						btn.setAttribute('type', "checkbox");
						btn.setAttribute('id', "btnControl");
						counter.style.position = "relative";
						counter.classList.add('heart');
						counter.innerHTML = "❤";
						counter.htmlFor = "btnControl";

						sub_div.appendChild(img);
						sub_div.appendChild(btn);
						sub_div.appendChild(counter);
						sub_div.setAttribute("id", "display" + i);
						div.appendChild(sub_div);
					}
				}
				else if (xhr.responseText === "" || !xhr.responseText)
				{
					console.log("SUCCESS but nothing to display");
				}
				// else
				// {
				// 	console.log("FAIL");
				// 	document.getElementById('camera-cont').style.display = "none";
				// 	let message = document.getElementById('subtitle');
				// 	message.style.fontFamily = "VT323, monospace";
				// 	message.style.paddingTop = "2%";
				// 	message.innerHTML = message.innerHTML.replace("Who do you want to be ?", "You need to be loggued in to have access to this page !");
				// 	document.getElementById('link_no_log').style.display = "flex";
				// }
			}
			else if (xhr.readyState === XMLHttpRequest.DONE && xhr.status != 200)
    			alert('Une erreur est survenue !\n\nCode :' + xhr.status + '\nTexte : ' + xhr.statusText);
		});

	}
	window.addEventListener('load', display_history, false);
})();
