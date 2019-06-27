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

		width = video.offsetWidth;
		video.height = width;
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
				//console.log("video width = " + video.width);
				video.setAttribute('height', height);
				//console.log("video height = " + video.height);
				canvas.setAttribute('width', width);
				canvas.setAttribute('height', height);
				canvas_skrs.setAttribute('width', width);
				canvas_skrs.setAttribute('height', height);
				streaming = true;
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
		if (width && height)
		{
			canvas.height = height;
			//console.log("canvas height = " + canvas.height);
			canvas.width = width;
			//console.log("canvas width = " + canvas.width);
			context.drawImage(video, 0, 0, width, height);
			let data = canvas.toDataURL('image/png');
			photo.setAttribute('src', data);
		}
		else
		{
			clearphoto();
		}
	}

	window.addEventListener('load', startup, false);
})();
