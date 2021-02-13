<?php
	function issetor(&$var, $default = '') {
    return isset($var) ? $var : $default;
}
?>

<h2 class="display-4 text-center pb-3"><?php echo $this->lang->line('titel'); ?></h2>
<section class="d-flex justify-content-center">
<?php 
	$attributes = array('class' => 'col-md-8'); 
	echo form_open('create_s505/s505/' . $document_id, $attributes); 
?>
     <div class="form-group">
       <div class="row">
         <div class="form-group col-md-6 col-xs-13">
           <label for="houderS627"><?php echo $this->lang->line('houderS627'); ?></label>
           <input type="text" name="houderS627" class="form-control" id="houderS627" placeholder="John Doe" value="<?php echo issetor($houderS627); ?>">
         </div>
         <div class="form-group col-md-6 col-xs-13">
           <label for="verantwoordelijkebss"><?php echo $this->lang->line('verantwoordelijkeBss'); ?></label>
           <input type="text" name="verantwoordelijkeBss" class="form-control" id="verantwoordelijkeBss" placeholder="Pieter-Jan Casteels" value="<?php echo issetor($verantwoordelijkeBss); ?>">
         </div>
       </div>
       <div class="form-group col-md-13 col-xs-13">
           <label for="gevallen"><?php echo $this->lang->line('gevallen'); ?></label>
           <input type="text" name="gevallen" class="form-control" id="gevallen" placeholder="29450, 29451, 29452, ..." value="<?php echo issetor($gevallen); ?>">
       </div>
       <div class="row">
         <div class="form-group col-md-4 col-xs-13">
           <label for="lijn"><?php echo $this->lang->line('lijn'); ?></label>
           <input type="text" name="lijn1" class="form-control" id="lijn1" placeholder="L75" value="<?php echo issetor($lijn1); ?>">
         </div>
         <div class="form-group col-md-2 col-xs-13">
           <label for="spoor"><?php echo $this->lang->line('spoor'); ?></label>
           <input type="text" name="spoor1" class="form-control" id="spoor1" placeholder="A" value="<?php echo issetor($spoor1); ?>">
         </div>
         <div class="form-group col-md-3 col-xs-13">
           <label for="ap"><?php echo $this->lang->line('ap'); ?></label>
           <input type="text" name="ap1" class="form-control" id="ap1" placeholder="25.000" value="<?php echo issetor($ap1); ?>">
         </div>
         <div class="form-group col-md-3 col-xs-13">
           <label for="ap"><?php echo $this->lang->line('ap'); ?></label>
           <input type="text" name="ap2" class="form-control" id="ap2" placeholder="25.001" value="<?php echo issetor($ap2); ?>">
         </div>
       </div>
       <div class="row">
         <div class="form-group col-md-4 col-xs-13">
           <label for="lijn"><?php echo $this->lang->line('lijn'); ?></label>
           <input type="text" name="lijn2" class="form-control" id="lijn2" placeholder="L75" value="<?php echo issetor($lijn2); ?>">
         </div>
         <div class="form-group col-md-2 col-xs-13">
           <label for="spoor"><?php echo $this->lang->line('spoor'); ?></label>
           <input type="text" name="spoor2" class="form-control" id="spoor2" placeholder="B" value="<?php echo issetor($spoor2); ?>">
         </div>
         <div class="form-group col-md-3 col-xs-13">
           <label for="ap"><?php echo $this->lang->line('ap'); ?></label>
           <input type="text" name="ap3" class="form-control" id="ap3" placeholder="25.000" value="<?php echo issetor($ap3); ?>">
         </div>
         <div class="form-group col-md-3 col-xs-13">
           <label for="ap"><?php echo $this->lang->line('ap'); ?></label>
           <input type="text" name="ap4" class="form-control" id="ap4" placeholder="25.001" value="<?php echo issetor($ap4); ?>">
         </div>
       </div>
       <div class="form-group col-md-13 col-xs-13">
           <label for="tpoBnx"><?php echo $this->lang->line('tpoBnx'); ?></label>
           <input type="text" name="tpoBnx" class="form-control" id="tpoBnx" placeholder="TPO of BNX" value="<?php echo issetor($tpoBnx); ?>">
       </div>
		
       <div class="row">
         <div class="form-group col-md-6 col-xs-13">
				 	 <?php echo form_error('eindDatum'); ?>
           <label for="eindDatum"><?php echo $this->lang->line('eindDatum'); ?><small class="text-info"><?php echo ' ' . $this->lang->line('datumNotatie'); ?></small></label>
           <input type="text" name="eindDatum" id="eindDatum" class="form-control date" placeholder="DD-MM-YYYY" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])-(0[1-9]|1[012])-[0-9]{4}" value="<?php echo issetor($eindDatum); ?>">
         </div>
         <div class="form-group col-md-6 col-xs-13">
				 	 <?php echo form_error('eindUur'); ?>
           <label for="eindUur"><?php echo $this->lang->line('eindUur'); ?><small class="text-info"><?php echo ' ' . $this->lang->line('uurNotatie'); ?></small></label>
           <input type="time" name="eindUur" class="form-control" id="eindUur" value="<?php echo issetor($eindUur); ?>">
         </div>
			 </div>
     </div>
     <input type="submit" class="btn btn-primary btn-block"><br><br>
   </form>
 </div>
<script src="<?php echo base_url('assets/js/date-format.js') ?>"></script>
</section>
