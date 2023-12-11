/* eslint-disable */
Drupal.behaviors.accordion = {
  attach(context) {

    const accordion = context.querySelectorAll('.accordion__header');
    const accordions = context.querySelectorAll('.accordion');


    Array.from(accordion).forEach((accordiona) => {
      accordiona.addEventListener('click', (e) => {

        const accordionSelec = e.currentTarget;

        const headerSelec = accordionSelec.closest('.accordion');

        if (headerSelec.classList.contains('is-open')) {
          headerSelec.classList.remove('is-open');
          console.log('quita');
        } else {
          Array.from(accordions).forEach((itema) => {
            itema.classList.remove('is-open');
          });
          headerSelec.classList.add('is-open');
          console.log('pone');
        }
      });
    });
  },
};
