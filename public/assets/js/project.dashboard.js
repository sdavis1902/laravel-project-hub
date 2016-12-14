$(document).ready(function(){
    dashboard.init();
});

var dashboard = {
    gridster: null,

    gridster_options: {
        widget_margins: [10,10],
        widget_base_dimensions: [370,127],
        max_cols: 4,
        resize: {
            enabled: true,
            stop: function(event, ui){
                dashboard.saveGridState()
            }
        },
        serialize_params: function(w, wgd) {
            return {
                x: wgd.col,
                y: wgd.row,
                width: wgd.size_x,
                height: wgd.size_y,
                id: $(w).attr('id'),
            };
        },
        draggable: {
            stop: function(event, ui){
                dashboard.saveGridState()
            }
        }
    },

    saveGridState: function(){
        var grid_data = this.gridster.serialize();
        console.log(grid_data);
        $.post( "/dashboard/save-user-dashboards", {grid_data: grid_data}, function( data ){
            if( data.status != 'success' ){
                Messenger().post({
                    message: 'Error saving dashboard',
                    type: 'error',
                    showCloseButton: true
                });
            }
        });

    },

    addDashboardItem: function(){
        var that = this;

        var modal = bootbox.dialog({
            message: $('#add-dashboard-item-div').html(),
            title: "Add Report to Dashboard",
            buttons: [{
                label: "Save",
                className: "btn btn-primary pull-left",
                callback: function() {
                    var dashboard_item = modal.find("#dashboard-item").val();
                    $.post( "/dashboard/add-dashboard-item", { "dashboard_item": dashboard_item }, function( data ){
                        if( data.status == 'success' ){
                            that.gridster.add_widget(data.html,1,1);
                            that.saveGridState();
                        }else{
                            Messenger().post({
                                message: 'Error adding report to dashboard',
                                type: 'error',
                                showCloseButton: true
                            });
                        }
                    });
                }
            },
            {
                label: "Close",
                className: "btn btn-default pull-left"
            }],
            show: false,
            onEscape: function() {
                modal.modal("hide");
            }
        });
        modal.modal("show");

    },

    removeGrid: function(that){
        var grid_id = that.data('grid-id');
        this.gridster.remove_widget( $('#' + grid_id ) );
        this.saveGridState();
    },

    init: function(){        var that = this;

        this.gridster = $(".gridster ul").gridster(this.gridster_options).data('gridster');

        $('#add-dashboard-item').click(function(e){
            e.preventDefault();
            that.addDashboardItem();
        });

        $('.gridster').on('click', '.remove-grid', function(e){
            e.preventDefault();
            that.removeGrid($(this));
        });
    }
};
