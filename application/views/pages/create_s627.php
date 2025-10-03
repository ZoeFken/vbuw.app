<?php
	// echo '<pre>';
	// var_dump($this->session->all_userdata()); 
	// var_dump($this->session->user_id);
	// echo '</pre>';
?>

<h2 class="display-4 text-center pb-3"><?php echo $this->lang->line('titel'); ?></h2>
<section class="d-flex justify-content-center">
<?php 
	$attributes = array('class' => 'col-md-8'); 
	echo form_open('create_s627/s627', $attributes); 
?>
     <div class="form-group">
       <div class="row">
        <div class="form-group col-md-12">
           <label for="documentNaam"><?php echo $this->lang->line('documentNaam'); ?></label>
           <input type="text" name="documentNaam" class="form-control" id="documentNaam" placeholder="L75 SP A&B Deinze - Waregem" value="<?php echo set_value('documentNaam'); ?>">
         </div>
         <div class="form-group col-md-8 col-xs-13">
           <label for="ingediendDoor"><?php echo $this->lang->line('ingediendDoor'); ?></label>
           <input type="text" name="ingediendDoor" class="form-control" id="ingediendDoor" placeholder="Pieter-Jan Casteels" value="<?php echo set_value('ingediendDoor'); ?>">
         </div>
         <div class="form-group col-md-4 col-xs-13">
           <label for="specialiteit"><?php echo $this->lang->line('specialiteit'); ?></label>
           <input type="text" name="specialiteit" class="form-control" id="specialiteit" placeholder="specialiteit" value="<?php echo set_value('specialiteit'); ?>">
         </div>
       </div>
       <div class="form-group col-md-13">
         <label for="aan"><?php echo $this->lang->line('aan'); ?></label>
         <input type="text" name="aan" class="form-control" id="aan" placeholder="John Doe" value="<?php echo set_value('aan'); ?>">
       </div>
       <div class="row">
         <div class="form-group col-md-6 col-xs-13">
           <label for="post"><?php echo $this->lang->line('post'); ?></label>
           <input type="text" name="post" class="form-control" id="post" placeholder="Blok 6" value="<?php echo set_value('post'); ?>">
         </div>
         <div class="form-group col-md-6 col-xs-13">
           <label for="station"><?php echo $this->lang->line('station'); ?></label>
           <input type="text" name="station" class="form-control" id="station" placeholder="Gent-Sint-Pieters" value="<?php echo set_value('station'); ?>">
         </div>
			 </div>
       <div class="form-group col-md-13">
         <label for="aanvraag"><?php echo $this->lang->line('aanvraag'); ?></label>
         <textarea name="aanvraag" class="form-control" rows="6" id="aanvraag" placeholder="...uw aanvraag hier..."><?php echo set_value('aanvraag'); ?></textarea>
			 </div>
			 <div class="form-group col-md-13">
			 	 <?php echo form_error('vermoedelijkeDuur'); ?>
         <label for="vermoedelijkeDuur"><?php echo $this->lang->line('vermoedelijkeDuur'); ?><small class="text-info"><?php echo ' ' . $this->lang->line('uurNotatie'); ?></small></label>
         <input type="text" name="vermoedelijkeDuur" class="form-control" id="vermoedelijkeDuur" placeholder="05:00" value="<?php echo set_value('vermoedelijkeDuur'); ?>">
       </div>
       <div class="form-group col-md-13">
         <label for="rubriek2ARMS"><?php echo $this->lang->line('rubriek2ARMS'); ?></label>
         <textarea name="rubriek2ARMS" class="form-control" rows="3" id="rubriek2ARMS" placeholder="...uw rmsen hier..."><?php echo set_value('rubriek2ARMS'); ?></textarea>
       </div>
       <div class="form-group col-md-13">
         <label for="rubriek2AAndere"><?php echo $this->lang->line('rubriek2AAndere'); ?></label>
         <textarea name="rubriek2AAndere" class="form-control" rows="3" id="rubriek2AAndere" placeholder="...uw andere hier..."><?php echo set_value('rubriek2AAndere'); ?></textarea>
			 </div>
			 <div class="form-group col-md-13">
         <label for="rubriek5VVHW"><?php echo $this->lang->line('rubriek5VVHW'); ?></label>
         <textarea name="rubriek5VVHW" class="form-control" rows="3" id="rubriek5VVHW" placeholder="...voltooiing van het werk..."><?php echo set_value('rubriek5VVHW'); ?></textarea>
			 </div>
       <div class="row">
         <div class="form-group col-md-6 col-xs-13">
				 	<?php echo form_error('aanvangDatum'); ?>
          <label for="aanvangDatum"><?php echo $this->lang->line('aanvangDatum'); ?><small class="text-info"><?php echo ' ' . $this->lang->line('datumNotatie'); ?></small></label>
          <input type="text" name="aanvangDatum" id="aanvangDatum" class="form-control date" placeholder="DD-MM-YYYY" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])-(0[1-9]|1[012])-[0-9]{4}">
         </div>
         <div class="form-group col-md-6 col-xs-13">
				   <?php echo form_error('aanvangUur'); ?>
           <label for="aanvangUur"><?php echo $this->lang->line('aanvangUur'); ?><small class="text-info"><?php echo ' ' . $this->lang->line('uurNotatie'); ?></small></label>
           <input type="time" name="aanvangUur" class="form-control" id="aanvangUur" value="<?php echo set_value('aanvangUur'); ?>">
         </div>
       </div>
       <div class="row">
         <div class="form-group col-md-6 col-xs-13">
				 	 <?php echo form_error('eindDatum'); ?>
           <label for="eindDatum"><?php echo $this->lang->line('eindDatum'); ?><small class="text-info"><?php echo ' ' . $this->lang->line('datumNotatie'); ?></small></label>
           <input type="text" name="eindDatum" id="eindDatum" class="form-control date" placeholder="DD-MM-YYYY" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])-(0[1-9]|1[012])-[0-9]{4}">
         </div>
         <div class="form-group col-md-6 col-xs-13">
				 	 <?php echo form_error('eindUur'); ?>
           <label for="eindUur"><?php echo $this->lang->line('eindUur'); ?><small class="text-info"><?php echo ' ' . $this->lang->line('uurNotatie'); ?></small></label>
           <input type="time" name="eindUur" class="form-control" id="eindUur" value="<?php echo set_value('eindUur'); ?>">
         </div>
			 </div>
     </div>
     <input type="submit" class="btn btn-primary btn-block"><br><br>
   </form>
 </div>

<script>
	// Script voor het uitschakelen van sommige velden bij ingave vermoedelijke duur.
	let vermoedelijkeDuur = document.getElementById("vermoedelijkeDuur");
	let eindDatum = document.getElementById("eindDatum");
	let eindUur = document.getElementById("eindUur");

	vermoedelijkeDuur.onkeyup = function(){
	if(vermoedelijkeDuur.value !== ""){
		eindDatum.disabled = true;
		eindUur.disabled = true;
	}else{
		eindDatum.disabled = false;
		eindUur.disabled = false;
	}
};
</script>
<script src="<?php echo base_url('assets/js/date-format.js') ?>"></script>
</section>
