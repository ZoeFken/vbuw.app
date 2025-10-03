<h1><?php echo lang('deactivate_heading');?></h1>
<p><?php echo sprintf(lang('deactivate_subheading'), $user->username);?></p>

<?php echo form_open("auth/deactivate/".$user->id);?>

  <p>
  	<?php echo lang('deactivate_confirm_y_label', 'confirm');?>
    <input type="radio" name="confirm" value="yes" checked="checked" />
    <?php echo lang('deactivate_confirm_n_label', 'confirm');?>
    <input type="radio" name="confirm" value="no" />
  </p>

  <?php echo form_hidden($csrf); ?>
  <?php echo form_hidden(['id' => $user->id]); ?>

	<div>
	<?php
		$data = array(
			'class' => 'btn btn-primary btn-block p-2',
			'type' => 'submit',
			'value' => lang('deactivate_submit_btn')
		);
		echo form_submit($data); 
	?>
	</div>

<?php echo form_close();?>
