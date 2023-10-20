<style>
    body {
        background-color: #111;
        color: #fff;
    }

    .card {
		background-color: #222;
		color: #fff;
	}

    #upload-label {
        display: inline-block;
        padding: 0px 15px;
        background-color: #333; /* Dark background color */
        color: #fff; /* Light text color */
        border: 1px solid rgba(255, 255, 255, 0.5);
        border-radius: 5px;
        cursor: pointer;
        text-align: center;
        font-size: 12px;
        text-decoration: none;
        margin-left: 10px;
    }
    
    form label:after {
        color: #e32;
        content: '*';
        display: inline;
    }

    label[for="photo-url"] {
        display: none;
    }

    input#photo-url {
        display: none;
    }
</style>

<?php echo $this->element('navbar'); ?>

<?php
    if (empty($user['User']['photo_url'])) {
        $photoUrl = 'https://cdn-icons-png.flaticon.com/512/1077/1077114.png';
    } else {
        $photoUrl = $this->Html->webroot($user['User']['photo_url']);
    }
?>

<div class="container d-flex justify-content-center">
	<div class="card my-5" style="width:100vh;">
        <h2 class="card-title text-center my-4">Update Profile</h2>
        <?php if ($this->Session->check('Message.error')): ?>
            <div class="alert alert-danger">
                <?php echo $this->Session->flash('error'); ?>
            </div>
        <?php endif;?>
        <?php echo $this->Form->create('User', array('type' => 'file')); ?>
        <div class="d-flex justify-content-center align-items-center" style="width: 50%; margin: 0 auto; text-align: center;">
            <img id="image-preview" src="<?php echo $photoUrl; ?>" style="max-height: 100%; border-radius: 15px; max-width: 150px;" class="form-group" />
            </div>
            <div class="d-flex justify-content-center mb-4">
                <label for="photo-url" id="upload-label">Upload Pic</label>
            </div>
            <div class="px-4">
            <?php
                echo $this->Form->input('photo_url', array('id' => 'photo-url', 'name' => 'data[User][photo_url]', 'accept' => '.jpg, .png, .gif', 'type' => 'file'));
                echo $this->Form->input('name', array('required', 'class' => 'form-control mb-3', 'style' => 'background-color: #333; color: #fff;', 'minlength' => 5, 'maxlength' => 20));
                echo $this->Form->input('birthdate', array(
                    'required',
                    'type' => 'text',
                    'class' => 'form-control datepicker mb-3',
                    'style' => 'background-color: #333; color: #fff;'
                ));
                echo $this->Form->input('gender', array('required', 'options' => array('m' => 'Male', 'f' => 'Female'), 'style' => 'background-color: #333; color: #fff;', 'class' => 'form-control mb-3'));
                echo $this->Form->input('hobby', array('required', 'style' => 'background-color: #333; color: #fff;', 'class' => 'form-control mb-3'));
                echo $this->Form->submit('Update', array('required', 'style' => 'background-color: #333; color: #fff;', 'class' => 'btn btn-secondary btn-block mb-4','style' => 'width: auto'));
                echo $this->Form->end();
            ?>
            </div>
        </div>
    </div>
</div>
<?php echo $this->element('footer'); ?>


<script>
  
  $(document).ready(function() {
    // Image preview
    $("#photo-url").change(function () {
        readURL(this);
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $("#image-preview").attr("src", e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    // date picker
    $('.datepicker').datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        yearRange: '-100:+0',
    });
  })
</script>