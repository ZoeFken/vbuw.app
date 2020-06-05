<h1><?php echo lang('edit_group_heading');?></h1>
<p><?php echo lang('edit_group_subheading');?></p>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open(current_url());?>

      <p>
            <?php echo lang('edit_group_name_label', 'group_name');?> <br />
            <?php echo form_input($group_name);?>
      </p>

      <p>
            <?php echo lang('edit_group_desc_label', 'description');?> <br />
            <?php echo form_input($group_description);?>
      </p>

	<div>
	<?php
		$data = array(
			'class' => 'btn btn-primary btn-block p-2',
			'type' => 'submit',
			'value' => lang('edit_group_submit_btn')
		);
		echo form_submit($data); 
	?>
	</div>

<?php echo form_close();?>
