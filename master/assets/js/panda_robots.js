jQuery(document).ready(function ($) {
  // Init tabs
  $("#panda-tabs")
    .tabs({
      activate: function (event, ui) {
        localStorage.setItem(
          "panda-tabs",
          $("#panda-tabs").tabs("option", "active")
        );
      },
      active: localStorage.getItem("panda-tabs") || 0,
    })
    .show();

  // Helper for swithcing tabs & linking anchors in different tabs
  $(".toplevel_page_panda_robots").on("click", ".change-tab", function (e) {
    e.preventDefault();

    $("#panda-tabs").tabs("option", "active", $(this).data("tab"));

    // get the link anchor and scroll to it
    target = this.href.split("#")[1];
    if (target) {
      $.scrollTo("#" + target, 500, { offset: { top: -50, left: 0 } });
    }

    $(this).blur();
    return false;
  });
});
