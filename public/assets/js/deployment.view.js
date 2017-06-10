var DeploymentView = (function(){
    'use strict';

	function _createEventListeners(){

	}

	function _createPusherListeners(){
		var notificationsChannel = pusher.subscribe('deployment');

		// listen for status change
        notificationsChannel.bind('status_change', function(notification){
            var deployment_status = notification.status;
			$('#deployment-status').html(deployment_status);

			$('#deployment-box').removeClass('box-info');
			$('#deployment-box').removeClass('box-success');
			$('#deployment-box').removeClass('box-danger');
			$('#deployment-box').removeClass('box-warning');
			if( deployment_status == 'Queued' ){
				$('#deployment-box').addClass('box-info');
			}else if( deployment_status == 'Active' ){
				$('#deployment-box').addClass('box-warning');
			}else if( deployment_status == 'Failed' ){
				$('#deployment-box').addClass('box-danger');
			}else if( deployment_status == 'Complete' ){
				$('#deployment-box').addClass('box-success');
			}
        });

		// listen for more logs
        notificationsChannel.bind('more_log', function(notification){
			$('#deployment-logs').append(notification.message);
		});
	}

	function init(){
        _createEventListeners();
		_createPusherListeners();
    }

    return {
        init: init
    };
})();
jQuery( DeploymentView.init() );
