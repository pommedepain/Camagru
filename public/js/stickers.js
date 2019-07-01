
function getStickers(source, num)
{
		let video = document.getElementById('webcam');
		let width = video.offsetWidth;
		let height = video.offsetHeight;
		console.log(num);
		let img_width = document.getElementById('rand_sticker_' + num).offsetWidth;
		let img_height = document.getElementById('rand_sticker_' + num).offsetHeight;
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
		image.style.cursor = "pointer";
		div.appendChild(image);
		image.addEventListener("click", moveStickers(image));
	}
}

function moveStickers(image)
{
		let pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
		image.onmousedown = dragMouseDown;
	
		function dragMouseDown(e)
		{
			e = e || window.event;
			e.preventDefault();
			pos3 = e.clientX;
			pos4 = e.clientY;
			document.onmouseup = closeDragElement;
			document.onmousemove = elementDrag;
		}

		function elementDrag(e)
		{
			e = e || window.event;
			e.preventDefault();
			pos1 = pos3 - e.clientX;
			pos2 = pos4 - e.clientY;
			pos3 = e.clientX;
			pos4 = e.clientY;
			image.style.top = (image.offsetTop - pos2) + "px";
    		image.style.left = (image.offsetLeft - pos1) + "px";
		}

		function closeDragElement()
		{
			document.onmouseup = null;
    		document.onmousemove = null;
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

function sizeMinus()
{
	let div = document.getElementById('overlay').querySelectorAll("img");
	
	if (div[0])
	{
		console.log(div);
		// let sticker = null;
		for (let i = 0; i < div.length; i++)
		{
			let sticker = new Image();
			sticker.src = div[i]['src'];
			console.log(sticker.src);
			sticker.style.width = div[i]['offsetWidth'];
			sticker.style.width = sticker.offsetWidth-10+'px';
			console.log(sticker.offsetWidth);
			sticker.style.height = sticker.offsetHeight-1+'%';
			console.log(sticker.offsetHeight);
		}
	}
}
