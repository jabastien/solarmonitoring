				<div id="header" class="grid_8 alpha omega">
					<h1 class="upper">Solar Monitoring</h1>
					<h2>EFACAP School - Lascahobas, Haiti</h2>
				</div>
				<div id="navigation" class="grid_8 alpha omega">
					<ul>
						<li><a href="<?php echo base_url();?>"<?php if ($this->uri->uri_string() == '') { echo 'class="main-nav-active"'; } ?>>Our Project</a></li>
						<li><a href="<?php echo base_url();?>solar-data"<?php if ($this->uri->uri_string() == 'solar-data' || $this->uri->segment(1) == 'technical-solar-data') { echo 'class="main-nav-active"'; } ?>>Solar Data</a></li>
						<li><a href="<?php echo base_url();?>solar-solution"<?php if ($this->uri->uri_string() == 'solar-solution') { echo 'class="main-nav-active"'; } ?>>Our Solar Solution</a></li>
						<li><a href="<?php echo base_url();?>about"<?php if ($this->uri->uri_string() == 'about') { echo 'class="main-nav-active"'; } ?>>About Our School</a></li>
						<li><a href="<?php echo base_url();?>project-affiliates"<?php if ($this->uri->uri_string() == 'project-affiliates') { echo 'class="main-nav-active"'; } ?> id="last-nav">Project Affiliates</a></li>
					</ul>
				</div>
