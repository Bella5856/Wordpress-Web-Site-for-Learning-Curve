jQuery(document).ready(function ($) {
  // Handle "Save Your Spot" form submission via AJAX
  $("#save-your-spot-form").on("submit", function (e) {
    e.preventDefault();

    var email = $("#save-your-spot-email").val();
    var nonce = custom_ajax_obj.nonce;

    $.ajax({
      type: "POST",
      url: custom_ajax_obj.ajax_url,
      data: {
        action: "handle_save_your_spot_ajax",
        email_for_save_your_spot: email,
        save_your_spot_nonce: nonce,
      },
      success: function (response) {
        $("#save-your-spot-response").html(response);
        $("#save-your-spot-form")[0].reset();
      },
      error: function () {
        $("#save-your-spot-response").html(
          '<p class="save-your-spot-error">An unexpected error occurred. Please try again later.</p>'
        );
      },
    });
  });

  // Handle Newsletter form submission via AJAX
  $("#newsletter-form").on("submit", function (e) {
    e.preventDefault();

    var email = $("#email-for-newsletter").val();
    var nonce = custom_ajax_obj.nonce;

    $.ajax({
      type: "POST",
      url: custom_ajax_obj.ajax_url,
      data: {
        action: "handle_newsletter_ajax",
        email_for_newsletter: email,
        newsletter_nonce: nonce,
      },
      success: function (response) {
        $("#newsletter-response").html(response);
        $("#newsletter-form")[0].reset();
      },
      error: function () {
        $("#newsletter-response").html(
          '<p class="newsletter-error">An unexpected error occurred. Please try again later.</p>'
        );
      },
    });
  });
});
