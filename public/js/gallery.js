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
				// if (needle < 0 && !xhr.responseText !== "" && xhr.responseText)
				if (xhr.responseText)
				{
					console.log("SUCCESS");
					let tab = JSON.parse(xhr.responseText);
					console.log(tab);
					for (let i = 0; i < tab['photo'].length; i++) 
					{
						/* Creation of the content div */
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

						/* Creation of the div for display of pseudo */
						let pseudo = document.createElement('h2');
						pseudo.style.position = "relative";
						pseudo.innerHTML = "@" + tab['pseudo'][i];
						pseudo.style.fontSize = "2vw";
						pseudo.style.width = "100%";
						pseudo.style.textAlign = "center";
						pseudo.style.marginTop = "2%";

						/* Creation of the image */
						let img = document.createElement("img");
						img.style.position = "relative";
						img.src = tab['photo'][i];
						img.style.width = "90%";
						img.style.height = "auto";
						img.style.marginBottom = "2%";
						img.style.marginLeft = "2%";

						/* Creation of the heart button */
						let span = document.createElement("span");
						let in_span = document.createElement("i");
						span.setAttribute('id', "heart" + i);
						span.classList.add('heart');
						in_span.classList.add('fa');
						in_span.classList.add('fa-heart-o');
						// if (tab['photo'][i])
						// 	in_span.classList.add('liked"');
						in_span.style.fontSize = "2.5vw";
						span.style.width = "2.5vw";
						in_span.setAttribute('aria-hidden', "true");
						span.appendChild(in_span);
						span.addEventListener('click', function () {
							heart(document.getElementById('heart' + i));
						}, false);

						/* Creation of the input for the comments */
						let com_div = document.createElement('div');
						let comment = document.createElement('input');
						let line = document.createElement('div');
						comment.setAttribute('id', "comment" + i);
						comment.classList.add('comment');
						com_div.classList.add('com_div');
						line.classList.add('line');
						comment.style.width = "100%";
						comment.style.fontFamily = "'VT323', monospace";
						comment.style.textAlign = "center";
						comment.placeholder = "What do you have to say ?";
						comment.addEventListener('keypress', function (e) {
							if (e.keyCode === 13)
								addComment(comment, comment.value);
						})
						com_div.appendChild(comment);
						com_div.appendChild(line);

						/* Creation of the left div for the display of the comments 
						+ special div for the heart button and comment section */
						let elem_div = document.createElement('div');
						elem_div.setAttribute('id', 'actions');
						elem_div.appendChild(span);
						elem_div.appendChild(com_div);
						let counter = document.createElement('div');
						counter.setAttribute('id', "counter" + i);
						counter.classList.add('counter');
						counter.innerHTML = "Likes: " + tab['likes'][i] + "	Comments: " + tab['comments'][i];
						counter.style.textAlign = "center";
						counter.style.marginBottom = "2%";
						let left_d = document.createElement('div');
						left_d.setAttribute('id', "left_d");
						left_d.appendChild(pseudo);
						left_d.append(img);
						left_d.appendChild(elem_div);
						left_d.appendChild(counter);

						/* Organisation of the parental links between the divs */
						let right_d = document.createElement('div');
						right_d.setAttribute('id', "right_d");
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
				else
				{
					console.log("FAIL");
				}
			}
			else if (xhr.readyState === XMLHttpRequest.DONE && xhr.status != 200)
    			alert('Une erreur est survenue !\n\nCode :' + xhr.status + '\nTexte : ' + xhr.statusText);
		});

		setTimeout(function () {
			let activity = "get";
			let xhr2 = new XMLHttpRequest();
			xhr2.open('POST', '../../controller/Cgallery.php', true);
			xhr2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr2.send(`activity=${activity}`);
			xhr2.addEventListener('readystatechange', function() {
				if (xhr2.readyState == XMLHttpRequest.DONE && xhr2.status == 200)
				{	
					console.log(xhr2.responseText)
					let needle = xhr2.responseText.indexOf("ERROR");
					console.log("needle = " + needle);
					let needle_EMPTY = xhr2.responseText.indexOf("No activity to display");
					console.log("needle_EMPTY = " + needle_EMPTY);
					if (needle < 0 && needle_EMPTY < 0)
					{
						console.log("SUCCESS ACTIVITY");
						let tab2 = JSON.parse(xhr2.responseText);
						console.log(tab2);
						console.log("coucou");
						let img = document.getElementById('stylish').querySelectorAll("img");
						for (let j = 0; j < img.length; j++) 
						{
							let image = img[j].src;
							let src = image.replace("http://localhost:8080", "..");
							for (let i = 0; i < tab2['photo'].length; i++) 
							{
								if (tab2['photo'][i] === src)
								{
									console.log(img[j]);
									let heart = img[j].parentElement.childNodes[2].childNodes[0];
									if (tab2['liked'][i] == 1)
									{
										heart.innerHTML = '<i class="fa fa-heart" aria-hidden="true"></i>';
										heart.classList.add("liked");
										heart.style.fontSize = "2.5vw";
										heart.style.width = "2.5vw";
									}
									if (tab2['comment'][i] !== null)
									{
										let right_d = img[j].parentElement.parentElement.childNodes[1];
										console.log(right_d);
										if (right_d.childNodes.length !== 0)
										{
											let bubble = right_d.childNodes[0];
											let mini_div = document.createElement('div');
											mini_div.innerHTML = "@" + tab2['from'][i] + ": " + tab2['comment'][i];
											bubble.appendChild(mini_div);
										}
										else
										{
											let bubble = document.createElement('div');
											bubble.setAttribute('id', "bubble");
											let mini_div = document.createElement('div');
											mini_div.innerHTML = "@" + tab2['from'][i] + ": " + tab2['comment'][i];
											bubble.appendChild(mini_div);
											right_d.appendChild(bubble);
										}
									}
								}
							}
						}
					}
					else if (needle_EMPTY >= 0)
					{
						console.log("No activity to display !");
					}
					else
					{
						console.log("FAIL");
					}
				}
				else if (xhr2.readyState === XMLHttpRequest.DONE && xhr2.status != 200)
    				alert('Une erreur est survenue !\n\nCode :' + xhr2.status + '\nTexte : ' + xhr2.statusText);
			});
		}, 20);
	}

	function heart(element)
	{
		console.log(element);
		let photo = element.parentElement.parentElement.childNodes[1].src;
		let pseudo = element.parentElement.parentElement.childNodes[0]['innerText'];
		let counter = element.parentElement.parentElement.childNodes[3]['innerText'];
		console.log(counter);
		if (element.classList.contains("liked"))
		{
			let like = "unliked";
			let xhr = new XMLHttpRequest();
			xhr.open('POST', '../../controller/CLike.php', true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.send(`pseudo=${pseudo}&photo=${photo}&like=${like}`);
			xhr.addEventListener('readystatechange', function() {
			if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200)
			{
				console.log(xhr.responseText);
				let needle_ERR = xhr.responseText.indexOf("ERROR");
				console.log("needle_ERR = " + needle_ERR);
				let needle_nope = xhr.responseText.indexOf("Photo already liked by");
				console.log("needle_nope = " + needle_nope);
				let needle_LOG = xhr.responseText.indexOf("User not loggued in !");
				console.log("needle_LOG = " + needle_LOG);
				if (needle_ERR < 0 && needle_nope < 0 && needle_LOG < 0)
				{
					element.innerHTML = '<i class="fa fa-heart-o" aria-hidden="true"></i>';
					element.classList.remove("liked");
					element.style.fontSize = "2.5vw";
					element.style.width = "2.5vw";
					let new_count = counter.replace(/Likes: (\d+)/g, function(match, number) {
							return "Likes: " + (parseInt(number)-1);
						});
					element.parentElement.parentElement.childNodes[3].innerHTML = new_count;
					console.log(new_count);
					console.log("SUCCESS");
				}
				else if (needle_LOG >= 0)
				{
					let nope = document.getElementById('alert');
					nope.style.display = "inline";
				}
				else
				{
					console.log("ERROR");
				}
			}
			else if (xhr.readyState === XMLHttpRequest.DONE && xhr.status != 200)
    			alert('Une erreur est survenue !\n\nCode :' + xhr.status + '\nTexte : ' + xhr.statusText);
			});
		}
		else
		{
			let like = "liked";
			let xhr = new XMLHttpRequest();
			xhr.open('POST', '../../controller/CLike.php', true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.send(`pseudo=${pseudo}&photo=${photo}&like=${like}`);
			xhr.addEventListener('readystatechange', function() {
			if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200)
			{
				console.log(xhr.responseText);
				let needle_ERR = xhr.responseText.indexOf("ERROR");
				console.log("needle_ERR = " + needle_ERR);
				let needle_nope = xhr.responseText.indexOf("Photo already liked by");
				console.log("needle_nope = " + needle_nope);
				let needle_LOG = xhr.responseText.indexOf("User not loggued in !");
				console.log("needle_LOG = " + needle_LOG);
				if (needle_ERR < 0 && needle_nope < 0 && needle_LOG < 0)
				{
					element.innerHTML = '<i class="fa fa-heart" aria-hidden="true"></i>';
					element.classList.add("liked");
					element.style.fontSize = "2.5vw";
					element.style.width = "2.5vw";
					let new_count = counter.replace(/Likes: (\d+)/g, function(match, number) {
							return "Likes: " + (parseInt(number)+1);
						});
					element.parentElement.parentElement.childNodes[3].innerHTML = new_count;
					console.log(new_count);
				}
				else if (needle_LOG >= 0)
				{
					let nope = document.getElementById('alert');
					nope.style.display = "inline";
				}
				else
				{
					console.log("ERROR");
				}
			}
			else if (xhr.readyState === XMLHttpRequest.DONE && xhr.status != 200)
    			alert('Une erreur est survenue !\n\nCode :' + xhr.status + '\nTexte : ' + xhr.statusText);
			});
		}
	}

	function addComment (elem, comment)
	{
		console.log(comment);
		console.log(elem);
		let photo = elem.parentElement.parentElement.parentElement.childNodes[1].src;
		let pseudo = elem.parentElement.parentElement.parentElement.childNodes[0]['innerText'];
		let right_d = elem.parentElement.parentElement.parentElement.parentElement.childNodes[1];
		let counter = elem.parentElement.parentElement.parentElement.childNodes[3]['innerText'];
		if (right_d.childNodes.length !== 0)
		{
			let xhr = new XMLHttpRequest();
			xhr.open('POST', '../../controller/Ccomm.php', true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.send(`pseudo=${pseudo}&photo=${photo}&comment=${comment}`);
			xhr.addEventListener('readystatechange', function() {
			if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200)
			{
				console.log(xhr.responseText);
				let needle = xhr.responseText.indexOf("ERROR");
				console.log("needle = " + needle);
				let needle_LOG = xhr.responseText.indexOf("User not loggued in !");
				console.log("needle_LOG = " + needle_LOG);
				if (needle < 0 && needle_LOG < 0)
				{
					console.log("new div");
					let bubble = right_d.childNodes[0];
					let mini_div = document.createElement('div');
					mini_div.innerHTML = comment;
					bubble.appendChild(mini_div);
					let new_count = counter.replace(/Comments: (\d+)/g, function(match, number) {
						return "Comments: " + (parseInt(number)+1);
					});
					elem.parentElement.parentElement.parentElement.childNodes[3].innerHTML = new_count;
					console.log(new_count);
					console.log("SUCCESS");
				}
				else if (needle_LOG >= 0)
				{
					let nope = document.getElementById('alert');
					nope.style.display = "inline";
				}
				else
				{
					console.log("ERROR");
				}
			}
			else if (xhr.readyState === XMLHttpRequest.DONE && xhr.status != 200)
    			alert('Une erreur est survenue !\n\nCode :' + xhr.status + '\nTexte : ' + xhr.statusText);
			});
		}
		else
		{
			let xhr = new XMLHttpRequest();
			xhr.open('POST', '../../controller/Ccomm.php', true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.send(`pseudo=${pseudo}&photo=${photo}&comment=${comment}`);
			xhr.addEventListener('readystatechange', function() {
			if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200)
			{
				console.log(xhr.responseText);
				let needle = xhr.responseText.indexOf("ERROR");
				console.log("needle = " + needle);
				let needle_LOG = xhr.responseText.indexOf("User not loggued in !");
				console.log("needle_LOG = " + needle_LOG);
				if (needle < 0 && needle_LOG < 0)
				{
					console.log("old div");
					let bubble = document.createElement('div');
					bubble.setAttribute('id', "bubble");
					let mini_div = document.createElement('div');
					mini_div.innerHTML = "@" + pseudo + ": " + comment;
					bubble.appendChild(mini_div);
					right_d.appendChild(bubble);
					let new_count = counter.replace(/Comments: (\d+)/g, function(match, number) {
						return "Comments: " + (parseInt(number)+1);
					});
					elem.parentElement.parentElement.parentElement.childNodes[3].innerHTML = new_count;
					console.log(new_count);
					console.log("SUCCESS");
				}
				else if (needle_LOG >= 0)
				{
					let nope = document.getElementById('alert');
					nope.style.display = "inline";
				}
				else
				{
					console.log("ERROR");
				}
			}
			else if (xhr.readyState === XMLHttpRequest.DONE && xhr.status != 200)
    			alert('Une erreur est survenue !\n\nCode :' + xhr.status + '\nTexte : ' + xhr.statusText);
			});
		}
		let clean = document.getElementsByClassName('com_div');
		for (let i = 0; i < clean.length; i++)
			clean[i].childNodes[0].value = "";
	}


	window.addEventListener('load', display_history, false);
})();
