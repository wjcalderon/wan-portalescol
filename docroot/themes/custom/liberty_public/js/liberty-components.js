/* eslint-disable */

Drupal.behaviors.tab = {
  attach(context) {
    const el = context.querySelectorAll('.tab');
    const newLocal = '.tab-nav';
    const tabNavigationLinks = context.querySelectorAll(newLocal);
    const newLocal_1 = '.tab-item';
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
        tabNavigationLinks[activeIndex].classList.remove('is-active');
        tabNavigationLinks[index].classList.add('is-active');
        tabContentContainers[activeIndex].classList.remove('is-active');
        tabContentContainers[index].classList.add('is-active');
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
      link.addEventListener('click', (e) => {
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
      el[e].classList.remove('no-js');
    }

    for (let i = 0; i < tabNavigationLinks.length; i += 1) {
      const link = tabNavigationLinks[i];
      handleClick(link, i);
    }
  },
};

Drupal.behaviors.hero = {
  attach(context) {
    const el = context.querySelectorAll('.hero-breaker');
    const newLocal = '.breaker-nav';
    const breakerNavigationLinks = context.querySelectorAll(newLocal);
    const newLocal_1 = '.breaker-item';
    const breakerContentContainers = context.querySelectorAll(newLocal_1);
    let activeIndex = 0;

    function goToSlide(index) {
      if (
        index !== activeIndex &&
        index >= 0 &&
        index <= breakerNavigationLinks.length
      ) {
        breakerNavigationLinks[activeIndex].classList.remove('is-active');
        breakerNavigationLinks[index].classList.add('is-active');
        breakerContentContainers[activeIndex].classList.remove('is-active');
        breakerContentContainers[index].classList.add('is-active');
        activeIndex = index;
      }
    }

    function handleClick(link, index) {
      link.addEventListener('click', (e) => {
        e.preventDefault();
        goToSlide(index);
      });
    }

    for (let e = 0; e < el.length; e += 1) {
      el[e].classList.remove('no-js');
    }

    for (let i = 0; i < breakerNavigationLinks.length; i += 1) {
      const link = breakerNavigationLinks[i];
      handleClick(link, i);
    }
  },
};

Drupal.behaviors.scrollspy = {
  attach(context) {

    window.onscroll = function () { scrollspy() };

    var scrollnav = document.getElementById("scrollnav");
    var sticky = scrollnav.offsetTop;

    function scrollspy() {
      if (window.pageYOffset >= sticky) {
        scrollnav.classList.add("sticky")
      } else {
        // scrollnav.classList.remove("sticky");
      }
    }

  },
};

