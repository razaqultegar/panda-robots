jQuery(function ($) {
  // panda_single_product_params is required to continue.
  if (typeof panda_single_product_params === "undefined") {
    return false;
  }

  /**
   * Product gallery class.
   */
  var ProductGallery = function ($target, args) {
    this.$target = $target;
    this.$images = $(".panda-product-gallery__image", $target);

    // No images? Abort.
    if (0 === this.$images.length) {
      this.$target.css("opacity", 1);
      return;
    }

    // Make this object available.
    $target.data("product_gallery", this);

    // Pick functionality to initialize...
    this.flexslider_enabled =
      "function" === typeof $.fn.flexslider &&
      panda_single_product_params.flexslider_enabled;
    this.zoom_enabled =
      "function" === typeof $.fn.zoom &&
      panda_single_product_params.zoom_enabled;
    this.photoswipe_enabled =
      typeof PhotoSwipe !== "undefined" &&
      panda_single_product_params.photoswipe_enabled;

    // ...also taking args into account.
    if (args) {
      this.flexslider_enabled =
        false === args.flexslider_enabled ? false : this.flexslider_enabled;
      this.zoom_enabled =
        false === args.zoom_enabled ? false : this.zoom_enabled;
      this.photoswipe_enabled =
        false === args.photoswipe_enabled ? false : this.photoswipe_enabled;
    }

    // ...and what is in the gallery.
    if (1 === this.$images.length) {
      this.flexslider_enabled = false;
    }

    // Bind functions to this.
    this.initFlexslider = this.initFlexslider.bind(this);
    this.initZoom = this.initZoom.bind(this);
    this.initZoomForTarget = this.initZoomForTarget.bind(this);
    this.initPhotoswipe = this.initPhotoswipe.bind(this);
    this.onResetSlidePosition = this.onResetSlidePosition.bind(this);
    this.getGalleryItems = this.getGalleryItems.bind(this);
    this.openPhotoswipe = this.openPhotoswipe.bind(this);

    if (this.flexslider_enabled) {
      this.initFlexslider(args.flexslider);
      $target.on(
        "panda_gallery_reset_slide_position",
        this.onResetSlidePosition
      );
    } else {
      this.$target.css("opacity", 1);
    }

    if (this.zoom_enabled) {
      this.initZoom();
      $target.on("panda_gallery_init_zoom", this.initZoom);
    }

    if (this.photoswipe_enabled) {
      this.initPhotoswipe();
    }
  };

  /**
   * Initialize flexSlider.
   */
  ProductGallery.prototype.initFlexslider = function (args) {
    var $target = this.$target,
      gallery = this;

    var options = $.extend(
      {
        selector:
          ".panda-product-gallery__wrapper > .panda-product-gallery__image",
        start: function () {
          $target.css("opacity", 1);
        },
        after: function (slider) {
          gallery.initZoomForTarget(gallery.$images.eq(slider.currentSlide));
        },
      },
      args
    );

    $target.flexslider(options);

    // Trigger resize after main image loads to ensure correct gallery size.
    $(
      ".panda-product-gallery__wrapper .panda-product-gallery__image:eq(0) .wp-post-image"
    )
      .one("load", function () {
        var $image = $(this);

        if ($image) {
          setTimeout(function () {
            var setHeight = $image
              .closest(".panda-product-gallery__image")
              .height();
            var $viewport = $image.closest(".flex-viewport");

            if (setHeight && $viewport) {
              $viewport.height(setHeight);
            }
          }, 100);
        }
      })
      .each(function () {
        if (this.complete) {
          $(this).trigger("load");
        }
      });
  };

  /**
   * Init zoom.
   */
  ProductGallery.prototype.initZoom = function () {
    this.initZoomForTarget(this.$images.first());
  };

  /**
   * Init zoom.
   */
  ProductGallery.prototype.initZoomForTarget = function (zoomTarget) {
    if (!this.zoom_enabled) {
      return false;
    }

    var galleryWidth = this.$target.width(),
      zoomEnabled = false;

    $(zoomTarget).each(function (index, target) {
      var image = $(target).find("img");

      if (image.data("large_image_width") > galleryWidth) {
        zoomEnabled = true;
        return false;
      }
    });

    // But only zoom if the img is larger than its container.
    if (zoomEnabled) {
      var zoom_options = $.extend(
        {
          touch: false,
        },
        panda_single_product_params.zoom_options
      );

      if ("ontouchstart" in document.documentElement) {
        zoom_options.on = "click";
      }

      zoomTarget.trigger("zoom.destroy");
      zoomTarget.zoom(zoom_options);

      setTimeout(function () {
        if (zoomTarget.find(":hover").length) {
          zoomTarget.trigger("mouseover");
        }
      }, 100);
    }
  };

  /**
   * Init PhotoSwipe.
   */
  ProductGallery.prototype.initPhotoswipe = function () {
    if (this.zoom_enabled && this.$images.length > 0) {
      this.$target.on(
        "click",
        ".panda-product-gallery__image",
        this.openPhotoswipe
      );
      this.$target.on("click", ".panda-product-gallery__image a", function (e) {
        e.preventDefault();
      });

      // If flexslider is disabled, gallery images also need to trigger photoswipe on click.
      if (!this.flexslider_enabled) {
        this.$target.on(
          "click",
          ".panda-product-gallery__image a",
          this.openPhotoswipe
        );
      }
    } else {
      this.$target.on(
        "click",
        ".panda-product-gallery__image a",
        this.openPhotoswipe
      );
    }
  };

  /**
   * Reset slide position to 0.
   */
  ProductGallery.prototype.onResetSlidePosition = function () {
    this.$target.flexslider(0);
  };

  /**
   * Get product gallery image items.
   */
  ProductGallery.prototype.getGalleryItems = function () {
    var $slides = this.$images,
      items = [];

    if ($slides.length > 0) {
      $slides.each(function (i, el) {
        var img = $(el).find("img");

        if (img.length) {
          var large_image_src = img.attr("data-large_image"),
            large_image_w = img.attr("data-large_image_width"),
            large_image_h = img.attr("data-large_image_height"),
            alt = img.attr("alt"),
            item = {
              alt: alt,
              src: large_image_src,
              w: large_image_w,
              h: large_image_h,
              title: img.attr("data-caption")
                ? img.attr("data-caption")
                : img.attr("title"),
            };
          items.push(item);
        }
      });
    }

    return items;
  };

  /**
   * Open photoswipe modal.
   */
  ProductGallery.prototype.openPhotoswipe = function (e) {
    e.preventDefault();

    var pswpElement = $(".pswp")[0],
      items = this.getGalleryItems(),
      eventTarget = $(e.target),
      clicked;

    if (0 < eventTarget.closest(".panda-product-gallery__image").length) {
      clicked = this.$target.find(".flex-active-slide");
    } else {
      clicked = eventTarget.closest(".panda-product-gallery__image");
    }

    var options = $.extend(
      {
        index: $(clicked).index(),
        addCaptionHTMLFn: function (item, captionEl) {
          if (!item.title) {
            captionEl.children[0].textContent = "";
            return false;
          }
          captionEl.children[0].textContent = item.title;
          return true;
        },
      },
      panda_single_product_params.photoswipe_options
    );

    // Initializes and opens PhotoSwipe.
    var photoswipe = new PhotoSwipe(
      pswpElement,
      PhotoSwipeUI_Default,
      items,
      options
    );
    photoswipe.init();
  };

  /**
   * Function to call panda_product_gallery on jquery selector.
   */
  $.fn.panda_product_gallery = function (args) {
    new ProductGallery(this, args || panda_single_product_params);
    return this;
  };

  /*
   * Initialize all galleries on page.
   */
  $(".panda-product-gallery").each(function () {
    $(this).trigger("panda-product-gallery-before-init", [
      this,
      panda_single_product_params,
    ]);

    $(this).panda_product_gallery(panda_single_product_params);

    $(this).trigger("panda-product-gallery-after-init", [
      this,
      panda_single_product_params,
    ]);
  });

  $(".product-content_more").click(function () {
    $(".product-content_description").attr("style", function (index, attr) {
      return attr == "height: 160px;" ? null : "height: 160px;";
    });
    $(".product-content_mask").toggle();

    $(this).toggleClass("close");

    if ($(this).hasClass("close")) {
      $(this).html("Lihat lebih sedikit");
    } else {
      $(this).html("Lihat selengkapnya");
    }
  });
});
