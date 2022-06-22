<section id="workTime_container" class="window<?php echo $this->isActive ? '' : ' inactive'; ?>">
	<article id="workTime">
		<aside id="time" class="display <?php echo $inBreakingTime ? 'inPause' : ''; ?>">
			<div id="timeH" class="hour">
				<p><?php echo $hours; ?></p>
				<span>88</span>
			</div>
			<div class="separator hour"><p>:</p></div>
			<div id="timeM" class="hour">
				<p><?php echo $minutes; ?></p>
				<span>88</span>
			</div>
			<div class="separator hour"><p>:</p></div>
			<div id="timeS" class="hour">
				<p><?php echo $seconds; ?></p>
				<span>88</span>
			</div>
		</aside>
	</article>

	<article id="buttons" class="<?php echo $notStart ? 'begin' : ($over ? 'end' : ($inBreakingTime ? 'pause' : '')); ?>">
		<?php //if($inBreakingTime) { ?>
		<span id="goToWork" title="Retourner au travail" class="icon-play"></span>
		<?php //}else{ ?>
		<span id="pause" title="Mettre en pause" class="icon-pause"></span>
		<?php //} ?>
		<span id="leave" title="Terminer" class="icon-stop"></span>
		<span id="start" title="Commencer" class="icon-play"></span>
		<div>
			<p>Vous avez terminé</p>
		</div>
	</article>

	<article id="statsUser">
		<div>
			<p><?php echo !is_null($statsUser['time_worked']) ? $statsUser['time_worked'] : '--'; ?></p>
			<label>heures de travail</label>
		</div>
		<div id="timeSupp">
			<p></p>
			<label>temps supplémentaire</label>
		</div>
		<div>
			<p><?php echo !is_null($statsUser['time_pause']) ? $statsUser['time_pause'] : '--'; ?></p>
			<label>minutes de pause</label>
		</div>
	</article>
</section>
<script type="text/javascript">
	var notStart 	= <?php echo json_encode($notStart); ?>,
		dayOver 	= <?php echo json_encode($over); ?>,
		inBreakingTime = <?php echo json_encode($inBreakingTime) ?>;
</script>