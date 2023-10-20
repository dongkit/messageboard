<section class="vh-100" style="background-color: #222; color: #fff;">
    <div class="mask d-flex align-items-center h-100 gradient-custom-3">
        <div class="container h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-md-9 col-lg-7">
                    <div class="card" style="background-color: #333;">
                        <div class="card-body p-4">
                            <h2 class="text-center mb-3">Message Board</h2>

                            <?php echo $this->Form->create('User'); ?>
                            <?php echo $this->Form->input('email', array('label' => 'Email', 'class' => 'form-control mb-3', 'style' => 'background-color: #444; color: #fff;')); ?>
                            <?php echo $this->Form->input('password', array('label' => 'Password', 'class' => 'form-control mb-4', 'style' => 'background-color: #444; color: #fff;')); ?>
                            <?php echo $this->Form->button('Log in', array('class' => 'btn btn-secondary btn-block mb-3 py-2')); ?>
                            <?php echo $this->Form->end(); ?>

                            <div class="d-flex align-items-center justify-content-center">
                                <p class="mb-0 me-2" style="color: #999;">Don't have an account? &nbsp</p>
                                <?php echo $this->Html->link('Register', array('controller' => 'users', 'action' => 'register'), array('style' => 'color:#fff;')); ?>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
