jQuery(document).ready(function ($) {
  // jQuery Tabs
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
});
