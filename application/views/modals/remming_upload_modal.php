<!-- Modal -->
<div class="modal fade" id="remming_upload_modal" tabindex="-1" role="dialog" aria-labelledby="documentModal" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="documentModalLabel">Upload Rebu</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
		
			<div class="modal-body d-flex justify-content-center">

				<?php 
				$attributes = array('class' => 'col-12'); 
				echo form_open_multipart('remming/readFile', $attributes); 
				?>
				<div class="form-group row justify-content-between">
                    <input type="file" name="userfile">
                </div>

				<div class="form-group row">

					<?php 
					$data = array(
						'class' => 'btn btn-primary btn-block',
						'type' => 'submit',
						'value' => 'Upload'
					);
					echo form_submit($data); 
					?>
					
				</div>

				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>
