<style>
    body {
        background-color: #111; /* Dark background color */
        color: #fff; /* Light text color */
    }
    .card {
		background-color: #222;
		color: #fff;
	}
    .message-content-container {
        margin-bottom: 15px;
    }
    .message-content-container .row {
        cursor: pointer;
    }
    .message-content-container .row:hover {
        opacity: 0.7;
    }
    #show-more {
        color: blue;
        cursor: pointer;
    }
    #show-more:hover {
        text-decoration: underline;
    }
    .message-body {
        display: flex;
    }
    .message-body #show-more-content {
        display: none;
        text-decoration: underline;
        margin-left: 10px;
    }
</style>

<?php echo $this->element('navbar'); ?>

<body>
    
<div class="container d-flex justify-content-center">
    <div class="messages my-4">
        <div class="card my-4" style="width:100vh;">
                <h2 class="card-title text-center m-4">Messages</h2>
                <div class="d-flex justify-content-start mx-4 mt-5">
                    <p></p>
                    <?php echo $this->Html->link('New Message', array('controller' => 'messages', 'action' => 'new'), array('class' => 'btn btn-secondary btn-block', 'style' => 'width: auto;')); ?>
                </div>
                <div class="d-flex align-items-center m-4">
                    <input type="text" class="form-control" id="search-message" placeholder="Search..." style="background-color: #333; color: #fff;">
                </div>
            
                
                        <?php foreach($messages as $index => $message): ?>
                            <div class="card-body message-content-container" data-message-id="<?php echo $message['Message']['id'] ?>">
                                <div class="card mx-auto" style="background-color:#333; width: 90%;">
                                    <div class="card-body row">
                                        <div class="col-md-1">
                                            <?php $photoUrl = $message['User']['photo_url'] 
                                                ? '/messageboard/' . $message['User']['photo_url']
                                                : 'https://cdn-icons-png.flaticon.com/512/1077/1077114.png' 
                                            ?>
                                            <img src="<?php echo $photoUrl; ?>" alt="Profile picture" class="my-3" style="border-radius:10px; margin-right:10px; width:90px; height:90px;">
                                        </div>
                                        <div class="col-md-10 ml-5 mt-3">
                                            <h4>
                                                <?php echo $message['User']['name']; ?>
                                            </h4>
                                                    
                                                <div class="text-left message-body">
                                                    <br>
                                                    <small>
                                                        <?php echo $message['Message']['content']; ?>
                                                    </small>
                                                    <a id="show-more-content">Show More</a>
                                                </div>
                                                
                                                <small class="text-muted text-right">
                                                    <?php echo $message['Message']['created']; ?>
                                                </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>

                    <?php if(count($messages) >= 4): ?>
                        <div class="text-center mb-5">
                            <a id="show-more" data-limit="20">Show More</a>
                        </div>
                    <?php endif; ?>

            </div>
        </div>
    </div>
</div>
</body>
<?php echo $this->element('footer'); ?>

<script>
  $(document).ready(function() {
    // for long messages
    function initLongMessages() {
      $('.container .message-body').each(function() {
        const pElement = $(this).find('p');
        const msgFullText = pElement.text().trim();
        if(msgFullText.length > 50) {
            var truncatedText = msgFullText.substring(0, 50) + "...";
            var isTruncated = true;
            $(pElement).text(truncatedText);
            $(this).find('a').show();

            $(this).find('a').on('click', function(el) {
                if (isTruncated) {
                    $(pElement).text(msgFullText);
                    $(this).parent().find('a').text('Show less');
                }else {
                    $(pElement).text(truncatedText);
                    $(this).parent().find('a').text('Show more');
                }
                isTruncated = !isTruncated;
            })
        }
  
      })
    }

    //get messages
    var isLoading = false;
    var limit = $('#show-more').data('limit');
    // Show more pagination
    $('#show-more').on('click', function() {
        if (isLoading) {
            return;
        }
        isLoading = true;
        $('#show-more').text('Loading...');
        getMessages();
    })

    //search message
    $('#search-message').on('keyup', function() {
        if (isLoading) {
            return;
        }
        isLoading = true;
        limit = 10;
        $('.message-content').empty();
        getMessages();
    })
    function getMessages() {
        const query = $('#search-message').val();
        if (query !== '') {
            $('#show-more').hide();
        }
        $.ajax({
            url: '/messageboard/users/getMessages/' + limit + '?q=' + query,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                const messageContainer = $('.message-content');
                const oldMessageContent = messageContainer.html();
                messageContainer.empty();
                if(data.length > 0) {
                    // if query is not empty and the data is less than equal to 9 then hide the show more button
                    if (query !== '') {
                        if (data.length <= 9) {
                            $('#show-more').hide();
                        } else { // show if the data is greater than 10
                            $('#show-more').show();
                        }
                    } else {
                        $('#show-more').show();
                    }
                    data.forEach(function(d) {
                        d.User.photo_url = d.User.photo_url 
                            ? '/messageboard/' + d.User.photo_url 
                            : 'https://cdn-icons-png.flaticon.com/512/147/147142.png'

                        const html = `
                            <div class="card-body message-content-container p-0" data-message-id="${d.Message.id}">
                                <div class="card mx-auto" style="width: 90%;">
                                    <div class="card-body row">
                                        <div class="col-md-1 mr-2">
                                            <img src="${d.User.photo_url}" alt="" width="40px" height="40px">
                                        </div>
                                        <div class="col-md-10">
                                            <div class="d-block">
                                                <div class="text-left message-body">
                                                    <p>
                                                        ${d.Message.content}
                                                    </p>
                                                    <a id="show-more-content">Show More</a>
                                                </div>
                                                <div class="date text-right">
                                                    <small class="text-muted">
                                                        ${d.Message.created}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> `;
                        messageContainer.append(html)
                    })
                    initLongMessages();
                    limit += 10;
                    $('#show-more')
                    .text('Show More')
                    .data('limit', limit);

                    if ($(messageContainer.html()).length == $(oldMessageContent).length) {
                        $('#show-more').hide();
                    }
                }
                 else {
                    if (query !== '') {
                        messageContainer.append(`<p class="text-center text-danger">-- Message Not Found -- </p>`)
                    }
                    $('#show-more').hide();
                }

                isLoading = false;
            },
            error: function() {
                isLoading = false;
            }
        })
    }

    // direct to convo
    $('.container').on('click', '.message-content-container', function(event) {
        if (!$(event.target).is('a')) { // prevent opening if clicking 'show more' or 'show less'
            const messageId = $(this).data('message-id');
            window.location.href = `/messageboard/convos/index/${messageId}`;
        }
    })
    initLongMessages();
  })
</script>