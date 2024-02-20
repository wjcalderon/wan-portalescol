const parentCarousels = document.getElementsByClassName("lib4-comp-carrousel");

for (const elements of parentCarousels) {
  let circleActions = elements.querySelectorAll(".lib4-comp-carrousel__circle");

  circleActions.forEach((circleAction, index) => {
    let number = index + 1;
    circleAction.addEventListener("click", (e) => {
      let clickActions = circleAction
        .closest(".lib4-comp-carrousel")
        .querySelectorAll(".lib4-comp-carrousel__items");

      clickActions.forEach((actionSingle) => {
        let items = actionSingle.querySelectorAll(".lib4-comp-carrousel__item");

        items.forEach((item) => {
          item.classList.remove("is-active");
          let classEdit = `lib4-comp-carrousel__item__${number}`;
          if (item.classList.contains(classEdit)) {
            item.classList.add("is-active");
          }
        });
      });
    });
  });
}
