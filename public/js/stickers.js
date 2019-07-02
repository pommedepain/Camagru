
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
		image.style.position = "absolute";
		let top = 0.5 * (height - img_height);
		let left = 0.5 * (width - img_width);
		image.style.top = top + "px";
		image.style.left = left + "px";
		image.style.width = img_width + "px";
		image.style.height = img_height + "px";
		image.style.cursor = "pointer";
		div.appendChild(image);
		image.addEventListener("click", moveStickers(image));
	}

	// let minus = document.getElementById('minus');
	// minus.addEventListener('click', function (e){
	// 	sizeMinus(source);
	// }, false);

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

function sizeMinus()
{
	let div = document.getElementById('overlay').querySelectorAll("img");
	//console.log("source: " + source);
	
	if (div[0])
	{
		console.log(div);
		// source = source.substr(1);
		// source = "http://localhost:8080" + source;
		let sticker = null;
		for (let i = 0; i < div.length; i++)
		{
				sticker = new Image();
				sticker.src = div[i]['src'];
				sticker.width = (div[i]['offsetWidth'] - 30);
				sticker.height = (div[i]['offsetHeight'] - 30);
				sticker.style.position = "absolute";
				let video = document.getElementById('webcam');
				let width = video.offsetWidth;
				let height = video.offsetHeight;
				let top = 0.5 * (height - sticker.height);
				let left = 0.5 * (width - sticker.width);
				sticker.style.top = top + "px";
				sticker.style.left = left + "px";
				console.log(sticker);
				sticker.style.cursor = "pointer";
				sticker.addEventListener("click", moveStickers(sticker));
				div[i].parentNode.replaceChild(sticker, div[i]);
		}
	}
}

function sizePlus()
{
	let div = document.getElementById('overlay').querySelectorAll("img");
	//console.log("source: " + source);
	
	if (div[0])
	{
		console.log(div);
		// source = source.substr(1);
		// source = "http://localhost:8080" + source;
		let sticker = null;
		for (let i = 0; i < div.length; i++)
		{
				sticker = new Image();
				sticker.src = div[i]['src'];
				sticker.width = (div[i]['offsetWidth'] + 30);
				sticker.height = (div[i]['offsetHeight'] + 30);
				sticker.style.position = "absolute";
				let video = document.getElementById('webcam');
				let width = video.offsetWidth;
				let height = video.offsetHeight;
				let top = 0.5 * (height - sticker.height);
				let left = 0.5 * (width - sticker.width);
				sticker.style.top = top + "px";
				sticker.style.left = left + "px";
				console.log(sticker);
				sticker.style.cursor = "pointer";
				sticker.addEventListener("click", moveStickers(sticker));
				div[i].parentNode.replaceChild(sticker, div[i]);
		}
	}
}
