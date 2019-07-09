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
						sub_div.setAttribute("id", "display" + i);
						sub_div.display = "flex";
						sub_div.flexDirection = "row";
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

						let span = document.createElement("span");
						let in_span = document.createElement("i");
						span.setAttribute('id', "heart" + i);
						span.classList.add('heart');
						in_span.classList.add('fa');
						in_span.classList.add('fa-heart-o');
						in_span.style.fontSize = "2vw";
						span.style.width = "2vw";
						in_span.setAttribute('aria-hidden', "true");
						span.appendChild(in_span);
						span.addEventListener('click', function () {
							heart(document.getElementById('heart' + i));
						}, false);

						let com_div = document.createElement('div');
						let comment = document.createElement('input');
						let line = document.createElement('div');
						comment.setAttribute('id', "comment" + i);
						comment.classList.add('comment');
						com_div.classList.add('com_div');
						line.classList.add('line');
						comment.style.width = "100%";
						comment.placeholder = " What do you have to say ?";
						comment.addEventListener('keypress', function (e) {
							if (e.keyCode === 13)
								addComment(comment, comment.value);
						})
						com_div.appendChild(comment);
						com_div.appendChild(line);

						let right_d = document.createElement('div');
						right_d.setAttribute('id', "right_d");

						let elem_div = document.createElement('div');
						elem_div.setAttribute('id', 'actions');
						elem_div.appendChild(span);
						elem_div.appendChild(com_div);
						let left_d = document.createElement('div');
						left_d.setAttribute('id', "left_d");
						left_d.append(img);
						left_d.appendChild(elem_div);
						sub_div.appendChild(left_d);
						sub_div.appendChild(right_d);
						sub_div.classList.add('display');
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

	function heart(element)
	{
		if (element.classList.contains("liked"))
		{
			element.innerHTML = '<i class="fa fa-heart-o" aria-hidden="true"></i>';
			element.classList.remove("liked");
			element.style.fontSize = "2vw";
			element.style.width = "2vw";
		}
		else
		{
			element.innerHTML = '<i class="fa fa-heart" aria-hidden="true"></i>';
			element.classList.add("liked");
			element.style.fontSize = "2vw";
			element.style.width = "2vw";
		}
	}

	function addComment (elem, comment)
	{
		console.log(comment);
		let div = elem.parentElement.parentElement.parentElement.parentElement;
		console.log(div);
		div = div.childNodes;
		let right_d = div[1];
		if (right_d.childNodes.length !== 0)
		{
			let bubble = right_d.childNodes[0];
			let mini_div = document.createElement('div');
			mini_div.innerHTML = comment;
			bubble.appendChild(mini_div);
		}
		else
		{
			let bubble = document.createElement('div');
			bubble.setAttribute('id', "bubble");
			let mini_div = document.createElement('div');
			mini_div.innerHTML = comment;
			bubble.appendChild(mini_div);
			right_d.appendChild(bubble);
		}
	}


	window.addEventListener('load', display_history, false);
})();
