<h2 class="display-4 text-center pb-3"><?php echo $this->lang->line('titel'); ?></h2>
<section class="d-flex justify-content-center">
<?php 
	$attributes = array('class' => 'col-md-12'); 
	echo form_open('create_s460/s460', $attributes); 
?>

	<div class="form-group" id="extend_field">
		<div class="row">
			<div class="form-group col-md-6 col-xs-13">
				<input type="text" name="s460Melding[0][s460_input_melding]" placeholder="<?php echo $this->lang->line('melding'); ?>" class="form-control name_list" required="" />
			</div>
			<div class="form-group col-md-6 col-xs-13 switch-field">
				<input type="radio" id="radio-0" name="s460verzender[0][s460_input_verzender]" value="1" checked/>
				<label for="radio-0"><?php echo $this->lang->line('verzender'); ?></label>
				<input type="radio" id="radio-00" name="s460verzender[0][s460_input_verzender]" value="0"/>
				<label for="radio-00"><?php echo $this->lang->line('ontvanger'); ?></label>
				<button type="button" name="add" id="add" class="btn btn-success ml-5"><?php echo $this->lang->line('voeg_meer_toe'); ?></button>
			</div>
		</div>
	</div>
	</div>
	<div class="form-group">
	<input type="submit" name="submit" id="submit" class="btn btn-primary btn-block" value="<?php echo $this->lang->line('submit'); ?>" /> 
	</div>

<?php echo form_close(); ?>

   
<script type="text/javascript">
    $(document).ready(function(){      
      var i=0;  
   
      $('#add').click(function(){  
           i++;  
		   $('#extend_field').append('<div class="row" id="row'+i+'"><div class="form-group col-md-6 col-xs-13"><input type="text" name="s460Melding['+i+'][s460_input_melding]" placeholder="<?php echo $this->lang->line('melding'); ?>" class="form-control name_list" required="" /></div><div class="form-group col-md-6 col-xs-13 text-center switch-field"><input type="radio" id="radio-'+i+'" name="s460verzender['+i+'][s460_input_verzender]" value="1" checked/><label for="radio-'+i+'"><?php echo $this->lang->line('verzender'); ?></label><input type="radio" id="radio-'+i+i+'" name="s460verzender['+i+'][s460_input_verzender]" value="0"/><label for="radio-'+i+i+'"><?php echo $this->lang->line('ontvanger'); ?></label><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove text-center ml-5">X</button></div></div>');
	  });
  
      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  
  
    });
</script>
</section>
