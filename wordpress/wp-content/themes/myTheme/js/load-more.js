jQuery(function ($) {
  var page = load_more_params.current_page;
  var loading = false;

  $("#load-more").on("click", function () {
    if (loading) return;
    loading = true;

    page++;

    $.ajax({
      url: load_more_params.ajax_url,
      type: "POST",
      data: {
        action: "load_more_posts",
        page: page,
      },
      success: function (response) {
        if (response) {
          $("#post-container").append(response);
        } else {
          $("#load-more").hide();
        }
        loading = false;
      },
    });
  });
});

document.addEventListener("DOMContentLoaded", function () {
  // Get all filter checkboxes
  const filterCheckboxes = document.querySelectorAll(".filter-checkbox");

  // Loop through each checkbox
  filterCheckboxes.forEach(function (checkbox) {
    checkbox.addEventListener("change", function () {
      if (checkbox.checked) {
        // Add 'active' class to the parent label when checkbox is checked
        checkbox.parentElement.classList.add("active");
      } else {
        // Remove 'active' class when checkbox is unchecked
        checkbox.parentElement.classList.remove("active");
      }
    });
  });
});
