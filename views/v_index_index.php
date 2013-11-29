<!-- Computer players area -->

<div id = "computer1" class = "computerCards1">
	<div class="textBox name">Computer 1</div>
	<div id="computer1Score" class="textBox">&nbsp;</div>
	<div id="computer1Cards" class="cardArea"></div>
</div>

<div id = "computer2" class = "computerCards2">
	<div class="textBox name">Computer 2</div>
	<div id="computer2Score" class="textBox">&nbsp;</div>
	<div id="computer2Cards" class="cardArea"></div>
</div>

<div id = "computer3" class = "computerCards3">
	<div class="textBox name">Computer 2</div>
	<div id="computer3Score" class="textBox">&nbsp;</div>
	<div id="computer3Cards" class="cardArea"></div>
</div>

<!-- Main player's area -->

<div id = "player0" class="playingField">
	<div class="textBox name">Player</div>
	<div id="player0Score" class="textBpx">&nbsp;</div>
	<div id="player0Cards" class="cardArea"></div>
</div>

<!--Game buttons -->



<input id="playbutton" type="reset" value="Play!" onclick="startRound()">



		<!--<input id = "playbutton" type = "button" value="Play!" onclick="startRound">-->


<script>
$("#playbutton").click(function() {
    $('#playbutton').css('display', 'none');
    
})

</SCRIPT>

















<p>
	<strong>Since everything is in working order, you should now delete <?php echo APP_PATH?>diagnostics.php</strong>
</p>