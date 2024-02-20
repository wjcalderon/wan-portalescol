/* eslint-disable */

Drupal.behaviors.tab = {
  attach(context) {
<<<<<<< HEAD
    const el = context.querySelectorAll('.tab');
    const newLocal = '.tab-nav';
    const tabNavigationLinks = context.querySelectorAll(newLocal);
    const newLocal_1 = '.tab-item';
=======
    const el = context.querySelectorAll(".tab");
    const newLocal = ".tab-nav";
    const tabNavigationLinks = context.querySelectorAll(newLocal);
    const newLocal_1 = ".tab-item";
>>>>>>> main
    const tabContentContainers = context.querySelectorAll(newLocal_1);
    let activeIndex = 0;

    /**
     * goToTab
     * @description Goes to a specific tab based on index. Returns nothing.
     * @param {Number} index The index of the tab to go to
     */
    function goToTab(index) {
      if (
        index !== activeIndex &&
        index >= 0 &&
        index <= tabNavigationLinks.length
      ) {
<<<<<<< HEAD
        tabNavigationLinks[activeIndex].classList.remove('is-active');
        tabNavigationLinks[index].classList.add('is-active');
        tabContentContainers[activeIndex].classList.remove('is-active');
        tabContentContainers[index].classList.add('is-active');
=======
        tabNavigationLinks[activeIndex].classList.remove("is-active");
        tabNavigationLinks[index].classList.add("is-active");
        tabContentContainers[activeIndex].classList.remove("is-active");
        tabContentContainers[index].classList.add("is-active");
>>>>>>> main
        activeIndex = index;
      }
    }

    /**
     * handleClick
     * @description Handles click event listeners on each of the links in the
     *   tab navigation. Returns nothing.
     * @param {HTMLElement} link The link to listen for events on
     * @param {Number} index The index of that link
     */
    function handleClick(link, index) {
<<<<<<< HEAD
      link.addEventListener('click', (e) => {
=======
      link.addEventListener("click", (e) => {
>>>>>>> main
        e.preventDefault();
        goToTab(index);
      });
    }

    /**
     * init
     * @description Initializes the component by removing the no-js class from
     *   the component, and attaching event listeners to each of the nav items.
     *   Returns nothing.
     */
    for (let e = 0; e < el.length; e += 1) {
<<<<<<< HEAD
      el[e].classList.remove('no-js');
=======
      el[e].classList.remove("no-js");
>>>>>>> main
    }

    for (let i = 0; i < tabNavigationLinks.length; i += 1) {
      const link = tabNavigationLinks[i];
      handleClick(link, i);
    }
  },
};

Drupal.behaviors.hero = {
  attach(context) {
<<<<<<< HEAD
    const el = context.querySelectorAll('.hero-breaker');
    const newLocal = '.breaker-nav';
    const breakerNavigationLinks = context.querySelectorAll(newLocal);
    const newLocal_1 = '.breaker-item';
=======
    const el = context.querySelectorAll(".hero-breaker");
    const newLocal = ".breaker-nav";
    const breakerNavigationLinks = context.querySelectorAll(newLocal);
    const newLocal_1 = ".breaker-item";
>>>>>>> main
    const breakerContentContainers = context.querySelectorAll(newLocal_1);
    let activeIndex = 0;

    function goToSlide(index) {
      if (
        index !== activeIndex &&
        index >= 0 &&
        index <= breakerNavigationLinks.length
      ) {
<<<<<<< HEAD
        breakerNavigationLinks[activeIndex].classList.remove('is-active');
        breakerNavigationLinks[index].classList.add('is-active');
        breakerContentContainers[activeIndex].classList.remove('is-active');
        breakerContentContainers[index].classList.add('is-active');
=======
        breakerNavigationLinks[activeIndex].classList.remove("is-active");
        breakerNavigationLinks[index].classList.add("is-active");
        breakerContentContainers[activeIndex].classList.remove("is-active");
        breakerContentContainers[index].classList.add("is-active");
>>>>>>> main
        activeIndex = index;
      }
    }

    function handleClick(link, index) {
<<<<<<< HEAD
      link.addEventListener('click', (e) => {
=======
      link.addEventListener("click", (e) => {
>>>>>>> main
        e.preventDefault();
        goToSlide(index);
      });
    }

    for (let e = 0; e < el.length; e += 1) {
<<<<<<< HEAD
      el[e].classList.remove('no-js');
=======
      el[e].classList.remove("no-js");
>>>>>>> main
    }

    for (let i = 0; i < breakerNavigationLinks.length; i += 1) {
      const link = breakerNavigationLinks[i];
      handleClick(link, i);
    }
  },
};

Drupal.behaviors.scrollspy = {
  attach(context) {
<<<<<<< HEAD

    window.onscroll = function () { scrollspy() };

    var scrollnav = document.getElementById("scrollnav");
    var sticky = scrollnav.offsetTop;

    function scrollspy() {
      if (window.pageYOffset >= sticky) {
        scrollnav.classList.add("sticky")
=======
    window.onscroll = function () {
      scrollspy();
    };

    let scrollnav = document.getElementById("scrollnav");
    let sticky = scrollnav.offsetTop;

    function scrollspy() {
      if (window.pageYOffset >= sticky) {
        scrollnav.classList.add("sticky");
>>>>>>> main
      } else {
        // scrollnav.classList.remove("sticky");
      }
    }
<<<<<<< HEAD

  },
};

=======
  },
};
>>>>>>> main
