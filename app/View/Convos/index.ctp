<style>
	body {
		background-color: #111; /* Dark background color */
		color: #fff; /* Light text color */
	}
    .card {
		background-color: #222;
		color: #fff;
	}
	.message-left {
		text-align: left;
	}
	.message-right {
		text-align: right;
	}
	.ellipsis {
		white-space: nowrap;
		overflow: hidden;
		text-overflow: ellipsis;
	}
	.delete-link {
		display: none;
		position: absolute;
		background: lightGray;
		padding: 10px;
		border-radius: 5px;
	}
	.delete-link.open {
		display: block;
	}
	#show-more {
		color: blue;
		cursor: pointer;
	}
	#show-more:hover {
		text-decoration: underline;
	}
</style>

<?php echo $this->element('navbar'); ?>

<body>
<div class="container mt-5">
	<div class="d-flex my-4">
		<?php echo $this->Html->link('Back', array(
			'controller' => 'users',
			'action' => 'index',
		),
		array(
			'class' => 'btn btn-secondary btn-sm mr-2',
		));
		?>
	</div>
	
	<div class="card">
		<?php if ($this->Session->check('Message.error')): ?>
		<div class="alert alert-danger">
			<?php echo $this->Session->flash('error'); ?>
		</div>
		<?php endif;?>

		<div class="card-body">
			<?php if (count($convos) === 0): ?>
				<p class="text-muted text-center" style="font-size: 12px">-- No Messages Yet --</p>
			<?php endif; ?>
			<p class="text-muted text-center no-messages-text" style="font-size: 12px"></p>
			<div class="message-convo">
				<?php foreach ($convos as $convo): ?>
					<?php $photoUrl = $convo['User']['photo_url']
						? '/messageboard/' . $convo['User']['photo_url']
						: 'https://cdn-icons-png.flaticon.com/512/1077/1077114.png';
					?>
					<?php
						$isConvoUserEqualToAuthUser = $convo['User']['id'] === AuthComponent::user('id') ? true : false;
					?>
					<div class="d-flex align-items-center p-2 <?php echo $isConvoUserEqualToAuthUser ? 'justify-content-end message-right' : 'message-left flex-row-reverse justify-content-end'; ?>" id="convo-container-<?php echo $convo['Convo']['id']; ?>">
						<span class="mr-2"><?php echo $convo['Convo']['reply']; ?></span>
						<img class="<?php echo !$isConvoUserEqualToAuthUser ? 'mr-2' : ''; ?>" src="<?php echo $photoUrl; ?>" width="35" height="35" style="border-radius: 50%" />
						<div class="ellipsis">
							<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 16 16">
								<g transform="rotate(-90 8 8)">
									<path fill="gray" d="M3 9.5a1.5 1.5 0 1 1 0-3a1.5 1.5 0 0 1 0 3zm5 9.5a1.5 1.5 0 1 1 0-3a1.5 1.5 0 0 1 0 3zm5 9.5a1.5 1.5 0 1 1 0-3a1.5 1.5 0 0 1 0 3z" />
								</g>
							</svg>
							<a href="#" class="delete-link" data-convo_id="<?php echo $convo['Convo']['id']; ?>">Delete</a>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<?php if (count($convos) >= 4): ?>
				<div class="text-center mb-2 mt-5">
					<a id="show-more" data-offset="4" style="color:#fff">Show More</a>
				</div>
			<?php endif; ?>
		</div>
		<div class="card-header">
			<form name="reply-form" id="reply-form">
				<div class="d-flex">
					<input type="text" id="reply-input" name="reply" class="form-control" placeholder="Reply..." style="width: 100%; background-color: #333; color:#fff;">
					<button type="submit" class="btn ml-2" style ="background-color: #999; color:#111;"> Send </button>&nbsp
					<button class="btn btn-sm" id="delete-btn" style ="background-color: #111; color:#999;">Delete</button>
				</div>
			</form>
		</div>
	</div>
</div>
</body>
<?php echo $this->element('footer'); ?>

<script>
	const messageData = <?php echo json_encode($messageData); ?>;
	const authId = <?php echo json_encode(AuthComponent::user('id')); ?>;

	if (authId === messageData.user_id) {
		receiver_id = messageData.receiver_id;
	} else {
		receiver_id = messageData.user_id;
	}

	$(document).ready(function() {
		$('#reply-form').on('submit', function(e) {
			e.preventDefault();
			const reply = $('#reply-input').val();
			$.ajax({
				url: '/messageboard/convos/reply',
				type: 'POST',
				data: { 
					reply, 
					user_id: authId,
					message_id: messageData.message_id,
					receiver_id: receiver_id
				},
				dataType: 'json',
				success: function(data) {
					window.location.href = data.url + messageData.message_id;
				},
				error: function(data) {
					console.log(data);
				}
			})
		})

		// delete main message
		$('#delete-btn').on('click', function() {
			$.ajax({
				url: '/messageboard/messages/delete/' + messageData.message_id,
				type: 'POST',
				dataType: 'json',
				success: function(data) {
					$('.container').fadeOut(1000, function() {
						window.location.href = '/messageboard/users/index';
					})
				},
				error: function(data) {
					console.log(data);
				}
			})
		})

		// delete per convo
		$('.container').on('click' , '.ellipsis', function(e) {
			e.preventDefault();
			const deleteLink = $(this).find('.delete-link');
			const allDeleteLinkOpen = ($('.ellipsis').find('.delete-link.open')).toArray()

			if (deleteLink.hasClass('open')) {
				deleteLink.removeClass('open');
			} else {
				deleteLink.addClass('open');
			}
			// remove other deleteLink
			allDeleteLinkOpen.forEach(item => {
				$(item).removeClass('open');
			})
		})
		$('.container').on('click', '.delete-link', function(e) {
			e.preventDefault();
			const convo_id = $(this).data('convo_id');
			$.ajax({
				url: '/messageboard/convos/delete/' + convo_id,
				type: 'POST',
				dataType: 'json',
				success: function(data) {
					const convoContainer = $('#convo-container-' + convo_id);
					$(convoContainer)
					.fadeOut('slow', function() {
						$(this).remove();
						const convoCount = $('.message-convo').children().length;
						if (convoCount === 0) {
							$('.no-messages-text').text('-- No Messsages Yet --');
						}
					})
				},
				error: function(data) {
					console.log(data);
				}
			})
		})

		// Show more pagination
		var isLoading = false;
		var offset = $('#show-more').data('offset'); // offset 10 by default
		$('#show-more').on('click', function() {
			if (isLoading) {
				return;
			}
			isLoading = true;
			$('#show-more').text('Loading...');
				
			$.ajax({
				url: '/messageboard/convos/showMore?offset=' + offset + '&messageId=' + messageData.message_id,
				type: 'GET',
				dataType: 'json',
				success: function(data) {
					if (data.length > 0) {
						data.forEach(function(d) {
							d.User.photo_url = d.User.photo_url ? '/messageboard/' +  d.User.photo_url : 'https://cdn-icons-png.flaticon.com/512/1077/1077114.png'
							const isConvoUserEqualToAuthUser = d.User.id === authId ? true : false;
							var html = `
							<div class="d-flex align-items-center p-2 ${isConvoUserEqualToAuthUser 
								? 'justify-content-end message-right' 
								:  'message-left justify-content-end flex-row-reverse'}" 
								id="convo-container-${d.Convo.id}">
								<span class="mr-2" > ${d.Convo.reply}</span>
								<img class="${!isConvoUserEqualToAuthUser ? 'mr-2' : ''}" src="${d.User.photo_url}" width="40" height="40" style="border-radius: 50%"/>
								<div class="ellipsis">
									<svg  xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 16 16"><g transform="rotate(-90 8 8)"><path fill="gray" d="M3 9.5a1.5 1.5 0 1 1 0-3a1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3a1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3a1.5 1.5 0 0 1 0 3z"/></g></svg>
									<a href="#" class="delete-link" data-convo_id="${d.Convo.id}">Delete</a>
								</div> 
							</div>
							`
							$('.message-convo').append(html);
						})
						offset += data.length;
						$('#show-more')
						.text('Show More')
						.data('offset', offset);
					} else {
						$('#show-more').hide();
					}

					isLoading = false;
				},
				error: function() {
					isLoading = false;
				}
			})
		})
	})
</script>