jQuery(document).ready(function ($) {
  // Check the value of the exclusive-brand-post field
  var exclusiveBrandFieldValue = customAdminData.exclusiveBrandField;

  // Add a custom class to the body element based on the field value
  if (exclusiveBrandFieldValue === "rolex-post") {
    $("body").addClass("rolex-post-admin");
  }
});
