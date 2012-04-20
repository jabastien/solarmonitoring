		
		<ul id="solar-nav">
						<li><a href="<?php echo base_url(); ?>technical-solar-data/kwh" <?php  if (activepage('kwh')) {echo 'class="solar-nav-active"';} ?>>kWh Generation</a></li>
						<li><a href="<?php echo base_url(); ?>technical-solar-data/battery" <?php  if (activepage('battery')) {echo 'class="solar-nav-active"';} ?>>Battery History</a></li>
						<li><a href="<?php echo base_url(); ?>technical-solar-data/amps" <?php  if (activepage('amps')) {echo 'class="solar-nav-active"';} ?>>Amps/Charge</a></li>
					<!--	<li><a href="technical-solar-data/voltamps">Volts/Amps</a></li> -->
						<li><a href="<?php echo base_url(); ?>technical-solar-data/pv" <?php  if (activepage('pv')) {echo 'class="solar-nav-active"';} ?>>Solar PVs</a></li>
		</ul>