<?php 

$title = "Montage"; 

ob_start();
?>

<div id="content">
	<div id="frame">
		<h2>Who do you want to be ?</h2>
		<div id="camera-cont">
			<div id="position">
				<div id="overlay"><video id="webcam"></video></div>
				<div id="buttonHolder">
					<a onclick='sizeMinus()' class='button minus' id="minus" style="cursor:pointer;"></a>
					<a onclick='addStickers()' id="takepic" class='button takepic' style="cursor:pointer;"></a>
					<a onclick='sizePlus()'  class='button plus' style="cursor:pointer;"></a>
				</div>
			</div>
			<!-- <img id="tv" src="https://library.kissclipart.com/20180830/faw/kissclipart-old-tv-clipart-pearland-television-advertisement-05163ef983d9af99.png" /> -->
			<div id="options">
				<h3>Stickers</h3>
				<?php
					$files = glob("./public/img/stickers/*.*");
					for ($i = 0; $i < count($files); $i++)
					{
						$path = $files[$i]; ?>
						<a style="cursor:pointer;" id='random_sticker'><img src='<?= $path ?>' alt='random stickers' id='rand_sticker_<?= $i ?>' onclick='getStickers("<?= $path ?>", <?= $i ?>)'/></a><br /><br />
				<?php }
				?>
			</div>
			<div id="history">
				<h3>Previously on Camagru...</h3>
			</div>
		</div>
		<div id="conteneur"><canvas id="transit"></canvas></div>
		<div id="conteneur"><canvas id="add_stickers"></canvas></div>
		<div id="output"><img id="result" /></div>
	</div>
</div>

<?php
$content = ob_get_clean();

require_once('account.php');
require_once('template.php');

?>
