<h2 class="display-4 text-center pb-3"><?php echo $this->lang->line('titel'); ?></h2>
<section class="d-flex justify-content-center">

<?php 
	$attributes = array('class' => 'col-md-8'); 
	echo form_open('create_verdeler/verdeler/' . $document_id, $attributes);
	echo validation_errors();
?>
     <div class="form-group">
       <div class="form-group col-md-13">
			   <?php echo form_error('bnx'); ?>
         <label for="bnx"><?php echo $this->lang->line('bnx'); ?></label>
         <input type="text" name="bnx" class="form-control" id="bnx" placeholder="43G-0000012-002" value="<?php echo $verdelers['verdeler_bnx'] ?>">
       </div>
			 <div class="form-group col-md-13">
			   <?php echo form_error('tpo'); ?>
         <label for="tpo"><?php echo $this->lang->line('tpo'); ?></label>    
         <input type="text" name="tpo" class="form-control" id="tpo" placeholder="I-AM-SP-2020-DNS-Addendum 2" value="<?php echo $verdelers['verdeler_tpo'] ?>">
       </div>
			 <div class="row">
			 	 <div class="form-group col-md-6 col-xs-13">
				 	 <?php echo form_error('aanvangsDatum'); ?>
           <label for="aanvangsDatum"><?php echo $this->lang->line('aanvangsDatum'); ?><small class="text-info"><?php echo ' ' . $this->lang->line('datumNotatie'); ?></small></label>
           <input type="text" name="aanvangsDatum" id="aanvangsDatum" class="form-control date" placeholder="DD-MM-YYYY" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])-(0[1-9]|1[012])-[0-9]{4}" value="<?php echo $verdelers['verdeler_aanvangsDatum'] ?>">
         </div>
         <div class="form-group col-md-6 col-xs-13">
				   <?php echo form_error('aanvangUur'); ?>
				   <label for="aanvangUur"><?php echo $this->lang->line('aanvangUur'); ?><small class="text-primary"><?php echo ' ' . $this->lang->line('uurNotatie'); ?></small></label>
           <input type="time" name="aanvangUur" class="form-control" id="aanvangUur" value="<?php echo $verdelers['verdeler_aanvangUur'] ?>">
         </div>
       </div>
       <div class="row">
			   <div class="form-group col-md-6 col-xs-13">
				 	  <?php echo form_error('eindDatum'); ?>
            <label for="eindDatum"><?php echo $this->lang->line('eindDatum'); ?><small class="text-info"><?php echo ' ' . $this->lang->line('datumNotatie'); ?></small></label>
            <input type="text" name="eindDatum" id="eindDatum" class="form-control date" placeholder="DD-MM-YYYY" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])-(0[1-9]|1[012])-[0-9]{4}" value="<?php echo $verdelers['verdeler_eindDatum'] ?>">
         </div>
         <div class="form-group col-md-6 col-xs-13">
					<?php echo form_error('eindUur'); ?>
					<label for="eindUur"><?php echo $this->lang->line('eindUur'); ?><small class="text-primary"><?php echo ' ' . $this->lang->line('uurNotatie'); ?></small></label>
					<input type="time" name="eindUur" class="form-control" id="eindUur" value="<?php echo $verdelers['verdeler_eindUur'] ?>">
         </div>
			 </div>
       <div class="row">
         <div class="form-group col-md-6 col-xs-13">
				 	 <?php echo form_error('lijn'); ?>
           <label for="lijn"><?php echo $this->lang->line('lijn'); ?></label>
           <input type="text" name="lijn" class="form-control" id="lijn" placeholder="75" value="<?php echo $verdelers['verdeler_lijn'] ?>">
         </div>
         <div class="form-group col-md-6 col-xs-13">
				   <?php echo form_error('spoor'); ?>
           <label for="spoor"><?php echo $this->lang->line('spoor'); ?></label>    
           <input type="text" name="spoor" class="form-control" id="spoor" placeholder="A&B" value="<?php echo $verdelers['verdeler_spoor'] ?>">
         </div>
       </div>
       <div class="row">
         <div class="form-group col-md-6 col-xs-13">
				   <?php echo form_error('kpVan'); ?>
           <label for="kpVan"><?php echo $this->lang->line('kpVan'); ?></label>
           <input type="text" name="kpVan" class="form-control" id="kpVan" placeholder="12.010" value="<?php echo $verdelers['verdeler_kpVan'] ?>">
         </div>
         <div class="form-group col-md-6 col-xs-13">
				   <?php echo form_error('kpTot'); ?>
           <label for="kpTot"><?php echo $this->lang->line('kpTot'); ?></label>
           <input type="text" name="kpTot" class="form-control" id="kpTot" placeholder="15.250" value="<?php echo $verdelers['verdeler_kpTot'] ?>">
         </div>
       </div>
       <div class="form-group col-md-13">
			   <?php echo form_error('gevallen'); ?>
         <label for="gevallen"><?php echo $this->lang->line('gevallen'); ?></label>    
         <input type="text" name="gevallen" class="form-control" id="gevallen" placeholder="29210, 29220, 292230" value="<?php echo $verdelers['verdeler_gevallen'] ?>">
       </div>
       <div class="form-group col-md-13">
			   <?php echo form_error('uiterstePalen'); ?>
         <label for="uiterstePalen"><?php echo $this->lang->line('uiterstePalen'); ?></label>    
         <input type="text" name="uiterstePalen" class="form-control" id="uiterstePalen" placeholder="Sp A: 13/20 & 15/15 en Sp B: 14/20 & 16/15" value="<?php echo $verdelers['verdeler_uiterstePalen'] ?>">
       </div>
       <div class="form-group col-md-13" >
			   <?php echo form_error('geplaatstePalen'); ?>
         <label for="geplaatstePalen"><?php echo $this->lang->line('geplaatstePalen'); ?></label>    
         <input type="text" name="geplaatstePalen" class="form-control" id="geplaatstePalen" placeholder="Sp A: 13/20 & 15/15 en Sp B: 14/20 & 16/15" value="<?php echo $verdelers['verdeler_geplaatstePalen'] ?>">
			 </div>
     </div>
     <input type="submit" class="btn btn-primary btn-block"><br><br>
     </form>

		 <script src="<?php echo base_url('assets/js/date-format.js') ?>"></script>
