$(document).on("click", "a:not([data-nd])", function() {
  var thisClass = $(this).attr("class");
  if (thisClass != null) {
    if (thisClass.indexOf('ui-datepicker-next') != -1 || thisClass.indexOf('ui-datepicker-prev') != -1) {
      return false;
    }
  }
  var linkUrl = $(this).attr('href');
  if (linkUrl.indexOf('javascript:') != -1) {
    return false;
  }
    loadPage(linkUrl, 0, null, linkUrl);
    return false;
});

$(window).bind('popstate', function() {
    var linkUrl = location.href;
    loadPage(linkUrl, 0, null, linkUrl);
});

function loadPage(argUrl, argType, argParams, linkUrl, options = {loadingBar: true}) {

    if(options.loadingBar) {
        loadingBar(1);
    }

    if(argType == 1) {
        argType = "POST";
    } else {
        argType = "GET";

        // Store the url to the last page accessed
        if(argUrl != window.location) {
            window.history.pushState({path: argUrl}, '', argUrl);
        }
    }

    // Request the page
    $.ajax({
        url: argUrl,
        type: argType,
        data: argParams,
        success: function(data) {
            // Parse the output
            try {
                var result = jQuery.parseJSON(data);
                var aaa = 0;
                $.each(result, function(item, value) {
                    // if (item == "url" && value == "") {
                    //   $("#sidebar").hide();
                    // }

                    if (item == "title") {
                        document.title = value;
                    } else if(['header', 'content', 'footer'].indexOf(item) > -1) {
                        $('#'+item).html(value);
                    } else {
                        $('#'+item).html(value);
                    }

                    if (aaa == 0) {
                      $(".sidebarList").removeClass("active");
                      leftNavActive(linkUrl);
                    }
                    if (parseInt($("#content").height()) > parseInt($(window).height())) {
                      $("#sidebar").css('height',$("#content").height());
                    } else {
                      $("#sidebar").css('height',$(window).height());
                    }

                    aaa++;

                });
            } catch(e) {

            }

            // Scroll the document at the top of the page
            $(document).scrollTop(0);

            // Reload functions
            reload();

            if(options.loadingBar) {
                loadingBar(0);
            }
        }
    })
}

function leftNavActive(linkUrl) {
  var urlArray = linkUrl.split("/");
}

/**
 * The loading bar animation
 *
 * @param   type    The type of animation, 1 for start, 0 for stop
 */
function loadingBar(type) {
    if(type) {
        $("#loading-bar").show();
        $("#loading-bar").width((50 + Math.random() * 30) + "%");
    } else {
        $("#loading-bar").width("100%").delay(50).fadeOut(400, function() {
            $(this).width("0");
        });
    }
}

/**
 * This function gets called every time a dynamic request is made
 */
function reload() {
    dragscroll.reset();
}


////////////////////////////////////////////////////////////////////////////////
// LOGIN
$(document).on("submit", "#login-form", function(){
  $(".form-return").hide();
  $(".form-return-text").text("");
  $(".login-loader").show();
  $(".login-button").hide();

  if(! $("#i_email").val() || $("#i_email").val() == "") {
    $(".form-return-text").text("Please fill out all the fields..");
    $(".form-return").show();
    $(".login-loader").hide();
    $(".login-button").show();
    return false;
  }

  if(! $("#i_password").val() || $("#i_password").val() == "") {
    $(".form-return-text").text("Please fill out all the fields..");
    $(".form-return").show();
    $(".login-loader").hide();
    $(".login-button").show();
    return false;
  }

  var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
  if(! testEmail.test($("#i_email").val())) {
    $(".form-return-text").text("You must enter a valid email.");
    $(".form-return").show();
    $(".login-loader").hide();
    $(".login-button").show();
    return false;
  }

  var dataString = "token_id=" + $("[name='token_id']").val() + "&email=" + $("#i_email").val() + "&password=" + $("#i_password").val() + "&remember=" + $("#i_remember").is(":checked");
  $.ajax({
    type: "POST",
    url: "/Ax3_framework/public/rq/login",
    data: dataString,
    success: function(data){
      var data = JSON.parse(data);
      console.log(data);
      if(data.status == "bad"){
        $(".form-return-text").text(data.message);
        $(".form-return").show();
        $(".login-loader").hide();
        $(".login-button").show();
      } else {
        top.location.href="admin/dashboard";
      }
      return false;
    }
  });
  return false;
});

////////////////////////////////////////////////////////////////////////////////
// ADD FUNCTIONS
$(document).on('keyup', '#network_name', function() {
  var network_name = $("#network_name").val();
  var dataString = "token_id=" + $("[name='token_id']").val() + "&network_name=" + network_name;
  $.ajax({
    type: "POST",
    url: "/rq/network_name_check",
    data: dataString,
    success: function(data){
      var data = JSON.parse(data);
      if(data.status == "bad"){
        alert(data.message);
      } else if (data.html) {
        $(".the-found").html(data.html);
        $(".alert-warning").show();
      } else {
        $(".the-found").html("");
        $(".alert-warning").hide();
      }
      return false;
    }
  });
});
$(document).on('click', '.add_network_submit', function() {
  $(".alert-danger").hide();
  $(".add_network_submit").hide();
  $("#form-loader").show();
  var network_name = $("#network_name").val();
  if (network_name == "") {
    $("#alert-danger-text").text("The name field is required.");
    $(".alert-danger").show();
    $(".add_network_submit").show();
    $("#form-loader").hide();
    return false;
  }
  var dataString = "token_id=" + $("[name='token_id']").val()
                    + "&network_name=" + network_name;
  $.ajax({
    type: "POST",
    url: "/rq/add_network_submit",
    data: dataString,
    success: function(data){
      var data = JSON.parse(data);
      if(data.status == "bad"){
        alert(data.message);
      } else {
        $('body').append("<a href='"+data.url+"' id='temp-link' style='display:none;'></a>");
        $("#temp-link").click();
        $("#temp-link").remove();
      }
    }
  });
});

$(document).on('keyup', '#product_name', function() {
  var product_name = $("#product_name").val();
  var dataString = "token_id=" + $("[name='token_id']").val() + "&product_name=" + product_name;
  $.ajax({
    type: "POST",
    url: "/rq/product_name_check",
    data: dataString,
    success: function(data){
      var data = JSON.parse(data);
      if(data.status == "bad"){
        alert(data.message);
      } else if (data.html) {
        $(".the-found").html(data.html);
        $(".alert-warning").show();
      } else {
        $(".the-found").html("");
        $(".alert-warning").hide();
      }
      return false;
    }
  });
});
$(document).on('click', '.add_product_submit', function() {
  $(".alert-danger").hide();
  $(".add_product_submit").hide();
  $("#form-loader").show();
  var product_name = $("#product_name").val();
  if (product_name == "") {
    $("#alert-danger-text").text("The name field is required.");
    $(".alert-danger").show();
    $(".add_product_submit").show();
    $("#form-loader").hide();
    return false;
  }
  var dataString = "token_id=" + $("[name='token_id']").val()
                    + "&product_name=" + product_name;
  $.ajax({
    type: "POST",
    url: "/rq/add_product_submit",
    data: dataString,
    success: function(data){
      var data = JSON.parse(data);
      if(data.status == "bad"){
        alert(data.message);
      } else {
        $('body').append("<a href='"+data.url+"' id='temp-link' style='display:none;'></a>");
        $("#temp-link").click();
        $("#temp-link").remove();
      }
    }
  });
});

$(document).on('keyup', '#studio_name', function() {
  var studio_name = $("#studio_name").val();
  var dataString = "token_id=" + $("[name='token_id']").val() + "&studio_name=" + studio_name;
  $.ajax({
    type: "POST",
    url: "/rq/studio_name_check",
    data: dataString,
    success: function(data){
      var data = JSON.parse(data);
      if(data.status == "bad"){
        alert(data.message);
      } else if (data.html) {
        $(".the-found").html(data.html);
        $(".alert-warning").show();
      } else {
        $(".the-found").html("");
        $(".alert-warning").hide();
      }
      return false;
    }
  });
});
$(document).on('click', '.add_studio_submit', function() {
  $(".alert-danger").hide();
  $(".add_studio_submit").hide();
  $("#form-loader").show();
  var studio_name = $("#studio_name").val();
  if (studio_name == "") {
    $("#alert-danger-text").text("The name field is required.");
    $(".alert-danger").show();
    $(".add_studio_submit").show();
    $("#form-loader").hide();
    return false;
  }
  var dataString = "token_id=" + $("[name='token_id']").val()
                    + "&studio_name=" + studio_name;
  $.ajax({
    type: "POST",
    url: "/rq/add_studio_submit",
    data: dataString,
    success: function(data){
      var data = JSON.parse(data);
      if(data.status == "bad"){
        alert(data.message);
      } else {
        $('body').append("<a href='"+data.url+"' id='temp-link' style='display:none;'></a>");
        $("#temp-link").click();
        $("#temp-link").remove();
      }
    }
  });
});

$(document).on('keyup', '#vendor_name', function() {
  var vendor_name = $("#vendor_name").val();
  var dataString = "token_id=" + $("[name='token_id']").val() + "&vendor_name=" + vendor_name;
  $.ajax({
    type: "POST",
    url: "/rq/vendor_name_check",
    data: dataString,
    success: function(data){
      var data = JSON.parse(data);
      if(data.status == "bad"){
        alert(data.message);
      } else if (data.html) {
        $(".the-found").html(data.html);
        $(".alert-warning").show();
      } else {
        $(".the-found").html("");
        $(".alert-warning").hide();
      }
      return false;
    }
  });
});
$(document).on('click', '.add_vendor_submit', function() {
  $(".alert-danger").hide();
  $(".add_vendor_submit").hide();
  $("#form-loader").show();
  var vendor_name = $("#vendor_name").val();
  if (vendor_name == "") {
    $("#alert-danger-text").text("The name field is required.");
    $(".alert-danger").show();
    $(".add_vendor_submit").show();
    $("#form-loader").hide();
    return false;
  }
  var dataString = "token_id=" + $("[name='token_id']").val()
                    + "&vendor_name=" + vendor_name;
  $.ajax({
    type: "POST",
    url: "/rq/add_vendor_submit",
    data: dataString,
    success: function(data){
      var data = JSON.parse(data);
      if(data.status == "bad"){
        alert(data.message);
      } else {
        $('body').append("<a href='"+data.url+"' id='temp-link' style='display:none;'></a>");
        $("#temp-link").click();
        $("#temp-link").remove();
      }
    }
  });
});

$(document).on('keyup', '.person_name_change', function() {
  var suffix = $("#p_suffix").val();
  var first_name = $("#p_first_name").val();
  var middle_name = $("#p_middle_name").val();
  var last_name = $("#p_last_name").val();

  var new_full_name = "";
  if (suffix && middle_name) {
    new_full_name = new_full_name = suffix + " " + first_name + " " + middle_name + " " + last_name;
  } else if (suffix) {
    new_full_name = suffix + " " + first_name + " " + middle_name + " " + last_name;
  } else {
    new_full_name = first_name + " " + last_name;
  }
  $("#p_full_name").val(new_full_name);

  var dataString = "token_id=" + $("[name='token_id']").val() + "&full_name=" + new_full_name;
  $.ajax({
    type: "POST",
    url: "/rq/person_name_check",
    data: dataString,
    success: function(data){
      var data = JSON.parse(data);
      if(data.status == "bad"){
        alert(data.message);
      } else if (data.html) {
        $(".the-found").html(data.html);
        $(".alert-warning").show();
      } else {
        $(".the-found").html("");
        $(".alert-warning").hide();
      }
      return false;
    }
  });
});
$(document).on('click', '.add_person_submit', function() {
  $(".alert-danger").hide();
  $(".add_person_submit").hide();
  $("#form-loader").show();
  var p_full_name = $("#p_full_name").val();
  var p_suffix = $("#p_suffix").val();
  var p_first_name = $("#p_first_name").val();
  var p_middle_name = $("#p_middle_name").val();
  var p_last_name = $("#p_last_name").val();
  var p_dob = $("#p_dob").val();
  var p_dod = $("#p_dod").val();
  var p_detailed_desc = $("#p_detailed_desc").val();
  var p_internal_notes = $("#p_internal_notes").val();

  if (p_first_name == "" || p_last_name == "") {
    $("#alert-danger-text").text("First and last name are required fields.");
    $(".alert-danger").show();
    $(".add_person_submit").show();
    $("#form-loader").hide();
    return false;
  }

  var dataString = "token_id=" + $("[name='token_id']").val()
                    + "&full_name=" + p_full_name
                    + "&suffix=" + p_suffix
                    + "&first_name=" + p_first_name
                    + "&middle_name=" + p_middle_name
                    + "&last_name=" + p_last_name
                    + "&dob=" + p_dob
                    + "&dod=" + p_dod
                    + "&detailed_desc=" + p_detailed_desc
                    + "&internal_notes=" + p_internal_notes;
  $.ajax({
    type: "POST",
    url: "/rq/add_person_submit",
    data: dataString,
    success: function(data){
      var data = JSON.parse(data);
      if(data.status == "bad"){
        alert(data.message);
      } else {
        $('body').append("<a href='"+data.url+"' id='temp-link' style='display:none;'></a>");
        $("#temp-link").click();
        $("#temp-link").remove();
      }
    }
  });
});

////////////////////////////////////////////////////////////////////////////////
// REGISTER
$(document).on("submit", "#registration-form", function(){
  $(".form-return").hide();
  $(".form-return-text").text("");
  $(".registration-loader").show();
  $(".register-button").hide();
  if($("#r_password").val() != $("#r_confirm-password").val()) {
    $(".form-return-text").text("Your passwords do not match.");
    $(".form-return").show();
    $(".registration-loader").hide();
    $(".register-button").show();
    return false;
  }
  if(!grecaptcha.getResponse()){
    $(".form-return-text").text("Please confirm you're not a robot.");
    $(".form-return").show();
    $(".registration-loader").hide();
    $(".register-button").show();
    return false;
  }

  var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
  if(! testEmail.test($("#r_email").val())) {
    $(".form-return-text").text("You must enter a valid email.");
    $(".form-return").show();
    $(".registration-loader").hide();
    $(".register-button").show();
    return false;
  }

  var dataString = "token_id=" + $("[name='token_id']").val() + "&username=" + $("#r_username").val() + "&email=" + $("#r_email").val() + "&password=" + $("#r_password").val() + "&g-recaptcha-response=" + grecaptcha.getResponse();
  $.ajax({
    type: "POST",
    url: "/rq/register",
    data: dataString,
    success: function(data){
      var data = JSON.parse(data);
      // console.log(data);
      if(data.status == "bad"){
        $(".form-return-text").text(data.message);
        $(".form-return").show();
        $(".registration-loader").hide();
        $(".register-button").show();
      } else {
        alert("You have registered successfully!");
        top.location.href="index";
      }
      return false;
    }
  });
  return false;
});

$(document).on("click", ".new_media_submit", function() {
  $(".new_media_submit").hide();
  $("#image-upload-loader").show();

  var attachments = "";
  $(".attachment_name").each(function() {
  if (attachments == "") {
    attachments += $(this).attr("name");
  } else {
    attachments += ','+$(this).attr("name");
  }
});

  var dataString = "token_id=" + $("[name='token_id']").val() + "&media_type=" + $("#media_type").val() + "&media_type_id=" + $("#media_type_id").val() + "&media_title=" + $("#media_title").val() + "&media_source=" + $("#media_source").val() + "&media_caption=" + $("#media_caption").val() + "&attachments=" + attachments;

  $.ajax({
    type: "POST",
    url: "/rq/new_media",
    data: dataString,
    success: function(data){
      var data = JSON.parse(data);
      if(data.status == "bad"){
        alert(data.message);
        $(".new_media_submit").show();
        $("#image-upload-loader").hide();
      } else {
        alert("Media successfully added. Refreshing..");
        top.location.reload();
      }
      return false;
    }
  });
  return false;
});

////////////////////////////////////////////////////////////////////////////////
// UPLOAD

window.imageBlob = "";

window.fileIsUploading = false;


$(document).on("click", ".upload-attachments", function(){
  $('#fileUpload').click();
});

$(document).on('click', '.delete-attachment', function() {
  var theDeleteButton = $(this);
  theDeleteButton.hide();
  var getPath = $(this).attr('name');
  var dataString = "token_id=" + $("[name='token_id']").val() + "&path=" + getPath;
  $.ajax({
    type: "POST",
    url: "/rq/delete_upload",
    data: dataString,
    success: function(data) {
      var data = JSON.parse(data);
      if (data.msg == "token") {
        theDeleteButton.show();
        alert("Token mismatch.");
        return false;
      } else if (data.msg == "empty") {
        theDeleteButton.show();
        alert("File not found.");
        return false;
      } else if (data.msg == "good"){
        $("#"+getPath.replace(".","")).remove();
      } else {
        theDeleteButton.show();
        alert("Something went wrong.");
        return false;
      }
    }
  });
  return false;

});

$(document).on('change', '#fileUpload', function(){
  $(".upload-attachments").hide();
  $("#image-upload-loader").show();
  window.fileIsUploading = true;
  if($('#fileUpload').prop('files').length > 0) {
    var file_data = $('#fileUpload').prop('files')[0];
    var form_data = new FormData();
    form_data.append('image', file_data);
    form_data.append('token_id', $("[name='token_id']").val());
  } else if (window.imageBlob != "") {
    var form_data = new FormData();
    var base64ImageContent = window.imageBlob.replace(/^data:image\/(png|gif|jpeg|jpg);base64,/, "");
    form_data.append('blob', base64ImageContent);
    form_data.append('blobName', window.blobName);
    form_data.append('token_id', $("[name='token_id']").val());
  } else {
    window.fileIsUploading = false;
    $("#image-upload-loader").hide();
    $(".upload-attachments").show();
    return false;
  }

  $.ajax({
      url: "/rq/upload",
      type: "POST",
      data: form_data,
      contentType: false,
      cache: false,
      processData:false,
      success: function(data){
        var data = JSON.parse(data);
        if (data.msg == "token"){
          alert("Token mismatch.");
          window.fileIsUploading = false;
          $("#image-upload-loader").hide();
          $(".upload-attachments").show();
          return false;
        }else if(data.msg == "extension"){
          alert("We only allow PNG, JPG, JPEG, GIF, & PDF uploads.");
          window.fileIsUploading = false;
          $("#image-upload-loader").hide();
          $(".upload-attachments").show();
          return false;
        } else if (data.msg == "error"){
          alert("Something went wrong. Please try again. If this persists please contact support.");
          window.fileIsUploading = false;
          $("#image-upload-loader").hide();
          $(".upload-attachments").show();
          return false;
        } else {
          $(".attachment-holder-container").show();
          var newAttachmentString = '<div id="'+data.partial_path.replace(".","")+'"><i class="fa fa-close red-close delete-attachment" name="'+data.partial_path+'"></i> &nbsp; <a href="'+data.full_path+'" target="_blank" data-nd class="attachment_name" name="'+data.partial_path+'">'+data.file_name+'</a></div>';
          $(".attachment-holder").append(newAttachmentString);
          window.fileIsUploading = false;
          $("#image-upload-loader").hide();
          $(".upload-attachments").show();
        }
        return false;
      }
    });

});

$(document).on('click', '.change-password', function() {
  $(".change-password").hide();
  $(".notification-box-error").hide();
  $(".notification-box-success").hide();
  var currentPassword = $("#r_current_password").val();
  var newPassword = $("#r_new_password").val();
  var confirmNewPassword = $("#r_confirm_new_password").val();
  if (newPassword == "" || currentPassword == "" || confirmNewPassword == "") {
    $(".form-return-text-error").text("You need to fill out all the fields.");
    $(".notification-box-error").show();
    $(".change-password").show();
    return false;
  } else if (confirmNewPassword != newPassword) {
    $(".form-return-text-error").text("Your new password and confirm new password doesn't match.");
    $(".notification-box-error").show();
    $(".change-password").show();
    return false;
  } else {
    $(".product-variant-new-product").hide();
    var dataString = "token_id=" + $("[name='token_id']").val() + "&np=" + newPassword + "&cp=" + currentPassword;
    $.ajax({
      type: "POST",
      url: "/rq/change_password",
      data: dataString,
      success: function(data){
        var data = JSON.parse(data);
        if (data.status == 'good') {
          $(".notification-box-success").show();
        } else {
          $(".form-return-text-error").text(data.message);
          $(".notification-box-error").show();
        }
        $(".change-password").show();
      }
    });
    return false;

  }
});
////////////////////////////////////////////////////////////////////////////////


$(document).on('change', '.switch-email', function(){
  var dataString = "token_id=" + $("[name='token_id']").val() + "&type=email&status=" + $(this).val();
  $.ajax({
    type: "POST",
    url: "/rq/notification_settings",
    data: dataString,
    success: function(data){
      var data = JSON.parse(data);
      if (data.status == "good") {
        $(".email-notif-return").css('color', '#008f00').text("Success");
        setTimeout(function() {
          $(".email-notif-return").css('color', '#7a7f8e').text("");
        },3000);
      } else {
        // something went wrong
        $(".email-notif-return").css('color', '#FF0000').text("Something went wrong.");
        setTimeout(function() {
          $(".email-notif-return").css('color', '#7a7f8e').text("");
        },3000);
      }
    }
  });
});

$(document).on('click', '.add_new_award', function() {
  var award_name = $(".award_name").val();
  var award_type = $(".award_type option:selected").val();
  var award_show_year_id = $("#award_show_year_id").val();
  if (award_name == "" || award_type == "") {
    alert("It looks like award name and / or award type are empty.");
    return false;
  }
  $('.add_new_award').hide();
  var dataString = "token_id=" + $("[name='token_id']").val()
                               + "&award_name=" + award_name
                               + "&award_type=" + award_type
                               + "&award_show_year_id=" + award_show_year_id;
  $.ajax({
    type: "POST",
    url: "/rq/new_award",
    data: dataString,
    success: function(data){
      var data = JSON.parse(data);
      if (data.status) {
        alert("Success");
        $('.add_new_award').show();
        $("#edit-award-existing-category").html(data.listAwardsChecklist);
      } else {
        alert("Something went wrong.");
        $('.add_new_award').show();
      }
    }
  });
});

$(document).on('click', '.edit_award_type', function() {
  var award_id = $(this).attr("name");
  var award_name = $("#award_name_text_" + award_id).text();
  var award_type = $("#award_type_text_" + award_id).text();
  $("#edit_award_name_input").val(award_name);
  $("#edit_award_type_input option[value='"+award_type+"']").attr('selected','selected');
  $("#edit_award_id_input").val(award_id);
  $('#edit_award_modal').modal('show');
});

$(document).on('click', '.edit_award_info', function() {
  $(".edit_award_info").hide();
  var award_id = $("#edit_award_id_input").val();
  var edit_award_name_input = $("#edit_award_name_input").val();
  var edit_award_type_input = $("#edit_award_type_input option:selected").val();

  var dataString = "token_id=" + $("[name='token_id']").val()
                               + "&award_id=" + award_id
                               + "&edit_award_name_input=" + edit_award_name_input
                               + "&edit_award_type_input=" + edit_award_type_input;
  $.ajax({
    type: "POST",
    url: "/rq/edit_award",
    data: dataString,
    success: function(data){
      var data = JSON.parse(data);
      if (data.status) {
        alert("Success");
        $('.edit_award_info').show();
        $('#edit_award_modal').modal('hide');
        $("#award_name_text_" + award_id).text(edit_award_name_input);
        $("#award_type_text_" + award_id).text(edit_award_type_input);
      } else {
        alert("Something went wrong.");
        $('.edit_award_info').show();
      }
    }
  });
});

$(document).on('click', '.add_another_row_title', function() {
  var getNewRow = parseInt($(this).attr('name')) + 1;
  $(".add_another_row_title").attr("name", getNewRow);
  var newRow = '<tr class="insert_nom_row" name="'+getNewRow+'">';
    newRow += '<td><input type="text" class="nom_name_'+getNewRow+'"></td>';
    newRow += '<td><input type="text" class="nom_network_'+getNewRow+'"></td>';
    newRow += '<td><input type="text" class="nom_studio_'+getNewRow+'"></td>';
  newRow += '</tr>';
  $(".insert_nom_row_body").append(newRow);
});

$(document).on('click', '.add_another_row_person', function() {
  var getNewRow = parseInt($(this).attr('name')) + 1;
  $(".add_another_row_title").attr("name", getNewRow);
  var newRow = '<tr class="insert_nom_row" name="'+getNewRow+'">';
    newRow += '<td><input type="text" class="nom_name_'+getNewRow+'"></td>';
    newRow += '<td><input type="text" class="nom_network_'+getNewRow+'"></td>';
    newRow += '<td><input type="text" class="nom_studio_'+getNewRow+'"></td>';
    newRow += '<td><input type="text" class="nom_name_'+getNewRow+'"></td>';
    newRow += '<td><input type="text" class="nom_job_title_'+getNewRow+'"></td>';
    newRow += '<td><input type="text" class="nom_character_'+getNewRow+'"></td>';
  newRow += '</tr>';
  $(".insert_nom_row_body").append(newRow);
});

$(document).on('click', '.add_another_row_person_craft', function() {
  var getNewRow = parseInt($(this).attr('name')) + 1;
  $(".add_another_row_title").attr("name", getNewRow);
  var newRow = '<tr class="insert_nom_row" name="'+getNewRow+'">';
    newRow += '<td><input type="text" class="nom_name_'+getNewRow+'"></td>';
    newRow += '<td><input type="text" class="nom_network_'+getNewRow+'"></td>';
    newRow += '<td><input type="text" class="nom_studio_'+getNewRow+'"></td>';
    newRow += '<td><input type="text" class="nom_name_'+getNewRow+'"></td>';
    newRow += '<td><input type="text" class="nom_job_title_'+getNewRow+'"></td>';
    newRow += '<td><input type="text" class="nom_episode_title_'+getNewRow+'"></td>';
    newRow += '<td><input type="text" class="nom_episode_number_'+getNewRow+'"></td>';
  newRow += '</tr>';
  $(".insert_nom_row_body").append(newRow);
});



///////////////////////////////////
////// LEGACY JS WHEN TIME REFACTOR
    $('#select_all').on('click',function(){
        if(this.checked){
            $('.checkbox').each(function(){
                this.checked = true;
            });
        }else{
             $('.checkbox').each(function(){
                this.checked = false;
            });
        }
    });

    $(document).on('change', '.media_conect_with', function() {
      var getVal = $(this).val();
      $(".media_connect").hide();
      $(".media_connection_"+getVal).show();
    });

    $('.checkbox').on('click',function(){
        if($('.checkbox:checked').length == $('.checkbox').length){
            $('#select_all').prop('checked',true);
        }else{
            $('#select_all').prop('checked',false);
        }
    });

    $(".add-new-awards-show-form").on('click', function() {
      if ($("#add-new-awards-show-form").css('display') == 'none') {
        $("#add-new-awards-show-form").slideDown();
      } else {
        $("#add-new-awards-show-form").slideUp();
      }
    });

    $(".add-new-awards-show-submit").on('click', function() {
      var award_show_full_name = $("#award_show_full_name").val();
      var award_show_short_name = $("#award_show_short_name").val();
      var award_show_abbreviation = $("#award_show_abbreviation").val();
      var award_show_website_url = $("#award_show_website_url").val();
      var award_show_admin_flag = $("#award_show_admin_flag").is(":checked");
      var award_show_admin_notes = $("#award_show_admin_notes").val();

      if (! award_show_full_name || ! award_show_short_name || ! award_show_abbreviation || ! award_show_website_url) {
        alert("You need to fill out all the first 4 fields to create a new award show.");
        return false;
      }

      var dataString = "token_id=" + $("[name='token_id']").val() + "&path=add_new_award_show&award_show_full_name=" + award_show_full_name +
                                               "&award_show_short_name=" + award_show_short_name +
                                               "&award_show_abbreviation=" + award_show_abbreviation +
                                               "&award_show_website_url=" + award_show_website_url +
                                               "&award_show_admin_flag=" + award_show_admin_flag +
                                               "&award_show_admin_notes=" + award_show_admin_notes;
      $.ajax({
        type: "POST",
        url: "/Ax3_framework/public/rq/c_ajax",
        data: dataString,
        success: function(data){
          var data = JSON.parse(data);
          if(data.status == "bad"){
            alert(data.message);
          } else {
            alert("Success! Added new Award Show!");
            top.location.reload();
          }
        }
      });
      return false;
    });

    $(document).on('click', ".edit_award_show", function() {
      var edit_award_show_full_name = $("#edit_award_show_full_name").val();
      var edit_award_show_short_name = $("#edit_award_show_short_name").val();
      var edit_award_show_abbreviation = $("#edit_award_show_abbreviation").val();
      var edit_award_show_website_url = $("#edit_award_show_website_url").val();
      var edit_award_show_visible_to_public = $(".edit_award_show_visible_to_public:checked").val();
      var edit_award_show_id = $("#edit_award_show_id").val();

      if (! edit_award_show_full_name || ! edit_award_show_short_name || ! edit_award_show_abbreviation || ! edit_award_show_website_url) {
        alert("You need to fill out all the first 4 fields to edit an award show.");
        return false;
      }

      var dataString = "token_id=" + $("[name='token_id']").val() + "&path=edit_award_show&edit_award_show_full_name=" + edit_award_show_full_name +
                                               "&edit_award_show_short_name=" + edit_award_show_short_name +
                                               "&edit_award_show_abbreviation=" + edit_award_show_abbreviation +
                                               "&edit_award_show_website_url=" + edit_award_show_website_url +
                                               "&edit_award_show_visible_to_public=" + edit_award_show_visible_to_public +
                                               "&edit_award_show_id=" + edit_award_show_id;
      $.ajax({
        type: "POST",
        url: "/Ax3_framework/public/rq/c_ajax",
        data: dataString,
        success: function(data){
          var data = JSON.parse(data);
          if(data.status == "bad"){
            alert(data.message);
          } else {
            alert("Success! Updated!");
            // top.location.reload();
          }
        }
      });
      return false;
    });

    $(document).on('click', '.add_new_show_year_submit', function() {
      var asy_title = $("#asy_title").val();
      var asy_show_number = $("#asy_show_number").val();
      var ns_eligibility_date_from = $("#ns_eligibility_date_from").val();
      var ns_eligibility_date_to = $("#ns_eligibility_date_to").val();
      var ns_ceremony_date = $("#ns_ceremony_date").val();
      var new_as_visible_to_public = $(".new_as_visible_to_public:checked").val();
      var asy_year_existing = $("#asy_year_existing").val();
      var asy_ceremony_date = $("#asy_ceremony_date").val();
      var asy_ceremony_year = $("#asy_ceremony_year").val();
      var asy_ceremony_venue = $("#asy_ceremony_venue").val();
      var asy_hosts = $("#asy_hosts").val();
      var ns_network_select = $("#ns_network_select").val();
      var ns_hours = $("#ns_hours").val();
      var ns_minutes = $("#ns_minutes").val();
      var asy_viewership = $("#asy_viewership").val();
      var asy_viewship_source = $("#asy_viewship_source").val();
      var asy_internal_notes = $("#asy_internal_notes").val();

      var award_show_id = $("#getAwardShowId").val();

      if (! asy_title || ! asy_show_number || ! ns_eligibility_date_from || ! ns_eligibility_date_to || ! ns_ceremony_date || ! new_as_visible_to_public) {
        alert("The fields with * are required..");
        return false;
      }

      var dataString = "token_id=" + $("[name='token_id']").val() + "&path=add_new_award_show_year&asy_title=" + asy_title +
                       "&award_show_id=" + award_show_id +
                       "&asy_show_number=" + asy_show_number +
                       "&ns_eligibility_date_from=" + ns_eligibility_date_from +
                       "&ns_eligibility_date_to=" + ns_eligibility_date_to +
                       "&ns_ceremony_date=" + ns_ceremony_date +
                       "&new_as_visible_to_public=" + new_as_visible_to_public +
                       "&asy_year_existing=" + asy_year_existing +
                       "&asy_ceremony_date=" + asy_ceremony_date +
                       "&asy_ceremony_year=" + asy_ceremony_year +
                       "&asy_ceremony_venue=" + asy_ceremony_venue +
                       "&asy_hosts=" + asy_hosts +
                       "&ns_network_select=" + ns_network_select +
                       "&ns_hours=" + ns_hours +
                       "&ns_minutes=" + ns_minutes +
                       "&asy_viewership=" + asy_viewership +
                       "&asy_viewship_source=" + asy_viewship_source +
                       "&asy_internal_notes=" + asy_internal_notes;
      $.ajax({
        type: "POST",
        url: "/Ax3_framework/public/rq/c_ajax",
        data: dataString,
        success: function(data){
          var data = JSON.parse(data);
          if(data.status == "bad"){
            alert(data.message);
          } else {
            alert("Success! Updated! Refreshing..");
            top.location.reload();
          }
        }
      });
      return false;
    });

    $(document).on('click', '.add_new_show_year_clear', function() {
      var r = confirm("Are you sure you want to clear Add new Show Year? This can't be undone.");
      if (r == true) {
        $("#asy_title").val("");
        $("#asy_show_number").val("");
        $("#ns_eligibility_date_from").val("");
        $("#ns_eligibility_date_to").val("");
        $("#ns_ceremony_date").val("");
        $(".new_as_visible_to_public").prop('checked', false);
        $("#asy_year_existing").val("");
        $("#asy_ceremony_date").val("");
        $("#asy_ceremony_year").val("");
        $("#asy_ceremony_venue").val("");
        $("#asy_hosts").val("");
        $("#ns_network_select").val("");
        $("#ns_hours").val("");
        $("#asy_viewership").val("");
        $("#asy_viewship_source").val("");
        $("#asy_internal_notes").val("");
      }
    });

    $(document).on('click', ".add_new_show_year_button", function() {
      // $(".edit_award_show").addClass("edit_award_show_toggle").removeClass("edit_award_show");
      $(".custom-button").removeClass("active");
      $(this).addClass("active");
      $(".award_show_info_container").hide();
      $(".add_new_show_year_container").show();
    });

    $(document).on('click', ".edit_award_show_toggle", function() {
      // $(".edit_award_show_toggle").addClass("edit_award_show").removeClass("edit_award_show_toggle");
      $(".custom-button").removeClass("active");
      $(this).addClass("active");
      $(".award_show_info_container").show();
      $(".add_new_show_year_container").hide()
    });

    $(document).on('click', ".edit_person_submit", function() {
      var p_first_name = $("#p_first_name").val();
      var p_middle_name = $("#p_middle_name").val();
      var p_last_name = $("#p_last_name").val();
      var p_dob = $("#p_dob").val();
      var p_dod = $("#p_dod").val();
      var p_detailed_desc = $("#p_detailed_desc").val();
      var p_internal_notes = $("#p_internal_notes").val();
      var person_id = $("#person_id").val();
      var p_suffix = $("#p_suffix").val();

      if (! person_id) {
        alert("Something went wrong. The person id was not found.");
        return false;
      }
      if (! p_first_name || ! p_last_name) {
        alert("You need to fill out all the first 4 fields to edit an award show.");
        return false;
      }

      var dataString = "token_id=" + $("[name='token_id']").val() + "&path=edit_person&p_first_name=" + p_first_name +
                                         "&p_middle_name=" + p_middle_name +
                                         "&p_last_name=" + p_last_name +
                                         "&p_dob=" + p_dob +
                                         "&p_dod=" + p_dod +
                                         "&p_detailed_desc=" + p_detailed_desc +
                                         "&person_id=" + person_id +
                                         "&p_suffix=" + p_suffix +
                                         "&p_internal_notes=" + p_internal_notes;
                                         // alert(dataString);
                                         // return false;
      $.ajax({
        type: "POST",
        url: "/Ax3_framework/public/rq/c_ajax",
        data: dataString,
        success: function(data){
          var data = JSON.parse(data);
          if(data.status == "bad"){
            alert(data.message);
          } else {
            alert("Success! Updated!");
            // top.location.reload();
          }
        }
      });
      return false;
    });

    $(document).on('click', '.toggle_media_upload_container', function(){
      if ($(".add_media_container").css('display') == "none") {
        $(".add_media_container").slideDown();
        $(".toggle_media_upload_container").text("Close");
      } else {
        $(".add_media_container").slideUp();
        $(".toggle_media_upload_container").text("Add New Media");
      }
    });


    $(document).on('click', '.change-sample-column', function() {
      var currentSampleColumnName = $(".sample-column-award-name").text();
      $("#exampleModalLongTitle").text("Choose a Sample Award - " + currentSampleColumnName + " (selected)");
      $('#change_sample_column_mod').modal('show')

    });

    $(document).on('click', '.change_sample_award', function() {
      $(".change_sample_award").hide();
      $(".change_sample_award_loading").show();
      var getAwardId = $('input[name="select_sample_award_radio"]:checked').val();
      var getAwardShowId = $("#getAwardShowId").val();
      var cleanUrl = window.location.href.split('/?sample=');
      top.location.href = cleanUrl[0] + "/?sample=" + getAwardId;
    });




$(document).on('click', '#award_show_year_notes_submit', function() {
	$(this).hide();

	if ($("#asy_internal_notes_textarea").val() == "") {
		alert("You need to enter somethiing to submit an internal note.");
		return false;
	}

	var award_show_year_id = $("#award_show_year_id").val();
	var dataString = "token_id=" + $("[name='token_id']").val() + "&path=new_internal_note&type=award_show_year&associated_id="+award_show_year_id+"&the_note="+$("#asy_internal_notes_textarea").val();
	$.ajax({
		type: "POST",
		url: "/Ax3_framework/public/rq/c_ajax",
		data: dataString,
		success: function(data){
			var data = JSON.parse(data);
			if(data.status == "bad"){
				alert(data.message);
			} else {
				$("#asy_internal_notes_textarea").val("");
				$(".internal_notes_tbody").prepend(data.html);

				$(".award_show_year_notes_submit").show();
			}
		}
	});
	return false;
});

$(document).on('click', '.edit_show_year_submit', function() {
	var asy_title = $("#asy_title").val();
	var asy_show_number = $("#asy_show_number").val();
	var ns_eligibility_date_from = $("#ns_eligibility_date_from").val();
	var ns_eligibility_date_to = $("#ns_eligibility_date_to").val();
	var ns_ceremony_date = $("#ns_ceremony_date").val();
	var new_as_visible_to_public = $("#new_as_visible_to_public:checked").val();
	var asy_year_existing = $("#asy_year_existing").val();
	var asy_ceremony_date = $("#asy_ceremony_date").val();
	var asy_ceremony_year = $("#asy_ceremony_year").val();
	var asy_ceremony_venue = $("#asy_ceremony_venue").val();
	var asy_hosts = $("#asy_hosts").val();
	var ns_network_select = $("#ns_network_select").val();
	var ns_hours = $("#ns_hours").val();
	var ns_minutes = $("#ns_minutes").val();
	var asy_viewership = $("#asy_viewership").val();
	var asy_viewship_source = $("#asy_viewship_source").val();
	// var asy_internal_notes = $("#asy_internal_notes").val();

	var award_show_year_id = $("#award_show_year_id").val();

	if (! asy_title || ! asy_show_number || ! ns_eligibility_date_from || ! ns_eligibility_date_to || ! ns_ceremony_date || ! new_as_visible_to_public) {
		alert("The fields with * are required..");
		return false;
	}

	var dataString = "token_id=" + $("[name='token_id']").val() + "&path=edit_award_show_year&asy_title=" + asy_title +
									 "&award_show_year_id=" + award_show_year_id +
									 "&asy_show_number=" + asy_show_number +
									 "&ns_eligibility_date_from=" + ns_eligibility_date_from +
									 "&ns_eligibility_date_to=" + ns_eligibility_date_to +
									 "&ns_ceremony_date=" + ns_ceremony_date +
									 "&new_as_visible_to_public=" + new_as_visible_to_public +
									 "&asy_year_existing=" + asy_year_existing +
									 "&asy_ceremony_date=" + asy_ceremony_date +
									 "&asy_ceremony_year=" + asy_ceremony_year +
									 "&asy_ceremony_venue=" + asy_ceremony_venue +
									 "&asy_hosts=" + asy_hosts +
									 "&ns_network_select=" + ns_network_select +
									 "&ns_hours=" + ns_hours +
									 "&ns_minutes=" + ns_minutes +
									 "&asy_viewership=" + asy_viewership +
									 "&asy_viewship_source=" + asy_viewship_source;
									 // "&asy_internal_notes=" + asy_internal_notes;
	$.ajax({
		type: "POST",
		url: "/Ax3_framework/public/rq/c_ajax",
		data: dataString,
		success: function(data){
			var data = JSON.parse(data);
			if(data.status == "bad"){
				alert(data.message);
			} else {
				alert("Success! Updated! Refreshing..");
				top.location.reload();
			}
		}
	});
	return false;
});

$(document).on('click', '#change-awards-submit', function() {

	var award_show_year_id = $("#award_show_year_id").val();
	var award_checkbox = "";
	$(".award_checkbox").each(function() {
		if ($(this).is(":checked")) {
			if (award_checkbox == "") {
				award_checkbox = $(this).val();
			} else {
				award_checkbox = award_checkbox + "," + $(this).val();
			}
		}
	});
	var dataString = "token_id=" + $("[name='token_id']").val() + "&path=edit_awards_to_award_show_year&award_checkbox=" + award_checkbox +
									 "&award_show_year_id=" + award_show_year_id;
	$.ajax({
		type: "POST",
		url: "/Ax3_framework/public/rq/c_ajax",
		data: dataString,
		success: function(data){
			var data = JSON.parse(data);
			if(data.status == "bad"){
				alert(data.message);
			} else {
				alert("Success! Updated! Refreshing..");
				top.location.reload();
			}
		}
	});
	return false;
});

$(document).on('click', '.edit_award_show_year_toggle', function() {
		$(".custom-button").removeClass("active");
		$(this).addClass("active");
		$(".edit_award_show_year_container").show();
		$(".award_show_year_categories_container").hide();
		$(".award_show_year_notes_container").hide();
})

$(document).on('click', '.edit_award_show_year_awards_toggle', function() {
		$(".custom-button").removeClass("active");
		$(this).addClass("active");
		$(".edit_award_show_year_container").hide();
		$(".award_show_year_categories_container").show();
		$(".award_show_year_notes_container").hide();
});

$(document).on('click', '.award_show_year_notes_toggle', function() {
		$(".custom-button").removeClass("active");
		$(this).addClass("active");
		$(".edit_award_show_year_container").hide();
		$(".award_show_year_categories_container").hide();
		$(".award_show_year_notes_container").show();
});

$(function() {
  $( "#ns_ceremony_date" ).datepicker({
    changeMonth: true,
    changeYear: true
  });
  $( "#ns_eligibility_date_from" ).datepicker({
    changeMonth: true,
    changeYear: true
  });
  $( "#ns_eligibility_date_to" ).datepicker({
    changeMonth: true,
    changeYear: true
  });
  $( "#p_dob" ).datepicker({
    changeMonth: true,
    changeYear: true,
    maxDate: "+2Y",
    minDate: "-100Y",
    yearRange: "-100:+2"
  });
  $( "#p_dod" ).datepicker({
    changeMonth: true,
    changeYear: true,
    maxDate: "+2Y",
    minDate: "-100Y",
    yearRange: "-100:+2"
  });

  $('#ns_person_select').selectize();
  $('#ns_project_select').selectize();
  $('#ns_vendor_select').selectize();
  $('#ns_product_select').selectize();
  $('#ns_studio_select').selectize();
  $('#ns_network_select').selectize();
});
