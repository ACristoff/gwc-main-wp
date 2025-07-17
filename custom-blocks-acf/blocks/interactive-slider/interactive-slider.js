const navItems = document.getElementsByClassName("ql-slide-nav-item");
const contentItems = document.getElementsByClassName("ql-slide-content-item");
const contentNodesArray = Array.from(contentItems);

function forEach(array, callback) {
  array = Array.from(array);

  for (var i = 0; i < array.length; i++) {
    callback(array[i], i, array);
  }
}

// Add initial height to content container
forEach(contentNodesArray, function (el, i, array) {
  if (i == 0) {
    // Get the element with the highest hight value
    const computedStyle = window.getComputedStyle(el);
    const contentHeight = parseInt(
      computedStyle.getPropertyValue("height"),
      10
    );

    // Add height to content container
    el.parentNode.style.height = contentHeight + "px";
  }
});

forEach(navItems, function (el, i, array) {
  el.addEventListener("click", function (event) {
    // Store all navigation elements in an array
    const navigation = this.parentNode;
    const navigationNodes = navigation.children;
    const navigationNodesArray = Array.from(navigationNodes);

    const siblings = navigationNodesArray.filter(function (sibling) {
      return sibling !== el;
    });

    // Add a current class to clicked nav item
    if (!this.classList.contains("current")) {
      this.classList.add("current");
    }

    // Extract the target class to match with content elements
    const targetClassArray = Array.from(this.classList);
    const targetClass = targetClassArray.find((className) =>
      className.includes("item-")
    );

    // Iterate over sibling nav items to remove current class
    forEach(siblings, function (el, i, array) {
      if (el.classList.contains("current")) {
        el.classList.remove("current");
      }
    });

    // Store all content elements in an array
    const contentItems = navigation.nextElementSibling;
    const contentNodes = contentItems.children;
    const contentNodesArray = Array.from(contentNodes);

    // console.log();
    var targetElement = event.target.nextElementSibling;

    forEach(contentNodesArray, function (el, i, array) {
      // If the target class matches the content element, add a current class
  
      if (el.classList.contains(targetClass)) {
        el.classList.add("current");

        // Get the element hight value
        const computedStyle = window.getComputedStyle(el);
        const contentHeight = parseInt(
          computedStyle.getPropertyValue("height"),
          10
        );

        console.log(el.scrollHeight);

        // Add height to content container
        el.parentNode.style.height = contentHeight + "px";
      } else {
        el.classList.remove("current");
      }
    });
  });
});
