<?php
// echo "<pre>";
// var_dump($this->session->all_userdata());
// var_dump($this->session->userdata('email'));
// var_dump($this->session->userdata('username'));
// echo "</pre>";
?>

<div id="login" class="row justify-content-center align-items-center">
    
        <?php $attributes = array('class' => 'w-75'); 
        echo form_open('login/authenticate', $attributes); ?>

        <?php if($this->session->tempdata('error')) : ?>
            <div class="alert alert-danger mt-2" role="alert">
                <?php echo $this->session->tempdata('error'); ?>
            </div>
        <?php endif; ?>

            <div class="text-center logo"><img class="mx-auto d-block" src="<?php echo base_url(); ?>assets/images/logo.svg" alt="Site logo"></div>

            <div class="input-group m-2">
				<div class="input-group-prepend">
					<span class="input-group-text" id="inputGroup-sizing-default"><?php echo $this->lang->line('email'); ?></span>
				</div>
                <?php 
                $data = array(
                    'id' => 'inputGroup-sizing-default',
                    'class' => 'form-control',
                    'type' => 'email',
                    'name' => 'email'
                );
                echo form_input($data); 
                ?>
            </div>

            <div class="input-group m-2">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default"><?php echo $this->lang->line('password'); ?></span>
            </div>
                <?php 
                $data = array(
                    'id' => 'inputGroup-sizing-default',
                    'class' => 'form-control',
                    'type' => 'password',
                    'name' => 'password'
                );
                echo form_password($data); 
                ?>
            </div>
            <div class="m-2">
                <?php 
                $data = array(
                    'class' => 'btn btn-primary btn-block p-2 m-2',
                    'type' => 'submit',
                    'value' => $this->lang->line('log_in')
                );
                echo form_submit($data); 
                ?>
            </div>
          <?php echo form_close(); ?>   

</div>

<?php $this->session->unset_tempdata('error'); ?>
<?php $this->session->unset_tempdata('msg'); ?>
