<section id="calendar_container" class="window<?php echo $this->isActive ? '' : ' inactive'; ?>">
	<article id="selectDate">
		<aside id="infosCalendar">
			<div class="activeMonth"><?php // echo $activeMonth; ?></div>
			<div class="activeYear"><?php // echo $activeYear; ?></div>
			<div id="months" class="selectOne">
				<?php
					foreach ($months as $key => $month) {
						echo '<div data-month="'.$key.'" '.($key === $activeMonth ? 'class="activeMonth"' : '').'>'.$month.'</div>';
					}
				?>
			</div>
			<div id="years" class="selectOne">
				<!-- <?php echo $activeYear; ?> -->
			</div>
		</aside>
	</article>
	<article id="displayCalendar">
		<aside id="backMonth" class="changeMonth"><i class="icon-arrow-down" style="transform: rotate(90deg);"></i></aside>
		<aside id="displayDays">

		</aside>
		<aside id="nextMonth" class="changeMonth"><i class="icon-arrow-down" style="transform: rotate(-90deg);"></i></aside>
<!-- 		<div id="daysLoader">
			<div class="circle"></div>
			<div class="circle"></div>
			<div class="circle"></div>
			<div class="circle"></div>
			<div class="circle"></div>
			<div class="circle"></div>
			<div class="circle"></div>
			<div class="circle"></div>
		</div> -->
	</article>
</section>
<script type="text/javascript">
	var dateNow = new Date(),
		date = {
			now: dateNow,
			calendar : dateNow
		},
		months = [
			"Janvier",
			"Février",
			"Mars",
			"Avril",
			"Mai",
			"Juin",
			"Juillet",
			"Août",
			"Septembre",
			"Octobre",
			"Novembre",
			"Décembre"
		];
</script>