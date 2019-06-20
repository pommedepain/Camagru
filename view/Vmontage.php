<?php 

$title = "Montage"; 

ob_start();
?>

<div id="content">
	<div id="frame">
		<h3>Do it</h3>
		<div id="camera-cont">
			<div id="position">
				<video id="webcam"></video>
				<button id="takepic">Take picture</button>
			</div>
			<!-- <img id="tv" src="https://library.kissclipart.com/20180830/faw/kissclipart-old-tv-clipart-pearland-television-advertisement-05163ef983d9af99.png" /> -->
			<div id="options">
				<nav>
					<ul>
						<li>Option 1</li>
						<li>Option 2</li>
						<li>Option 3</li>
					</ul>
				</nav>
			</div>
		</div>
		<canvas id="manip"></canvas>
		<div id="output">
			<img id="result" />
		</div>
	</div>
</div>

<?php
$content = ob_get_clean();

require_once('account.php');
require_once('template.php');

?>
