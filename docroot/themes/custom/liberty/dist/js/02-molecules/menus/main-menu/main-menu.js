/******/ (function() { // webpackBootstrap
<<<<<<< HEAD
var __webpack_exports__ = {};
=======
let __webpack_exports__ = {};
>>>>>>> main
/*!**************************************************************!*\
  !*** ./components/02-molecules/menus/main-menu/main-menu.js ***!
  \**************************************************************/
Drupal.behaviors.mainMenu={attach(a){const b=a.getElementById("toggle-expand"),c=a.getElementById("main-nav");if(c){const a=c.getElementsByClassName("expand-sub");b.addEventListener("click",a=>{b.classList.toggle("toggle-expand--open"),c.classList.toggle("main-nav--open"),a.preventDefault()}),Array.from(a).forEach(a=>{a.addEventListener("click",a=>{const b=a.currentTarget,c=b.nextElementSibling;b.classList.toggle("expand-sub--open"),c.classList.toggle("main-menu--sub-open")})})}}};
/******/ })()
;
//# sourceMappingURL=main-menu.js.map