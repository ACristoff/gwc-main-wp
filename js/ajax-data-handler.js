jQuery(document).ready(function ($) {
  const displayFeaturedProductData = function () {
    $.ajax({
      url: ajax_object.ajax_url,
      method: "POST",
      dataType: "json",
      data: {
        action: "get_featured_products_data",
        // nonce: acf_data_nonce, // Include nonce in the request
      },
      success: function (data) {
        // Handle the response data and update the DOM
        if (data.visibility_bool == false) {
          const products = data.product_repeater_data;
          var productList = $("<ul></ul>").addClass("featured-products");
          $("#menu-item-9128 > .sub-menu").append(productList);

          $(products).each(function () {
            // console.log(this);

            // Create HTML elements for the product
            var listItem = $("<li></li>").addClass("product");
            var image = $("<img>")
              .addClass("product-image")
              .attr("src", this.product_image);
            var rolloverImage = $("<img>")
              .addClass("product-rollover-image")
              .attr("src", this.product_rollover_image);
            var imageLink = $("<a></a>")
              .addClass("product-image-link")
              .attr("href", this.product_link);
            var titleLink = $("<a></a>").attr("href", this.product_link);
            var title = $("<h3></h3>")
              .addClass("product-title")
              .text(this.product_title);
            var differentiator = $("<p></p>")
              .addClass("product-differentiator")
              .html(this.product_differentiator);

            // Nest image and title inside a link tag
            imageLink.append(image, rolloverImage);
            titleLink.append(title);

            // Append the imageLink, titleLink and differentiator to the list item
            listItem.append(imageLink, titleLink, differentiator);

            // Append the list item to the target
            $(productList).append(listItem);
          });
        }
      },
      error: function (error) {
        console.error("AJAX request failed:", error);
      },
    });
  };

  $(window).on("load", displayFeaturedProductData);
});
