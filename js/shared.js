jQuery(document).ready(function ($) {
  // -_-_-_-_- Rolex cookies -_-_-_-_- //

  // -_-_-_-_- Rolex retailer clock logo -_-_-_-_- //
  var rdp = new RolexRetailerClock();
  var rdpConfig = {
    dealerAPIKey: "c4ee227dac0acf64c88ec4df25bd0b2d",
    lang: "en_ca",
    colour: "gold",
  };
  try {
    rdp.getRetailerClock(rdpConfig);
  } catch (err) {}

  // -_-_-_-_- Tab functionality for focus states -_-_-_-_- //

  function handleFirstTab(e) {
    if (e.keyCode === 9) {
      // the "I am a keyboard user" key
      document.body.classList.add("user-is-tabbing");
      window.removeEventListener("keydown", handleFirstTab);
    }
  }
  window.addEventListener("keydown", handleFirstTab);

  // -_-_-_-_- Back-to-top button functionality -_-_-_-_- //
  var btn = $("#back-to-top__button");

  $(window).scroll(function () {
    if ($(window).scrollTop() > 300) {
      btn.addClass("show");
    } else {
      btn.removeClass("show");
    }
  });

  btn.on("click", function (e) {
    e.preventDefault();
    $("html, body").animate({ scrollTop: 0 }, "300");
  });

  // -_-_-_-_- Site-wide search functionality -_-_-_-_- //
  const $headerSearchOpen = $(".site-header .search .openBtn");
  const $headerSearchClose = $(".site-header .search .closeBtn");
  const $headerSearchForm = $(".site-header .header-search-wrap");

  $headerSearchOpen.on("click", function (e) {
    let $siteHeaderHeight = $(".site-header").outerHeight();
    if ($("body").hasClass("logged-in") && $(window).width() <= 783) {
      $siteHeaderHeight = $(".site-header").outerHeight() + 14;
    }

    // Prevent the click event from bubbling up to the document
    e.stopPropagation();

    $headerSearchForm.toggleClass("active");

    // Hide the search form if visible
    if ($headerSearchForm.css("opacity") == 1) {
      $headerSearchForm.css({
        opacity: 0,
      });
    }
    // Show the search form if hidden
    else {
      $headerSearchForm.css({
        opacity: 1,
        top: $siteHeaderHeight,
      });
      $headerSearchForm.find($(".search-form-input")).focus();
    }
  });

  $headerSearchClose.on("click", function (e) {
    $headerSearchForm.toggleClass("active");

    if ($headerSearchForm.css("opacity") == 1) {
      $headerSearchForm.css({
        opacity: 0,
      });
    }
  });

  // -_-_-_-_- Navigation on scroll animation -_-_-_-_- //

  $(window).scroll(function () {
    var scroll = $(window).scrollTop();

    if (scroll >= 75) {
      $(".site-header").addClass("headerOnScroll");
    } else {
      $(".site-header").removeClass("headerOnScroll");
    }
  });

  // -_-_-_-_- Smoothcroll -_-_-_-_- //
  var smoothScrollTarget = $(".smooth-scroll");
  $(smoothScrollTarget).on("click", function (event) {
    event.preventDefault();

    $("html, body").animate(
      {
        scrollTop: $($.attr(this, "href")).offset().top - 250,
      },
      500
    );
  });

  // Scroll progress bar functionality
  $(window).scroll(function () {
    var winScroll =
      document.body.scrollTop || document.documentElement.scrollTop;
    var height =
      document.documentElement.scrollHeight -
      document.documentElement.clientHeight;
    var scrolled = (winScroll / height) * 100;

    $(".progress-bar").css("width", scrolled + "%");
  });

  // -_-_-_-_- Compensating for site-header height and adjusting specified element's CSS when this changes -_-_-_-_- //
  const compensateForHeaderHeight = function () {
    let siteHeaderHeight = $(".site-header").outerHeight();
    let siteHeaderHeightLoggedIn = siteHeaderHeight + 32;
    if ($(window).width() <= 783) {
      siteHeaderHeightLoggedIn = siteHeaderHeight + 46;
    }

    $(".site-inner.not-found, body.search main.content").css(
      "margin-top",
      siteHeaderHeight
    );
    $(
      ".site-inner .hero-primary, .site-inner .hero-secondary, .site-inner.rolex-post"
    ).css("padding-top", siteHeaderHeight);

    if ($(window).width() <= 960 && $("body").hasClass("logged-in")) {
      $(".site-header .genesis-responsive-menu").css(
        "top",
        siteHeaderHeightLoggedIn + "px"
      );
      $(".js .nav-primary > .wrap").css(
        "height",
        "calc(100% - " + siteHeaderHeightLoggedIn + "px)"
      );
    } else if ($(window).width() <= 960) {
      $(".site-header .genesis-responsive-menu").css(
        "top",
        siteHeaderHeight + "px"
      );
      $(".js .nav-primary > .wrap").css(
        "height",
        "calc(100% - " + siteHeaderHeight + "px)"
      );
    }

    if ($("body").hasClass("logged-in")) {
      $(
        ".site-inner .hero-primary .hero-slider, .site-inner .hero-primary .hero-slider .slick-list, .site-inner .hero-primary .hero-slider .slick-track"
      ).css("height", "calc(100vh - " + siteHeaderHeightLoggedIn + "px)");
      $(
        ".genesis-responsive-menu .genesis-nav-menu .full-width-menu-item > .sub-menu, .progress-bar-wrap"
      ).css("top", siteHeaderHeightLoggedIn);
    } else {
      $(
        ".site-inner .hero-primary .hero-slider, .site-inner .hero-primary .hero-slider .slick-list, .site-inner .hero-primary .hero-slider .slick-track"
      ).css("height", "calc(100vh - " + siteHeaderHeight + "px)");
      $(
        ".genesis-responsive-menu .genesis-nav-menu .full-width-menu-item > .sub-menu, .progress-bar-wrap"
      ).css("top", siteHeaderHeight);
    }
  };
  $(window).on("load resize", compensateForHeaderHeight);

  // -_-_-_-_- Full width menu items -_-_-_-_- //
  const fullWidthMenuItemFunction = function () {
    const menuItems = $(
      ".genesis-responsive-menu .genesis-nav-menu .full-width-menu-item > .sub-menu > .menu-item"
    );

    if ($(window).width() >= 960) {
      // Add hover event listeners to each menu item
      menuItems.hover(
        function () {
          // Remove "active" class from all sibling menu items
          $(this).siblings().removeClass("active");
          // Add "active" class to the hovered menu item
          $(this).addClass("active");
        },
        function () {
          // Do nothing on mouse leave
        }
      );

      const animateMenuItems = $(
        ".genesis-responsive-menu .genesis-nav-menu .menu-item"
      );
      animateMenuItems.each(function () {
        var subMenu = $(this).find(".sub-menu");

        subMenu.children().each(function (index) {
          // Calculate the animation delay
          if (index >= 0) {
            var animationDelay = index * 35;
          }

          // Apply the animation delay to the current list item
          $(this).css("animation-delay", animationDelay + "ms");
        });
      });
    }
  };
  $(window).on("load", fullWidthMenuItemFunction);

  // Adding the Chopard image link container to the full width menu
  const addChopardMenuContainer = function () {
    var chopardContainer = $("<div></div>").addClass("chopard-container");

    // Create HTML elements for the product
    var containerLink = $("<a></a>")
      .addClass("image-link")
      .attr("href", "https://globalwatchco.com/chopard/");
    var image = $("<img>")
      .addClass("background-image")
      .attr(
        "src",
        "https://gwcdevelopingtestserver.com/wp-content/uploads/2024/01/GWC-homepage-we-value.webp"
      );
    var label = $("<h4></h4>").text("Explore Chopard");

    // Nest image and title inside a link tag
    containerLink.append(image, label);

    // Append the imageLink, titleLink and differentiator to the list item
    chopardContainer.append(containerLink);

    // Append the list item to the target
    $("#menu-item-9128 > .sub-menu").append(chopardContainer);
  };
  $(window).on("load", addChopardMenuContainer);

  // -_-_-_-_- Responsive menu customizations -_-_-_-_- //
  $(window).bind("load", function () {
    $("#genesis-mobile-nav-primary").on("click", function () {
      $("body").toggleClass("noscroll");
      $(".nav-primary").css("display", "inline-block");

      // When menu is being closed, also close the search form (if this is currently open)
      if (!$(this).hasClass("activated")) {
        if ($headerSearchForm.css("opacity") == 1) {
          $headerSearchForm.css({
            opacity: 0,
          });
        }
      }
    });
  });

  $(window)
    .resize(function () {
      if ($(window).width() >= 960) {
        // if larger or equal
        $(".nav-primary").css("display", "");
      }
    })
    .resize();

  // -_-_-_-_- Generic Accordion functionality -_-_-_-_- //
  const accordionHeads = $(".accordion-head");

  const accordionFunction = function (e) {
    $(this).on("click", function () {
      // Toggle between adding and removing the "active" class
      $(this).toggleClass("active");

      /* Toggle between hiding and showing the active accordion body */
      const accordionBody = this.nextElementSibling;
      if (accordionBody.style.maxHeight) {
        accordionBody.style.maxHeight = null;
      } else {
        accordionBody.style.maxHeight = accordionBody.scrollHeight + "px";
      }
    });
  };

  $(accordionHeads).each(accordionFunction);

  // adding class to last accordion
  $(".ql-accordion").last().addClass("last");

  // Initializing the sliders
  var heroSlider = $(".hero-primary .hero-slider");
  $(heroSlider).slick({
    adaptiveHeight: false,
    dots: true,
    slidesToShow: 1,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 4000,
    prevArrow: '<button type="button" class="slick-prev slick-arrow"></button>',
    nextArrow: '<button type="button" class="slick-next slick-arrow"></button>',
  });

  // Making the hero section clickable
  var heroSlides = $(".hero-primary .hero-slider .hero-slide");
  $(heroSlides).each(function () {
    var heroButton = $(this).find(".hero-content .button");
    // If there's no buttons, return
    if (!heroButton.length) {
      return;
    }

    var heroLink = heroButton[0].getAttribute("href");
    $(this).addClass("slide-has-button");
    $(this).wrapInner('<a href="' + heroLink + '"></a>');
  });

  // -_-_-_-_- Adding margins to content elements on generic and single pages -_-_-_-_- //
  $(".main-generic > .entry, .main-single > .entry").children().css({
    "max-width": "1250px",
    "margin-left": "auto",
    "margin-right": "auto",
  });

  // -_-_-_-_- Changing primary hero featured images src on smaller screen sizes -_-_-_-_- //
  var lazyImages = document.querySelectorAll(
    ".hero-primary .hero-background-img"
  );
  var lazyVideos = document.querySelectorAll(
    ".hero-primary .hero-background-video"
  );

  var lazyLoad = function (e) {
    screenWidth = window.innerWidth;

    for (var i = 0; i < lazyImages.length; i++) {
      if (screenWidth > 783) {
        lazyImages[i].src = lazyImages[i].getAttribute("data-src-desktop");
      } else if (screenWidth < 783) {
        lazyImages[i].src = lazyImages[i].getAttribute("data-src-mobile");
      }
    }

    for (var i = 0; i < lazyVideos.length; i++) {
      if (screenWidth > 783) {
        lazyVideos[i].src = lazyVideos[i].getAttribute("data-src-desktop");
      } else if (screenWidth < 783) {
        lazyVideos[i].src = lazyVideos[i].getAttribute("data-src-mobile");
      }
    }
  };

  // lazyLoad(); // Initial load

  window.addEventListener("load", lazyLoad);
  window.addEventListener("resize", lazyLoad);

  // Image resizing
  function removeImgSrcset() {
    let ImageEl = document.querySelectorAll(".hero-background-img");

    for (var i = 0; i < ImageEl.length; i++) {
      let srcSet = ImageEl[i].getAttribute("srcset");

      if (srcSet) {
        ImageEl[i].removeAttribute("srcset");
      }
    }
  }
  removeImgSrcset();
});
