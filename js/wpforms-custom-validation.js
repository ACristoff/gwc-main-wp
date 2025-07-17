jQuery(document).ready(function ($) {
  // -_-_-_-_- Custom WPForms validation -_-_-_-_- //
  // Phone number validation function
  function validatePhoneNumber(phone) {
    // Regex for a basic Canadian phone number (10 digits)
    var phoneRegex =
      /^(?:\+1|1-)?(?:\d{3}-\d{3}-\d{4}|\(\d{3}\) \d{3}-\d{4}|(?:\d{4}|\d{5}) \d{6}|(?:\d{4}|\d{5})-\d{6}|(?:\d{4}|\d{5})\d{6})$/;
    return phoneRegex.test(phone);
  }

  // Email address validation function
  function validateEmailAddress(email) {
    // Regex for a basic email address pattern
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
  }

  // Function to check if either email or phone is filled out
  function isEitherEmailOrPhoneFilled(emailField, phoneField) {
    var emailValue = $(emailField).val();
    var phoneValue = $(phoneField).val();

    return (
      (emailValue.trim() !== "" && validateEmailAddress(emailValue)) ||
      (phoneValue.trim() !== "" && validatePhoneNumber(phoneValue))
    );
  }

  // Function to enable/disable submit button
  function updateSubmitButton(
    firstNameField,
    lastNameField,
    emailField,
    phoneField,
    termsCheckbox,
    submitButton
  ) {
    var firstNameValue = $(firstNameField).val();
    var lastNameValue = $(lastNameField).val();
    var termsCheckbox = $(termsCheckbox);
    var submitButton = $(submitButton);

    if (
      firstNameValue.trim() !== "" &&
      lastNameValue.trim() !== "" &&
      isEitherEmailOrPhoneFilled(emailField, phoneField) &&
      termsCheckbox.is(":checked")
    ) {
      submitButton.removeAttr("disabled");
    } else {
      submitButton.attr("disabled", "disabled");
    }
  }

  var targetForms = $(
    ".ql-multi-form-selector-wrap .wpforms-container .wpforms-form"
  );
  if (targetForms.length) {
    $(targetForms).each(function (e) {
      var firstNameField = $(this).find("input.wpforms-field-name-first");
      var lastNameField = $(this).find("input.wpforms-field-name-last");
      var emailField = $(this).find(".wpforms-field-email input");
      var phoneField = $(this).find(".wpforms-field-phone input");
      var termsCheckbox = $(this).find(
        ".wpforms-field-checkbox input[type='checkbox']"
      )[0];
      var submitButton = $(this).find(".wpforms-submit");

      // Initial check
      updateSubmitButton(
        firstNameField,
        lastNameField,
        emailField,
        phoneField,
        termsCheckbox,
        submitButton
      );
    });

    // Monitor form fields for changes
    $(
      "input.wpforms-field-name-first, input.wpforms-field-name-last, .wpforms-field-email input, .wpforms-field-phone input, .wpforms-field-checkbox, .wpforms-submit"
    ).on("input", function () {
      var activeForm = $(this).closest("form.wpforms-form");

      var firstNameField = $(activeForm).find("input.wpforms-field-name-first");
      var lastNameField = $(activeForm).find("input.wpforms-field-name-last");
      var emailField = $(activeForm).find(".wpforms-field-email input");
      var phoneField = $(activeForm).find(".wpforms-field-phone input");
      var termsCheckbox = $(activeForm).find(
        ".wpforms-field-checkbox input[type='checkbox']"
      )[0];
      var submitButton = $(activeForm).find(".wpforms-submit");

      updateSubmitButton(
        firstNameField,
        lastNameField,
        emailField,
        phoneField,
        termsCheckbox,
        submitButton
      );
    });
  }
});
