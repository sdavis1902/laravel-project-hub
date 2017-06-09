var TaskView = (function(){
    'use strict';

	function _createEventListeners(){
		$('#chat-box').slimScroll({
			height: '250px'
		});
	}

	function _pusherNewGitPush(){
		var notificationsChannel = pusher.subscribe('task_' + task_id);

        notificationsChannel.bind('new_comment', function(notification){
            var comment_html = notification.comment_html;
			$('#chat-box').append(comment_html);
        });
	}

	function init(){
        _createEventListeners();
		_pusherNewGitPush();
    }

    return {
        init: init
    };
})();
jQuery( TaskView.init() );
