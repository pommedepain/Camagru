
function getStickers(source, num)
{
		let video = document.getElementById('webcam');
		let width = video.offsetWidth;
		let height = video.offsetHeight;
		console.log(num);
		let img_width = document.getElementById('rand_sticker_' + num).offsetWidth;
		let img_height = document.getElementById('rand_sticker_' + num).offsetHeight;
		let canvas_skrs = null;
		console.log("getStickers() triggered");
		console.log(source);
		addStickersToCam(source);


	function addStickersToCam(source)
	{
		let div = document.getElementById('overlay');
		let image = document.createElement("img");
		image.src = source;
		//console.log(source);
		image.style.position = "absolute";
		let top = 0.5 * (height - img_height);
		//console.log(top);
		let left = 0.5 * (width - img_width);
		//console.log(left);
		image.style.top = top + "px";
		image.style.left = left + "px";
		image.style.width = img_width + "px";
		image.style.height = img_height + "px";
		div.appendChild(image);
	}
}

function addStickers()
{
	console.log("addStickers() triggered");
	let video = document.getElementById('webcam');
	let width = video.offsetWidth;
	let height = video.offsetHeight;
	let div = document.getElementById('overlay').querySelectorAll("img");
	console.log(div);
	canvas_skrs = document.getElementById('add_stickers');
	let context_skrs = canvas_skrs.getContext('2d');
	if (width && height)
	{
		canvas_skrs.height = height;
		canvas_skrs.width = width;
		for (let i = 0; i < div.length ; i++)
		{
			let image = new Image();
			image.src = div[i]['src'];
			image.addEventListener('load', function() {
				let img_width = div[i]['width'];
				let img_height = div[i]['height'];
				let x = div[i]['offsetLeft'];
				let y = div[i]['offsetTop'];
				context_skrs.drawImage(image, x, y, img_width, img_height);
			});
		}
		console.log("draw");
		let data_skrs = canvas_skrs.toDataURL('image/png');
	}
}
