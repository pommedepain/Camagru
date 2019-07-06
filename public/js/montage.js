(function ()
{
	let width = 0;
	let height = 0;
	let streaming = false;
	let video = null;
	let canvas = null;
	let canvas_skrs = null;
	let photo = null;
	let button = null;

	function startup()
	{
		video = document.getElementById('webcam');
   		canvas = document.getElementById('transit');
		photo = document.getElementById('result');
		button = document.getElementById('takepic');
		canvas_skrs = document.getElementById('add_stickers');
		
		video.style.width = "95%";
		if (video.offsetWidth >= 720)
			width = 720;
		else
			width = video.offsetWidth;
		
		video.setAttribute('width', width);
		video.setAttribute('height', width);
		canvas.setAttribute('width', width);
		canvas.setAttribute('height', width);
		canvas_skrs.setAttribute('width', width);
		
		navigator.mediaDevices.getUserMedia({ video: { width: width, height: width }, audio: false })
			.then(function(stream) {
				video.srcObject = stream;
				video.play();
			})
			.catch(function(err) {
				console.log("An error occured: " + err);
			});

		video.addEventListener('canplay', function(ev){
			if (!streaming) {
				height = width;
				
				if (isNaN(height))
				{
					height = width;
				}

				streaming = true;
				ev.preventDefault();
			}
		}, false);

		button.addEventListener('click', function(ev){
			takepicture();
			ev.preventDefault();
		}, false);

		clearphoto();
		display_history();
	}

	function clearphoto()
	{
		let context = canvas.getContext('2d');
		let context_skrs = canvas_skrs.getContext('2d');
		context.fillStyle = "#AAA";
		context_skrs.fillStyle = "#AAA";
		context.fillRect(0, 0, canvas.width, canvas.height);
		context_skrs.fillRect(0, 0, canvas.width, canvas.height);

		let data = canvas.toDataURL('image/png');
		photo.setAttribute('src', data);
	}

	function addStickers()
	{
		console.log("addStickers() triggered");
		console.log("width: " + width);
		console.log("height: " + height);
		let div = document.getElementById('overlay').querySelectorAll("img");
		console.log(div);
		let context_skrs = canvas_skrs.getContext('2d');
		if (width && height && div[0])
		{
			canvas_skrs.height = height;
			canvas_skrs.width = width;
			for (let i = 0; i < div.length ; i++)
			{
				let image = new Image();
				image.addEventListener('load', function() {
					let img_width = div[i]['width'];
					let img_height = div[i]['height'];
					let x = (div[i]['offsetLeft'] - 100);
					console.log("x: " + x);
					let y = div[i]['offsetTop'];
					console.log("y: " + y);
					context_skrs.drawImage(image, x, y, img_width, img_height);
				});
				image.src = div[i]['src'];
			}
			setTimeout(function() {
				window.data_skrs = canvas_skrs.toDataURL('image/png');
				console.log("draw");
				return (window.data_skrs);
			}, 5);
		}
		else
		{
			let nope = document.getElementById('alert');
			nope.style.display = "inline";
		}
	}

	function takepicture()
	{
		console.log("takepicture() triggered");
		let context = canvas.getContext('2d');
		let div = document.getElementById('overlay').querySelectorAll("img");
		if (width && height && div[0])
		{
			canvas.height = height;
			addStickers();
			console.log("canvas height = " + canvas.height);
			canvas.width = width;
			console.log("canvas width = " + canvas.width);
			context.drawImage(video, 0, 0, width, height);
			let data = canvas.toDataURL('image/png');
			setTimeout(function () {
				if (data && window.data_skrs)
				{
					let xhr = new XMLHttpRequest();
					xhr.open('POST', '../../controller/Cmontage.php', true);
					xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
					xhr.send(`photo=${data}&stickers=${window.data_skrs}&size=${height}`);
					xhr.addEventListener('readystatechange', function() {
						if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200)
						{
							console.log(xhr.responseText);
							let needle = xhr.responseText.indexOf("ERROR");
							console.log("needle = " + needle);
							if (needle < 0)
							{
								/* Displays the newly taken picture in the frame below the camera */
								console.log("SUCCESS");
								name = xhr.responseText.match(/\d+/)[0];
								console.log(name);
								photo.setAttribute('src', '../public/img/photos_user/' + name + '.png');
								photo.style.display = "inline";
								document.getElementById("cadre").style.display = "inline";
								document.getElementById('blah').style.display = "none";
								
								/* Appends the newly taken picture in top of the history display */
								let div = document.getElementById('previous');
								let sub_div = document.createElement("div");
								let img = document.createElement("img");
								img.src = '../public/img/photos_user/' + name + '.png';
								let size = div.offsetWidth;
								img.width = size;
								img.height = size;
								img.style.marginTop = "5%";
								sub_div.style.marginBottom = "8%";
								let linky = document.createElement("a");
								linky.classList.add("buttony");
								linky.classList.add("cross");
								linky.style.cursor= "pointer";
								linky.style.position = "absolute";
								linky.addEventListener("click", function () {
									del(document.getElementById("img_div" + i));
								}, false);
								sub_div.appendChild(img);
								sub_div.appendChild(linky);
								sub_div.setAttribute("id", "img_div" + "00");
								div.insertBefore(sub_div, div.childNodes[0]);

								/* Remove all stickers previously selected from the camera */
								let stickers = document.getElementById('overlay').querySelectorAll("img");
								console.log(stickers);
								for (let i = 0; i < stickers.length; i++) 
								{
									if (stickers[i]['id'] !== 'webcam')
										stickers[i].parentNode.removeChild(stickers[i]);
								}
							}
						}
						else if (xhr.readyState === XMLHttpRequest.DONE && xhr.status != 200)
    						alert('Une erreur est survenue !\n\nCode :' + xhr.status + '\nTexte : ' + xhr.statusText);
					});
				}
			}, 20);
		}
		else
		{
			let nope = document.getElementById('alert');
			nope.style.display = "inline";
			clearphoto();
		}
	}

	function display_history()
	{
		let div = document.getElementById('previous');

		let xhr = new XMLHttpRequest();
		xhr.open('POST', '../../controller/Chistory.php', true);
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
					let size = div.offsetWidth;
					console.log(tab);
					for (let i = 0; i < tab['photo'].length; i++) 
					{
						let sub_div = document.createElement("div");
						let img = document.createElement("img");
						img.src = tab['photo'][i];
						img.width = size;
						img.height = size;
						img.style.marginTop = "5%";
						sub_div.style.marginBottom = "8%";
						let linky = document.createElement("a");
						linky.classList.add("buttony");
						linky.classList.add("cross");
						linky.style.cursor= "pointer";
						linky.style.position = "absolute";
						linky.addEventListener("click", function () {
							del(document.getElementById("img_div" + i));
						}, false);
						sub_div.appendChild(img);
						sub_div.appendChild(linky);
						sub_div.setAttribute("id", "img_div" + i);
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
					document.getElementById('camera-cont').style.display = "none";
					let message = document.getElementById('subtitle');
					message.style.fontFamily = "VT323, monospace";
					message.style.paddingTop = "2%";
					message.innerHTML = message.innerHTML.replace("Who do you want to be ?", "You need to be loggued in to have access to this page !");
					document.getElementById('link_no_log').style.display = "flex";
				}
			}
			else if (xhr.readyState === XMLHttpRequest.DONE && xhr.status != 200)
    			alert('Une erreur est survenue !\n\nCode :' + xhr.status + '\nTexte : ' + xhr.statusText);
		});
	}

	function del(id)
	{
		console.log(id);
		let src = id.querySelectorAll("img");
		src = src[0]['src'];
		let name = src.replace("http://localhost:8080/public/img/photos_user/", "");
		console.log(name);

		let xhr = new XMLHttpRequest();
		xhr.open('POST', '../../controller/Cdel.php', true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send(`photo=${name}`);
		xhr.addEventListener('readystatechange', function() {
			if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200)
			{
				console.log(xhr.responseText);
				let needle = xhr.responseText.indexOf("ERROR");
				console.log("needle = " + needle);
				if (needle < 0)
				{
					console.log("photo del");
					window.location.href = './index.php?action=montage';
				}
				else
					console.log("Pb with del photo");
			}
			else if (xhr.readyState === XMLHttpRequest.DONE && xhr.status != 200)
				alert('Une erreur est survenue !\n\nCode :' + xhr.status + '\nTexte : ' + xhr.statusText);
			});
	}

	window.addEventListener('load', startup, false);
})();
