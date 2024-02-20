<<<<<<< HEAD
const parentCarousel = document.getElementsByClassName('lib4-comp-carrousel')


for(let i=0; i<parentCarousel.length; i++){
  const elements = parentCarousel[i];
  let circleAction = elements.querySelectorAll('.lib4-comp-carrousel__circle')  
  for(let j=0; j<circleAction.length; j++){
    let circleActionSingle = circleAction[j];
    let number = j+1;
    circleActionSingle.addEventListener('click', function(e){
      let clickAction= circleActionSingle.closest('.lib4-comp-carrousel').querySelectorAll('.lib4-comp-carrousel__items');
      for(let t=0; t<clickAction.length; t++){
        let actionSingle = clickAction[t];
        let item = actionSingle.querySelectorAll('.lib4-comp-carrousel__item');
        for(let y=0; y<item.length; y++){
          item[y].classList.remove('is-active');
          let classEdit = `lib4-comp-carrousel__item__${number}`;
          if(item[y].classList.contains(classEdit)){
            item[y].classList.add('is-active');
          }
          
        }
      }
    })
  }
}
  
=======
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
>>>>>>> main
