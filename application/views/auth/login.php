<div class="row justify-content-center align-items-center">
	<div class="text-center logo col-sm-12"><img class="mx-auto d-block" src="<?php echo base_url(); ?>assets/images/logo.svg" alt="Site logo"></div>
	<div class="text-center col-sm-12" id="infoMessage"><?php echo $message;?></div>
	<?php $attributes = array('class' => 'w-75'); 
		echo form_open("auth/login", $attributes);
	?>
	<div class="form-group">
		<label for="inputUser"><?php echo lang('login_identity_label', 'identity');?></label>
		<?php echo form_input($identity);?>
	</div>
	<div class="form-group">
		<label for="inputPassword"><?php echo lang('login_password_label', 'password');?></label>
		<?php echo form_input($password);?>
	</div>
	<div class="form-group">
		<?php echo lang('login_remember_label', 'remember');?>
		<?php
		$data = array(
		'name'          => 'remember',
		'id'            => 'remember',
		'value'         => '1',
		'checked'       => false,
		'style'         => 'margin:10px'
		);
		echo form_checkbox($data);
		?>
	</div>
	<div>
	<?php
		$data = array(
			'class' => 'btn btn-primary btn-block p-2',
			'type' => 'submit',
			'value' => lang('login_submit_btn')
		);
		echo form_submit($data); 
	?>
	</div>
	<?php echo form_close();?>
</div>
<div class="row justify-content-center align-items-center pt-3"><a href="forgot_password"><?php echo lang('login_forgot_password');?></a></div>
