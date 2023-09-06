(function ($) {
  $(document).ready(function () {
    $(".panda-custom-dropdown-content").hide();
    $(".panda-custom-menu").click(function (e) {
      e.preventDefault();
      $(".panda-custom-dropdown-content").toggle();
    });
  });

  function setup_collapsible_submenus() {
    // mobile menu
    $(".mobile_nav .menu-item-has-children > a").after(
      '<span class="menu-closed"></span>'
    );
    $(".mobile_nav .menu-item-has-children > a").each(function () {
      $(this).next().next(".sub-menu").toggleClass("hide", 1000);
    });
    $(".mobile_nav .menu-item-has-children > a + span").on(
      "click",
      function (event) {
        event.preventDefault();
        $(this).toggleClass("menu-open");
        $(this).next(".sub-menu").toggleClass("hide", 1000);
      }
    );
  }

  $(window).load(function () {
    setTimeout(function () {
      setup_collapsible_submenus();
    }, 0);
  });
})(jQuery);
