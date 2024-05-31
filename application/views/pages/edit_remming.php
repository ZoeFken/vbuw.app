<h2 class="display-4 text-center pb-3"><?php echo $this->lang->line('titel'); ?></h2>
<section class="d-flex justify-content-center float-right">
  <button class="btn btn-primary" data-toggle="modal" data-target="#remming_upload_modal">Upload rebu</button>
  <?php
    $this->load->view('modals/remming_upload_modal');
  ?>
</section>
<?php echo validation_errors(); ?>
<section>
<table id="remming" class="table table-hover">
  <thead class="thead-light">
    <tr>
      <th></th>
      <th><?php echo $this->lang->line('nrWagen'); ?></th>
      <th><?php echo $this->lang->line('lengte'); ?></th>
      <th><?php echo $this->lang->line('massa'); ?></th>
      <th><?php echo $this->lang->line('dg'); ?></th>
      <th>&nbsp;</th>
      <th><?php echo $this->lang->line('handrem'); ?></th>
      <th><?php echo $this->lang->line('alternator'); ?></th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>OGPA</th>
    </tr>
    <tr>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th><?php echo $this->lang->line('dm'); ?></th>
      <th><?php echo $this->lang->line('netto'); ?></th>
      <th><?php echo $this->lang->line('tarra'); ?></th>
      <th><?php echo $this->lang->line('totaal'); ?></th>
      <th><?php echo $this->lang->line('ton'); ?></th>
      <th><?php echo $this->lang->line('min'); ?></th>
      <th><?php echo $this->lang->line('omschakel'); ?></th>
      <th><?php echo $this->lang->line('max'); ?></th>
      <th><?php echo $this->lang->line('alterType'); ?></th>
    </tr>
  </thead>
  <tbody>
  <?php 
  if(isset($wagens)):
    foreach($wagens as $wagen):?>
    <tr class="remming_links">
      <th scope="row"><a href data-toggle="modal" data-target="#remming_edit_modal_<?php echo $wagen['wagen_id'] ?>" class="stretched-link nounderline"><?php echo $wagen['wagen_plaats'] ?></a></th>
      <td><?php echo $wagen['wagen_nummer'] ?></td>
      <td><?php echo $wagen['wagen_lengte'] ?></td>
      <td><?php echo $wagen['wagen_massa_netto'] ?></td>
      <td><?php echo $wagen['wagen_tarra'] ?></td>
      <td><?php echo $wagen['wagen_totaal'] ?></td>
      <td><?php echo $wagen['wagen_handrem'] ?></td>
      <td><?php echo $wagen['wagen_remming_min'] ?></td>
      <td><?php echo $wagen['wagen_remming_kantel'] ?></td>
      <td><?php echo $wagen['wagen_frein'] ?></td>
      <td>OGPA</td>
    </tr>
  </tbody>
<?php   endforeach; 
      endif; ?>
</table>

<button type="button" name="add" id="add" class="btn btn-success ml-5">Voeg toe</button>

</section>



<script src="<?php echo base_url('assets/js/remming.js'); ?>"></script>