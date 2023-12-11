/* eslint-disable */
var itemson = document.querySelectorAll('.lib-comp-qa__question');

    for (let i = 0; i < itemson.length; i++) {
    itemson[i].addEventListener("click", function(event) {
        event.preventDefault();
        if (itemson[i].closest('.lib-comp-qa__item').classList.contains('is-active')){
            itemson[i].closest('.lib-comp-qa__item').classList.remove('is-active');
        } else {
            itemson[i].closest('.lib-comp-qa__item').classList.add('is-active');
        }
    });
};