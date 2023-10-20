<style>
	body {
		background-color: #111; /* Dark background color */
		color: #fff; /* Light text color */
	}
	.card {
		background-color: #222;
		color: #fff;
	}
	.message-receiver-label:after {
		color: #e32;
		content: '*';
		display: inline;
	}
	.form-control {
		background-color: #333; /* Dark form background color */
		color: #fff; /* Light form text color */
	}
	.alert {
		background-color: #e32; /* Error message background color */
		color: #fff; /* Error message text color */
	}
</style>

<?php echo $this->element('navbar'); ?>

<?php echo $this->Html->css('form'); ?>


<body>
<div class="container d-flex justify-content-center">
	<div class="card my-5" style="width:100vh;">
		<h2 class="card-title text-center m-4">New Message</h2>

		<div class="card-body">
			
			<?php if ($this->Session->check('Message.error')): ?>
				<div class="alert alert-danger">
					<?php echo $this->Session->flash('error'); ?>
				</div>
			<?php endif;?>

			<div>
				<?php echo $this->Form->create('Message'); ?>
				<div hidden>
				
				<?php echo $this->Form->input('receiver', array('id' => 'receiver-id')); ?>
				</div>
				<div class="d-flex justify-content-center mt-3">
					<label class="mr-5 message-receiver-label">Receiver</label>
					<input type="text" required name="receiver_name" id="search-receiver" class="form-control" placeholder="Search receiver name ...">
				</div>
				<?php echo $this->Form->input('content', array(
						'id' => 'message-content',
						'label' => array(
							'text' => 'Message',
							'class' => 'mr-5',
						),
						'div' => array(
							'class' => 'd-flex justify-content-center mt-3'
						),
						'rows' => '5',
						'class' => 'form-control',
					));
				?>
				<?php echo $this->Form->submit('Send Message', array(
						'class' => 'btn btn-block btn-secondary',
						'style' => 'width: 150px; margin-left: 118px; margin-top: 20px'
					));
				?>
				<?php echo $this->Form->end();?>
			</div>
		</div>
	</div>
</div>
</body>

<script>
	const users = <?php echo json_encode($users); ?>;
	$(document).ready(function() {
		const availableUsers = [];
		users.forEach((user) => {
			availableUsers.push({
			id: user.User.id,
			label: user.User.name,
			photo_url: user.User.photo_url 
				? '/messageboard/' + user.User.photo_url 
				: 'https://cdn-icons-png.flaticon.com/512/1077/1077114.png',
			})
		})
		$("#search-receiver").autocomplete({
			source: availableUsers,
			minLength: 1,
			select: function(event, ui) {
				$('#receiver-id').val(ui.item.id);
			},
			focus: function (event, ui) {
				event.preventDefault();
			},
			open: function (event, ui) {

			}
		}).data('ui-autocomplete')._renderItem = function (ul, item) {
			return $('<li>')
				.append('<div class="d-block text-decoration-none"><img style="width: 60px; max-height: 60px; border-radius: 10%; margin-right: 5px" src="' + item.photo_url + '"/><span>' + item.label + '</span></div>')
				.appendTo(ul);
		};
	});

</script>