var new_report = {
   ready: function() {
      //$('#form_account_account_activity_detailed').dataTable();
      
      var data_table_store = {
                                 financial_data_preview_table: null,
                                 administrative_data_preview_table:null,
                                 account_membership_data_preview_table:null,
                                 reader_data_preview_table:null,
                                 tag_membership_data_preview_table: null,
                                 transaction_analysis_data_preview_table: null,
                                 demographic_membership_data_preview_table: null,
                                 account_definition_data_preview_table: null
                                 };
      var subtotals_data_table_store = {};
      
      var date_prefix = ['start', 'end'];
      var time_prefix = ['relative_start', 'relative_end'];
      var current_form_id = 'account_account_activity_detailed_form';
      var max_pdf_columns = 7;
      
      var create_modal_data = {'save_modal': {
                                 'height':'auto',
                                 'width': 450,
                                 'submit_text': 'Save',
                                 'download': false
                                 },
                        'download_modal': {
                                 'height':'auto',
                                 'width': 450,
                                 'submit_text': 'Download',
                                 'download': true
                                 },
                        'schedule_modal': {
                                 'height':'auto',
                                 'width': 580,
                                 'submit_text': 'Schedule',
                                 'download': false
                                 },
                        'email_modal': {
                                 'height':'auto',
                                 'width': 580,
                                 'submit_text': 'Send',
                                 'download': false
                                 }
                        };
      
      
      // intialize dialogbox for preview
      $('#loading_preview').dialog({
                                    height: 120,
                                    width: 425,
                                    autoOpen: false,
                                    modal: true,
                                    draggable: false,
                                    open: function(){
                                       $(".ui-dialog-titlebar-close").hide();
                                       $('#loading_preview .ajax-loader').show().next().hide();
                                    },
                                    close: function(){

                                    }
                                 });
      
      $('#loading_template').dialog({
                                    height: 400,
                                    width: 'auto',
                                    autoOpen: false,
                                    modal: false,
                                    draggable: false,
                                    dialogClass:'dialog-fullscreen',
                                    open: function(){
                                       $(".ui-dialog-titlebar-close").hide();
                                    },
                                    close: function(){

                                    }
                                 });
      $('#loading_template_warning, #loading_people_warning').dialog({
                                    height: 'auto',
                                    width: 'auto',
                                    autoOpen: false,
                                    modal: true,
                                    draggable: false,
                                    open: function(){
                                       $(".ui-dialog-titlebar-close").show();
                                    },
                                    close: function(){
                                       $(this).filter('.response-message').html('');
                                    }
                                 });
      
      // intialize dialogbox for mandatory filter check
      $('#mandatory_filter_check').dialog({
                                    height: 100,
                                    width: 325,
                                    autoOpen: false,
                                    modal: true,
                                    draggable: false,
                                    open: function(){
                                       $(".ui-dialog-titlebar-close").show();
                                    },
                                    close: function(){
                                       $(this).filter('.response-message').html('');
                                       return false;
                                    }
                                 });
      
      
      
       // intialize dialogbox for mandatory filter check
      $('#exclusive_filter_check').dialog({
                                    height: 100,
                                    width: 400,
                                    autoOpen: false,
                                    modal: true,
                                    draggable: false,
                                    open: function(){
                                       $(".ui-dialog-titlebar-close").show();
                                    },
                                    close: function(){
                                       $(this).filter('.response-message').html('');
                                       return false;
                                    }
                                 });
      
      // intialize form action modals
      $('.create-modal').each(function(){
         var id = $(this).attr('id');
         var data =  create_modal_data[id];
        
         $(this).dialog({
                                    height: data.height,
                                    width: data.width,
                                    autoOpen: false,
                                    modal: true,
                                    draggable: false,
                                    open: function(){
                                       $(".ui-dialog-titlebar-close").show();
                                       $('.create-modal .ajax-loader').hide().next().html('').hide();
                                       $('.create-modal .error').removeClass('error');
                                       $(this).keypress(function(event){
                                          if (event.keyCode == 13) {
                                             $(this).parent().find('.modal-submit-button').trigger('click');
                                             event.preventDefault();
                                          }
                                          if (event.keyCode == 27) {
                                             $(this).parent().find('.modal-cancel-button').trigger('click');
                                             event.preventDefault();
                                          }
                                       });
                                       
                                    },
                                    close: function(){
                                       
                                    },
                                    buttons: [
                                                {
                                                text: data.submit_text,
                                                class: 'modal-submit-button',
                                                click: function() {
                                                         processReport(id, data.download);
                                                      }
                                                },
                                                {
                                                text: "Cancel",
                                                class: 'modal-cancel-button',
                                                click: function() {
                                                         $(this).dialog("close");
                                                      }
                                                }
                                             ]
            
         });              
      });
      
      
      // intialize starover button
      $('#start_over').on('click', function(){
         //location.reload();
         window.location = location.href;
      });
      
      //initialize sticky
       //$(".sticker").sticky({topSpacing:0});
      
      
      // initialize display of report type selector
      $(document).on('click', '.report-sub-types-header', function(){
         if ($(this).hasClass('closed')){
            $(this).removeClass('closed').addClass('open');
         }
         else{
            $(this).removeClass('open').addClass('closed');
         }
         $(this).next().slideToggle('slow');
      });
      
      // initialize report filter selection/ filter display  subsection
      $(document).on('click', '.toggle', function(){
         if ($(this).hasClass('closed')){
            $(this).removeClass('closed').addClass('open'); //.parent().find('output-options .scroll-pane').jScrollPane();
         }
         else{
            $(this).removeClass('open').addClass('closed');
         }
         $(this).next().slideToggle('slow');
      });
      
      // initialize show/hide appropriate report pane
      $(document).on('click', '.capture-report-type', function(){
         
         // define some local variables
         var caption;
         var report_type = $(this).data('report_type');
         var report_pane = $('#' + report_type);
         var mandatory_filters = (mandatory_filters_data[report_type] != 'undefined') ? mandatory_filters_data[report_type] : [];
         var default_filters = (default_filters_data[report_type] != 'undefined') ? default_filters_data[report_type] : [];
         var url = '/reports/get_template/?report_type=' + report_type;
         
         // do not process any further if clicked on the same report type
         if (report_pane.is(':visible')) return;
         
         // remove summary
         $('.seleted-report-types').hide();
         $('.report-summary-sub-section').html('');
         $('.report-summary').hide();
         
         // remove all filters that is selected
         $('.activate-filter').each(function(){
            if ($(this).hasClass('selected')) $(this).trigger('click');   
         });
         
         // show caption
         if ($(this).hasClass('report-sub-types')) {
            caption = $(this).parent().prev().html() + ' (' + $(this).html().trim() + ')';
            $(this).parent().parent().prev().html(caption).show();
         }
         else{
            caption = $(this).html();
            $(this).parent().prev().html(caption).show();
         }
         
         
         // show right form panel
         if (report_pane.length == 0){
            $('.report-form-container').hide(); 
            $('#coming_soon').show();
         }
         else{
            $('#coming_soon').hide();
            if (report_pane.html().trim().length == 0) {
               $('#loading_template').dialog('open');
               // make ajax call
               $.ajax({
                  type: "GET",
                  url: url,
                  success: function(response){
                     
                     if (response.success) {

                        // hide panels
                        $('.report-form-container').hide();
                        
                        // show correct panel
                        report_pane.append(response.template).show();
                        
                        // Styled Select plugin
                        //report_pane.find('select').styledSelect();
                        
                        report_pane.find('.activate-filter').each(function(){
                           if($.inArray($(this).data('filter'), mandatory_filters) > -1) {
                              $(this).trigger('click');
                           }
                           else if ($.inArray($(this).data('filter'), default_filters) > -1) {
                              $(this).trigger('click');
                           }
                        });
                        
                        // init other events
                        initEvents(report_pane);
                        // close dialog
                        $('#loading_template').dialog('close');
                     }
                     else{
                        // close dialog
                        $('#loading_template').dialog('close');
                        var error = (typeof(response.error) != 'undefined' || response.error != null) ? response.error : 'Sorry, an error occured while processing your request.';
                        $('#loading_template_warning').dialog('open');
                        $("#loading_template_warning .response-message").html(error);
                     }
                     
                  },
                  error: function(){
                     $('.report-form-container').hide(); 
                     $('#loading_template').dialog('close');
                     $('#loading_template_warning').dialog('open');
                     $("#loading_template_warning .response-message").html('Sorry, an error occured while processing your request.');
                  }
               });
            }
            else{
               $('.report-form-container').hide(); 
               report_pane.show();
               report_pane.find('.activate-filter').each(function(){
                  if($.inArray($(this).data('filter'), mandatory_filters) > -1) {
                     $(this).trigger('click');
                  }
                  else if ($.inArray($(this).data('filter'), default_filters) > -1) {
                     $(this).trigger('click');
                  }
               });
            }
         }
      });
      
      /** Active Search - AJAX call on keyup input box */
      $(document).on('keyup', '.load-people' , function(event) {
         var form = $(this).closest('form');
         var person_preview_pane = form.find('.person-preview-pane');
         form.find('.person-profile-mandatory-filter').val('');
         form.find('.load-people').each(function(){
            if (!$(this).is(':visible')) {
               $(this).val('');
            }
         });
         form.find('.select-person-id').removeClass('person-selected');
         
         if (event.keyCode === 27) { //if esc is pressed we want to clear the value of search box
             form.find('.load-people').val('');
             person_preview_pane.empty();
             return;
         }
         var val = $.trim($(this).val());
         var proceed = false;
         if (event.keyCode != 13 && val.length < 3) {
            person_preview_pane.empty();
            return;
         }
         else if (event.keyCode == 13){
            // check if at least one filter is
            form.find('.load-people').each(function(){
               if ($.trim($(this).val()).length) {
                  proceed = true;
               }
            });
         }
         else{
            proceed = true;
         }
         if (!proceed) {
            return;
         }
         var data = form.serialize();
         var url = '/reports/person_search';
         $.ajax({
                  type: "POST",
                  data: data,
                  url: url,
                  success: function(response){
                     if (response.success) {
                        person_preview_pane.html(response.template).slideDown('slow');
                        person_preview_pane.find('.report-tooltips').qtip({
                                                                           show: 'mouseover',
                                                                           hide: 'mouseout',
                                                                           style: {
                                                                                    tip: true,
                                                                                    width: 100,
                                                                                    padding: 5,
                                                                                    margin: {
                                                                                       left: 10
                                                                                    },
                                                                                    color: '#FFFFFF',
                                                                                    radius: 3,
                                                                                    border: {
                                                                                       radius: 3,
                                                                                       color: "#303030"
                                                                                    },
                                                                                    background: "#303030",
                                                                                    opacity: 0.9,
                                                                                    filter: 'alpha(opacity=90)', // IE 8 and earlier
                                                                                 },
                                                                           position: {
                                                                              corner: {
                                                                                 target: 'rightMiddle',
                                                                                 tooltip: 'leftMiddle'
                                                                              }
                                                                           }
                                                                        });
                     }
                     else{
                        var error = (typeof(response.error) != 'undefined' || response.error != null) ? response.error : 'Sorry, an error occured while processing your request.';
                        $('#loading_people_warning').dialog('open');
                        $("#loading_people_warning .response-message").html(error);
                     }
                     
                  },
                  error: function(){
                     $('#loading_people_warning').dialog('open');
                     $("#loading_people_warning .response-message").html('Sorry, an error occured while processing your request.');
                  }
               });
      });
      
      $(document).on('click', '.select-person-id' , function(event) {
          //alert($(this).data('person_id'));
          var form = $(this).closest('form');
          form.find('.select-person-id').removeClass('person-selected');
          $(this).addClass('person-selected');
          form.find('input[name="filters[person][]"]').val($(this).data('person_id'));
          form.find('input[name="filters[person_search][identifier]"]').val($(this).data('person_identifier'));
          form.find('input[name="filters[person_search][last_name]"]').val($(this).data('person_last_name'));
          form.find('input[name="filters[person_search][first_name]"]').val($(this).data('person_first_name'));
          //form.find('.form-action').trigger('click');
      });
      
      initEvents = function(context){
         
         // sortable option for output columns
         context.find(".sortable" ).sortable().disableSelection().mousedown(function(){$(this).addClass('mousedown')}).mouseup(function(){$(this).removeClass('mousedown')});
                     
         // stick property for the preview button
         context.find(".sticker").sticky({topSpacing:0});
         
         // initialize calendar
         context.find('.pick-date').datepicker({
                        dateFormat  : 'yy-mm-dd',
                        showOtherMonths: true,
                        selectOtherMonths: true,
                        changeMonth: true,
                        changeYear: true,    
                        onSelect	: function(dateText) {
                           //$(this).val(dateText);
                        },
                        onClose: function( selectedDate ) {
                           
                           // make sure start date and end date range is appropriate
                           if ($(this).hasClass('start')) {
                              $(this).closest('.date-table').find('.pick-date.end' ).datepicker( "option", "minDate", selectedDate );
                           }
                           else if ($(this).hasClass('end')) {
                              $(this).closest('.date-table').find('.pick-date.start' ).datepicker( "option", "maxDate", selectedDate );
                           }
                        }
         });
         
         //initialize search boxes
         context.find('.filter').each(function(){
            var form_id = $(this).closest('form').attr('id');
            var filter = $(this).closest('.filter-group').data('filter');
            var element = '#' + form_id + ' .filter-group.' + filter + ' .' + 'filter-list';
            $(this).fastLiveFilter(element);
         });
      };
      
      initEvents($(document));
      
      $(document).on('click', '.deactivate-filter', function(){
         //alert('test');
         var filter = $(this).closest('.filter-group').data('filter');
         $(this).closest('form').find('.activate-filter').each(function(){
            if ($(this).data('filter') == filter) {
               $(this).trigger('click');
            }
         });
      });
      
      // initialize report tooltip
      $(".report-tooltips").qtip({
         show: 'mouseover',
         hide: 'mouseout',
         style: {
                  tip: true,
                  width: 300,
                  padding: 5,
                  margin: {
                     left: 10
                  },
                  color: '#FFFFFF',
                  radius: 3,
                  border: {
                     radius: 3,
                     color: "#303030"
                  },
                  background: "#303030",
                  opacity: 0.9,
                  filter: 'alpha(opacity=90)', // IE 8 and earlier
               },
         position: {
            corner: {
               target: 'rightMiddle',
               tooltip: 'leftMiddle'
            }
         }
      });
      
      
      
      // initialize select all for sections and subsection checkboxes
      $(document).on('click', '.select-all-next', function(event){
         if ($(this).hasClass('sub-section')) {
            if ($(this).hasClass('all')) {
               $(this).removeClass('all').addClass('none').parent().parent().next().find(':checkbox').prop('checked', true).parent().addClass('checked').parent().prev().find('.sub-section').removeClass('all').addClass('none');
            }
            else{
               $(this).removeClass('none').addClass('all').parent().parent().next().find(':checkbox').prop('checked', false).parent().removeClass('checked').parent().prev().find('.sub-section').removeClass('none').addClass('all');
            }
         }
         else{
            if ($(this).hasClass('all')) {
               $(this).removeClass('all').addClass('none').html('<span></span>select none').parent().parent().next().find(':checkbox').prop('checked', true).parent().addClass('checked').parent().prev().find('.sub-section').removeClass('all').addClass('none');
            }
            else{
               $(this).removeClass('none').addClass('all').html('<span></span>select all').parent().parent().next().find(':checkbox').prop('checked', false).parent().removeClass('checked').parent().prev().find('.sub-section').removeClass('none').addClass('all');
            }  
         }
         
         // reset filter count
         resetFilterCount(this);
         
         // stop propagation of clicks
         event.stopPropagation();
      });
      
      $(document).on('click', '.include-all', function(event){
         var element = $(this);
         var element_action = element.data('action');
         var sibling_action = (element_action == 'include') ? 'exclude' : 'include';
         if (element.hasClass('all')) {
            element.removeClass('all').addClass('none').html('<span></span>' + element_action + ' none')
            .siblings().removeClass('none').addClass('all').html('<span></span>' + sibling_action + ' all')
            .parent().parent().next().find('.checkbox.'+ element_action).next().prop('checked', false).prev().trigger('click');
         }
         else{
            element.removeClass('none').addClass('all').html('<span></span>' + element_action + ' all')
            .parent().parent().next().find('.checkbox.'+element.data('action')).next().prop('checked', true).prev().trigger('click');
         }  
         
         // reset filter count
         resetFilterCount(this);
         
         // stop propagation of clicks
         event.stopPropagation();
      });
      
      // initialize individual checkboxes
      $(document).on('click', '.checkbox', function(){
         if ($(this).next().prop('checked')) {
            $(this).next().prop('checked', false).parent().removeClass('checked').parent().prev().find('.sub-section').removeClass('none').addClass('all');
            if ($(this).hasClass('paired')) {
               $(this).parent().parent().removeClass('include').removeClass('exclude');
            }
            if ($(this).hasClass('toggle-next')) {
               $(this).parent().next().slideUp('slow').find('.sub-row.checked .checkbox').trigger('click');
            }
            if ($(this).hasClass('label')) {
               $(this).next().next().prop('disabled', true).val('').addClass('hidden');
            }
            if ($(this).hasClass('save-modal')) {
               $(this).next().val("0");
            }
         }
         else{
            if ($(this).hasClass('toggle-next')) {
               //$(this).closest('.container.subtotals').find('.rows.checked .checkbox').trigger('click');
               $(this).parent().next().slideDown('slow');
            }
            if ($(this).hasClass('unique')) {
                $(this).closest('.sub-subtotals').find('.rows.checked .checkbox').trigger('click');
            }
            
            var grand_parent = $(this).next().prop('checked', true).parent().addClass('checked').parent();
            if (grand_parent.children().length == grand_parent.children('.checked').length) {
               grand_parent.prev().find('.sub-section').removeClass('all').addClass('none');
            }
            if ($(this).hasClass('paired')) {
               $(this).parent().siblings().removeClass('checked').children().prop('checked', false);
               $(this).parent().parent().removeClass('include').removeClass('exclude').addClass($(this).data('action'));
            }
            if ($(this).hasClass('label')) {
               $(this).next().next().prop('disabled', false).removeClass('hidden').focus();
            }
            if ($(this).hasClass('save-modal')) {
               $(this).next().val("1");
            }
         }
         
         resetFilterCount(this);
      });
      
      // reset filter count
      resetFilterCount =  function(element){
         var filter_group = $(element).closest('.filter-group');
         
         var total_filter = filter_group.find('input:checkbox.paired').length/2;
         if (total_filter == 0) total_filter = filter_group.find('input:checkbox').length;
         var selected_filter = filter_group.find('input:checkbox:checked').length;
         var text = selected_filter + ' of ' + total_filter + ' filter(s) selected';
         filter_group.find('.filter-count').html(text);
      }
      
      /*
      $('.update-row').on('change', function(){
         if ($(this).prop('checked')) $(this).parent().addClass('checked');
         else $(this).parent().removeClass('checked');
      })
      */
      
     
      
      
      //$('#favorite_list_filter').fastLiveFilter('#favorite_list');
      //$('#my_list_filter').fastLiveFilter('#my_list');
      //$('#public_list_filter').fastLiveFilter('#public_list');
      //console.log(row_filter_data);
      /*
      $.each(row_filter_data, function(key, value){
         $('#' + key).fastLiveFilter('#'+ value);                   
      });
      */
      
      // initialize select/unselect filter
      $(document).on('click', '.activate-filter', function(){
         var clicked = $(this);
         var filter = clicked.data('filter');
         var form = clicked.closest('form');
         var element = form.find('.hide-filter.'+filter)
         
         // exclusivity check for filters
         var exclusive_warning = '';
         $(exclusive_filters_data).each(function(key, exclusive_filters){
            if (typeof exclusive_filters[filter] != 'undefined'){
               var excluded_filters = exclusive_filters[filter];
               for(var i=0; i<excluded_filters.length; i++){
                  var excluded_filter = excluded_filters[i];
                  //console.log('.hide-filter.'+ excluded_filter);
                  if (clicked.closest('form'). find('.hide-filter.'+ excluded_filter).is(':visible')) {
                     exclusive_warning += 'Please remove "<span class="filter-name">'+ excluded_filter.replace('-', ' ') + '</span>" filter to activate "<span class="filter-name">'+ filter.replace('-', ' ') + '</span>" filter. <br/>';
                  }
               }
            }
         });
         if (exclusive_warning.length>0) {
            $("#exclusive_filter_check .response-message").html(exclusive_warning);
            $("#exclusive_filter_check").dialog('open');
            return false;
         }
         
         if ($(this).hasClass('selected')) {
            // remove all user input values
            element.slideUp().find(':checkbox').prop('disabled', true).prop('checked', false).parent().removeClass('checked');
            element.find(':text').each(function(){
               var input_value = $.trim($(this).val());
               if (input_value.length) {
                  form.find('.person-preview-pane').empty();
               }
            }).val('');
            element.find('.select-all-next').removeClass('none').addClass('all');
            element.find('.include-all').removeClass('none').addClass('all');
            $(this).removeClass('selected');
            if (element.siblings(':visible').length == 0) {
               element.parent().parent().slideUp();
            }
         }
         else{
            element.slideDown().find(':checkbox').prop('disabled', false);
            element.parent().parent().slideDown();
            $(this).addClass('selected');
         }
         
         resetFilterCount(element);
         
         return false;
      });
      
      //initialize output option scroll pane
      //$('.output-options .scroll-pane').jScrollPane();
      
      // check mandatory filter
      checkMandatoryFilter = function (form_id){
         
         var form = $('#'+form_id);
         var report_type = form.data('report_type');
         
         //console.log(report_type);
         
         //check if from has madatory filter: if no data is set for mandatory filter for the form there is no mandatory filter
         if (typeof mandatory_filters_data[report_type] == 'undefined') return true;
         
         var mandatory_filters = mandatory_filters_data[report_type];
         var mandatory_filters_check_message = '';
         
         $(mandatory_filters).each(function(key, filter_name){
            if (filter_name == 'place') filter_name = 'location'; // alias for place
            
            switch(filter_name){
               case 'person-tags':
                  if ($('#'+form_id + ' .person-tags-input:checked').length == 0) {
                     mandatory_filters_check_message += 'You must select at least one '+ filter_name.replace('-', ' ') + '.<br/>';
                  }
               break;
               case 'person':
                     if ($('#'+form_id + ' .person-profile-mandatory-filter').val() == '') {
                        mandatory_filters_check_message += 'You must select at least one '+ filter_name + '.<br/>';
                     }
               break;
               default:
                  var filter = 'filters['+ filter_name + '][]';
                  var input_name = filter.replace('-', '_');
                  var mandatory_filter_selected = false;
                  
                  // check if primary mandatory filter is selected
                  if($('#'+form_id +' input[name="'+ input_name + '"]:checked').length > 0){
                     mandatory_filter_selected = true;
                  }
                  else if (typeof alternate_mandatory_filters_data[filter_name] != 'undefined') {
                     // check is alternate to mandatory filter is selected
                     //console.log(alternate_mandatory_filters_data[filter_name])
                     var alternate_filters = alternate_mandatory_filters_data[filter_name];
                     for (var i=0; i<alternate_filters.length; i++){
                        input_name = alternate_filters[i].replace('-', '_');
                        var input_class = alternate_filters[i] + '-input';
                        //console.log('#' + form_id + ' .' + input_class + ':checked');
                        //console.log(alternate_filters[i]);
                        if($('#'+form_id +' input[name="'+ input_name + '"]:checked').length > 0 || $('#' + form_id + ' .' + input_class + ':checked').length > 0) {
                           mandatory_filter_selected = true;
                           break;
                        }
                     }
                  }
                  if (!mandatory_filter_selected){
                     mandatory_filters_check_message += 'You must select at least one '+ filter_name.replace('-', ' ') + '.<br/>';
                  }
               break;
            }
         });
         
         form.find('.label-text').each(function(){
            if (!$(this).is(':disabled')) {
               var label_text = $(this).val().trim();
               if (label_text.length == 0) {
                  mandatory_filters_check_message += "You must enter a text for label '" + $(this).prev().prev().html() + "'. <br/>";
               }
            }
         })
         
         if (mandatory_filters_check_message.length>0) {
            //console.log(mandatory_filters_check_message);
            $("#mandatory_filter_check .response-message").html(mandatory_filters_check_message);
            $("#mandatory_filter_check").dialog('open');
            return false;
         }
         return true;
      }
      
      // initialize preview button
      $(document).on('click', '.form-action', function(event){
         
         // check for mandatory filters
         var current_form = $(this).closest('form');
         var report_type = current_form.data('report_type');
         current_form_id = current_form.attr('id');
      
         // checking mandatory filters
         if (!checkMandatoryFilter(current_form_id)) return false;
         
         // open ajax loader modal
         $('#loading_preview').dialog('open');
         
         //update date fileds
         $.each(date_prefix, function(key, prefix){
            var date = current_form.find('input[name="' + prefix + '_date_date' + '"]').val();
            var hour = current_form.find('select[name="' + prefix + '_time_hour' + '"]').val();
            var min = current_form.find('select[name="' + prefix + '_time_min' + '"]').val();
            var am_pm = current_form.find('select[name="' + prefix + '_am_pm' + '"]').val();
            var timestamp = date + ' ' + hour + ':' + min + ' ' + am_pm;
            current_form.find('.report-'+ prefix + '-date').val(timestamp);
         });
         
         $.each(time_prefix, function(key, prefix){
            hour = current_form.find('select[name="' + prefix + '_time_hour' + '"]').val();
            min = current_form.find('select[name="' + prefix + '_time_min' + '"]').val();
            am_pm = current_form.find('select[name="' + prefix + '_am_pm' + '"]').val();
            timestamp = hour + ':' + min + ' ' + am_pm;
            current_form.find('.report-'+ prefix + '-time').val(timestamp);
         });
         
         /*
         console.log($('#account_account_activity_detailed .report-relative_start-time').val());
         console.log($('#account_account_activity_detailed .report-relative_end-time').val());
         $('#loading_preview').dialog('close');
         return;
         */
         //define preview url
         $('#' + current_form_id + ' .modal-input').remove();
         var path  = base_url + 'reports/preview';
         
         // make ajax call
         $.ajax({
            type: "POST",
            url: path,
            data: current_form.serialize(),
            success: function(response){
               if (response.success) {
                  $('#report_summary').show();
                  $('#create_form_panel').hide();
                  $('#report_summary_options').html('');
                  $('#report_summary_pane').html('');
                  
                  // create summary for selected options
                  var selected_filters_data = (response.selected_filters) ? response.selected_filters : null;
                  createSelectedOptionsSummary(selected_filters_data);
   
                  // create financial summary
                  //console.log(response.summary_data);
                  var summary_data = (response.summary_data) ? response.summary_data : null;
                  //console.log(response.summary_data);
                  createSummary(summary_data);
                  
                  var profile_template = (response.profile_template) ? response.profile_template : null;
                  if (profile_template) {
                     showProfile(profile_template);
                  }
                  else{
                     hideProfile();
                  }
                  
                  // create financial subtotals
                  var subtotals = (response.subtotals) ? response.subtotals : null;
                  createSubtotals(subtotals);
                  //if ($('.subtotals-data-preview-table select').length > 0) $('.subtotals-data-preview-table select').styledSelect();
                  
                  //console.log(response.report_data);
                  // create preview table
                  var report_data = (response.report_data) ? response.report_data : null;
                  var columns_data = (response.columns) ? response.columns : null;
                  
                  //console.log(report_data);
                  //return;
                  //console.log(columns_data);
                  createPreviewTables(report_data, columns_data);
                  //if ($('.data-preview-table select').length > 0) $('.data-preview-table select').styledSelect();
   
                  $('#loading_preview').dialog('close');
                  $('#sidebar_report').show();
                  window.scrollTo(0, 0);
               }
               else{
                  var error = (typeof(response.error) != 'undefined' || response.error != null) ? response.error : 'Sorry, an error occured while processing your request.';
                  $(".ui-dialog-titlebar-close").show();
                  $("#loading_preview .ajax-loader").hide().next().html(error).show();
               }
               
            },
            error: function(){
               $(".ui-dialog-titlebar-close").show();
               $("#loading_preview .ajax-loader").hide().next().html('Sorry, an error occured. Please try again later.').show();
            }
         });
         return false;
      });
      
      // function definition for creating selected options summary preview
      var createSelectedOptionsSummary =  function(data){
         var parent_element = $('<div/>').addClass('summary-options').html('Selected Options information is not available.');
         var child_element;
         if (data) {
            parent_element.html('');
            $.each(data, function(key, value){
               child_element = $('<div/>').addClass('rows')
                              .append($('<div/>').addClass('left').html(key.replace(/_/g, ' ')))
                              .append($('<div/>').addClass('right').html(value));
               parent_element.append(child_element);
            });   
         }
         $('#report_summary_options').append(parent_element);
      }
      
      // function definition creating financial summary preview
      var createSummary = function(data){
         //console.log(data.length);
         //console.log(data);
         var parent_element;
         var child_element;
         if (data && data.length) {
            //alert('test2');
            $.each(data, function(whatever, row_data){
               parent_element = $('<div/>').addClass('summary-panes');
               $.each(row_data, function(key, value){
                  child_element = $('<div/>').addClass('rows').addClass(key)
                              .append($('<div/>').addClass('left').html(key.replace(/_/g, ' ')))
                              .append($('<div/>').addClass('right').html(value));
                  parent_element.append(child_element);
               });
               $('#report_summary_pane').append(parent_element).append($('<div/>').addClass('separator-row'));
            });
         }
         else{
            //alert('test3');
            parent_element = $('<div/>').addClass('summary-panes').html('Summary is not available.');
            $('#report_summary_pane').append(parent_element);
         }
      }
      
      var showProfile = function (template){
         $('#report_person_profile_pane').html(template).slideDown('slow').find('.jscrollpane').jScrollPane();;
      }
      var hideProfile = function(){
         var parent_element = $('<div/>').addClass('summary-panes').html('Profile is not available.');
         $('#report_person_profile_pane').html('').append(parent_element);
      }
      
      // function definition creating financial subtotals preview
      var createSubtotals = function(subtotals_data){
         
         //console.log(subtotals_data);
         // destroy all data table
         $.each(subtotals_data_table_store, function(key, value){
            if(value != null) value.fnDestroy(true);
            subtotals_data_table_store[key] =  null;
         });
         $('.subtotals-data-preview-table').hide();
         var preview_pane = '#financial_subtotals_data_preview_pane';
         
         if (subtotals_data) {
            //alert('creating');
            // remove previous preview info
            $(preview_pane + ' .summary-panes').remove();
            $(preview_pane + ' .subtotal-group.no-data').remove();
            $(preview_pane).show();
            
            $.each(subtotals_data.tables, function(table_type, key){
               var table_data = subtotals_data.data[table_type];
               var column_data = subtotals_data.columns[table_type];
               var table_id = key;
               var preview_table = '#' + table_id;
               //console.log(column_data);
               //console.log(table_id);
               
               // setup data
               var columns_headers = new Array();
               var column_values = new Array();
                     
               // setup column header data for datatable
               $.each(column_data, function(key, value){
                  obj = new Object();
                  obj.sTitle = value.replace(/_/g, ' ');
                  columns_headers.push(obj);
               });
               
               // setup row data for datatable
               $.each(table_data, function(row_key, row_value){
                  column_values[row_key] = new Array();
                  $.each(row_value, function(key, value){
                     column_values[row_key].push(value);
                  });
               });
               
               //console.log(column_values.length);
               if (column_values.length) {
                  $(preview_pane).append($('<table/>').addClass('report-summary-sub-section').attr('id', table_id));
                  subtotals_data_table_store[table_id]= $(preview_table).dataTable({
                                                                                          "sPaginationType": "full_numbers",
                                                                                          "aaSorting": [ ],
                                                                                          "bLengthChange": false,
                                                                                          "aaData": column_values,
                                                                                          "aoColumns": columns_headers,
                                                                                          "bFilter": false,
                                                                                          "fnDrawCallback": function() {
                                                                        
                                                                                          }
                                                                                       });
                  var table_wrapper = preview_table +'_wrapper';
                  $(table_wrapper).prepend($('<div/>').addClass('subtotal-group').html(table_type));
               }
               else{
                  $(preview_pane).append($('<div/>').addClass('subtotal-group').addClass('no-data').html(table_type +'<div class="rows"> Preview is not available.</div>'));
               }
               
            });
         }
         else{
            // show message
            var element = $('<div/>').addClass('summary-panes').append($('<div/>').addClass('rows').html('Subtotal Preview is not available.'));
            $(preview_pane).append(element);
         }
         
      }
      
      // function definition for creating preview table
      var createPreviewTables = function(data, columns){
         
         // destroy all data table
         $.each(data_table_store, function(key, value){
            if(value != null) value.fnDestroy(true);
            data_table_store[key] =  null;
         });
         // hide all preview tables
         $('.data-preview-table').hide();
         
         if (data && columns){
            $.each(data, function(report_type, report_data){
               
               
               //console.log(report_type);
               //console.log(report_data);
               var preview_pane = '#' + report_type + '_data_preview_pane';
               var preview_table = '#' + report_type + '_data_preview_table';
               var preview_table_id = report_type + '_data_preview_table';
               //console.log(preview_pane);
               //console.log(preview_table);
               //console.log(preview_table_id);
               //console.log(report_data.length);
               
               // remove previous preview info
               $(preview_pane + ' .summary-panes').remove();
               $(preview_pane).show();
               if (report_data.length) {
                 
                  var columns_headers = new Array();
                  var column_values = new Array();
                  
                  // setup column header data for datatable
                  $.each(columns[report_type], function(key, value){
                     obj = new Object();
                     obj.sTitle = value.replace(/_/g, ' ');
                     columns_headers.push(obj);
                  });
                  
                  
                  
                  // setup row data for datatable
                  
                  $.each(report_data, function(row_key, row_value){
                     column_values[row_key] = new Array();
                     $.each(row_value, function(key, value){
                        column_values[row_key].push(value);
                     });
                  });
                  
                  // destry data table and re-initialize it
                  //console.log($(preview_table));
                  
                  //return;
                  
                  
                  $(preview_pane).append($('<table/>').addClass('report-summary-sub-section').attr('id', preview_table_id));
                  data_table_store[preview_table_id]= $(preview_table).dataTable({
                                                                                    "sPaginationType": "full_numbers",
                                                                                    "aaSorting": [ ],
                                                                                    "aaData": column_values,
                                                                                    "aoColumns": columns_headers,
                                                                                    "bFilter": false,
                                                                                    "fnDrawCallback": function() {
                                                                  
                                                                                    }
                                                                                 });
                  
                  
               }
               else{
                  //hide datatable
                  //$(preview_table + '_wrapper').hide();
                  
                  //console.log($(preview_pane));
                  // show message
                  var element = $('<div/>').addClass('summary-panes').append($('<div/>').addClass('rows').html('Preview is not available.'));
                  $(preview_pane).append(element);
               }    
            });
            
            
         }
         else{
            
         }
      }
      
      // initialize enable/disable sort options based on columns picked
      $(document).on('click', '.update-sort-by', function(){
         var value = $(this).next().val();
         // disabled for now
         //$(".dynamic-option option[value='"+ value +"']").prop('disabled', !$(this).next().prop('checked'));
      });
      
      // initialize edit report button
      $(document).on('click', '#edit_report', function(){
         $('#create_form_panel').show();
         $('#report_summary_options').html('');
         $('#report_summary_pane').html('');
         $('#report_summary').hide();
         $('#sidebar_report').hide();
      });
      
      // initialize styled radio button
      $(document).on('click', '.radio', function(){
         if(!$(this).hasClass('checked')){
            $(this).parent().find('.radio').removeClass('checked');
            $(this).addClass('checked').find('input:radio').prop('checked', true);
         }
         if($(this).hasClass('disabled')){
            $(this).parent().find('input:hidden').prop('disabled', true);
         }
         else{
            $(this).parent().find('input:hidden').prop('disabled', false);
         }
      });
      
      $(document).on('click', '.mode', function(){
         if ($(this).hasClass('relative')){
            $('.absolute-mode-inputs').hide();
            $('.relative-mode-inputs').show();
         }
         else{
            $('.absolute-mode-inputs').show();
            $('.relative-mode-inputs').hide();
         }
      });
      
      // initialize report action
      $(document).on('click', '.report-action', function(){
         var action = $(this).attr('id').replace('report_', '');
         var modal = action + '_modal';
         //alert('#'+ modal);
            $('#'+ modal).dialog('open');   
      });
      
      
      processReport = function(type, download) {
         //alert (type);
         //alert(download);
         var modal = '#' + type;
         var form1 = '#' + type + ' form';
         var form2 = '#' + current_form_id;
         var error = false;
         //console.log(current_form_id);
        
         var error_text = '';
         $(form2).find('.modal-input').remove();
         // add form element from form1 to form2
         $(form1).find('input').each(function(){
               if(!$(this).filter(':input["type=text"]').val().trim()){
                  $(this).addClass('error');
                  error = true;
                  error_text += $(this).parent().prev().html() + ' field is required. <br/>'
               }
               var element_name = $(this).prop('name');
               var element_value = $(this).val();
               var new_element = $('<input/>').addClass('modal-input').prop('type', 'hidden').prop('name', element_name).val(element_value);
               $(form2).append(new_element);
         });
         
         $(form1).find('select, textarea').each(function(){
            var element_name = $(this).prop('name');
            var element_value = $(this).val();
            var new_element = $('<input/>').addClass('modal-input').prop('type', 'hidden').prop('name', element_name).val(element_value);
            $(form2).append(new_element);
         });
         
         if (!pdfColumnCheck(form2, type)) return false;
         //console.log($(form2));
         
         if (error) {
            $('#' + type + ' .ajax-loader').hide().next().html(error_text).show();
            return false;
         }
          //return;
         if (!download) {
            $('#' + type + ' .ajax-loader').show().next().html('').hide();
            
            var data = $(form2).serialize();
            
            //define preview url
            var path  = base_url + 'reports/process';
             // make ajax call
            $.ajax({
               type: "POST",
               url: path,
               data: data,
               success: function(response){
                  //console.log(response);
                  if (response.success) {
                     $('#' + type + ' .ajax-loader').hide().next().html('Your request completed sucessfully.').show();
                     
                     // close the modal after 2 seconds.
                     setTimeout("$('" + modal+ "').dialog('close')", 2000);
                  }
                  else{
                     var error = (typeof(response.error) != 'undefined' || response.error != null) ? response.error : 'Sorry, an error occured while processing your request.';
                     $('#' + type + ' .ajax-loader').hide().next().html(error).show();
                     
                  }
               },
               error: function(){
                  $('#' + type + ' .ajax-loader').hide().next().html('Sorry an error occured while processing your request.').show();
               }
            });   
         }
         else{
            //submit form for download
            $(modal).dialog('close');
            $(form2).prop('target', '_blank').submit();
            return false;
         }
         return false;
      }
      
      /**
       * Check if number of output columns have exceeded number allowed for pdf reports
       *
       */
      var pdfColumnCheck = function(form, type){
         // output columns can be display horizontal or verical (e.g. person profile)
         // Number of column restriction is applicable to only horizontal display for pdf file
         // it's determined if the output column field has the class "vertical" or not
         var view_pdf = true;
         var display_individual_transactions = $(form + ' .display_individual_transactions');

         if($(form+ ' [name=file_format]').val() == 'pdf'){
            if ((display_individual_transactions.val() !== undefined && !display_individual_transactions.prop('disabled')) || display_individual_transactions.val() === undefined) {
               
               $(form).find('.output-options .container').each(function(){
                  if ($(this).find(".output-columns:checked").not('.vertical').length > max_pdf_columns) {
                     view_pdf = false;
                  }
               });
            }
         }
         if (!view_pdf){   
            $('#' + type + ' .ajax-loader').hide().next().html('Sorry, you exceeded number of columns allowed for a pdf report.').show();
            return false;
         }
         return true;
      }
      
      
      // index file
      $('#remove_count_check_modal, #unschedule_count_check_modal').dialog({
                                    height: 100,
                                    width: 325,
                                    autoOpen: false,
                                    modal: true,
                                    draggable: false,
                                    open: function(){
                                       $(".ui-dialog-titlebar-close").show();
                                    },
                                    close: function(){
                                       return false;
                                    }
                                 });
       $('#run_input_modal').dialog({
                                    height: 230,
                                    width: 450,
                                    autoOpen: false,
                                    modal: true,
                                    draggable: false,
                                    open: function(){
                                       $(".ui-dialog-titlebar-close").show();
                                    },
                                    close: function(){
                                       return false;
                                    },
                                    buttons: [
                                                {
                                                text: 'Run',
                                                click: function() {
                                                         processAction($(this).data('report_id'), 'run');
                                                      }
                                                },
                                                {
                                                text: "Cancel",
                                                click: function() {
                                                         $(this).dialog("close");
                                                         return false;
                                                      }
                                                }
                                             ]
                                 });
      
      var index_modal_data = {
                           'remove_warning_modal': {
                           'height':150,
                           'width': 450,
                           'submit_text': 'Continue',
                           'download': false
                           },
                           'unschedule_warning_modal': {
                           'height':150,
                           'width': 450,
                           'submit_text': 'Continue',
                           'download': false
                           }
                  };  
      
      $('.index-modal').each(function(){
         var id = $(this).attr('id');
         var data =  index_modal_data[id];
         $(this).dialog({
                                    height: data.height,
                                    width: data.width,
                                    autoOpen: false,
                                    modal: true,
                                    draggable: false,
                                    open: function(){
                                       $('.index-modal .ajax-loader').hide().next().html('').hide();
                                       $('.index-modal .error').removeClass('error');
                                    },
                                    close: function(){
                                       
                                    },
                                    buttons: [
                                                {
                                                text: data.submit_text,
                                                click: function() {
                                                         processAction($(this).data('report_ids'), $(this).data('action'));
                                                      }
                                                },
                                                {
                                                text: "Cancel",
                                                click: function() {
                                                         $(this).dialog("close");
                                                         return false;
                                                      }
                                                }
                                             ]
            
         });              
      });
      
      $(document).on('click', '.remove-selected', function(){
         var report_ids = [];
         $(this).parent().parent().next().find('input:checked').each(function(){
               report_ids.push($(this).val());
         });
         
         if (report_ids.length == 0) {
            $('#remove_count_check_modal').dialog('open');
            return false;
         }
         $('#remove_warning_modal').data('report_ids', report_ids).dialog('open');
         return false;
      });
      
      $(document).on('click', '.unschedule-selected', function(){
         var report_ids = [];
         $(this).parent().parent().next().find('input.has-schedule:checked').each(function(){
               report_ids.push($(this).val());
         });
         
         if (report_ids.length == 0) {
            $('#unschedule_count_check_modal').dialog('open');
            return false;
         }
         $('#unschedule_warning_modal').data('report_ids', report_ids).dialog('open');
         return false;
      });
      
      $(document).on('click', '.action.remove', function(){
         var report_ids = [];
         report_ids.push($(this).data('report_id'));
         $('#remove_warning_modal').data('report_ids', report_ids).dialog('open');
         return false;
      });
      
      $(document).on('click', '.action.unschedule', function(){
         var report_ids = [];
         report_ids.push($(this).data('report_id'));
         $('#unschedule_warning_modal').data('report_ids', report_ids).dialog('open');
         return false;
      });
      
      $(document).on('click', '.action.add-schedule', function(){
         var report_id = $(this).data('report_id');
         $("#index_schedule_modal input[name='id']").val($(this).data('report_id'));
         $('#index_schedule_modal .name').html($(this).data('report_name'));
         $('#index_schedule_modal').data('report_id', report_id).dialog('open');
         return false;
      });
      
      $(document).on('click', '.action.run', function(){
         var report_id = $(this).data('report_id');
         $('#run_input_modal').data('report_id', report_id).dialog('open');
         return false;
      });
      
      $(document).on('click', '.action.edit', function(){
         var report_id = $(this).data('report_id');
         processAction(report_id, 'edit');
      });
      
      $(document).on('click', '.action.copy', function(){
         var report_id = $(this).data('report_id');
         processAction(report_id, 'copy');
      });
      
      
      var processAction = function(report_ids, action){
         //alert(action);
         //return;
         //console.log(report_ids);
         $('#remove_warning_modal .ajax-loader').show().next().html('');
         
         if (action == 'delete') {
            var data = {};
            data.id = report_ids;   
               //define preview url
            var path  = base_url + 'reports/destroy';
             // make ajax call
            $.ajax({
               type: "POST",
               url: path,
               data: data,
               success: function(response){
                  
                  if (response.success) {
                     //console.log(response.report_ids);
                     $('#remove_warning_modal .ajax-loader').hide().next().html('Your request completed sucessfully.').show();
                     //console.log(data.id);
                     $.each(data.id, function(key, value){
                        $('#my_reports_'+value).remove();
                        $('#public_reports_'+value).remove();
                     });
                     setTimeout("$('#remove_warning_modal').dialog('close')", 2000);
                  }
                  else{
                     var error = (typeof(response.error) != 'undefined' || response.error != null) ? response.error : 'Sorry, an error occured while processing your request.';
                     $('#remove_warning_modal .ajax-loader').hide().next().html(error).show();
                  }
               },
               error: function(){
                  
                  $('#remove_warning_modal .ajax-loader').hide().next().html('Sorry an error occured while processing your request.').show();
                  
               }
            });   
         }
         else if (action == 'unschedule') {
            var data = {};
            data.id = report_ids;   
               //define preview url
            var path  = base_url + 'reports/unschedule';
             // make ajax call
            $.ajax({
               type: "POST",
               url: path,
               data: data,
               success: function(response){
                  
                  if (response.success) {
                     //console.log(response.report_ids);
                     $('#unschedule_warning_modal .ajax-loader').hide().next().html('Your request completed sucessfully.').show();
                     //console.log(data.id);
                     $.each(data.id, function(key, value){
                        $('#my_reports_'+value).find('.schedule.description').remove();
                        $('#public_reports_'+value).find('.schedule.description').remove();
                        $('#my_reports_'+value).find('.action.unschedule').removeClass('unschedule').addClass('add-schedule').html('schedule');
                        $('#public_reports_'+value).find('.action.unschedule').removeClass('unschedule').addClass('add-schedule').html('schedule');
                     });
                     setTimeout("$('#unschedule_warning_modal').dialog('close')", 2000);
                  }
                  else{
                     var error = (typeof(response.error) != 'undefined' || response.error != null) ? response.error : 'Sorry, an error occured while processing your request.';
                     $('#unschedule_warning_modal .ajax-loader').hide().next().html(error).show();
                  }
               },
               error: function(){
                  
                  $('#unschedule_warning_modal .ajax-loader').hide().next().html('Sorry an error occured while processing your request.').show();
                  
               }
            });   
         }
         else if (action == 'add-schedule') {
            var form = $('#schedule_modal_form');
            var ajax_loader = $('#schedule_modal_form').find('.ajax-loader');
            ajax_loader.show().next().html('').hide();
            var error = false;
            var error_text = '';
            $(form).find('input').each(function(){
               if(!$(this).filter(':input["type=text"]').val().trim()){
                  $(this).addClass('error');
                  error = true;
                  error_text += $(this).parent().prev().html() + ' field is required. <br/>'
               }
            });
            if (error) {
               ajax_loader.hide().next().html(error_text).show();
               return false;
            }

            var data = form.serialize();   
            //define preview url
            var path  = base_url + 'reports/schedule';
            // make ajax call
            $.ajax({
               type: "POST",
               url: path,
               data: data,
               success: function(response){
                  if (response.success) {
                     ajax_loader.hide().next().html('Your request completed sucessfully.').show();
                     //$('#my_reports_'+report_ids).find('.action.add-schedule').removeClass('add-schedule').addClass('unschedule').html('unschedule');
                     //$('#public_reports_'+report_ids).find('.action.add-schedule').removeClass('add-schedule').addClass('unschedule').html('unschedule');
                     
                     setTimeout("$('#index_schedule_modal').dialog('close'); location.reload()", 2000);
                     //setTimeout("location.reload()", 2000);
                  }
                  else{
                     var error = (typeof(response.error) != 'undefined' || response.error != null) ? response.error : 'Sorry, an error occured while processing your request.';
                     $(ajax_loader).hide().next().html(error).show();
                  }
               },
               error: function(){
                  $(ajax_loader).hide().next().html('Sorry an error occured while processing your request.').show();
               }
            });   
         }
         else if(action=='run'){
            $("#run_modal input[name='id']").val(report_ids);
            $("#run_modal").submit();
            $('#run_input_modal').dialog('close');
         }
         else if(action=='edit'){
            window.location = '/reports/edit/'+report_ids;
         }
         else if(action=='copy'){
            window.location = '/reports/copy/'+report_ids;
         }
         
      }
      
      $(document).on('click', '.trigger-capture-report-type', function(){
         $('body').css('cursor', 'wait');
         var report_type = $(this).data('report_type');
         $('.capture-report-type').each(function(){
            if (report_type == $(this).data('report_type')) {
               $(this).trigger('click');
               $('body').css('cursor', 'default');
               return false;
            }
         });
      });
      
      // display selected filters on edit page
      if (typeof selected_filters != 'undefined') {
         
         $('.activate-filter').each(function(){
               if($.inArray($(this).data('filter'), selected_filters) > -1) {
                  $(this).trigger('click');
               }
            });
         
      }
      
      // schedule modal on index page
      $('#index_schedule_modal').dialog({
                                 height: 670,
                                 width: 580,
                                 autoOpen: false,
                                 modal: true,
                                 draggable: false,
                                 open: function(){
                                    $(".ui-dialog-titlebar-close").show();
                                    $('.create-modal .ajax-loader').hide().next().html('').hide();
                                    $('.create-modal .error').removeClass('error');
                                 },
                                 close: function(){
                                    
                                 },
                                 buttons: [
                                             {
                                             text: 'Schedule',
                                             click: function() {
                                                      processAction($(this).data('report_id'), 'add-schedule');
                                                   }
                                             },
                                             {
                                             text: "Cancel",
                                             click: function() {
                                                      $(this).dialog("close");
                                                   }
                                             }
                                          ]
                        
      });
      
   }// end of new_report.ready function
};

$(document).ready(function(){
   // instantiate event listener
   new_report.ready();
   
});
