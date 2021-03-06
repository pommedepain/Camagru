
function getStickers(source, num)
{
		let width = 0;
		let height = 0;
		let video = document.getElementById('webcam');
		
		width = video.width;
		/* console.log("width canvas: " + width); */
		height = video.height;
		/* console.log("height canvas: " + height); */
		/* console.log(num); */
		let img_width = document.getElementById('rand_sticker_' + num).offsetWidth;
		let img_height = document.getElementById('rand_sticker_' + num).offsetHeight;
		/* console.log("getStickers() triggered"); */
		/* console.log(source); */
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
		image.style.zIndex = "10000";
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

function sizeMinus()
{
	let div = document.getElementById('overlay').querySelectorAll("img");
	
	if (div[0])
	{
		/* console.log(div); */
		let sticker = null;
		for (let i = 0; i < div.length; i++)
		{
			if (i + 1 >= div.length)
			{
				sticker = new Image();
				sticker.src = div[i]['src'];
				sticker.width = div[i]['offsetWidth'];
				sticker.height = div[i]['offsetHeight'];
				let ratio = sticker.height/sticker.width;
				sticker.width -= 30;
				sticker.height = sticker.width * ratio;
				sticker.style.position = "absolute";
				let video = document.getElementById('webcam');
				let width = video.offsetWidth;
				let height = video.offsetHeight;
				let top = 0.5 * (height - sticker.height);
				let left = 0.5 * (width - sticker.width);
				sticker.style.top = top + "px";
				sticker.style.left = left + "px";
				/* console.log(sticker); */
				sticker.style.cursor = "pointer";
				sticker.addEventListener("click", moveStickers(sticker));
				div[i].parentNode.replaceChild(sticker, div[i]);
			}
		}
	}
}

function sizePlus()
{
	let div = document.getElementById('overlay').querySelectorAll("img");
	
	if (div[0])
	{
		/* console.log(div); */
		let sticker = null;
		for (let i = 0; i < div.length; i++)
		{
			if (i + 1 >= div.length)
			{
				sticker = new Image();
				sticker.src = div[i]['src'];
				sticker.width = div[i]['offsetWidth'];
				sticker.height = div[i]['offsetHeight'];
				let ratio = sticker.height/sticker.width;
				sticker.width += 30;
				sticker.height = sticker.width * ratio;
				sticker.style.position = "absolute";
				let video = document.getElementById('webcam');
				let width = video.offsetWidth;
				let height = video.offsetHeight;
				let top = 0.5 * (height - sticker.height);
				let left = 0.5 * (width - sticker.width);
				sticker.style.top = top + "px";
				sticker.style.left = left + "px";
				/* console.log(sticker); */
				sticker.style.cursor = "pointer";
				sticker.addEventListener("click", moveStickers(sticker));
				div[i].parentNode.replaceChild(sticker, div[i]);
			}
		}
	}
}

function ShowImage(input)
{
	if (input.files && input.files[0])
	{
		let reader = new FileReader();

		reader.onload = function (e) {
			let img = document.getElementById('blah');
			img.setAttribute('src', e.target.result);
			img.style.width = "15%";
			img.style.height = "auto";
			img.style.display = "inline";
		};

		reader.readAsDataURL(input.files[0]);
	}
}

function LoadImage()
{
	let input = document.getElementById('img_to_upload');
	
	if (input.files && input.files[0])
	{
		let reader = new FileReader();

		reader.onload = function (e) {
			let webcam = document.getElementById('webcam');
			width = webcam.width;
			let img = document.createElement("img");
			img.width = width;
			img.height = width;
			/* console.log("img.width: " + img.width + " & height: " + img.height); */
			img.setAttribute('src', e.target.result);

			let div = document.getElementById('overlay');
			div.innerHTML = "";
			img.setAttribute("id", 'webcam');
			div.appendChild(img);
		};

		reader.readAsDataURL(input.files[0]);
	}
}
