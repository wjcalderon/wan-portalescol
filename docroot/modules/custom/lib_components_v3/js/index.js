const parentCarousel = document.getElementsByClassName("lib-comp-carrousel");

for (const elements of parentCarousel) {
  let circleAction = elements.querySelectorAll(".lib-comp-carrousel__circle");
  for (const circleActionSingle of circleAction) {
    let number = Array.from(circleAction).indexOf(circleActionSingle) + 1;
    circleActionSingle.addEventListener("click", function (e) {
      let clickAction = circleActionSingle
        .closest(".lib-comp-carrousel")
        .querySelectorAll(".lib-comp-carrousel__items");
      for (const actionSingle of clickAction) {
        let item = actionSingle.querySelectorAll(".lib-comp-carrousel__item");
        for (const itemSingle of item) {
          itemSingle.classList.remove("is-active");
          let classEdit = `lib-comp-carrousel__item__${number}`;
          if (itemSingle.classList.contains(classEdit)) {
            itemSingle.classList.add("is-active");
          }
        }
      }
    });
  }
}
