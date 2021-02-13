<h2 class="display-4 text-center pb-3"><?php echo $this->lang->line('titel'); ?></h2>

<section>
<table class="table">
	<thead class="thead-light">
		<tr>
			<th style="width: 40%"><?php echo $this->lang->line('aangemaakt'); ?></th>
			<th style="width: 40%"><?php echo $this->lang->line('opgemaaktDoor'); ?></th>
			<th style="width: 20%" class="text-right" ><?php echo $this->lang->line('type'); ?></th>
		</tr>
	</thead>
	</tbody>
	<?php if(!empty($documents)): 
		  foreach($documents as $document): ?>
		<tr>
			<td><?php echo $document['document_created_at']; ?></td>
			<td><?php echo $document['last_name'] . ' ' . $document['first_name']; ?></a></td>
			<td class="text-right">
				<button class="btn btn-primary" data-toggle="modal" data-target="#docmodal_<?php echo $document['document_id'] ?>"><?php echo $document['document_type']; ?></button>
				<?php if ($this->ion_auth->is_admin() || $persoonlijk === TRUE) : ?>
					<a href="<?php echo base_url('documents/removeDocument/' . $document['document_id']) ?>" class="ml-2 btn btn-danger">X</a>
				<?php endif; ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
</section>
<section id="modal">
	<?php
		foreach($documents as $document)
		{
			switch ($document['document_type'])
			{
				case 's627':
					$this->load->view('modals/s627_modal', array('document_id' => $document['document_id']));
				break;
				case 'verdeler':
					$this->load->view('modals/verdeler_modal', array('document_id' => $document['document_id']));
				break;
				case 's460':
					$this->load->view('modals/s460_modal', array('document_id' => $document['document_id']));
				break;
				case 's505':
					$this->load->view('modals/s505_modal', array('document_id' => $document['document_id']));
				break;
			}	
		}
		endif;
	?>
</section>
<script src="<?php echo base_url('assets/js/date-format.js') ?>"></script>
