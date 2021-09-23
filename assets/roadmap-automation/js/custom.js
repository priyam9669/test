var baseURL = 'http://localhost/atrium-roadmap-automation/';
$(function () {

  //Start Date picker
  $(".startdate").datetimepicker({
    format: 'YYYY-MM-DD'
  });
  //End Date picker
  $(".enddate").datetimepicker({
    format: 'YYYY-MM-DD'
  });

  $('#settings_form').submit(function (e) {
    e.preventDefault();

    $('#update_settings_btn').hide();
    $('#update_settings_loader').addClass('visible');

    var formData = new FormData(this);

    $.ajax({
      url: baseURL + 'roadmap/updatesettings',
      data: formData,
      type: "POST",
      cache: false,
      dataType: "json",
      contentType: false,
      processData: false,
      success: function (response) {
        if (response.status == false && response.type == "error") {
          $("#success_alert").hide('fast');
          $("#error_alert").html(response.message);
          $("#error_alert").show('fast');
          $('html, body').animate({ scrollTop: 0 }, "slow");
        } else {
          if (response.status == true) {
            $("#error_alert").hide('fast');
            $("#success_alert").html(response.message);
            $("#success_alert").show('fast');
            $('html, body').animate({ scrollTop: 0 }, "slow");
            setTimeout(() => {
              $("#success_alert").hide('fast');
            }, 10000);
          }
        }
        $('#update_settings_loader').removeClass('visible');
        $('#update_settings_btn').show();
      },
      error: function (error) {
        console.log("Error", error);

        $("#success_alert").hide('fast');
        $("#error_alert").html("Something went wrong, please try again.");
        $("#error_alert").show('fast');
        $('html, body').animate({ scrollTop: 0 }, "slow");
        setTimeout(() => {
          $("#error_alert").hide('fast');
        }, 10000);

        $('#update_settings_loader').removeClass('visible');
        $('#update_settings_btn').show();
      }
    });
  });

  $('#refresh_data_btn').click(function () {
    $('#refresh_data_btn').hide();
    $('#refresh_data_loader').addClass('visible');
    $.get({
      url: baseURL + 'roadmap/refreshzohodata',
      data: null,
      cache: false,
      success: function (response) {
        // console.log(response);
        window.location.reload();
      },
      error: function (error) {
        console.log("Error", error);

        $("#success_alert").hide('fast');
        $("#error_alert").html("Something went wrong, please try again.");
        $("#error_alert").show('fast');
        $('html, body').animate({ scrollTop: 0 }, "slow");
        setTimeout(() => {
          $("#error_alert").hide('fast');
        }, 10000);

        $('#refresh_data_loader').removeClass('visible');
        $('#refresh_data_btn').show();
      }
    });
  });

  $('#update_roadmap_form').submit(function (e) {
    e.preventDefault();

    $('#update_roadmap_btn').hide();
    $('#update_roadmap_loader').addClass('visible');

    var formData = new FormData(this);

    $.ajax({
      url: baseURL + 'roadmap/calculateroadmap',
      data: formData,
      type: "POST",
      cache: false,
      dataType: "json",
      contentType: false,
      processData: false,
      success: function (response) {
        if (response.status == false && response.type == "error") {
          $("#success_alert").hide('fast');
          $("#error_alert").html(response.message);
          $("#error_alert").show('fast');
          $('html, body').animate({ scrollTop: 0 }, "slow");
          setTimeout(() => {
            $("#error_alert").hide('fast');
          }, 10000);
        } else {
          if (response.status == true) {
            $("#error_alert").hide('fast');
            $("#success_alert").html(response.message);
            $("#success_alert").show('fast');
            $('html, body').animate({ scrollTop: 0 }, "slow");
            setTimeout(() => {
              $("#success_alert").hide('fast');
            }, 10000);
          }
        }
        $('#update_roadmap_loader').removeClass('visible');
        $('#update_roadmap_btn').show();
      },
      error: function (error) {
        console.log("Error", error);

        $("#success_alert").hide('fast');
        $("#error_alert").html("Something went wrong, please try again.");
        $("#error_alert").show('fast');
        $('html, body').animate({ scrollTop: 0 }, "slow");
        setTimeout(() => {
          $("#error_alert").hide('fast');
        }, 10000);

        $('#update_roadmap_loader').removeClass('visible');
        $('#update_roadmap_btn').show();
      }
    });
  })
});