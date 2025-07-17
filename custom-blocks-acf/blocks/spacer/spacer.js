const spacers = document.querySelectorAll(".ql-spacer");

const addResponsiveHeight = function () {
  spacers.forEach(function (e) {
    let screenWidth = window.innerWidth;
    const spacer = e;

    // Storing height values
    const spacerDesktopHeight = spacer.getAttribute("data-height-desktop");
    const spacerTabletHeight = spacer.getAttribute("data-height-tablet");
    const spacerMobileHeight = spacer.getAttribute("data-height-mobile");
    const isResponsive = spacer.classList.contains("is-responsive");

    // Adding appropriate inline height styles based on screen width
    if (
      (screenWidth > 960 && spacerDesktopHeight) ||
      (!isResponsive && spacerDesktopHeight)
    ) {
      spacer.style.height = spacerDesktopHeight + "px";
    }
    if (screenWidth < 960 && isResponsive && spacerTabletHeight >= 0) {
      spacer.style.height = spacerTabletHeight + "px";
    }
    if (screenWidth < 480 && isResponsive && spacerMobileHeight >= 0) {
      spacer.style.height = spacerMobileHeight + "px";
    }
  });
};

// // // Call the function on page load
window.addEventListener("load", addResponsiveHeight);

// // // Call the function on screen resize
window.addEventListener("resize", addResponsiveHeight);
