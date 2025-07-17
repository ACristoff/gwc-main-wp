const formNavItems = document.querySelectorAll(
  ".ql-form-nav-menu .ql-menu-item"
);
const forms = document.querySelectorAll(
  ".ql-multi-form-selector .wpforms-container"
);
const formsNodesArray = Array.from(forms);
const formDescriptionContainer = document.querySelectorAll(
  ".ql-multi-form-description"
);
const formDescriptionElements = document.querySelectorAll(
  ".ql-multi-form-description .form-title, .ql-multi-form-description .form-description"
);
const formDescriptionElementsArray = Array.from(formDescriptionElements);

function forEach(array, callback) {
  array = Array.from(array);

  for (var i = 0; i < array.length; i++) {
    callback(array[i], i, array);
  }
}

forEach(formsNodesArray, function (el, i, array) {
  // Hide all forms except for the first one
  if (i != 0) {
    el.classList.add("hide");
  }
});

forEach(formNavItems, function (el, i, array) {
  el.addEventListener("click", function (event) {
    event.preventDefault();

    let targetEl = document.getElementById("ql-multi-form-scroll-target");

    // Smoothscroll to top of this block
    if (targetEl) {
      const elementPosition =
        targetEl.getBoundingClientRect().top + window.scrollY;

      window.scrollTo({
        top: elementPosition - 200,
        behavior: "smooth",
      });
    }

    // Store all navigation elements in an array
    const navigation = this.parentNode;
    const navigationNodes = navigation.children;
    const navigationNodesArray = Array.from(navigationNodes);

    const siblings = navigationNodesArray.filter(function (sibling) {
      return sibling !== el;
    });

    // Add a current class to clicked nav item
    if (!this.classList.contains("active")) {
      this.classList.add("active");
    }

    // Extract the target ID
    const targetId = this.id;
    const targetFormClass = "form-" + targetId;

    // Iterate over sibling nav items to remove active class
    forEach(siblings, function (el, i, array) {
      if (el.classList.contains("active")) {
        el.classList.remove("active");
      }
    });

    // Iterate over the form description elements to remove active class
    forEach(formDescriptionElementsArray, function (el, i, array) {
      if (
        el.classList.contains("active") &&
        !el.classList.contains(targetFormClass)
      ) {
        el.classList.remove("active");
      }
      if (
        !el.classList.contains("active") &&
        el.classList.contains(targetFormClass)
      ) {
        el.classList.add("active");
      }
    });

    forEach(formsNodesArray, function (el, i, array) {
      const formId = el.id;
      // console.log(i + ": " + formId + ". Target ID: " + targetId);

      if (formId.includes(targetId)) {
        el.classList.remove("hide");
      } else {
        el.classList.add("hide");
      }
    });
  });
});
