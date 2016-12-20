$(document).ready(function(){
    dashboard.init();
});

var dashboard = {
	init: function(){
		$( ".sortable" ).sortable({
			connectWith: ".connectedSortable",
			update: function( event, ui ) {
				var task_updates = [];
				var state_id = $(this).data('state-id');
				$(this).find('li').each(function(index){
					var task_id = $(this).data('task-id');
					task_updates.push({
						state_id : state_id,
						task_id  : task_id,
						priority : index+1
					});
				});

				$.post( "/project/dashboard-update", { tasks: task_updates }, function( data ){
					
				});
			}
		}).disableSelection();
	}
};
