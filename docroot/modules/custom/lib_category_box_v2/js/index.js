/* eslint-disable */
Drupal.behaviors.libTabs = {
    attach(context) {
  
        var tabnav = document.querySelectorAll('.lib-comp-catbox__tab');
        var tabitem = document.querySelectorAll('.lib-comp-catbox__grid');
        
            for (let i = 0; i < tabnav.length; i++) {
            tabnav[i].addEventListener("click", function(event) {
                event.preventDefault();
                for (let q = 0; q < tabitem.length; q++) {
                const element = tabitem[q];
                    if (element.classList.contains('is-active')) {
                        element.classList.remove('is-active');
                    }
                    tabnav[q].classList.remove('is-active');
                }
                tabitem[i].classList.add('is-active');
                tabnav[i].classList.add('is-active');
            });
        };
        
    },
  };