jQuery(document).ready(function ($) {
  var panda_file_frame;

  jQuery(".panda-upload-image-button").on("click", function (event) {
    var this_el = jQuery(this),
      button_text = this_el.data("button_text"),
      window_title = panda_uploader.media_window_title,
      fileInput = this_el.parent().prev("input.panda-upload-field");

    event.preventDefault();

    panda_file_frame = wp.media.frames.panda_file_frame = wp.media({
      title: window_title,
      library: {
        type: "image",
      },
      button: {
        text: button_text,
      },
      multiple: false,
    });

    panda_file_frame.on("select", function () {
      var attachment = panda_file_frame.state().get("selection").first().toJSON();
      fileInput.val(attachment.url);
    });

    panda_file_frame.open();

    return false;
  });
});
