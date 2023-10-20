<?php echo $this->Html->css('form'); ?>

<section class="vh-100 bg-image" style="background-color: #222; color: #fff;">
    <div class="mask d-flex align-items-center h-100 gradient-custom-3">
        <div class="container h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-md-9 col-lg-7">
                    <div class="card" style="background-color: #333;">
                        <div class="card-body p-4">
                            <h2 class="text-center mb-3">Registration</h2>

                            <?php
                            echo $this->Form->create('User');
                            echo $this->Form->input('name', [
                                'label' => 'Full Name',
                                'class' => 'form-control form-control-lg mb-3',
                                'style' => 'background-color: #444; color: #fff;',
                            ]);
                            echo $this->Form->input('email', [
                                'label' => 'Email',
                                'class' => 'form-control form-control-lg mb-3',
                                'style' => 'background-color: #444; color: #fff;',
                            ]);
                            echo $this->Form->input('password', [
                                'label' => 'Password',
                                'class' => 'form-control form-control-lg mb-3',
                                'style' => 'background-color: #444; color: #fff;',
                            ]);
                            echo $this->Form->input('confirm_password', [
                                'label' => 'Confirm password',
                                'type' => 'password',
                                'class' => 'form-control form-control-lg mb-4',
                                'style' => 'background-color: #444; color: #fff; width: 100%;',
                            ]);
                            ?>

						<?php echo $this->Form->button('Register', array('class' => 'btn btn-secondary btn-block mb-3 py-2')); ?>


                            <p class="text-center text-muted mt-3">
                                Already have an account?
                                <?php echo $this->Html->link('Login', ['controller' => 'Users', 'action' => 'login'], ['style' => 'color:#fff;']); ?>
                            </p>
                            <?php echo $this->Form->end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function () {
        $('#UserConfirmPassword').on('change', function () {
            var password = $('#UserPassword').val();
            var confirm_password = $(this).val();
            if (password !== confirm_password) {
                $('#confirm-password-error').show();
                $('#submitButton').attr('disabled', true);
                $('#submitButton').attr('style', 'opacity: 30%');
            } else {
                $('#confirm-password-error').hide();
                $('#submitButton').attr('disabled', false);
                $('#submitButton').attr('style', 'opacity: 100%');
            }
        });
    });
</script>
