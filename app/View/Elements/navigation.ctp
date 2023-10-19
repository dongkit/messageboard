<nav class="navbar navbar-expand-lg bg-dark px-5">
	<h4>
	<?php echo $this->Html->link('Message Board', array('controller' => 'users', 'action' => 'index'), array('style' => 'text-decoration: none; color: #fff;')); ?>
	</h4>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03"
		aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>

	<?php if(AuthComponent::user()): ?>

		<div class="collapse navbar-collapse" id="navbarTogglerDemo03">
			<ul class="navbar-nav ml-auto m-4">
				<li class="nav-item mr-4">
					<?= $this->Html->link('Home', ['controller' => 'users', 'action' => 'home'], ['class' => 'nav-link text-light']);
					?>
				</li>
				<li class="nav-item mr-4">
					<?= $this->Html->link('Profile', ['controller' => 'users', 'action' => 'profile', AuthComponent::user('id')], ['class' => 'nav-link text-light']);
					?>
				</li>
				<li class="nav-item mr-4">
					<?= $this->Html->link('Update', ['controller' => 'users', 'action' => 'edit'], ['class' => 'nav-link text-light']);
					?>
				</li>
				<li class="nav-item mr-4">
					<?= $this->Html->link('Messages', ['controller' => 'messages', 'action' => 'index'], ['class' => 'nav-link text-light']);
					?>
				</li>
			</ul>
			<div class="dropdown">
				<button class="btn btn-outline-light dropdown-toggle" type="button" id="dropdownMenuButton"
					data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				</button>

				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton"  style="color:#fff; background-color:#999;">
					<?php
						echo $this->Html->link('Profile', array('controller' => 'users', 'action' => 'profile', AuthComponent::user('id')), array('class' => 'dropdown-item', 'style' => 'text-decoration: none; color: black;'));
						echo $this->Html->link('Update Profile', array('controller' => 'users', 'action' => 'edit'), array('class' => 'dropdown-item', 'style' => 'text-decoration: none; color: black;'));
						echo $this->Html->link('Update Email', array('controller' => 'users', 'action' => 'email'), array('class' => 'dropdown-item', 'style' => 'text-decoration: none; color: black;'));
						echo $this->Html->link('Update Password', array('controller' => 'users', 'action' => 'password'), array('class' => 'dropdown-item', 'style' => 'text-decoration: none; color: black;'));
					?>
					<hr>
					<?php echo $this->Html->link('Logout', array('controller' => 'users', 'action' => 'logout'), array('class' => 'dropdown-item')); ?>
				</div>
			</div>
		</div>

	<?php endif; ?>

</nav>