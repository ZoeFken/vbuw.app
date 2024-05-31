<!-- Modal -->
<div class="modal fade" id="remming_edit_modal_<?php echo $wagen_id ?>" tabindex="-1" role="dialog" aria-labelledby="documentModal" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="documentModalLabel">Edit wagen: <?php echo $wagen_nummer ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
		
			<div class="modal-body d-flex justify-content-center">
            <?php 
                $attributes = array('class' => 'col-md-8'); 
                echo form_open('create_s627/s627', $attributes); 
            ?>
                <div class="form-group">
                    <div class="row">
                        <div class="form-group col-md-6 col-xs-13">
                            <label for="post"><?php echo $this->lang->line('loco'); ?></label>
                            <input type="checkbox" name="locomotief" class="form-control" id="loco" value="loco" 
                            <?php 
                                if($wagen_plaats == '0')
                                echo 'checked'; 
                            ?>>
                        </div>
                        <div class="form-group col-md-6 col-xs-13">
                        <label for="post"><?php echo $this->lang->line('nrWagen'); ?></label>
                            <input type="text" name="wagen_nummer" class="form-control" value="<?php echo $wagen_nummer ?>">
                        </div>
                    </div>
                </form>
                    <div class="form-group col-md-13">
                        <table>
                            <tr>
                                <td><?php echo $wagen_plaats ?></td>
                                <td><?php echo $wagen_nummer ?></td>
                                <td><?php echo $wagen_lengte ?></td>
                                <td><?php echo $wagen_massa_netto ?></td>
                                <td><?php echo $wagen_tarra ?></td>
                                <td><?php echo $wagen_totaal ?></td>
                                <td><?php echo $wagen_handrem ?></td>
                                <td><?php echo $wagen_remming_min ?></td>
                                <td><?php echo $wagen_remming_kantel ?></td>
                                <td><?php echo $wagen_frein ?></td>
                                <td>OGPA</td>
                            </tr>
                        </table>
                    </div>
                </div>
			</div>
            <div class="modal-body d-flex justify-content-center">
                <button class="prev btn btn-primary mr-1">Prev</button>
                <button class="save btn btn-primary">Save</button>
                <button class="next btn btn-primary ml-1">Next</button>
            </div>
		</div>
	</div>
</div>
