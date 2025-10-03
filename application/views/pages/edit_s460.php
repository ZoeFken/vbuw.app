<h2 class="display-4 text-center pb-3"><?php echo $this->lang->line('titel'); ?></h2>
<section class="d-flex justify-content-center">
<?php 
	$attributes = array('class' => 'col-md-12'); 
	echo form_open('create_s460/s460/' . $document_id, $attributes); 
?>
	
	<div class="form-group" id="extend_field">
		<?php $i = 0;
		foreach($fields as $field): ?>
		<div class="row" id="<?php echo 'row' . $i; ?>">
			<div class="form-group col-md-6 col-xs-13">
				<input type="text" name="s460Melding[<?php echo $i; ?>][s460_input_melding]" placeholder="<?php echo $this->lang->line('melding'); ?>" class="form-control name_list" required="" value="<?php echo $field[1]; ?>"/>
			</div>
			<div class="form-group col-md-6 col-xs-13 switch-field">
				<input type="radio" id="radio-<?php echo $i; ?>" name="s460verzender[<?php echo $i; ?>][s460_input_verzender]" value="1" <?php if($field[2] == 1) echo 'checked' ?>/>
				<label for="radio-<?php echo $i; ?>"><?php echo $this->lang->line('verzender'); ?></label>
				<input type="radio" id="radio-<?php echo $i.$i; ?>" name="s460verzender[<?php echo $i; ?>][s460_input_verzender]" value="0" <?php if($field[2] == 0) echo 'checked' ?>/>
				<label for="radio-<?php echo $i.$i; ?>"><?php echo $this->lang->line('ontvanger'); ?></label>
				<?php if($i == 0) : ?>
				<button type="button" name="add" id="add" class="btn btn-success ml-5"><?php echo $this->lang->line('voeg_meer_toe'); ?></button>
				<?php else : ?>
				<button type="button" name="remove" id="<?php echo $i; ?>" class="btn btn-danger btn_remove ml-5">X</button></td>
				<?php endif; ?>
			</div>
		</div>
		<?php $i++;
		endforeach; ?>
	</div>
	<div class="form-group">
	<input type="submit" name="submit" id="submit" class="btn btn-primary btn-block" value="<?php echo $this->lang->line('submit'); ?>" /> 
	</div>

<?php echo form_close(); ?>

<div id="field-ammount" style="display: none;"><?php echo htmlspecialchars($i) ?></div>

<script type="text/javascript">
    $(document).ready(function(){      
	  var i = document.getElementById("field-ammount").textContent;
   
      $('#add').click(function(){    
		   $('#extend_field').append('<div class="row" id="row'+i+'"><div class="form-group col-md-6 col-xs-13"><input type="text" name="s460Melding['+i+'][s460_input_melding]" placeholder="<?php echo $this->lang->line('melding'); ?>" class="form-control name_list" required="" /></div><div class="form-group col-md-6 col-xs-13 text-center switch-field"><input type="radio" id="radio-'+i+'" name="s460verzender['+i+'][s460_input_verzender]" value="1" checked/><label for="radio-'+i+'"><?php echo $this->lang->line('verzender'); ?></label><input type="radio" id="radio-'+i+i+'" name="s460verzender['+i+'][s460_input_verzender]" value="0"/><label for="radio-'+i+i+'"><?php echo $this->lang->line('ontvanger'); ?></label><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove text-center ml-5">X</button></div></div>');
		   i++;
	  });
  
      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  
  
    });
</script>
</section>
