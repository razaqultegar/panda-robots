jQuery(document).ready(function ($) {
  if ($("body").hasClass("toplevel_page_panda_robots")) {
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

    // Init color picker
    $("#accent_color").wpColorPicker({
      change: function (event, ui) {
        $(".color-alpha").css("backgroundColor", ui.color.toString());
      },
    });
    $(".wp-color-result").attr("title", "Pilih Warna");
    $(".wp-color-result").attr("data-current", "Warna Sekarang");

    var currentColor = $("#accent_color").data("default-color");
    function hexToRgb(hex) {
      var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
      return result
        ? {
            r: parseInt(result[1], 16),
            g: parseInt(result[2], 16),
            b: parseInt(result[3], 16),
          }
        : null;
    }

    $(".wp-color-result-text").after(
      '<span class="color-alpha" style="width: 100%;height: 100%;position: absolute;top: 0px;left: 0px;border-top-left-radius: 3px;border-bottom-left-radius: 3px;background: rgb(' +
        hexToRgb(currentColor).r +
        ", " +
        hexToRgb(currentColor).g +
        ", " +
        hexToRgb(currentColor).b +
        ');"></span>'
    );
  }
});
