function NAQ_like_btn_ajax(postId, usrid) {
  var post_id = postId;
  var user_id = usrid;

  jQuery.ajax({
    url: NAQ_ajax_url.ajax_url, // Ensure NAQ_ajax_url.ajax_url is correctly localized in your PHP
    type: "post",
    data: {
      action: "NAQ_like_btn_ajax_action", // Action name for your AJAX handler
      pid: post_id,
      uid: user_id,
    },
    success: function (response) {
      jQuery("#NAQAjaxResponse span").html(response);
    },
    error: function (xhr, status, error) {
      console.log("AJAX Error: " + status + " - " + error);
    },
  });
}
