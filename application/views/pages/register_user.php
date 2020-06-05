<h2 class="display-4 text-center pb-3"><?php echo $this->lang->line('titel'); ?></h2>
<div class="d-flex justify-content-center">
<?php 
	$attributes = array('class' => 'col-8'); 
	echo form_open('register/register', $attributes); 
	echo validation_errors();
?>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label dark-blue"><?php echo $this->lang->line('email'); ?></label>
        <div class="col-sm-10">
            <?php 
            $data = array(
                'class' => 'form-control',
                'type' => 'email',
                'name' => 'email',
                'placeholder' => $this->lang->line('email')
            );
            echo form_input($data); 
            ?>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label dark-blue"><?php echo $this->lang->line('name'); ?></label>
        <div class="col-sm-10">
            <?php 
            $data = array(
                'class' => 'form-control',
                'type' => 'text',
                'name' => 'name',
                'placeholder' => $this->lang->line('name')
            );
            echo form_input($data); 
            ?>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label dark-blue"><?php echo $this->lang->line('firstname'); ?></label>
        <div class="col-sm-10">
            <?php 
            $data = array(
                'class' => 'form-control',
                'type' => 'text',
                'name' => 'firstname',
                'placeholder' => $this->lang->line('firstname')
            );
            echo form_input($data); 
            ?>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('language'); ?></label>
        <div class="col-sm-10">
            <?php 
            $directory = dirname(dirname(dirname(__FILE__))) . '/language';
            $optionsNoVlaue = array_diff(scandir($directory), array('..', '.', 'index.html'));
            $options = array_combine($optionsNoVlaue, $optionsNoVlaue);

            $data = array(
                'class' => 'form-control',
                'name' => 'language'
            );
            echo form_dropdown($data, $options); 
            ?>
        </div>
    </div>

    <?php
    // checkboxes
    if($this->authorize->checkAllow(CREATEADMIN))
    {
        // Klant
        echo "<div class='form-group'>";
        $data = array(
            'name'          => 'clientadmin',
            'id'            => 'client',
            'value'         => 'USER',
            'checked'       => true,
            'style'         => 'margin:10px'
        );
        echo $this->lang->line('client');
        echo form_radio($data);
        echo "</div>";

        // Admin
        echo "<div class='form-group'>";
        $data = array(
            'name'          => 'clientadmin',
            'id'            => 'admin',
            'value'         => 'ADMIN',
            'checked'       => false,
            'style'         => 'margin:10px'
        );
        echo $this->lang->line('admin');;
        echo form_radio($data);

        // Create Admin
        $data = array(
            'name'          => 'createadmin',
            'id'            => 'createadmin',
            'value'         => 'createadmin',
            'checked'       => false,
            'style'         => 'margin:10px'
        );
        echo $this->lang->line('create_admin');
        echo form_checkbox($data);
        echo "</div>";
    }
    ?>

    <div class="form-group row">
        <?php 
        $data = array(
            'class' => 'btn btn-primary btn-block',
            'type' => 'submit',
            'value' => $this->lang->line('create')
        );
        echo form_submit($data); 
        ?>
    </div>
    <?php echo form_close(); ?>   
</div>
