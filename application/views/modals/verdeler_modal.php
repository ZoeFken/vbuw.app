<!-- Modal -->
<div class="modal fade" id="docmodal_<?php echo $document_id ?>" tabindex="-1" role="dialog" aria-labelledby="documentModal" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="documentModalLabel">Download Verdeler</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
		
			<div class="modal-body d-flex justify-content-center">
				<?php 
				$attributes = array('class' => 'col-12'); 
				echo form_open('downloads/verdeler/' . $document_id, $attributes); 
				?>
				<div class="form-group row justify-content-between">

					<?php
					echo "<div class='form-check form-check-inline'>";
					$data = array(
						'name'          => 'verdelertype',
						'id'            => 'verdeler',
						'value'         => 'verdeler',
						'checked'       => true,
						'style'         => 'margin:10px',
						'class'			=> 'form-check-input'
					);
					echo "<label class='form-check-label' for='inlineRadio1'>Verdeler</label>";
					echo form_radio($data);
					echo "</div>";

					echo "<div class='form-check form-check-inline'>";
					$data = array(
						'name'          => 'verdelertype',
						'id'            => 'overdracht',
						'value'         => 'overdracht',
						'checked'       => false,
						'style'         => 'margin:10px'
					);
					echo "<label class='form-check-label' for='inlineRadio1'>Overdracht</label>";
					echo form_radio($data);
					echo "</div>";
					?>

				</div>

				<div class="form-group row">
					<label>Aantal Dagen <small class="text-warning">tussen 0 en 8</small></label>
					<?php 
					$data = array(
						'class' => 'form-control mb-2',
						'type' => 'text',
						'name' => 'hoeveelDagen',
						'placeholder' => 1,
						'value' => '1'
					);
					echo form_input($data); 
					?>
				</div>

				<div class="form-group row">

					<?php 
					$data = array(
						'class' => 'btn btn-primary btn-block',
						'type' => 'submit',
						'value' => 'Download'
					);
					echo form_submit($data); 
					?>
					
				</div>

				<div class="form-group row">
					<a class="btn btn-warning btn-block" href="<?php echo base_url('create_verdeler/editDocument/' . $document_id) ?>" role="button">Edit</a>
				</div>

				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>
