<style>
    body {
        background-color: #111; /* Dark background color */
        color: #fff; /* Light text color */
    }

    .card {
		background-color: #222;
		color: #fff;
	}

    .form-control {
        background-color: #333; /* Dark input background color */
        color: #fff; /* Light input text color */
    }
</style>

<?php echo $this->Html->css('form'); ?>
<?php echo $this->element('navbar'); ?>

<body>
<div class="container d-flex justify-content-center mt-5">
    <div class="card" style="width:100vh;">
            <h2 class="card-title text-center m-4">Update Email</h2>
        <div class="card-body">
            <?php if ($this->Session->check('Message.error')): ?>
                <div class="alert alert-danger">
                    <?php echo $this->Session->flash('error'); ?>
                </div>
            <?php endif;?>
            <?php if ($this->Session->check('Message.success')): ?>
                <div class="alert alert-success">
                    <?php echo $this->Session->flash('success'); ?>
                </div>
            <?php endif;?>

            <?php
                echo $this->Form->create('User'); 
                echo $this->Form->input('email', array('readonly', 'label' => 'Current Email', 'style' => 'background-color: #333; color: #fff;', 'class' => 'form-control', 'div' => array('class' => 'form-group')));
                echo $this->Form->input('new_email', array('value' => '', 'type' => 'email', 'style' => 'background-color: #333; color: #fff;', 'class' => 'form-control', 'div' => array('class' => 'form-group')));
                echo $this->Form->submit('Update Email', array('class' => 'btn btn-secondary btn-block mt-4','style' => 'width: auto'));
                echo $this->Form->end();
            ?>
        </div>
    </div>
</div>
</body>
<?php echo $this->element('footer'); ?>