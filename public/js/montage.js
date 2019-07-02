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

		if (video.offsetWidth >= 720)
			width = 720;
		else
			width = video.offsetWidth;
		document.getElementById('transit').width = width;
		document.getElementById('result').width = width;
		
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

				video.setAttribute('width', width);
				// console.log("video width = " + video.videoWidth);
				video.setAttribute('height', height);
				// console.log("video height = " + video.videoHeight);
				canvas.setAttribute('width', width);
				canvas.setAttribute('height', height);
				canvas_skrs.setAttribute('width', width);
				canvas_skrs.setAttribute('height', height);
				streaming = true;
				ev.preventDefault();
			}
		}, false);

		button.addEventListener('click', function(ev){
			takepicture();
			ev.preventDefault();
		}, false);

		clearphoto();
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

	function takepicture()
	{
		console.log("takepicture() triggered");
		let context = canvas.getContext('2d');
		let div = document.getElementById('overlay').querySelectorAll("img");
		if (width && height && div[0])
		{
			let data_skrs = addStickers();
			canvas.height = height;
			console.log("canvas height = " + canvas.height);
			canvas.width = width;
			console.log("canvas width = " + canvas.width);
			context.drawImage(video, 0, 0, width, height);
			let data = canvas.toDataURL('image/png');
			if (data && data_skrs)
			{
				let xhr = new XMLHttpRequest();
				xhr.open('POST', '../../controller/Cmontage.php', true);
				xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				xhr.send(`photo=${data}&stickers=${data_skrs}&size=${height}`);
				xhr.addEventListener('readystatechange', function() {
					if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200)
					{
						console.log(xhr.responseText);
						/* Check if the datas have been successfully sent to the db thanks to the string created by XHR */
						let needle = xhr.responseText.indexOf("ERROR");
						console.log("needle = " + needle);
						if (needle < 0)
						{
							console.log("SUCCESS");
							photo.setAttribute('src', data);
						}
					}
					else if (xhr.readyState === XMLHttpRequest.DONE && xhr.status != 200)
    					alert('Une erreur est survenue !\n\nCode :' + xhr.status + '\nTexte : ' + xhr.statusText);
				});
			}
		}
		else
		{
			clearphoto();
		}
	}

	function addStickers()
	{
		console.log("addStickers() triggered");
		let video = document.getElementById('webcam');
		let width = video.width;
		console.log("width: " + width);
		let height = video.offsetHeight;
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
					let x = (div[i]['offsetLeft'] - 155);
					console.log("x: " + x);
					let y = div[i]['offsetTop'];
					console.log("y: " + y);
					context_skrs.drawImage(image, x, y, img_width, img_height);
				});
				image.src = div[i]['src'];
			}
			setTimeout(function() {
				let data_skrs = canvas_skrs.toDataURL('image/png');
				console.log("draw");
				console.log(data_skrs);
				return (data_skrs);
			}, 30000);
		}
		else
		{
			let nope = document.getElementById('alert');
			nope.style.display = "inline";
		}
	}

	// function addStickers()
	// {
	// 	console.log("addStickers() triggered");
	// 	let video = document.getElementById('webcam');
	// 	let width = video.width;
	// 	console.log("width: " + width);
	// 	let height = video.offsetHeight;
	// 	console.log("height: " + height);
	// 	let div = document.getElementById('overlay').querySelectorAll("img");
	// 	console.log(div);
	// 	let context_skrs = canvas_skrs.getContext('2d');
	// 	if (width && height && div[0])
	// 	{
	// 		canvas_skrs.height = height;
	// 		canvas_skrs.width = width;
	// 		for (let i = 0; i < div.length ; i++)
	// 		{
	// 			let image = new Image();
	// 			image.addEventListener('load', function() {
	// 				let img_width = div[i]['width'];
	// 				let img_height = div[i]['height'];
	// 				let x = (div[i]['offsetLeft'] - 155);
	// 				console.log("x: " + x);
	// 				let y = div[i]['offsetTop'];
	// 				console.log("y: " + y);
	// 				context_skrs.drawImage(image, x, y, img_width, img_height);
	// 			});
	// 			image.src = div[i]['src'];
	// 		}
	// 		isLoaded()
	// 			.then(sendPic)
	// 			.catch (function (err) {
	// 				console.log(err.message);
	// 			});
	// 	}
	// 	else
	// 	{
	// 		let nope = document.getElementById('alert');
	// 		nope.style.display = "inline";
	// 	}
	// }

	// function isLoaded()
	// {
	// 	return new Promise (function (resolve, reject)
	// 	{
	// 		image.onload = function () {
	// 			resolve(image);
	// 		};
	// 		image.onerror = function () {
	// 			reject(Error("image didn't load"));
	// 		};
	// 	}
	// }

	// function sendPic ()
	// {
	// 	let data_skrs = canvas_skrs.toDataURL('image/png');
	// 	console.log("draw");
	// 	console.log(data_skrs);
	// 	return (data_skrs);
	// }

	window.addEventListener('load', startup, false);
})();
