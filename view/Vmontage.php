<?php 

$title = "Montage";
$stylesheet = '<link rel="stylesheet" type="text/css" href="./public/css/montage.css">';

ob_start();
?>

<div id="content">
	<div id="frame">
		<h2 id="subtitle">Who do you want to be ?</h2>
		<div id="link_no_log"><a id="not_loggued">You can <a id="register" href="index.php?action=register"> Register </a> or <a id="signin" href="index.php?action=sign_in"> Sign-in</a></a></div>
		<div class="alert" id="alert">
  			<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>  
  			<strong>Oops!</strong> You need to add at least one sticker
		</div>
		<div id="camera-cont">
			<div id="position">
				<div id="overlay"><video id="webcam"></video></div>
				<div id="buttonHolder">
					<a onclick='sizeMinus()' class='button minus' id="minus" style="cursor:pointer;"></a>
					<a id="takepic" class='button takepic' style="cursor:pointer;"></a>
					<a onclick='sizePlus()'  class='button plus' style="cursor:pointer;"></a>
				</div>
				<div id="upload">
					<div id="select_submit">
						Select image to upload:
						<input type="file" id="img_to_upload" onchange="ShowImage(this)">
						<label for="img_to_upload" id="to_upload">Search</label>
						<input type="submit" value="Submit" id="submit" onclick="LoadImage()">
					</div>
				</div>
			</div>
			<div id="options">
				<h3>Stickers</h3>
				<div id="optionss">
					<?php
						$files = glob("./public/img/stickers/*.*");
						for ($i = 0; $i < count($files); $i++)
						{
							$path = $files[$i]; ?>
							<a style="cursor:pointer;" id='random_sticker'><img src='<?= $path ?>' alt='random stickers' id='rand_sticker_<?= $i ?>' onclick='getStickers("<?= $path ?>", <?= $i ?>)'/></a><br /><br />
					<?php }
					?>
				</div>
			</div>
			<div id="history">
				<h3>Previously on Camagru...</h3>
				<div id="previous"></div>
			</div>
		</div>
		<img id="blah" src="#"/>
		<div id="conteneur"><canvas id="transit"></canvas></div>
		<div id="conteneur"><canvas id="add_stickers"></canvas></div>
		<div id="output"><img id="cadre" src="../public/img/frame.png"/><img id="result" /></div>
	</div>
</div>
<script src="./public/js/montage.js"></script>
<script src="./public/js/stickers.js"></script>

<?php
$content = ob_get_clean();

require_once('account.php');
require_once('template.php');

?>
