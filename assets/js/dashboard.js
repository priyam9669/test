var dashboard = {
   ready: function() {
        
        
        $('#show_readers').dialog({
                                    height: 'auto',
                                    width: 'auto',
                                    autoOpen: false,
                                    modal: true,
                                    draggable: false,
                                    open: function(){
                                       //$(".ui-dialog-titlebar-close").hide();
                                       //$('#loading_preview .ajax-loader').show().next().hide();
                                    },
                                    close: function(){

                                    }
                                });
        
        $(document).on('click', '.show-readers', function(){
            var conn_id = $(this).data('conn_id');
            var atrium_instance = $(this).data('atrium_instance');
            //console.log('/dashboard/show_readers/'+atrium_instance+'/'+conn_id);
            $.ajax({
                type: 'GET',
                url: '/dashboard/show_readers/'+atrium_instance+'/'+conn_id,
                success: function(response){
                    $('#reader_list').html(response);
                    $('#show_readers').dialog('open');
                },
                error: function(){
                    $('#reader_list').html('An error occured while processing your request.');
                    $('#show_readers').dialog('open');
                }
            });
        });
        
        $(document).on('change', '#select_school', function(){
            var selected = $(this).find("option:selected").text();
            //console.log(selected);
            if (selected != 'all schools'){
                $('.school-group').hide();
                $('.school-group.'+selected).show();
            }
            else{
                $('.school-group').show();
            }
        });
        
        $(document).on('change', '#select_connection', function(){
            var selected = $(this).val();
            $('.school-group').show();
            //alert('.connection-id_'+selected);
            if (selected != 0){
                $('.connection-group').hide();
                $('.connection-id_'+selected).show();
            }
            else{
                $('.connection-group').show();
            }
        });
      
    }// end of new_report.ready function
};

$(document).ready(function(){
   // instantiate event listener
   dashboard.ready();
   
});
