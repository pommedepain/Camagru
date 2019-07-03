<?php 

$title = "Montage"; 

ob_start();
?>

<div id="content">
	<div id="frame">
		<h2>Who do you want to be ?</h2>
		<div class="alert" id="alert">
  			<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>  
  			<strong>Oops!</strong> You need to addat least one sticker
		</div>
		<div id="camera-cont">
			<div id="position">
				<div id="overlay"><video id="webcam"></video></div>
				<div id="buttonHolder">
					<a onclick='sizeMinus()' class='button minus' id="minus" style="cursor:pointer;"></a>
					<a id="takepic" class='button takepic' style="cursor:pointer;"></a>
					<a onclick='sizePlus()'  class='button plus' style="cursor:pointer;"></a>
				</div>
			</div>
			<!-- <img id="tv" src="https://library.kissclipart.com/20180830/faw/kissclipart-old-tv-clipart-pearland-television-advertisement-05163ef983d9af99.png" /> -->
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
		<div id="conteneur"><canvas id="transit"></canvas></div>
		<div id="conteneur"><canvas id="add_stickers"></canvas></div>
		<div id="output"><img id="result" /></div>
	</div>
</div>
<script src="./public/js/montage.js"></script>
<script src="./public/js/stickers.js"></script>

<?php
$content = ob_get_clean();

require_once('account.php');
require_once('template.php');

?>
