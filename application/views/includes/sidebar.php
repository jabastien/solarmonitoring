</div> <!-- end grid_8 for page-body -->
			<div class="grid_4 sidebar">
				<div class="box blue-box">
					<p class="upper white">Data as of: <?php echo date("g:i A " ,strtotime($this->load->get_var("last_poll_date"))); echo $this->load->get_var("site_short_TZ");  ?> <span class="orange">|</span> <?php echo date("M jS Y", strtotime($this->load->get_var("last_poll_date"))); ?></p>
					<h4 class="upper white top-ten">Current Laptops Charged</h4>
					<p id="laptop-count"class="white upper font-16"><span class="count"><?php echo $this->load->get_var("laptops_charged") ?></span> laptops out of 400</p>
					<div id="laptop-graphic-wrapper" class="float-left relative">
					 <img class="laptop-graphic percent-0" src="<?php echo base_url(); ?>img/olpc-sprite.png" /> 
					 </div>
					<br class="clear">
					<p id="laptops-charging" class="white"><?php echo $this->load->get_var("avg_laptops_charged") ?> Laptops daily charging average since Aug 2011</p>
				</div>

				<?php
					if (is_array($w))
					{
						foreach ($w as $i => $value)
						{
							$val = 'includes/widgets/' . $value;
							$this->load->view($val);
						}	
					}
					
				?>
				
				
				
			</div>
