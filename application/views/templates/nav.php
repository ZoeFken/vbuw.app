	<div class="navbar navbar-expand-lg fixed-top navbar-dark bg-primary">
		<div class="container">
			<a href="<?php echo base_url() ?>" class="navbar-brand"><?php echo $this->lang->line('titel'); ?></a>
			<?php if ($this->ion_auth->logged_in()) : ?>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarResponsive">
					<ul class="navbar-nav mr-auto">
						<li class="nav-item">
							<a class="nav-link" href="<?php echo base_url('welcome') ?>"><?php echo $this->lang->line('home'); ?></a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="<?php echo base_url('create_s627') ?>"><?php echo $this->lang->line('s627'); ?></a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="<?php echo base_url('create_verdeler') ?>"><?php echo $this->lang->line('verdeler'); ?></a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="<?php echo base_url('create_s460') ?>"><?php echo $this->lang->line('s460'); ?></a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="<?php echo base_url('create_s505') ?>"><?php echo $this->lang->line('s505'); ?></a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="https://drive.google.com/drive/folders/1wfK-iDhOTg_Xtzm-rLQYlmB-5gyzOYTZ" target="_blanck"><?php echo $this->lang->line('drive'); ?></a>
						</li>

						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $this->lang->line('doc'); ?></a>
							<div class="dropdown-menu">
								<a class="dropdown-item" href="<?php echo base_url('documents/personal') ?>"><?php echo $this->lang->line('persoonlijk'); ?></a>
								<a class="dropdown-item" href="<?php echo base_url('documents/all') ?>"><?php echo $this->lang->line('alle'); ?></a>
								<a class="dropdown-item" href="<?php echo base_url('locations') ?>"><?php echo $this->lang->line('locations'); ?></a>
								<?php
								// if($this->ion_auth->is_admin()) :
								// $attributes = array('class' => 'p-2'); ;
								// echo form_open('documents/specific', $attributes); 
								?>
								<!-- <input type="text" name="user" class="form-control" id="user" placeholder="Pieter-Jan">
						<input type="submit" class="btn btn-primary btn-block mt-2"> -->
								<?php
								// echo form_close();
								// endif; 
								?>
								<div class="dropdown-divider"></div>
								<!-- <a class="dropdown-item" href="https://drive.google.com/drive/folders/1wfK-iDhOTg_Xtzm-rLQYlmB-5gyzOYTZ?usp=sharing" target="_blanck"><?php echo $this->lang->line('blanco'); ?></a> -->
								<a class="dropdown-item" href="https://amdm-web.infrabel.be/" target="_blanck"><?php echo $this->lang->line('amdm'); ?></a>
								<a class="dropdown-item" href="https://dailyin-website.infrabel.be/" target="_blanck"><?php echo $this->lang->line('bnx'); ?></a>
								<a class="dropdown-item" href="https://drawin-website.infrabel.be/" target="_blanck"><?php echo $this->lang->line('drawin'); ?></a>
								<a class="dropdown-item" href="https://drive.google.com/drive/folders/1VVXU8_Kzdat8EtwjHAh6fCrv8yoMkxCR?usp=sharing" target="_blanck"><?php echo $this->lang->line('rostar'); ?></a>
							</div>
						</li>

					</ul>

					<ul class="navbar-nav navbar-right">
						<li class="nav-item">
							<a class="nav-link" href="<?php echo base_url('auth/edit_user/' . $this->session->user_id); ?>"><?php echo $this->lang->line('edit'); ?></a>
						</li>
						<li class="nav-item">
							<a class="nav-link text-warning" href="<?php echo base_url('auth/logout'); ?>"><?php echo $this->lang->line('logout'); ?></a>
						</li>
					</ul>
				</div>

			<?php else : ?>
				<ul class="navbar-nav navbar-right">
				<li class="nav-item">
						<a class="nav-link text-white" href="<?php echo base_url('locations'); ?>"><?php echo $this->lang->line('locations'); ?></a>
					</li>
					<li class="nav-item">
						<a class="nav-link text-white" href="<?php echo base_url('login'); ?>"><?php echo $this->lang->line('login'); ?></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?php echo base_url('request'); ?>"><?php echo $this->lang->line('register'); ?></a>
					</li>
				</ul>
			<?php endif; ?>
		</div>
	</div>