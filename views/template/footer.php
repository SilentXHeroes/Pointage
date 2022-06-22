		</section>
	</section>
	<script type="text/javascript" src="assets/script/jquery.js"></script>
	<script type="text/javascript" src="assets/script/script.js?version=<?php echo $this->version; ?>"></script>
	<script type="text/javascript">
		var base = 'http://pointage.georgesreydy.fr/index.php/';
	</script>
	<?php
		if(isset($js) && !empty($js)){
			foreach($js as $file){
				echo '<script type="text/javascript" src="assets/script/'. $file .'?version='.$this->version.'"></script>';
			}
		}
	?>
</body>
</html>