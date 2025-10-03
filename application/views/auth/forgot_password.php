<h1><?php echo lang('forgot_password_heading');?></h1>
<p><?php echo sprintf(lang('forgot_password_subheading'), $identity_label);?></p>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open("auth/forgot_password");?>

      <p>
      	<label for="identity"><?php echo (($type=='email') ? sprintf(lang('forgot_password_email_label'), $identity_label) : sprintf(lang('forgot_password_identity_label'), $identity_label));?></label> <br />
      	<?php echo form_input($identity);?>
      </p>
	<div>
	<?php
		$data = array(
			'class' => 'btn btn-primary btn-block p-2',
			'type' => 'submit',
			'value' => lang('forgot_password_submit_btn')
		);
		echo form_submit($data); 
	?>
	</div>

<?php echo form_close();?>
