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
</table>

<button type="button" name="add" id="add" class="btn btn-success ml-5">Voeg toe</button>

</section>

<section id="wagens">
  <div class="form-group">

    <div class="row">
      <div class="form-group form-floating col-md-8 col-xs-13">
        <label for="nrWagen"><?php echo $this->lang->line('nrWagen'); ?></label>
        <input type="text" name="nrWagen" class="form-control" id="nrWagen" placeholder="808811111111" value="<?php echo set_value('nrWagen'); ?>">
      </div>
      <div class="form-group col-md-4 col-xs-13">
        <label for="volgNummer"><?php echo $this->lang->line('volgNummer'); ?></label>
        <input type="text" name="volgNummer" class="form-control" id="volgNummer" placeholder="123456" value="<?php echo set_value('volgNummer'); ?>">
      </div>
    </div>

    <div class="row">
      <div class="form-group col-md-6 col-xs-13">
        <label for="lengte"><?php echo $this->lang->line('lengte') ?> <small class="text-info"><?php echo $this->lang->line('dm'); ?></small></label>
        <input type="text" name="lengte" class="form-control" id="lengte" placeholder="147" value="<?php echo set_value('lengte'); ?>">
      </div>
      <div class="form-group col-md-6 col-xs-13">
        <label for="handrem"><?php echo $this->lang->line('handrem'); ?> <small class="text-info"><?php echo $this->lang->line('geenHandrem'); ?></small></label>
        <input type="text" name="handrem" class="form-control" id="handrem" placeholder="0" value="<?php echo set_value('handrem'); ?>">
      </div>
    </div>

    <div class="row">
      <div class="form-group col-md-6 col-xs-13">
        <label for="tarra"><?php echo $this->lang->line('tarra'); ?> <small class="text-info"><?php echo $this->lang->line('dg'); ?></small></label>
        <input type="text" name="tarra" class="form-control" id="tarra" placeholder="220" value="<?php echo set_value('tarra'); ?>">
      </div>
      <div class="form-group col-md-6 col-xs-13">
        <label for="netto"><?php echo $this->lang->line('netto'); ?> <small class="text-info"><?php echo $this->lang->line('dg'); ?></small></label>
        <input type="text" name="netto" class="form-control" id="netto" placeholder="0" value="<?php echo set_value('netto'); ?>">
      </div>
    </div>

    <div class="row">
      <div class="form-group col-md-6 col-xs-13">
        <label for="alternator"><?php echo $this->lang->line('alternator') ?></label>
        <select class="form-control">
          <option><?php echo $this->lang->line('alternatorAuto') ?></option>
          <option><?php echo $this->lang->line('alternatorLedigBeladen') ?></option>
          <option><?php echo $this->lang->line('alternatorGeen') ?></option>
        </select>
      </div>
      <div class="form-group col-md-6 col-xs-13">
        <label for="max"><?php echo $this->lang->line('max'); ?> <small class="text-info"><?php echo $this->lang->line('ton'); ?></small></label>
        <input type="text" name="max" class="form-control" id="max" placeholder="47" value="<?php echo set_value('max'); ?>">
      </div>
    </div>

    <div class="row">
      <div class="form-group col-md-6 col-xs-13">
        <label for="omschakel"><?php echo $this->lang->line('omschakel') ?> <small class="text-info"><?php echo $this->lang->line('ton'); ?></small></label>
        <input type="text" name="omschakel" class="form-control" id="omschakel" placeholder="0" value="<?php echo set_value('omschakel'); ?>">
      </div>
      <div class="form-group col-md-6 col-xs-13">
        <label for="min"><?php echo $this->lang->line('min'); ?> <small class="text-info"><?php echo $this->lang->line('ton'); ?></small></label>
        <input type="text" name="min" class="form-control" id="min" placeholder="0" value="<?php echo set_value('min'); ?>">
      </div>
    </div>

  </div>
</section>

<script src="<?php echo base_url('assets/js/remming.js'); ?>"></script>