const parentCarousel = document.getElementsByClassName('lib-comp-carrousel')


for(let i=0; i<parentCarousel.length; i++){
  const elements = parentCarousel[i];
  let circleAction = elements.querySelectorAll('.lib-comp-carrousel__circle')  
  for(let j=0; j<circleAction.length; j++){
    let circleActionSingle = circleAction[j];
    let number = j+1;
    circleActionSingle.addEventListener('click', function(e){
      let clickAction= circleActionSingle.closest('.lib-comp-carrousel').querySelectorAll('.lib-comp-carrousel__items');
      for(let t=0; t<clickAction.length; t++){
        let actionSingle = clickAction[t];
        let item = actionSingle.querySelectorAll('.lib-comp-carrousel__item');
        for(let y=0; y<item.length; y++){
          item[y].classList.remove('is-active');
          let classEdit = `lib-comp-carrousel__item__${number}`;
          if(item[y].classList.contains(classEdit)){
            item[y].classList.add('is-active');
          }
          
        }
      }
    })
  }
}
  