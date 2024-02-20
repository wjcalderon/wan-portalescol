/**
 * Intro.js v2.9.3
 * https://github.com/usablica/intro.js
 *
 * Copyright (C) 2017 Afshin Mehrabani (@afshinmeh)
 */
<<<<<<< HEAD
(function(f) {
    if (typeof exports === "object" && typeof module !== "undefined") {
        module.exports = f();
        // deprecated function
        // @since 2.8.0
        module.exports.introJs = function () {
          console.warn('Deprecated: please use require("intro.js") directly, instead of the introJs method of the function');
          // introJs()
          return f().apply(this, arguments);
        };
    } else if (typeof define === "function" && define.amd) {
        define([], f);
    } else {
        var g;
        if (typeof window !== "undefined") {
            g = window;
        } else if (typeof global !== "undefined") {
            g = global;
        } else if (typeof self !== "undefined") {
            g = self;
        } else {
            g = this;
        }
        g.introJs = f();
    }
})(function () {
  //Default config/variables
  var VERSION = '2.9.3';
=======
(function (f) {
  if (typeof exports === "object" && typeof module !== "undefined") {
    module.exports = f();
    // deprecated function
    // @since 2.8.0
    module.exports.introJs = function () {
      console.warn(
        'Deprecated: please use require("intro.js") directly, instead of the introJs method of the function'
      );
      // introJs()
      return f().apply(this, arguments);
    };
  } else if (typeof define === "function" && define.amd) {
    define([], f);
  } else {
    let g;
    if (typeof window !== "undefined") {
      g = window;
    } else if (typeof global !== "undefined") {
      g = global;
    } else if (typeof self !== "undefined") {
      g = self;
    } else {
      g = this;
    }
    g.introJs = f();
  }
})(function () {
  //Default config/variables
  let VERSION = "2.9.3";
>>>>>>> main

  /**
   * IntroJs main class
   *
   * @class IntroJs
   */
  function IntroJs(obj) {
    this._targetElement = obj;
    this._introItems = [];

    this._options = {
      /* Next button label in tooltip box */
<<<<<<< HEAD
      nextLabel: 'Next &rarr;',
      /* Previous button label in tooltip box */
      prevLabel: '&larr; Back',
      /* Skip button label in tooltip box */
      skipLabel: 'Skip',
      /* Done button label in tooltip box */
      doneLabel: 'Done',
=======
      nextLabel: "Next &rarr;",
      /* Previous button label in tooltip box */
      prevLabel: "&larr; Back",
      /* Skip button label in tooltip box */
      skipLabel: "Skip",
      /* Done button label in tooltip box */
      doneLabel: "Done",
>>>>>>> main
      /* Hide previous button in the first step? Otherwise, it will be disabled button. */
      hidePrev: false,
      /* Hide next button in the last step? Otherwise, it will be disabled button. */
      hideNext: false,
      /* Default tooltip box position */
<<<<<<< HEAD
      tooltipPosition: 'bottom',
      /* Next CSS class for tooltip boxes */
      tooltipClass: '',
      /* CSS class that is added to the helperLayer */
      highlightClass: '',
=======
      tooltipPosition: "bottom",
      /* Next CSS class for tooltip boxes */
      tooltipClass: "",
      /* CSS class that is added to the helperLayer */
      highlightClass: "",
>>>>>>> main
      /* Close introduction when pressing Escape button? */
      exitOnEsc: true,
      /* Close introduction when clicking on overlay layer? */
      exitOnOverlayClick: true,
      /* Show step numbers in introduction? */
      showStepNumbers: true,
      /* Let user use keyboard to navigate the tour? */
      keyboardNavigation: true,
      /* Show tour control buttons? */
      showButtons: true,
      /* Show tour bullets? */
      showBullets: true,
      /* Show tour progress? */
      showProgress: false,
      /* Scroll to highlighted element? */
      scrollToElement: true,
      /*
       * Should we scroll the tooltip or target element?
       *
       * Options are: 'element' or 'tooltip'
       */
<<<<<<< HEAD
      scrollTo: 'element',
=======
      scrollTo: "element",
>>>>>>> main
      /* Padding to add after scrolling when element is not in the viewport (in pixels) */
      scrollPadding: 30,
      /* Set the overlay opacity */
      overlayOpacity: 0.8,
      /* Precedence of positions, when auto is enabled */
      positionPrecedence: ["bottom", "top", "right", "left"],
      /* Disable an interaction with element? */
      disableInteraction: false,
      /* Set how much padding to be used around helper element */
      helperElementPadding: 10,
      /* Default hint position */
<<<<<<< HEAD
      hintPosition: 'top-middle',
      /* Hint button label */
      hintButtonLabel: 'Got it',
      /* Adding animation to hints? */
      hintAnimation: true,
      /* additional classes to put on the buttons */
      buttonClass: "introjs-button"
=======
      hintPosition: "top-middle",
      /* Hint button label */
      hintButtonLabel: "Got it",
      /* Adding animation to hints? */
      hintAnimation: true,
      /* additional classes to put on the buttons */
      buttonClass: "introjs-button",
>>>>>>> main
    };
  }

  /**
   * Initiate a new introduction/guide from an element in the page
   *
   * @api private
   * @method _introForElement
   * @param {Object} targetElm
   * @param {String} group
   * @returns {Boolean} Success or not?
   */
  function _introForElement(targetElm, group) {
<<<<<<< HEAD
    var allIntroSteps = targetElm.querySelectorAll("*[data-intro]"),
        introItems = [];

    if (this._options.steps) {
      //use steps passed programmatically
      _forEach(this._options.steps, function (step) {
        var currentItem = _cloneObject(step);

        //set the step
        currentItem.step = introItems.length + 1;

        //use querySelector function only when developer used CSS selector
        if (typeof (currentItem.element) === 'string') {
          //grab the element with given selector from the page
          currentItem.element = document.querySelector(currentItem.element);
        }

        //intro without element
        if (typeof (currentItem.element) === 'undefined' || currentItem.element === null) {
          var floatingElementQuery = document.querySelector(".introjsFloatingElement");

          if (floatingElementQuery === null) {
            floatingElementQuery = document.createElement('div');
            floatingElementQuery.className = 'introjsFloatingElement';

            document.body.appendChild(floatingElementQuery);
          }

          currentItem.element  = floatingElementQuery;
          currentItem.position = 'floating';
        }

        currentItem.scrollTo = currentItem.scrollTo || this._options.scrollTo;

        if (typeof (currentItem.disableInteraction) === 'undefined') {
          currentItem.disableInteraction = this._options.disableInteraction;
        }

        if (currentItem.element !== null) {
          introItems.push(currentItem);
        }
      }.bind(this));

    } else {
      //use steps from data-* annotations
      var elmsLength = allIntroSteps.length;
      var disableInteraction;
=======
    let allIntroSteps = targetElm.querySelectorAll("*[data-intro]"),
      introItems = [];

    if (this._options.steps) {
      //use steps passed programmatically
      _forEach(
        this._options.steps,
        function (step) {
          let currentItem = _cloneObject(step);

          //set the step
          currentItem.step = introItems.length + 1;

          //use querySelector function only when developer used CSS selector
          if (typeof currentItem.element === "string") {
            //grab the element with given selector from the page
            currentItem.element = document.querySelector(currentItem.element);
          }

          //intro without element
          if (
            typeof currentItem.element === "undefined" ||
            currentItem.element === null
          ) {
            let floatingElementQuery = document.querySelector(
              ".introjsFloatingElement"
            );

            if (floatingElementQuery === null) {
              floatingElementQuery = document.createElement("div");
              floatingElementQuery.className = "introjsFloatingElement";

              document.body.appendChild(floatingElementQuery);
            }

            currentItem.element = floatingElementQuery;
            currentItem.position = "floating";
          }

          currentItem.scrollTo = currentItem.scrollTo || this._options.scrollTo;

          if (typeof currentItem.disableInteraction === "undefined") {
            currentItem.disableInteraction = this._options.disableInteraction;
          }

          if (currentItem.element !== null) {
            introItems.push(currentItem);
          }
        }.bind(this)
      );
    } else {
      //use steps from data-* annotations
      let elmsLength = allIntroSteps.length;
      let disableInteraction;
>>>>>>> main

      //if there's no element to intro
      if (elmsLength < 1) {
        return false;
      }

<<<<<<< HEAD
      _forEach(allIntroSteps, function (currentElement) {

        // PR #80
        // start intro for groups of elements
        if (group && (currentElement.getAttribute("data-intro-group") !== group)) {
          return;
        }

        // skip hidden elements
        if (currentElement.style.display === 'none') {
          return;
        }

        var step = parseInt(currentElement.getAttribute('data-step'), 10);

        if (typeof (currentElement.getAttribute('data-disable-interaction')) !== 'undefined') {
          disableInteraction = !!currentElement.getAttribute('data-disable-interaction');
        } else {
          disableInteraction = this._options.disableInteraction;
        }

        if (step > 0) {
          introItems[step - 1] = {
            element: currentElement,
            intro: currentElement.getAttribute('data-intro'),
            step: parseInt(currentElement.getAttribute('data-step'), 10),
            tooltipClass: currentElement.getAttribute('data-tooltipclass'),
            highlightClass: currentElement.getAttribute('data-highlightclass'),
            position: currentElement.getAttribute('data-position') || this._options.tooltipPosition,
            scrollTo: currentElement.getAttribute('data-scrollto') || this._options.scrollTo,
            disableInteraction: disableInteraction
          };
        }
      }.bind(this));

      //next add intro items without data-step
      //todo: we need a cleanup here, two loops are redundant
      var nextStep = 0;

      _forEach(allIntroSteps, function (currentElement) {

        // PR #80
        // start intro for groups of elements
        if (group && (currentElement.getAttribute("data-intro-group") !== group)) {
          return;
        }

        if (currentElement.getAttribute('data-step') === null) {

          while (true) {
            if (typeof introItems[nextStep] === 'undefined') {
              break;
            } else {
              nextStep++;
            }
          }

          if (typeof (currentElement.getAttribute('data-disable-interaction')) !== 'undefined') {
            disableInteraction = !!currentElement.getAttribute('data-disable-interaction');
=======
      _forEach(
        allIntroSteps,
        function (currentElement) {
          // PR #80
          // start intro for groups of elements
          if (
            group &&
            currentElement.getAttribute("data-intro-group") !== group
          ) {
            return;
          }

          // skip hidden elements
          if (currentElement.style.display === "none") {
            return;
          }

          let step = parseInt(currentElement.getAttribute("data-step"), 10);

          if (
            typeof currentElement.getAttribute("data-disable-interaction") !==
            "undefined"
          ) {
            disableInteraction = !!currentElement.getAttribute(
              "data-disable-interaction"
            );
>>>>>>> main
          } else {
            disableInteraction = this._options.disableInteraction;
          }

<<<<<<< HEAD
          introItems[nextStep] = {
            element: currentElement,
            intro: currentElement.getAttribute('data-intro'),
            step: nextStep + 1,
            tooltipClass: currentElement.getAttribute('data-tooltipclass'),
            highlightClass: currentElement.getAttribute('data-highlightclass'),
            position: currentElement.getAttribute('data-position') || this._options.tooltipPosition,
            scrollTo: currentElement.getAttribute('data-scrollto') || this._options.scrollTo,
            disableInteraction: disableInteraction
          };
        }
      }.bind(this));
    }

    //removing undefined/null elements
    var tempIntroItems = [];
    for (var z = 0; z < introItems.length; z++) {
=======
          if (step > 0) {
            introItems[step - 1] = {
              element: currentElement,
              intro: currentElement.getAttribute("data-intro"),
              step: parseInt(currentElement.getAttribute("data-step"), 10),
              tooltipClass: currentElement.getAttribute("data-tooltipclass"),
              highlightClass: currentElement.getAttribute(
                "data-highlightclass"
              ),
              position:
                currentElement.getAttribute("data-position") ||
                this._options.tooltipPosition,
              scrollTo:
                currentElement.getAttribute("data-scrollto") ||
                this._options.scrollTo,
              disableInteraction: disableInteraction,
            };
          }
        }.bind(this)
      );

      //next add intro items without data-step
      //todo: we need a cleanup here, two loops are redundant
      let nextStep = 0;

      _forEach(
        allIntroSteps,
        function (currentElement) {
          // PR #80
          // start intro for groups of elements
          if (
            group &&
            currentElement.getAttribute("data-intro-group") !== group
          ) {
            return;
          }

          if (currentElement.getAttribute("data-step") === null) {
            while (true) {
              if (typeof introItems[nextStep] === "undefined") {
                break;
              } else {
                nextStep++;
              }
            }

            if (
              typeof currentElement.getAttribute("data-disable-interaction") !==
              "undefined"
            ) {
              disableInteraction = !!currentElement.getAttribute(
                "data-disable-interaction"
              );
            } else {
              disableInteraction = this._options.disableInteraction;
            }

            introItems[nextStep] = {
              element: currentElement,
              intro: currentElement.getAttribute("data-intro"),
              step: nextStep + 1,
              tooltipClass: currentElement.getAttribute("data-tooltipclass"),
              highlightClass: currentElement.getAttribute(
                "data-highlightclass"
              ),
              position:
                currentElement.getAttribute("data-position") ||
                this._options.tooltipPosition,
              scrollTo:
                currentElement.getAttribute("data-scrollto") ||
                this._options.scrollTo,
              disableInteraction: disableInteraction,
            };
          }
        }.bind(this)
      );
    }

    //removing undefined/null elements
    let tempIntroItems = [];
    for (let z = 0; z < introItems.length; z++) {
>>>>>>> main
      if (introItems[z]) {
        // copy non-falsy values to the end of the array
        tempIntroItems.push(introItems[z]);
      }
    }

    introItems = tempIntroItems;

    //Ok, sort all items with given steps
    introItems.sort(function (a, b) {
      return a.step - b.step;
    });

    //set it to the introJs object
    this._introItems = introItems;

    //add overlay layer to the page
<<<<<<< HEAD
    if(_addOverlayLayer.call(this, targetElm)) {
=======
    if (_addOverlayLayer.call(this, targetElm)) {
>>>>>>> main
      //then, start the show
      _nextStep.call(this);

      if (this._options.keyboardNavigation) {
<<<<<<< HEAD
        DOMEvent.on(window, 'keydown', _onKeyDown, this, true);
      }
      //for window resize
      DOMEvent.on(window, 'resize', _onResize, this, true);
=======
        DOMEvent.on(window, "keydown", _onKeyDown, this, true);
      }
      //for window resize
      DOMEvent.on(window, "resize", _onResize, this, true);
>>>>>>> main
    }
    return false;
  }

<<<<<<< HEAD
  function _onResize () {
=======
  function _onResize() {
>>>>>>> main
    this.refresh.call(this);
  }

  /**
<<<<<<< HEAD
  * on keyCode:
  * https://developer.mozilla.org/en-US/docs/Web/API/KeyboardEvent/keyCode
  * This feature has been removed from the Web standards.
  * Though some browsers may still support it, it is in
  * the process of being dropped.
  * Instead, you should use KeyboardEvent.code,
  * if it's implemented.
  *
  * jQuery's approach is to test for
  *   (1) e.which, then
  *   (2) e.charCode, then
  *   (3) e.keyCode
  * https://github.com/jquery/jquery/blob/a6b0705294d336ae2f63f7276de0da1195495363/src/event.js#L638
  *
  * @param type var
  * @return type
  */
  function _onKeyDown (e) {
    var code = (e.code === null) ? e.which : e.code;

    // if code/e.which is null
    if (code === null) {
      code = (e.charCode === null) ? e.keyCode : e.charCode;
    }

    if ((code === 'Escape' || code === 27) && this._options.exitOnEsc === true) {
      //escape key pressed, exit the intro
      //check if exit callback is defined
      _exitIntro.call(this, this._targetElement);
    } else if (code === 'ArrowLeft' || code === 37) {
      //left arrow
      _previousStep.call(this);
    } else if (code === 'ArrowRight' || code === 39) {
      //right arrow
      _nextStep.call(this);
    } else if (code === 'Enter' || code === 13) {
      //srcElement === ie
      var target = e.target || e.srcElement;
      if (target && target.className.match('introjs-prevbutton')) {
        //user hit enter while focusing on previous button
        _previousStep.call(this);
      } else if (target && target.className.match('introjs-skipbutton')) {
        //user hit enter while focusing on skip button
        if (this._introItems.length - 1 === this._currentStep && typeof (this._introCompleteCallback) === 'function') {
            this._introCompleteCallback.call(this);
        }

        _exitIntro.call(this, this._targetElement);
      } else if (target && target.getAttribute('data-stepnumber')) {
=======
   * on keyCode:
   * https://developer.mozilla.org/en-US/docs/Web/API/KeyboardEvent/keyCode
   * This feature has been removed from the Web standards.
   * Though some browsers may still support it, it is in
   * the process of being dropped.
   * Instead, you should use KeyboardEvent.code,
   * if it's implemented.
   *
   * jQuery's approach is to test for
   *   (1) e.which, then
   *   (2) e.charCode, then
   *   (3) e.keyCode
   * https://github.com/jquery/jquery/blob/a6b0705294d336ae2f63f7276de0da1195495363/src/event.js#L638
   *
   * @param type var
   * @return type
   */
  function _onKeyDown(e) {
    let code = e.code === null ? e.which : e.code;

    // if code/e.which is null
    if (code === null) {
      code = e.charCode === null ? e.keyCode : e.charCode;
    }

    if (
      (code === "Escape" || code === 27) &&
      this._options.exitOnEsc === true
    ) {
      //escape key pressed, exit the intro
      //check if exit callback is defined
      _exitIntro.call(this, this._targetElement);
    } else if (code === "ArrowLeft" || code === 37) {
      //left arrow
      _previousStep.call(this);
    } else if (code === "ArrowRight" || code === 39) {
      //right arrow
      _nextStep.call(this);
    } else if (code === "Enter" || code === 13) {
      //srcElement === ie
      let target = e.target || e.srcElement;
      if (target && target.className.match("introjs-prevbutton")) {
        //user hit enter while focusing on previous button
        _previousStep.call(this);
      } else if (target && target.className.match("introjs-skipbutton")) {
        //user hit enter while focusing on skip button
        if (
          this._introItems.length - 1 === this._currentStep &&
          typeof this._introCompleteCallback === "function"
        ) {
          this._introCompleteCallback.call(this);
        }

        _exitIntro.call(this, this._targetElement);
      } else if (target && target.getAttribute("data-stepnumber")) {
>>>>>>> main
        // user hit enter while focusing on step bullet
        target.click();
      } else {
        //default behavior for responding to enter
        _nextStep.call(this);
      }

      //prevent default behaviour on hitting Enter, to prevent steps being skipped in some browsers
<<<<<<< HEAD
      if(e.preventDefault) {
=======
      if (e.preventDefault) {
>>>>>>> main
        e.preventDefault();
      } else {
        e.returnValue = false;
      }
    }
  }

<<<<<<< HEAD
 /*
   * makes a copy of the object
   * @api private
   * @method _cloneObject
  */
  function _cloneObject(object) {
      if (object === null || typeof (object) !== 'object' || typeof (object.nodeType) !== 'undefined') {
        return object;
      }
      var temp = {};
      for (var key in object) {
        if (typeof(window.jQuery) !== 'undefined' && object[key] instanceof window.jQuery) {
          temp[key] = object[key];
        } else {
          temp[key] = _cloneObject(object[key]);
        }
      }
      return temp;
=======
  /*
   * makes a copy of the object
   * @api private
   * @method _cloneObject
   */
  function _cloneObject(object) {
    if (
      object === null ||
      typeof object !== "object" ||
      typeof object.nodeType !== "undefined"
    ) {
      return object;
    }
    let temp = {};
    for (let key in object) {
      if (
        typeof window.jQuery !== "undefined" &&
        object[key] instanceof window.jQuery
      ) {
        temp[key] = object[key];
      } else {
        temp[key] = _cloneObject(object[key]);
      }
    }
    return temp;
>>>>>>> main
  }
  /**
   * Go to specific step of introduction
   *
   * @api private
   * @method _goToStep
   */
  function _goToStep(step) {
    //because steps starts with zero
    this._currentStep = step - 2;
<<<<<<< HEAD
    if (typeof (this._introItems) !== 'undefined') {
=======
    if (typeof this._introItems !== "undefined") {
>>>>>>> main
      _nextStep.call(this);
    }
  }

  /**
   * Go to the specific step of introduction with the explicit [data-step] number
   *
   * @api private
   * @method _goToStepNumber
   */
  function _goToStepNumber(step) {
    this._currentStepNumber = step;
<<<<<<< HEAD
    if (typeof (this._introItems) !== 'undefined') {
=======
    if (typeof this._introItems !== "undefined") {
>>>>>>> main
      _nextStep.call(this);
    }
  }

  /**
   * Go to next step on intro
   *
   * @api private
   * @method _nextStep
   */
  function _nextStep() {
<<<<<<< HEAD
    this._direction = 'forward';

    if (typeof (this._currentStepNumber) !== 'undefined') {
      _forEach(this._introItems, function (item, i) {
        if( item.step === this._currentStepNumber ) {
          this._currentStep = i - 1;
          this._currentStepNumber = undefined;
        }
      }.bind(this));
    }

    if (typeof (this._currentStep) === 'undefined') {
=======
    this._direction = "forward";

    if (typeof this._currentStepNumber !== "undefined") {
      _forEach(
        this._introItems,
        function (item, i) {
          if (item.step === this._currentStepNumber) {
            this._currentStep = i - 1;
            this._currentStepNumber = undefined;
          }
        }.bind(this)
      );
    }

    if (typeof this._currentStep === "undefined") {
>>>>>>> main
      this._currentStep = 0;
    } else {
      ++this._currentStep;
    }

<<<<<<< HEAD
    var nextStep = this._introItems[this._currentStep];
    var continueStep = true;

    if (typeof (this._introBeforeChangeCallback) !== 'undefined') {
      continueStep = this._introBeforeChangeCallback.call(this, nextStep.element);
=======
    let nextStep = this._introItems[this._currentStep];
    let continueStep = true;

    if (typeof this._introBeforeChangeCallback !== "undefined") {
      continueStep = this._introBeforeChangeCallback.call(
        this,
        nextStep.element
      );
>>>>>>> main
    }

    // if `onbeforechange` returned `false`, stop displaying the element
    if (continueStep === false) {
      --this._currentStep;
      return false;
    }

<<<<<<< HEAD
    if ((this._introItems.length) <= this._currentStep) {
      //end of the intro
      //check if any callback is defined
      if (typeof (this._introCompleteCallback) === 'function') {
=======
    if (this._introItems.length <= this._currentStep) {
      //end of the intro
      //check if any callback is defined
      if (typeof this._introCompleteCallback === "function") {
>>>>>>> main
        this._introCompleteCallback.call(this);
      }
      _exitIntro.call(this, this._targetElement);
      return;
    }

    _showElement.call(this, nextStep);
  }

  /**
   * Go to previous step on intro
   *
   * @api private
   * @method _previousStep
   */
  function _previousStep() {
<<<<<<< HEAD
    this._direction = 'backward';
=======
    this._direction = "backward";
>>>>>>> main

    if (this._currentStep === 0) {
      return false;
    }

    --this._currentStep;

<<<<<<< HEAD
    var nextStep = this._introItems[this._currentStep];
    var continueStep = true;

    if (typeof (this._introBeforeChangeCallback) !== 'undefined') {
      continueStep = this._introBeforeChangeCallback.call(this, nextStep.element);
=======
    let nextStep = this._introItems[this._currentStep];
    let continueStep = true;

    if (typeof this._introBeforeChangeCallback !== "undefined") {
      continueStep = this._introBeforeChangeCallback.call(
        this,
        nextStep.element
      );
>>>>>>> main
    }

    // if `onbeforechange` returned `false`, stop displaying the element
    if (continueStep === false) {
      ++this._currentStep;
      return false;
    }

    _showElement.call(this, nextStep);
  }

  /**
   * Update placement of the intro objects on the screen
   * @api private
   */
  function _refresh() {
    // re-align intros
<<<<<<< HEAD
    _setHelperLayerPosition.call(this, document.querySelector('.introjs-helperLayer'));
    _setHelperLayerPosition.call(this, document.querySelector('.introjs-tooltipReferenceLayer'));
    _setHelperLayerPosition.call(this, document.querySelector('.introjs-disableInteraction'));

    // re-align tooltip
    if(this._currentStep !== undefined && this._currentStep !== null) {
      var oldHelperNumberLayer = document.querySelector('.introjs-helperNumberLayer'),
        oldArrowLayer        = document.querySelector('.introjs-arrow'),
        oldtooltipContainer  = document.querySelector('.introjs-tooltip');
      _placeTooltip.call(this, this._introItems[this._currentStep].element, oldtooltipContainer, oldArrowLayer, oldHelperNumberLayer);
=======
    _setHelperLayerPosition.call(
      this,
      document.querySelector(".introjs-helperLayer")
    );
    _setHelperLayerPosition.call(
      this,
      document.querySelector(".introjs-tooltipReferenceLayer")
    );
    _setHelperLayerPosition.call(
      this,
      document.querySelector(".introjs-disableInteraction")
    );

    // re-align tooltip
    if (this._currentStep !== undefined && this._currentStep !== null) {
      let oldHelperNumberLayer = document.querySelector(
          ".introjs-helperNumberLayer"
        ),
        oldArrowLayer = document.querySelector(".introjs-arrow"),
        oldtooltipContainer = document.querySelector(".introjs-tooltip");
      _placeTooltip.call(
        this,
        this._introItems[this._currentStep].element,
        oldtooltipContainer,
        oldArrowLayer,
        oldHelperNumberLayer
      );
>>>>>>> main
    }

    //re-align hints
    _reAlignHints.call(this);
    return this;
  }

  /**
   * Exit from intro
   *
   * @api private
   * @method _exitIntro
   * @param {Object} targetElement
   * @param {Boolean} force - Setting to `true` will skip the result of beforeExit callback
   */
  function _exitIntro(targetElement, force) {
<<<<<<< HEAD
    var continueExit = true;
=======
    let continueExit = true;
>>>>>>> main

    // calling onbeforeexit callback
    //
    // If this callback return `false`, it would halt the process
    if (this._introBeforeExitCallback !== undefined) {
      continueExit = this._introBeforeExitCallback.call(this);
    }

    // skip this check if `force` parameter is `true`
    // otherwise, if `onbeforeexit` returned `false`, don't exit the intro
    if (!force && continueExit === false) return;

    //remove overlay layers from the page
<<<<<<< HEAD
    var overlayLayers = targetElement.querySelectorAll('.introjs-overlay');

    if (overlayLayers && overlayLayers.length) {
      _forEach(overlayLayers, function (overlayLayer) {
        overlayLayer.style.opacity = 0;
        window.setTimeout(function () {
          if (this.parentNode) {
            this.parentNode.removeChild(this);
          }
        }.bind(overlayLayer), 500);
      }.bind(this));
    }

    //remove all helper layers
    var helperLayer = targetElement.querySelector('.introjs-helperLayer');
=======
    let overlayLayers = targetElement.querySelectorAll(".introjs-overlay");

    if (overlayLayers && overlayLayers.length) {
      _forEach(
        overlayLayers,
        function (overlayLayer) {
          overlayLayer.style.opacity = 0;
          window.setTimeout(
            function () {
              if (this.parentNode) {
                this.parentNode.removeChild(this);
              }
            }.bind(overlayLayer),
            500
          );
        }.bind(this)
      );
    }

    //remove all helper layers
    let helperLayer = targetElement.querySelector(".introjs-helperLayer");
>>>>>>> main
    if (helperLayer) {
      helperLayer.parentNode.removeChild(helperLayer);
    }

<<<<<<< HEAD
    var referenceLayer = targetElement.querySelector('.introjs-tooltipReferenceLayer');
=======
    let referenceLayer = targetElement.querySelector(
      ".introjs-tooltipReferenceLayer"
    );
>>>>>>> main
    if (referenceLayer) {
      referenceLayer.parentNode.removeChild(referenceLayer);
    }

    //remove disableInteractionLayer
<<<<<<< HEAD
    var disableInteractionLayer = targetElement.querySelector('.introjs-disableInteraction');
=======
    let disableInteractionLayer = targetElement.querySelector(
      ".introjs-disableInteraction"
    );
>>>>>>> main
    if (disableInteractionLayer) {
      disableInteractionLayer.parentNode.removeChild(disableInteractionLayer);
    }

    //remove intro floating element
<<<<<<< HEAD
    var floatingElement = document.querySelector('.introjsFloatingElement');
=======
    let floatingElement = document.querySelector(".introjsFloatingElement");
>>>>>>> main
    if (floatingElement) {
      floatingElement.parentNode.removeChild(floatingElement);
    }

    _removeShowElement();

    //remove `introjs-fixParent` class from the elements
<<<<<<< HEAD
    var fixParents = document.querySelectorAll('.introjs-fixParent');
=======
    let fixParents = document.querySelectorAll(".introjs-fixParent");
>>>>>>> main
    _forEach(fixParents, function (parent) {
      _removeClass(parent, /introjs-fixParent/g);
    });

    //clean listeners
<<<<<<< HEAD
    DOMEvent.off(window, 'keydown', _onKeyDown, this, true);
    DOMEvent.off(window, 'resize', _onResize, this, true);
=======
    DOMEvent.off(window, "keydown", _onKeyDown, this, true);
    DOMEvent.off(window, "resize", _onResize, this, true);
>>>>>>> main

    //check if any callback is defined
    if (this._introExitCallback !== undefined) {
      this._introExitCallback.call(this);
    }

    //set the step to zero
    this._currentStep = undefined;
  }

  /**
   * Render tooltip box in the page
   *
   * @api private
   * @method _placeTooltip
   * @param {HTMLElement} targetElement
   * @param {HTMLElement} tooltipLayer
   * @param {HTMLElement} arrowLayer
   * @param {HTMLElement} helperNumberLayer
   * @param {Boolean} hintMode
   */
<<<<<<< HEAD
  function _placeTooltip(targetElement, tooltipLayer, arrowLayer, helperNumberLayer, hintMode) {
    var tooltipCssClass = '',
        currentStepObj,
        tooltipOffset,
        targetOffset,
        windowSize,
        currentTooltipPosition;
=======
  function _placeTooltip(
    targetElement,
    tooltipLayer,
    arrowLayer,
    helperNumberLayer,
    hintMode
  ) {
    let tooltipCssClass = "",
      currentStepObj,
      tooltipOffset,
      targetOffset,
      windowSize,
      currentTooltipPosition;
>>>>>>> main

    hintMode = hintMode || false;

    //reset the old style
<<<<<<< HEAD
    tooltipLayer.style.top        = null;
    tooltipLayer.style.right      = null;
    tooltipLayer.style.bottom     = null;
    tooltipLayer.style.left       = null;
    tooltipLayer.style.marginLeft = null;
    tooltipLayer.style.marginTop  = null;

    arrowLayer.style.display = 'inherit';

    if (typeof(helperNumberLayer) !== 'undefined' && helperNumberLayer !== null) {
      helperNumberLayer.style.top  = null;
=======
    tooltipLayer.style.top = null;
    tooltipLayer.style.right = null;
    tooltipLayer.style.bottom = null;
    tooltipLayer.style.left = null;
    tooltipLayer.style.marginLeft = null;
    tooltipLayer.style.marginTop = null;

    arrowLayer.style.display = "inherit";

    if (
      typeof helperNumberLayer !== "undefined" &&
      helperNumberLayer !== null
    ) {
      helperNumberLayer.style.top = null;
>>>>>>> main
      helperNumberLayer.style.left = null;
    }

    //prevent error when `this._currentStep` is undefined
    if (!this._introItems[this._currentStep]) return;

    //if we have a custom css class for each step
    currentStepObj = this._introItems[this._currentStep];
<<<<<<< HEAD
    if (typeof (currentStepObj.tooltipClass) === 'string') {
=======
    if (typeof currentStepObj.tooltipClass === "string") {
>>>>>>> main
      tooltipCssClass = currentStepObj.tooltipClass;
    } else {
      tooltipCssClass = this._options.tooltipClass;
    }

<<<<<<< HEAD
    tooltipLayer.className = ('introjs-tooltip ' + tooltipCssClass).replace(/^\s+|\s+$/g, '');
    tooltipLayer.setAttribute('role', 'dialog');
=======
    tooltipLayer.className = ("introjs-tooltip " + tooltipCssClass).replace(
      /^\s+|\s+$/g,
      ""
    );
    tooltipLayer.setAttribute("role", "dialog");
>>>>>>> main

    currentTooltipPosition = this._introItems[this._currentStep].position;

    // Floating is always valid, no point in calculating
    if (currentTooltipPosition !== "floating") {
<<<<<<< HEAD
      currentTooltipPosition = _determineAutoPosition.call(this, targetElement, tooltipLayer, currentTooltipPosition);
    }

    var tooltipLayerStyleLeft;
    targetOffset  = _getOffset(targetElement);
    tooltipOffset = _getOffset(tooltipLayer);
    windowSize    = _getWinSize();

    _addClass(tooltipLayer, 'introjs-' + currentTooltipPosition);

    switch (currentTooltipPosition) {
      case 'top-right-aligned':
        arrowLayer.className      = 'introjs-arrow bottom-right';

        var tooltipLayerStyleRight = 0;
        _checkLeft(targetOffset, tooltipLayerStyleRight, tooltipOffset, tooltipLayer);
        tooltipLayer.style.bottom    = (targetOffset.height +  20) + 'px';
        break;

      case 'top-middle-aligned':
        arrowLayer.className      = 'introjs-arrow bottom-middle';

        var tooltipLayerStyleLeftRight = targetOffset.width / 2 - tooltipOffset.width / 2;
=======
      currentTooltipPosition = _determineAutoPosition.call(
        this,
        targetElement,
        tooltipLayer,
        currentTooltipPosition
      );
    }

    let tooltipLayerStyleLeft;
    targetOffset = _getOffset(targetElement);
    tooltipOffset = _getOffset(tooltipLayer);
    windowSize = _getWinSize();

    _addClass(tooltipLayer, "introjs-" + currentTooltipPosition);

    switch (currentTooltipPosition) {
      case "top-right-aligned":
        arrowLayer.className = "introjs-arrow bottom-right";

        let tooltipLayerStyleRight = 0;
        _checkLeft(
          targetOffset,
          tooltipLayerStyleRight,
          tooltipOffset,
          tooltipLayer
        );
        tooltipLayer.style.bottom = targetOffset.height + 20 + "px";
        break;

      case "top-middle-aligned":
        arrowLayer.className = "introjs-arrow bottom-middle";

        let tooltipLayerStyleLeftRight =
          targetOffset.width / 2 - tooltipOffset.width / 2;
>>>>>>> main

        // a fix for middle aligned hints
        if (hintMode) {
          tooltipLayerStyleLeftRight += 5;
        }

<<<<<<< HEAD
        if (_checkLeft(targetOffset, tooltipLayerStyleLeftRight, tooltipOffset, tooltipLayer)) {
          tooltipLayer.style.right = null;
          _checkRight(targetOffset, tooltipLayerStyleLeftRight, tooltipOffset, windowSize, tooltipLayer);
        }
        tooltipLayer.style.bottom = (targetOffset.height + 20) + 'px';
        break;

      case 'top-left-aligned':
      // top-left-aligned is the same as the default top
      case 'top':
        arrowLayer.className = 'introjs-arrow bottom';

        tooltipLayerStyleLeft = (hintMode) ? 0 : 15;

        _checkRight(targetOffset, tooltipLayerStyleLeft, tooltipOffset, windowSize, tooltipLayer);
        tooltipLayer.style.bottom = (targetOffset.height +  20) + 'px';
        break;
      case 'right':
        tooltipLayer.style.left = (targetOffset.width + 20) + 'px';
=======
        if (
          _checkLeft(
            targetOffset,
            tooltipLayerStyleLeftRight,
            tooltipOffset,
            tooltipLayer
          )
        ) {
          tooltipLayer.style.right = null;
          _checkRight(
            targetOffset,
            tooltipLayerStyleLeftRight,
            tooltipOffset,
            windowSize,
            tooltipLayer
          );
        }
        tooltipLayer.style.bottom = targetOffset.height + 20 + "px";
        break;

      case "top-left-aligned":
      // top-left-aligned is the same as the default top
      case "top":
        arrowLayer.className = "introjs-arrow bottom";

        tooltipLayerStyleLeft = hintMode ? 0 : 15;

        _checkRight(
          targetOffset,
          tooltipLayerStyleLeft,
          tooltipOffset,
          windowSize,
          tooltipLayer
        );
        tooltipLayer.style.bottom = targetOffset.height + 20 + "px";
        break;
      case "right":
        tooltipLayer.style.left = targetOffset.width + 20 + "px";
>>>>>>> main
        if (targetOffset.top + tooltipOffset.height > windowSize.height) {
          // In this case, right would have fallen below the bottom of the screen.
          // Modify so that the bottom of the tooltip connects with the target
          arrowLayer.className = "introjs-arrow left-bottom";
<<<<<<< HEAD
          tooltipLayer.style.top = "-" + (tooltipOffset.height - targetOffset.height - 20) + "px";
        } else {
          arrowLayer.className = 'introjs-arrow left';
        }
        break;
      case 'left':
        if (!hintMode && this._options.showStepNumbers === true) {
          tooltipLayer.style.top = '15px';
=======
          tooltipLayer.style.top =
            "-" + (tooltipOffset.height - targetOffset.height - 20) + "px";
        } else {
          arrowLayer.className = "introjs-arrow left";
        }
        break;
      case "left":
        if (!hintMode && this._options.showStepNumbers === true) {
          tooltipLayer.style.top = "15px";
>>>>>>> main
        }

        if (targetOffset.top + tooltipOffset.height > windowSize.height) {
          // In this case, left would have fallen below the bottom of the screen.
          // Modify so that the bottom of the tooltip connects with the target
<<<<<<< HEAD
          tooltipLayer.style.top = "-" + (tooltipOffset.height - targetOffset.height - 20) + "px";
          arrowLayer.className = 'introjs-arrow right-bottom';
        } else {
          arrowLayer.className = 'introjs-arrow right';
        }
        tooltipLayer.style.right = (targetOffset.width + 20) + 'px';

        break;
      case 'floating':
        arrowLayer.style.display = 'none';

        //we have to adjust the top and left of layer manually for intro items without element
        tooltipLayer.style.left   = '50%';
        tooltipLayer.style.top    = '50%';
        tooltipLayer.style.marginLeft = '-' + (tooltipOffset.width / 2)  + 'px';
        tooltipLayer.style.marginTop  = '-' + (tooltipOffset.height / 2) + 'px';

        if (typeof(helperNumberLayer) !== 'undefined' && helperNumberLayer !== null) {
          helperNumberLayer.style.left = '-' + ((tooltipOffset.width / 2) + 18) + 'px';
          helperNumberLayer.style.top  = '-' + ((tooltipOffset.height / 2) + 18) + 'px';
        }

        break;
      case 'bottom-right-aligned':
        arrowLayer.className      = 'introjs-arrow top-right';

        tooltipLayerStyleRight = 0;
        _checkLeft(targetOffset, tooltipLayerStyleRight, tooltipOffset, tooltipLayer);
        tooltipLayer.style.top    = (targetOffset.height +  20) + 'px';
        break;

      case 'bottom-middle-aligned':
        arrowLayer.className      = 'introjs-arrow top-middle';

        tooltipLayerStyleLeftRight = targetOffset.width / 2 - tooltipOffset.width / 2;
=======
          tooltipLayer.style.top =
            "-" + (tooltipOffset.height - targetOffset.height - 20) + "px";
          arrowLayer.className = "introjs-arrow right-bottom";
        } else {
          arrowLayer.className = "introjs-arrow right";
        }
        tooltipLayer.style.right = targetOffset.width + 20 + "px";

        break;
      case "floating":
        arrowLayer.style.display = "none";

        //we have to adjust the top and left of layer manually for intro items without element
        tooltipLayer.style.left = "50%";
        tooltipLayer.style.top = "50%";
        tooltipLayer.style.marginLeft = "-" + tooltipOffset.width / 2 + "px";
        tooltipLayer.style.marginTop = "-" + tooltipOffset.height / 2 + "px";

        if (
          typeof helperNumberLayer !== "undefined" &&
          helperNumberLayer !== null
        ) {
          helperNumberLayer.style.left =
            "-" + (tooltipOffset.width / 2 + 18) + "px";
          helperNumberLayer.style.top =
            "-" + (tooltipOffset.height / 2 + 18) + "px";
        }

        break;
      case "bottom-right-aligned":
        arrowLayer.className = "introjs-arrow top-right";

        tooltipLayerStyleRight = 0;
        _checkLeft(
          targetOffset,
          tooltipLayerStyleRight,
          tooltipOffset,
          tooltipLayer
        );
        tooltipLayer.style.top = targetOffset.height + 20 + "px";
        break;

      case "bottom-middle-aligned":
        arrowLayer.className = "introjs-arrow top-middle";

        tooltipLayerStyleLeftRight =
          targetOffset.width / 2 - tooltipOffset.width / 2;
>>>>>>> main

        // a fix for middle aligned hints
        if (hintMode) {
          tooltipLayerStyleLeftRight += 5;
        }

<<<<<<< HEAD
        if (_checkLeft(targetOffset, tooltipLayerStyleLeftRight, tooltipOffset, tooltipLayer)) {
          tooltipLayer.style.right = null;
          _checkRight(targetOffset, tooltipLayerStyleLeftRight, tooltipOffset, windowSize, tooltipLayer);
        }
        tooltipLayer.style.top = (targetOffset.height + 20) + 'px';
=======
        if (
          _checkLeft(
            targetOffset,
            tooltipLayerStyleLeftRight,
            tooltipOffset,
            tooltipLayer
          )
        ) {
          tooltipLayer.style.right = null;
          _checkRight(
            targetOffset,
            tooltipLayerStyleLeftRight,
            tooltipOffset,
            windowSize,
            tooltipLayer
          );
        }
        tooltipLayer.style.top = targetOffset.height + 20 + "px";
>>>>>>> main
        break;

      // case 'bottom-left-aligned':
      // Bottom-left-aligned is the same as the default bottom
      // case 'bottom':
      // Bottom going to follow the default behavior
      default:
<<<<<<< HEAD
        arrowLayer.className = 'introjs-arrow top';

        tooltipLayerStyleLeft = 0;
        _checkRight(targetOffset, tooltipLayerStyleLeft, tooltipOffset, windowSize, tooltipLayer);
        tooltipLayer.style.top    = (targetOffset.height +  20) + 'px';
=======
        arrowLayer.className = "introjs-arrow top";

        tooltipLayerStyleLeft = 0;
        _checkRight(
          targetOffset,
          tooltipLayerStyleLeft,
          tooltipOffset,
          windowSize,
          tooltipLayer
        );
        tooltipLayer.style.top = targetOffset.height + 20 + "px";
>>>>>>> main
    }
  }

  /**
   * Set tooltip left so it doesn't go off the right side of the window
   *
   * @return boolean true, if tooltipLayerStyleLeft is ok.  false, otherwise.
   */
<<<<<<< HEAD
  function _checkRight(targetOffset, tooltipLayerStyleLeft, tooltipOffset, windowSize, tooltipLayer) {
    if (targetOffset.left + tooltipLayerStyleLeft + tooltipOffset.width > windowSize.width) {
      // off the right side of the window
      tooltipLayer.style.left = (windowSize.width - tooltipOffset.width - targetOffset.left) + 'px';
      return false;
    }
    tooltipLayer.style.left = tooltipLayerStyleLeft + 'px';
=======
  function _checkRight(
    targetOffset,
    tooltipLayerStyleLeft,
    tooltipOffset,
    windowSize,
    tooltipLayer
  ) {
    if (
      targetOffset.left + tooltipLayerStyleLeft + tooltipOffset.width >
      windowSize.width
    ) {
      // off the right side of the window
      tooltipLayer.style.left =
        windowSize.width - tooltipOffset.width - targetOffset.left + "px";
      return false;
    }
    tooltipLayer.style.left = tooltipLayerStyleLeft + "px";
>>>>>>> main
    return true;
  }

  /**
   * Set tooltip right so it doesn't go off the left side of the window
   *
   * @return boolean true, if tooltipLayerStyleRight is ok.  false, otherwise.
   */
<<<<<<< HEAD
  function _checkLeft(targetOffset, tooltipLayerStyleRight, tooltipOffset, tooltipLayer) {
    if (targetOffset.left + targetOffset.width - tooltipLayerStyleRight - tooltipOffset.width < 0) {
      // off the left side of the window
      tooltipLayer.style.left = (-targetOffset.left) + 'px';
      return false;
    }
    tooltipLayer.style.right = tooltipLayerStyleRight + 'px';
=======
  function _checkLeft(
    targetOffset,
    tooltipLayerStyleRight,
    tooltipOffset,
    tooltipLayer
  ) {
    if (
      targetOffset.left +
        targetOffset.width -
        tooltipLayerStyleRight -
        tooltipOffset.width <
      0
    ) {
      // off the left side of the window
      tooltipLayer.style.left = -targetOffset.left + "px";
      return false;
    }
    tooltipLayer.style.right = tooltipLayerStyleRight + "px";
>>>>>>> main
    return true;
  }

  /**
   * Determines the position of the tooltip based on the position precedence and availability
   * of screen space.
   *
   * @param {Object}    targetElement
   * @param {Object}    tooltipLayer
   * @param {String}    desiredTooltipPosition
   * @return {String}   calculatedPosition
   */
<<<<<<< HEAD
  function _determineAutoPosition(targetElement, tooltipLayer, desiredTooltipPosition) {

    // Take a clone of position precedence. These will be the available
    var possiblePositions = this._options.positionPrecedence.slice();

    var windowSize = _getWinSize();
    var tooltipHeight = _getOffset(tooltipLayer).height + 10;
    var tooltipWidth = _getOffset(tooltipLayer).width + 20;
    var targetElementRect = targetElement.getBoundingClientRect();

    // If we check all the possible areas, and there are no valid places for the tooltip, the element
    // must take up most of the screen real estate. Show the tooltip floating in the middle of the screen.
    var calculatedPosition = "floating";

    /*
    * auto determine position
    */

    // Check for space below
    if (targetElementRect.bottom + tooltipHeight + tooltipHeight > windowSize.height) {
=======
  function _determineAutoPosition(
    targetElement,
    tooltipLayer,
    desiredTooltipPosition
  ) {
    // Take a clone of position precedence. These will be the available
    let possiblePositions = this._options.positionPrecedence.slice();

    let windowSize = _getWinSize();
    let tooltipHeight = _getOffset(tooltipLayer).height + 10;
    let tooltipWidth = _getOffset(tooltipLayer).width + 20;
    let targetElementRect = targetElement.getBoundingClientRect();

    // If we check all the possible areas, and there are no valid places for the tooltip, the element
    // must take up most of the screen real estate. Show the tooltip floating in the middle of the screen.
    let calculatedPosition = "floating";

    /*
     * auto determine position
     */

    // Check for space below
    if (
      targetElementRect.bottom + tooltipHeight + tooltipHeight >
      windowSize.height
    ) {
>>>>>>> main
      _removeEntry(possiblePositions, "bottom");
    }

    // Check for space above
    if (targetElementRect.top - tooltipHeight < 0) {
      _removeEntry(possiblePositions, "top");
    }

    // Check for space to the right
    if (targetElementRect.right + tooltipWidth > windowSize.width) {
      _removeEntry(possiblePositions, "right");
    }

    // Check for space to the left
    if (targetElementRect.left - tooltipWidth < 0) {
      _removeEntry(possiblePositions, "left");
    }

<<<<<<< HEAD
    // @var {String}  ex: 'right-aligned'
    var desiredAlignment = (function (pos) {
      var hyphenIndex = pos.indexOf('-');
=======
    // @let {String}  ex: 'right-aligned'
    let desiredAlignment = (function (pos) {
      let hyphenIndex = pos.indexOf("-");
>>>>>>> main
      if (hyphenIndex !== -1) {
        // has alignment
        return pos.substr(hyphenIndex);
      }
<<<<<<< HEAD
      return '';
    })(desiredTooltipPosition || '');
=======
      return "";
    })(desiredTooltipPosition || "");
>>>>>>> main

    // strip alignment from position
    if (desiredTooltipPosition) {
      // ex: "bottom-right-aligned"
      // should return 'bottom'
<<<<<<< HEAD
      desiredTooltipPosition = desiredTooltipPosition.split('-')[0];
    }

    if (possiblePositions.length) {
      if (desiredTooltipPosition !== "auto" &&
          possiblePositions.indexOf(desiredTooltipPosition) > -1) {
=======
      desiredTooltipPosition = desiredTooltipPosition.split("-")[0];
    }

    if (possiblePositions.length) {
      if (
        desiredTooltipPosition !== "auto" &&
        possiblePositions.indexOf(desiredTooltipPosition) > -1
      ) {
>>>>>>> main
        // If the requested position is in the list, choose that
        calculatedPosition = desiredTooltipPosition;
      } else {
        // Pick the first valid position, in order
        calculatedPosition = possiblePositions[0];
      }
    }

    // only top and bottom positions have optional alignments
<<<<<<< HEAD
    if (['top', 'bottom'].indexOf(calculatedPosition) !== -1) {
      calculatedPosition += _determineAutoAlignment(targetElementRect.left, tooltipWidth, windowSize, desiredAlignment);
=======
    if (["top", "bottom"].indexOf(calculatedPosition) !== -1) {
      calculatedPosition += _determineAutoAlignment(
        targetElementRect.left,
        tooltipWidth,
        windowSize,
        desiredAlignment
      );
>>>>>>> main
    }

    return calculatedPosition;
  }

  /**
<<<<<<< HEAD
  * auto-determine alignment
  * @param {Integer}  offsetLeft
  * @param {Integer}  tooltipWidth
  * @param {Object}   windowSize
  * @param {String}   desiredAlignment
  * @return {String}  calculatedAlignment
  */
  function _determineAutoAlignment (offsetLeft, tooltipWidth, windowSize, desiredAlignment) {
    var halfTooltipWidth = tooltipWidth / 2,
      winWidth = Math.min(windowSize.width, window.screen.width),
      possibleAlignments = ['-left-aligned', '-middle-aligned', '-right-aligned'],
      calculatedAlignment = '';
=======
   * auto-determine alignment
   * @param {Integer}  offsetLeft
   * @param {Integer}  tooltipWidth
   * @param {Object}   windowSize
   * @param {String}   desiredAlignment
   * @return {String}  calculatedAlignment
   */
  function _determineAutoAlignment(
    offsetLeft,
    tooltipWidth,
    windowSize,
    desiredAlignment
  ) {
    let halfTooltipWidth = tooltipWidth / 2,
      winWidth = Math.min(windowSize.width, window.screen.width),
      possibleAlignments = [
        "-left-aligned",
        "-middle-aligned",
        "-right-aligned",
      ],
      calculatedAlignment = "";
>>>>>>> main

    // valid left must be at least a tooltipWidth
    // away from right side
    if (winWidth - offsetLeft < tooltipWidth) {
<<<<<<< HEAD
      _removeEntry(possibleAlignments, '-left-aligned');
=======
      _removeEntry(possibleAlignments, "-left-aligned");
>>>>>>> main
    }

    // valid middle must be at least half
    // width away from both sides
<<<<<<< HEAD
    if (offsetLeft < halfTooltipWidth ||
      winWidth - offsetLeft < halfTooltipWidth) {
      _removeEntry(possibleAlignments, '-middle-aligned');
=======
    if (
      offsetLeft < halfTooltipWidth ||
      winWidth - offsetLeft < halfTooltipWidth
    ) {
      _removeEntry(possibleAlignments, "-middle-aligned");
>>>>>>> main
    }

    // valid right must be at least a tooltipWidth
    // width away from left side
    if (offsetLeft < tooltipWidth) {
<<<<<<< HEAD
      _removeEntry(possibleAlignments, '-right-aligned');
=======
      _removeEntry(possibleAlignments, "-right-aligned");
>>>>>>> main
    }

    if (possibleAlignments.length) {
      if (possibleAlignments.indexOf(desiredAlignment) !== -1) {
        // the desired alignment is valid
        calculatedAlignment = desiredAlignment;
      } else {
        // pick the first valid position, in order
        calculatedAlignment = possibleAlignments[0];
      }
    } else {
      // if screen width is too small
      // for ANY alignment, middle is
      // probably the best for visibility
<<<<<<< HEAD
      calculatedAlignment = '-middle-aligned';
=======
      calculatedAlignment = "-middle-aligned";
>>>>>>> main
    }

    return calculatedAlignment;
  }

  /**
   * Remove an entry from a string array if it's there, does nothing if it isn't there.
   *
   * @param {Array} stringArray
   * @param {String} stringToRemove
   */
  function _removeEntry(stringArray, stringToRemove) {
    if (stringArray.indexOf(stringToRemove) > -1) {
      stringArray.splice(stringArray.indexOf(stringToRemove), 1);
    }
  }

  /**
   * Update the position of the helper layer on the screen
   *
   * @api private
   * @method _setHelperLayerPosition
   * @param {Object} helperLayer
   */
  function _setHelperLayerPosition(helperLayer) {
    if (helperLayer) {
      //prevent error when `this._currentStep` in undefined
      if (!this._introItems[this._currentStep]) return;

<<<<<<< HEAD
      var currentElement  = this._introItems[this._currentStep],
          elementPosition = _getOffset(currentElement.element),
          widthHeightPadding = this._options.helperElementPadding;
=======
      let currentElement = this._introItems[this._currentStep],
        elementPosition = _getOffset(currentElement.element),
        widthHeightPadding = this._options.helperElementPadding;
>>>>>>> main

      // If the target element is fixed, the tooltip should be fixed as well.
      // Otherwise, remove a fixed class that may be left over from the previous
      // step.
      if (_isFixed(currentElement.element)) {
<<<<<<< HEAD
        _addClass(helperLayer, 'introjs-fixedTooltip');
      } else {
        _removeClass(helperLayer, 'introjs-fixedTooltip');
      }

      if (currentElement.position === 'floating') {
=======
        _addClass(helperLayer, "introjs-fixedTooltip");
      } else {
        _removeClass(helperLayer, "introjs-fixedTooltip");
      }

      if (currentElement.position === "floating") {
>>>>>>> main
        widthHeightPadding = 0;
      }

      //set new position to helper layer
<<<<<<< HEAD
      helperLayer.style.cssText = 'width: ' + (elementPosition.width  + widthHeightPadding)  + 'px; ' +
                                        'height:' + (elementPosition.height + widthHeightPadding)  + 'px; ' +
                                        'top:'    + (elementPosition.top    - widthHeightPadding / 2)   + 'px;' +
                                        'left: '  + (elementPosition.left   - widthHeightPadding / 2)   + 'px;';

=======
      helperLayer.style.cssText =
        "width: " +
        (elementPosition.width + widthHeightPadding) +
        "px; " +
        "height:" +
        (elementPosition.height + widthHeightPadding) +
        "px; " +
        "top:" +
        (elementPosition.top - widthHeightPadding / 2) +
        "px;" +
        "left: " +
        (elementPosition.left - widthHeightPadding / 2) +
        "px;";
>>>>>>> main
    }
  }

  /**
   * Add disableinteraction layer and adjust the size and position of the layer
   *
   * @api private
   * @method _disableInteraction
   */
  function _disableInteraction() {
<<<<<<< HEAD
    var disableInteractionLayer = document.querySelector('.introjs-disableInteraction');

    if (disableInteractionLayer === null) {
      disableInteractionLayer = document.createElement('div');
      disableInteractionLayer.className = 'introjs-disableInteraction';
=======
    let disableInteractionLayer = document.querySelector(
      ".introjs-disableInteraction"
    );

    if (disableInteractionLayer === null) {
      disableInteractionLayer = document.createElement("div");
      disableInteractionLayer.className = "introjs-disableInteraction";
>>>>>>> main
      this._targetElement.appendChild(disableInteractionLayer);
    }

    _setHelperLayerPosition.call(this, disableInteractionLayer);
  }

  /**
   * Setting anchors to behave like buttons
   *
   * @api private
   * @method _setAnchorAsButton
   */
<<<<<<< HEAD
  function _setAnchorAsButton(anchor){
    anchor.setAttribute('role', 'button');
=======
  function _setAnchorAsButton(anchor) {
    anchor.setAttribute("role", "button");
>>>>>>> main
    anchor.tabIndex = 0;
  }

  /**
   * Show an element on the page
   *
   * @api private
   * @method _showElement
   * @param {Object} targetElement
   */
  function _showElement(targetElement) {
<<<<<<< HEAD
    if (typeof (this._introChangeCallback) !== 'undefined') {
      this._introChangeCallback.call(this, targetElement.element);
    }

    var self = this,
        oldHelperLayer = document.querySelector('.introjs-helperLayer'),
        oldReferenceLayer = document.querySelector('.introjs-tooltipReferenceLayer'),
        highlightClass = 'introjs-helperLayer',
        nextTooltipButton,
        prevTooltipButton,
        skipTooltipButton,
        scrollParent;

    //check for a current step highlight class
    if (typeof (targetElement.highlightClass) === 'string') {
      highlightClass += (' ' + targetElement.highlightClass);
    }
    //check for options highlight class
    if (typeof (this._options.highlightClass) === 'string') {
      highlightClass += (' ' + this._options.highlightClass);
    }

    if (oldHelperLayer !== null) {
      var oldHelperNumberLayer = oldReferenceLayer.querySelector('.introjs-helperNumberLayer'),
          oldtooltipLayer      = oldReferenceLayer.querySelector('.introjs-tooltiptext'),
          oldArrowLayer        = oldReferenceLayer.querySelector('.introjs-arrow'),
          oldtooltipContainer  = oldReferenceLayer.querySelector('.introjs-tooltip');

      skipTooltipButton    = oldReferenceLayer.querySelector('.introjs-skipbutton');
      prevTooltipButton    = oldReferenceLayer.querySelector('.introjs-prevbutton');
      nextTooltipButton    = oldReferenceLayer.querySelector('.introjs-nextbutton');
=======
    if (typeof this._introChangeCallback !== "undefined") {
      this._introChangeCallback.call(this, targetElement.element);
    }

    let self = this,
      oldHelperLayer = document.querySelector(".introjs-helperLayer"),
      oldReferenceLayer = document.querySelector(
        ".introjs-tooltipReferenceLayer"
      ),
      highlightClass = "introjs-helperLayer",
      nextTooltipButton,
      prevTooltipButton,
      skipTooltipButton,
      scrollParent;

    //check for a current step highlight class
    if (typeof targetElement.highlightClass === "string") {
      highlightClass += " " + targetElement.highlightClass;
    }
    //check for options highlight class
    if (typeof this._options.highlightClass === "string") {
      highlightClass += " " + this._options.highlightClass;
    }

    if (oldHelperLayer !== null) {
      let oldHelperNumberLayer = oldReferenceLayer.querySelector(
          ".introjs-helperNumberLayer"
        ),
        oldtooltipLayer = oldReferenceLayer.querySelector(
          ".introjs-tooltiptext"
        ),
        oldArrowLayer = oldReferenceLayer.querySelector(".introjs-arrow"),
        oldtooltipContainer = oldReferenceLayer.querySelector(
          ".introjs-tooltip"
        );

      skipTooltipButton = oldReferenceLayer.querySelector(
        ".introjs-skipbutton"
      );
      prevTooltipButton = oldReferenceLayer.querySelector(
        ".introjs-prevbutton"
      );
      nextTooltipButton = oldReferenceLayer.querySelector(
        ".introjs-nextbutton"
      );
>>>>>>> main

      //update or reset the helper highlight class
      oldHelperLayer.className = highlightClass;
      //hide the tooltip
      oldtooltipContainer.style.opacity = 0;
      oldtooltipContainer.style.display = "none";

      if (oldHelperNumberLayer !== null) {
<<<<<<< HEAD
        var lastIntroItem = this._introItems[(targetElement.step - 2 >= 0 ? targetElement.step - 2 : 0)];

        if (lastIntroItem !== null && (this._direction === 'forward' && lastIntroItem.position === 'floating') || (this._direction === 'backward' && targetElement.position === 'floating')) {
=======
        let lastIntroItem = this._introItems[
          targetElement.step - 2 >= 0 ? targetElement.step - 2 : 0
        ];

        if (
          (lastIntroItem !== null &&
            this._direction === "forward" &&
            lastIntroItem.position === "floating") ||
          (this._direction === "backward" &&
            targetElement.position === "floating")
        ) {
>>>>>>> main
          oldHelperNumberLayer.style.opacity = 0;
        }
      }

      // scroll to element
<<<<<<< HEAD
      scrollParent = _getScrollParent( targetElement.element );
=======
      scrollParent = _getScrollParent(targetElement.element);
>>>>>>> main

      if (scrollParent !== document.body) {
        // target is within a scrollable element
        _scrollParentToElement(scrollParent, targetElement.element);
      }

      // set new position to helper layer
      _setHelperLayerPosition.call(self, oldHelperLayer);
      _setHelperLayerPosition.call(self, oldReferenceLayer);

      //remove `introjs-fixParent` class from the elements
<<<<<<< HEAD
      var fixParents = document.querySelectorAll('.introjs-fixParent');
=======
      let fixParents = document.querySelectorAll(".introjs-fixParent");
>>>>>>> main
      _forEach(fixParents, function (parent) {
        _removeClass(parent, /introjs-fixParent/g);
      });

      //remove old classes if the element still exist
      _removeShowElement();

      //we should wait until the CSS3 transition is competed (it's 0.3 sec) to prevent incorrect `height` and `width` calculation
      if (self._lastShowElementTimer) {
        window.clearTimeout(self._lastShowElementTimer);
      }

<<<<<<< HEAD
      self._lastShowElementTimer = window.setTimeout(function() {
=======
      self._lastShowElementTimer = window.setTimeout(function () {
>>>>>>> main
        //set current step to the label
        if (oldHelperNumberLayer !== null) {
          oldHelperNumberLayer.innerHTML = targetElement.step;
        }
        //set current tooltip text
        oldtooltipLayer.innerHTML = targetElement.intro;
        //set the tooltip position
        oldtooltipContainer.style.display = "block";
<<<<<<< HEAD
        _placeTooltip.call(self, targetElement.element, oldtooltipContainer, oldArrowLayer, oldHelperNumberLayer);

        //change active bullet
        if (self._options.showBullets) {
            oldReferenceLayer.querySelector('.introjs-bullets li > a.active').className = '';
            oldReferenceLayer.querySelector('.introjs-bullets li > a[data-stepnumber="' + targetElement.step + '"]').className = 'active';
        }
        oldReferenceLayer.querySelector('.introjs-progress .introjs-progressbar').style.cssText = 'width:' + _getProgress.call(self) + '%;';
        oldReferenceLayer.querySelector('.introjs-progress .introjs-progressbar').setAttribute('aria-valuenow', _getProgress.call(self));
=======
        _placeTooltip.call(
          self,
          targetElement.element,
          oldtooltipContainer,
          oldArrowLayer,
          oldHelperNumberLayer
        );

        //change active bullet
        if (self._options.showBullets) {
          oldReferenceLayer.querySelector(
            ".introjs-bullets li > a.active"
          ).className = "";
          oldReferenceLayer.querySelector(
            '.introjs-bullets li > a[data-stepnumber="' +
              targetElement.step +
              '"]'
          ).className = "active";
        }
        oldReferenceLayer.querySelector(
          ".introjs-progress .introjs-progressbar"
        ).style.cssText = "width:" + _getProgress.call(self) + "%;";
        oldReferenceLayer
          .querySelector(".introjs-progress .introjs-progressbar")
          .setAttribute("aria-valuenow", _getProgress.call(self));
>>>>>>> main

        //show the tooltip
        oldtooltipContainer.style.opacity = 1;
        if (oldHelperNumberLayer) oldHelperNumberLayer.style.opacity = 1;

        //reset button focus
<<<<<<< HEAD
        if (typeof skipTooltipButton !== "undefined" && skipTooltipButton !== null && /introjs-donebutton/gi.test(skipTooltipButton.className)) {
          // skip button is now "done" button
          skipTooltipButton.focus();
        } else if (typeof nextTooltipButton !== "undefined" && nextTooltipButton !== null) {
=======
        if (
          typeof skipTooltipButton !== "undefined" &&
          skipTooltipButton !== null &&
          /introjs-donebutton/gi.test(skipTooltipButton.className)
        ) {
          // skip button is now "done" button
          skipTooltipButton.focus();
        } else if (
          typeof nextTooltipButton !== "undefined" &&
          nextTooltipButton !== null
        ) {
>>>>>>> main
          //still in the tour, focus on next
          nextTooltipButton.focus();
        }

        // change the scroll of the window, if needed
<<<<<<< HEAD
        _scrollTo.call(self, targetElement.scrollTo, targetElement, oldtooltipLayer);
=======
        _scrollTo.call(
          self,
          targetElement.scrollTo,
          targetElement,
          oldtooltipLayer
        );
>>>>>>> main
      }, 350);

      // end of old element if-else condition
    } else {
<<<<<<< HEAD
      var helperLayer       = document.createElement('div'),
          referenceLayer    = document.createElement('div'),
          arrowLayer        = document.createElement('div'),
          tooltipLayer      = document.createElement('div'),
          tooltipTextLayer  = document.createElement('div'),
          bulletsLayer      = document.createElement('div'),
          progressLayer     = document.createElement('div'),
          buttonsLayer      = document.createElement('div');

      helperLayer.className = highlightClass;
      referenceLayer.className = 'introjs-tooltipReferenceLayer';

      // scroll to element
      scrollParent = _getScrollParent( targetElement.element );
=======
      let helperLayer = document.createElement("div"),
        referenceLayer = document.createElement("div"),
        arrowLayer = document.createElement("div"),
        tooltipLayer = document.createElement("div"),
        tooltipTextLayer = document.createElement("div"),
        bulletsLayer = document.createElement("div"),
        progressLayer = document.createElement("div"),
        buttonsLayer = document.createElement("div");

      helperLayer.className = highlightClass;
      referenceLayer.className = "introjs-tooltipReferenceLayer";

      // scroll to element
      scrollParent = _getScrollParent(targetElement.element);
>>>>>>> main

      if (scrollParent !== document.body) {
        // target is within a scrollable element
        _scrollParentToElement(scrollParent, targetElement.element);
      }

      //set new position to helper layer
      _setHelperLayerPosition.call(self, helperLayer);
      _setHelperLayerPosition.call(self, referenceLayer);

      //add helper layer to target element
      this._targetElement.appendChild(helperLayer);
      this._targetElement.appendChild(referenceLayer);

<<<<<<< HEAD
      arrowLayer.className = 'introjs-arrow';

      tooltipTextLayer.className = 'introjs-tooltiptext';
      tooltipTextLayer.innerHTML = targetElement.intro;

      bulletsLayer.className = 'introjs-bullets';

      if (this._options.showBullets === false) {
        bulletsLayer.style.display = 'none';
      }

      var ulContainer = document.createElement('ul');
      ulContainer.setAttribute('role', 'tablist');

      var anchorClick = function () {
          self.goToStep(this.getAttribute('data-stepnumber'));
      };

      _forEach(this._introItems, function (item, i) {
        var innerLi    = document.createElement('li');
        var anchorLink = document.createElement('a');

        innerLi.setAttribute('role', 'presentation');
        anchorLink.setAttribute('role', 'tab');

        anchorLink.onclick = anchorClick;

        if (i === (targetElement.step-1)) {
          anchorLink.className = 'active';
=======
      arrowLayer.className = "introjs-arrow";

      tooltipTextLayer.className = "introjs-tooltiptext";
      tooltipTextLayer.innerHTML = targetElement.intro;

      bulletsLayer.className = "introjs-bullets";

      if (this._options.showBullets === false) {
        bulletsLayer.style.display = "none";
      }

      let ulContainer = document.createElement("ul");
      ulContainer.setAttribute("role", "tablist");

      let anchorClick = function () {
        self.goToStep(this.getAttribute("data-stepnumber"));
      };

      _forEach(this._introItems, function (item, i) {
        let innerLi = document.createElement("li");
        let anchorLink = document.createElement("a");

        innerLi.setAttribute("role", "presentation");
        anchorLink.setAttribute("role", "tab");

        anchorLink.onclick = anchorClick;

        if (i === targetElement.step - 1) {
          anchorLink.className = "active";
>>>>>>> main
        }

        _setAnchorAsButton(anchorLink);
        anchorLink.innerHTML = "&nbsp;";
<<<<<<< HEAD
        anchorLink.setAttribute('data-stepnumber', item.step);
=======
        anchorLink.setAttribute("data-stepnumber", item.step);
>>>>>>> main

        innerLi.appendChild(anchorLink);
        ulContainer.appendChild(innerLi);
      });

      bulletsLayer.appendChild(ulContainer);

<<<<<<< HEAD
      progressLayer.className = 'introjs-progress';

      if (this._options.showProgress === false) {
        progressLayer.style.display = 'none';
      }
      var progressBar = document.createElement('div');
      progressBar.className = 'introjs-progressbar';
      progressBar.setAttribute('role', 'progress');
      progressBar.setAttribute('aria-valuemin', 0);
      progressBar.setAttribute('aria-valuemax', 100);
      progressBar.setAttribute('aria-valuenow', _getProgress.call(this));
      progressBar.style.cssText = 'width:' + _getProgress.call(this) + '%;';

      progressLayer.appendChild(progressBar);

      buttonsLayer.className = 'introjs-tooltipbuttons';
      if (this._options.showButtons === false) {
        buttonsLayer.style.display = 'none';
      }

      tooltipLayer.className = 'introjs-tooltip';
=======
      progressLayer.className = "introjs-progress";

      if (this._options.showProgress === false) {
        progressLayer.style.display = "none";
      }
      let progressBar = document.createElement("div");
      progressBar.className = "introjs-progressbar";
      progressBar.setAttribute("role", "progress");
      progressBar.setAttribute("aria-valuemin", 0);
      progressBar.setAttribute("aria-valuemax", 100);
      progressBar.setAttribute("aria-valuenow", _getProgress.call(this));
      progressBar.style.cssText = "width:" + _getProgress.call(this) + "%;";

      progressLayer.appendChild(progressBar);

      buttonsLayer.className = "introjs-tooltipbuttons";
      if (this._options.showButtons === false) {
        buttonsLayer.style.display = "none";
      }

      tooltipLayer.className = "introjs-tooltip";
>>>>>>> main
      tooltipLayer.appendChild(tooltipTextLayer);
      tooltipLayer.appendChild(bulletsLayer);
      tooltipLayer.appendChild(progressLayer);

      //add helper layer number
<<<<<<< HEAD
      var helperNumberLayer = document.createElement('span');
      if (this._options.showStepNumbers === true) {
        helperNumberLayer.className = 'introjs-helperNumberLayer';
=======
      let helperNumberLayer = document.createElement("span");
      if (this._options.showStepNumbers === true) {
        helperNumberLayer.className = "introjs-helperNumberLayer";
>>>>>>> main
        helperNumberLayer.innerHTML = targetElement.step;
        referenceLayer.appendChild(helperNumberLayer);
      }

      tooltipLayer.appendChild(arrowLayer);
      referenceLayer.appendChild(tooltipLayer);

      //next button
<<<<<<< HEAD
      nextTooltipButton = document.createElement('a');

      nextTooltipButton.onclick = function() {
=======
      nextTooltipButton = document.createElement("a");

      nextTooltipButton.onclick = function () {
>>>>>>> main
        if (self._introItems.length - 1 !== self._currentStep) {
          _nextStep.call(self);
        }
      };

      _setAnchorAsButton(nextTooltipButton);
      nextTooltipButton.innerHTML = this._options.nextLabel;

      //previous button
<<<<<<< HEAD
      prevTooltipButton = document.createElement('a');

      prevTooltipButton.onclick = function() {
=======
      prevTooltipButton = document.createElement("a");

      prevTooltipButton.onclick = function () {
>>>>>>> main
        if (self._currentStep !== 0) {
          _previousStep.call(self);
        }
      };

      _setAnchorAsButton(prevTooltipButton);
      prevTooltipButton.innerHTML = this._options.prevLabel;

      //skip button
<<<<<<< HEAD
      skipTooltipButton = document.createElement('a');
      skipTooltipButton.className = this._options.buttonClass + ' introjs-skipbutton ';
      _setAnchorAsButton(skipTooltipButton);
      skipTooltipButton.innerHTML = this._options.skipLabel;

      skipTooltipButton.onclick = function() {
        if (self._introItems.length - 1 === self._currentStep && typeof (self._introCompleteCallback) === 'function') {
          self._introCompleteCallback.call(self);
        }

        if (self._introItems.length - 1 !== self._currentStep && typeof (self._introExitCallback) === 'function') {
          self._introExitCallback.call(self);
        }

        if (typeof(self._introSkipCallback) === 'function') {
=======
      skipTooltipButton = document.createElement("a");
      skipTooltipButton.className =
        this._options.buttonClass + " introjs-skipbutton ";
      _setAnchorAsButton(skipTooltipButton);
      skipTooltipButton.innerHTML = this._options.skipLabel;

      skipTooltipButton.onclick = function () {
        if (
          self._introItems.length - 1 === self._currentStep &&
          typeof self._introCompleteCallback === "function"
        ) {
          self._introCompleteCallback.call(self);
        }

        if (
          self._introItems.length - 1 !== self._currentStep &&
          typeof self._introExitCallback === "function"
        ) {
          self._introExitCallback.call(self);
        }

        if (typeof self._introSkipCallback === "function") {
>>>>>>> main
          self._introSkipCallback.call(self);
        }

        _exitIntro.call(self, self._targetElement);
      };

      buttonsLayer.appendChild(skipTooltipButton);

      //in order to prevent displaying next/previous button always
      if (this._introItems.length > 1) {
        buttonsLayer.appendChild(prevTooltipButton);
        buttonsLayer.appendChild(nextTooltipButton);
      }

      tooltipLayer.appendChild(buttonsLayer);

      //set proper position
<<<<<<< HEAD
      _placeTooltip.call(self, targetElement.element, tooltipLayer, arrowLayer, helperNumberLayer);
=======
      _placeTooltip.call(
        self,
        targetElement.element,
        tooltipLayer,
        arrowLayer,
        helperNumberLayer
      );
>>>>>>> main

      // change the scroll of the window, if needed
      _scrollTo.call(this, targetElement.scrollTo, targetElement, tooltipLayer);

      //end of new element if-else condition
    }

    // removing previous disable interaction layer
<<<<<<< HEAD
    var disableInteractionLayer = self._targetElement.querySelector('.introjs-disableInteraction');
=======
    let disableInteractionLayer = self._targetElement.querySelector(
      ".introjs-disableInteraction"
    );
>>>>>>> main
    if (disableInteractionLayer) {
      disableInteractionLayer.parentNode.removeChild(disableInteractionLayer);
    }

    //disable interaction
    if (targetElement.disableInteraction) {
      _disableInteraction.call(self);
    }

    // when it's the first step of tour
    if (this._currentStep === 0 && this._introItems.length > 1) {
<<<<<<< HEAD
      if (typeof skipTooltipButton !== "undefined" && skipTooltipButton !== null) {
        skipTooltipButton.className = this._options.buttonClass + ' introjs-skipbutton';
      }
      if (typeof nextTooltipButton !== "undefined" && nextTooltipButton !== null) {
        nextTooltipButton.className = this._options.buttonClass + ' introjs-nextbutton';
      }

      if (this._options.hidePrev === true) {
        if (typeof prevTooltipButton !== "undefined" && prevTooltipButton !== null) {
          prevTooltipButton.className = this._options.buttonClass + ' introjs-prevbutton introjs-hidden';
        }
        if (typeof nextTooltipButton !== "undefined" && nextTooltipButton !== null) {
          _addClass(nextTooltipButton, 'introjs-fullbutton');
        }
      } else {
        if (typeof prevTooltipButton !== "undefined" && prevTooltipButton !== null) {
          prevTooltipButton.className = this._options.buttonClass + ' introjs-prevbutton introjs-disabled';
        }
      }

      if (typeof skipTooltipButton !== "undefined" && skipTooltipButton !== null) {
        skipTooltipButton.innerHTML = this._options.skipLabel;
      }
    } else if (this._introItems.length - 1 === this._currentStep || this._introItems.length === 1) {
      // last step of tour
      if (typeof skipTooltipButton !== "undefined" && skipTooltipButton !== null) {
        skipTooltipButton.innerHTML = this._options.doneLabel;
        // adding donebutton class in addition to skipbutton
        _addClass(skipTooltipButton, 'introjs-donebutton');
      }
      if (typeof prevTooltipButton !== "undefined" && prevTooltipButton !== null) {
        prevTooltipButton.className = this._options.buttonClass + ' introjs-prevbutton';
      }

      if (this._options.hideNext === true) {
        if (typeof nextTooltipButton !== "undefined" && nextTooltipButton !== null) {
          nextTooltipButton.className = this._options.buttonClass + ' introjs-nextbutton introjs-hidden';
        }
        if (typeof prevTooltipButton !== "undefined" && prevTooltipButton !== null) {
          _addClass(prevTooltipButton, 'introjs-fullbutton');
        }
      } else {
        if (typeof nextTooltipButton !== "undefined" && nextTooltipButton !== null) {
          nextTooltipButton.className = this._options.buttonClass + ' introjs-nextbutton introjs-disabled';
=======
      if (
        typeof skipTooltipButton !== "undefined" &&
        skipTooltipButton !== null
      ) {
        skipTooltipButton.className =
          this._options.buttonClass + " introjs-skipbutton";
      }
      if (
        typeof nextTooltipButton !== "undefined" &&
        nextTooltipButton !== null
      ) {
        nextTooltipButton.className =
          this._options.buttonClass + " introjs-nextbutton";
      }

      if (this._options.hidePrev === true) {
        if (
          typeof prevTooltipButton !== "undefined" &&
          prevTooltipButton !== null
        ) {
          prevTooltipButton.className =
            this._options.buttonClass + " introjs-prevbutton introjs-hidden";
        }
        if (
          typeof nextTooltipButton !== "undefined" &&
          nextTooltipButton !== null
        ) {
          _addClass(nextTooltipButton, "introjs-fullbutton");
        }
      } else {
        if (
          typeof prevTooltipButton !== "undefined" &&
          prevTooltipButton !== null
        ) {
          prevTooltipButton.className =
            this._options.buttonClass + " introjs-prevbutton introjs-disabled";
        }
      }

      if (
        typeof skipTooltipButton !== "undefined" &&
        skipTooltipButton !== null
      ) {
        skipTooltipButton.innerHTML = this._options.skipLabel;
      }
    } else if (
      this._introItems.length - 1 === this._currentStep ||
      this._introItems.length === 1
    ) {
      // last step of tour
      if (
        typeof skipTooltipButton !== "undefined" &&
        skipTooltipButton !== null
      ) {
        skipTooltipButton.innerHTML = this._options.doneLabel;
        // adding donebutton class in addition to skipbutton
        _addClass(skipTooltipButton, "introjs-donebutton");
      }
      if (
        typeof prevTooltipButton !== "undefined" &&
        prevTooltipButton !== null
      ) {
        prevTooltipButton.className =
          this._options.buttonClass + " introjs-prevbutton";
      }

      if (this._options.hideNext === true) {
        if (
          typeof nextTooltipButton !== "undefined" &&
          nextTooltipButton !== null
        ) {
          nextTooltipButton.className =
            this._options.buttonClass + " introjs-nextbutton introjs-hidden";
        }
        if (
          typeof prevTooltipButton !== "undefined" &&
          prevTooltipButton !== null
        ) {
          _addClass(prevTooltipButton, "introjs-fullbutton");
        }
      } else {
        if (
          typeof nextTooltipButton !== "undefined" &&
          nextTooltipButton !== null
        ) {
          nextTooltipButton.className =
            this._options.buttonClass + " introjs-nextbutton introjs-disabled";
>>>>>>> main
        }
      }
    } else {
      // steps between start and end
<<<<<<< HEAD
      if (typeof skipTooltipButton !== "undefined" && skipTooltipButton !== null) {
        skipTooltipButton.className = this._options.buttonClass + ' introjs-skipbutton';
      }
      if (typeof prevTooltipButton !== "undefined" && prevTooltipButton !== null) {
        prevTooltipButton.className = this._options.buttonClass + ' introjs-prevbutton';
      }
      if (typeof nextTooltipButton !== "undefined" && nextTooltipButton !== null) {
        nextTooltipButton.className = this._options.buttonClass + ' introjs-nextbutton';
      }
      if (typeof skipTooltipButton !== "undefined" && skipTooltipButton !== null) {
=======
      if (
        typeof skipTooltipButton !== "undefined" &&
        skipTooltipButton !== null
      ) {
        skipTooltipButton.className =
          this._options.buttonClass + " introjs-skipbutton";
      }
      if (
        typeof prevTooltipButton !== "undefined" &&
        prevTooltipButton !== null
      ) {
        prevTooltipButton.className =
          this._options.buttonClass + " introjs-prevbutton";
      }
      if (
        typeof nextTooltipButton !== "undefined" &&
        nextTooltipButton !== null
      ) {
        nextTooltipButton.className =
          this._options.buttonClass + " introjs-nextbutton";
      }
      if (
        typeof skipTooltipButton !== "undefined" &&
        skipTooltipButton !== null
      ) {
>>>>>>> main
        skipTooltipButton.innerHTML = this._options.skipLabel;
      }
    }

<<<<<<< HEAD
    prevTooltipButton.setAttribute('role', 'button');
    nextTooltipButton.setAttribute('role', 'button');
    skipTooltipButton.setAttribute('role', 'button');

    //Set focus on "next" button, so that hitting Enter always moves you onto the next step
    if (typeof nextTooltipButton !== "undefined" && nextTooltipButton !== null) {
=======
    prevTooltipButton.setAttribute("role", "button");
    nextTooltipButton.setAttribute("role", "button");
    skipTooltipButton.setAttribute("role", "button");

    //Set focus on "next" button, so that hitting Enter always moves you onto the next step
    if (
      typeof nextTooltipButton !== "undefined" &&
      nextTooltipButton !== null
    ) {
>>>>>>> main
      nextTooltipButton.focus();
    }

    _setShowElement(targetElement);

<<<<<<< HEAD
    if (typeof (this._introAfterChangeCallback) !== 'undefined') {
=======
    if (typeof this._introAfterChangeCallback !== "undefined") {
>>>>>>> main
      this._introAfterChangeCallback.call(this, targetElement.element);
    }
  }

  /**
   * To change the scroll of `window` after highlighting an element
   *
   * @api private
   * @method _scrollTo
   * @param {String} scrollTo
   * @param {Object} targetElement
   * @param {Object} tooltipLayer
   */
  function _scrollTo(scrollTo, targetElement, tooltipLayer) {
<<<<<<< HEAD
    if (scrollTo === 'off') return;
    var rect;

    if (!this._options.scrollToElement) return;

    if (scrollTo === 'tooltip') {
=======
    if (scrollTo === "off") return;
    let rect;

    if (!this._options.scrollToElement) return;

    if (scrollTo === "tooltip") {
>>>>>>> main
      rect = tooltipLayer.getBoundingClientRect();
    } else {
      rect = targetElement.element.getBoundingClientRect();
    }

    if (!_elementInViewport(targetElement.element)) {
<<<<<<< HEAD
      var winHeight = _getWinSize().height;
      var top = rect.bottom - (rect.bottom - rect.top);
=======
      let winHeight = _getWinSize().height;
      let top = rect.bottom - (rect.bottom - rect.top);
>>>>>>> main

      // TODO (afshinm): do we need scroll padding now?
      // I have changed the scroll option and now it scrolls the window to
      // the center of the target element or tooltip.

      if (top < 0 || targetElement.element.clientHeight > winHeight) {
<<<<<<< HEAD
        window.scrollBy(0, rect.top - ((winHeight / 2) -  (rect.height / 2)) - this._options.scrollPadding); // 30px padding from edge to look nice

      //Scroll down
      } else {
        window.scrollBy(0, rect.top - ((winHeight / 2) -  (rect.height / 2)) + this._options.scrollPadding); // 30px padding from edge to look nice
=======
        window.scrollBy(
          0,
          rect.top -
            (winHeight / 2 - rect.height / 2) -
            this._options.scrollPadding
        ); // 30px padding from edge to look nice

        //Scroll down
      } else {
        window.scrollBy(
          0,
          rect.top -
            (winHeight / 2 - rect.height / 2) +
            this._options.scrollPadding
        ); // 30px padding from edge to look nice
>>>>>>> main
      }
    }
  }

  /**
   * To remove all show element(s)
   *
   * @api private
   * @method _removeShowElement
   */
  function _removeShowElement() {
<<<<<<< HEAD
    var elms = document.querySelectorAll('.introjs-showElement');
=======
    let elms = document.querySelectorAll(".introjs-showElement");
>>>>>>> main

    _forEach(elms, function (elm) {
      _removeClass(elm, /introjs-[a-zA-Z]+/g);
    });
  }

  /**
   * To set the show element
   * This function set a relative (in most cases) position and changes the z-index
   *
   * @api private
   * @method _setShowElement
   * @param {Object} targetElement
   */
  function _setShowElement(targetElement) {
<<<<<<< HEAD
    var parentElm;
=======
    let parentElm;
>>>>>>> main
    // we need to add this show element class to the parent of SVG elements
    // because the SVG elements can't have independent z-index
    if (targetElement.element instanceof SVGElement) {
      parentElm = targetElement.element.parentNode;

      while (targetElement.element.parentNode !== null) {
<<<<<<< HEAD
        if (!parentElm.tagName || parentElm.tagName.toLowerCase() === 'body') break;

        if (parentElm.tagName.toLowerCase() === 'svg') {
          _addClass(parentElm, 'introjs-showElement introjs-relativePosition');
=======
        if (!parentElm.tagName || parentElm.tagName.toLowerCase() === "body")
          break;

        if (parentElm.tagName.toLowerCase() === "svg") {
          _addClass(parentElm, "introjs-showElement introjs-relativePosition");
>>>>>>> main
        }

        parentElm = parentElm.parentNode;
      }
    }

<<<<<<< HEAD
    _addClass(targetElement.element, 'introjs-showElement');

    var currentElementPosition = _getPropValue(targetElement.element, 'position');
    if (currentElementPosition !== 'absolute' &&
        currentElementPosition !== 'relative' &&
        currentElementPosition !== 'fixed') {
      //change to new intro item
      _addClass(targetElement.element, 'introjs-relativePosition');
=======
    _addClass(targetElement.element, "introjs-showElement");

    let currentElementPosition = _getPropValue(
      targetElement.element,
      "position"
    );
    if (
      currentElementPosition !== "absolute" &&
      currentElementPosition !== "relative" &&
      currentElementPosition !== "fixed"
    ) {
      //change to new intro item
      _addClass(targetElement.element, "introjs-relativePosition");
>>>>>>> main
    }

    parentElm = targetElement.element.parentNode;
    while (parentElm !== null) {
<<<<<<< HEAD
      if (!parentElm.tagName || parentElm.tagName.toLowerCase() === 'body') break;

      //fix The Stacking Context problem.
      //More detail: https://developer.mozilla.org/en-US/docs/Web/Guide/CSS/Understanding_z_index/The_stacking_context
      var zIndex = _getPropValue(parentElm, 'z-index');
      var opacity = parseFloat(_getPropValue(parentElm, 'opacity'));
      var transform = _getPropValue(parentElm, 'transform') || _getPropValue(parentElm, '-webkit-transform') || _getPropValue(parentElm, '-moz-transform') || _getPropValue(parentElm, '-ms-transform') || _getPropValue(parentElm, '-o-transform');
      if (/[0-9]+/.test(zIndex) || opacity < 1 || (transform !== 'none' && transform !== undefined)) {
        _addClass(parentElm, 'introjs-fixParent');
=======
      if (!parentElm.tagName || parentElm.tagName.toLowerCase() === "body")
        break;

      //fix The Stacking Context problem.
      //More detail: https://developer.mozilla.org/en-US/docs/Web/Guide/CSS/Understanding_z_index/The_stacking_context
      let zIndex = _getPropValue(parentElm, "z-index");
      let opacity = parseFloat(_getPropValue(parentElm, "opacity"));
      let transform =
        _getPropValue(parentElm, "transform") ||
        _getPropValue(parentElm, "-webkit-transform") ||
        _getPropValue(parentElm, "-moz-transform") ||
        _getPropValue(parentElm, "-ms-transform") ||
        _getPropValue(parentElm, "-o-transform");
      if (
        /[0-9]+/.test(zIndex) ||
        opacity < 1 ||
        (transform !== "none" && transform !== undefined)
      ) {
        _addClass(parentElm, "introjs-fixParent");
>>>>>>> main
      }

      parentElm = parentElm.parentNode;
    }
  }

  /**
<<<<<<< HEAD
  * Iterates arrays
  *
  * @param {Array} arr
  * @param {Function} forEachFnc
  * @param {Function} completeFnc
  * @return {Null}
  */
  function _forEach(arr, forEachFnc, completeFnc) {
    // in case arr is an empty query selector node list
    if (arr) {
      for (var i = 0, len = arr.length; i < len; i++) {
=======
   * Iterates arrays
   *
   * @param {Array} arr
   * @param {Function} forEachFnc
   * @param {Function} completeFnc
   * @return {Null}
   */
  function _forEach(arr, forEachFnc, completeFnc) {
    // in case arr is an empty query selector node list
    if (arr) {
      for (let i = 0, len = arr.length; i < len; i++) {
>>>>>>> main
        forEachFnc(arr[i], i);
      }
    }

<<<<<<< HEAD
    if (typeof(completeFnc) === 'function') {
=======
    if (typeof completeFnc === "function") {
>>>>>>> main
      completeFnc();
    }
  }

  /**
<<<<<<< HEAD
  * Mark any object with an incrementing number
  * used for keeping track of objects
  *
  * @param Object obj   Any object or DOM Element
  * @param String key
  * @return Object
  */
  var _stamp = (function () {
    var keys = {};
    return function stamp (obj, key) {

      // get group key
      key = key || 'introjs-stamp';
=======
   * Mark any object with an incrementing number
   * used for keeping track of objects
   *
   * @param Object obj   Any object or DOM Element
   * @param String key
   * @return Object
   */
  let _stamp = (function () {
    let keys = {};
    return function stamp(obj, key) {
      // get group key
      key = key || "introjs-stamp";
>>>>>>> main

      // each group increments from 0
      keys[key] = keys[key] || 0;

      // stamp only once per object
      if (obj[key] === undefined) {
        // increment key for each new object
        obj[key] = keys[key]++;
      }

      return obj[key];
    };
  })();

  /**
<<<<<<< HEAD
  * DOMEvent Handles all DOM events
  *
  * methods:
  *
  * on - add event handler
  * off - remove event
  */
  var DOMEvent = (function () {
    function DOMEvent () {
      var events_key = 'introjs_event';

      /**
      * Gets a unique ID for an event listener
      *
      * @param Object obj
      * @param String type        event type
      * @param Function listener
      * @param Object context
      * @return String
      */
      this._id = function (obj, type, listener, context) {
        return type + _stamp(listener) + (context ? '_' + _stamp(context) : '');
      };

      /**
      * Adds event listener
      *
      * @param Object obj
      * @param String type        event type
      * @param Function listener
      * @param Object context
      * @param Boolean useCapture
      * @return null
      */
      this.on = function (obj, type, listener, context, useCapture) {
        var id = this._id.apply(this, arguments),
            handler = function (e) {
              return listener.call(context || obj, e || window.event);
            };

        if ('addEventListener' in obj) {
          obj.addEventListener(type, handler, useCapture);
        } else if ('attachEvent' in obj) {
          obj.attachEvent('on' + type, handler);
=======
   * DOMEvent Handles all DOM events
   *
   * methods:
   *
   * on - add event handler
   * off - remove event
   */
  let DOMEvent = (function () {
    function DOMEvent() {
      let events_key = "introjs_event";

      /**
       * Gets a unique ID for an event listener
       *
       * @param Object obj
       * @param String type        event type
       * @param Function listener
       * @param Object context
       * @return String
       */
      this._id = function (obj, type, listener, context) {
        return type + _stamp(listener) + (context ? "_" + _stamp(context) : "");
      };

      /**
       * Adds event listener
       *
       * @param Object obj
       * @param String type        event type
       * @param Function listener
       * @param Object context
       * @param Boolean useCapture
       * @return null
       */
      this.on = function (obj, type, listener, context, useCapture) {
        let id = this._id.apply(this, arguments),
          handler = function (e) {
            return listener.call(context || obj, e || window.event);
          };

        if ("addEventListener" in obj) {
          obj.addEventListener(type, handler, useCapture);
        } else if ("attachEvent" in obj) {
          obj.attachEvent("on" + type, handler);
>>>>>>> main
        }

        obj[events_key] = obj[events_key] || {};
        obj[events_key][id] = handler;
      };

      /**
<<<<<<< HEAD
      * Removes event listener
      *
      * @param Object obj
      * @param String type        event type
      * @param Function listener
      * @param Object context
      * @param Boolean useCapture
      * @return null
      */
      this.off = function (obj, type, listener, context, useCapture) {
        var id = this._id.apply(this, arguments),
            handler = obj[events_key] && obj[events_key][id];
=======
       * Removes event listener
       *
       * @param Object obj
       * @param String type        event type
       * @param Function listener
       * @param Object context
       * @param Boolean useCapture
       * @return null
       */
      this.off = function (obj, type, listener, context, useCapture) {
        let id = this._id.apply(this, arguments),
          handler = obj[events_key] && obj[events_key][id];
>>>>>>> main

        if (!handler) {
          return;
        }

<<<<<<< HEAD
        if ('removeEventListener' in obj) {
          obj.removeEventListener(type, handler, useCapture);
        } else if ('detachEvent' in obj) {
          obj.detachEvent('on' + type, handler);
=======
        if ("removeEventListener" in obj) {
          obj.removeEventListener(type, handler, useCapture);
        } else if ("detachEvent" in obj) {
          obj.detachEvent("on" + type, handler);
>>>>>>> main
        }

        obj[events_key][id] = null;
      };
    }

    return new DOMEvent();
  })();

  /**
   * Append a class to an element
   *
   * @api private
   * @method _addClass
   * @param {Object} element
   * @param {String} className
   * @returns null
   */
  function _addClass(element, className) {
    if (element instanceof SVGElement) {
      // svg
<<<<<<< HEAD
      var pre = element.getAttribute('class') || '';

      element.setAttribute('class', pre + ' ' + className);
    } else {
      if (element.classList !== undefined) {
        // check for modern classList property
        var classes = className.split(' ');
        _forEach(classes, function (cls) {
          element.classList.add( cls );
        });
      } else if (!element.className.match( className )) {
        // check if element doesn't already have className
        element.className += ' ' + className;
=======
      let pre = element.getAttribute("class") || "";

      element.setAttribute("class", pre + " " + className);
    } else {
      if (element.classList !== undefined) {
        // check for modern classList property
        let classes = className.split(" ");
        _forEach(classes, function (cls) {
          element.classList.add(cls);
        });
      } else if (!element.className.match(className)) {
        // check if element doesn't already have className
        element.className += " " + className;
>>>>>>> main
      }
    }
  }

  /**
   * Remove a class from an element
   *
   * @api private
   * @method _removeClass
   * @param {Object} element
   * @param {RegExp|String} classNameRegex can be regex or string
   * @returns null
   */
  function _removeClass(element, classNameRegex) {
    if (element instanceof SVGElement) {
<<<<<<< HEAD
      var pre = element.getAttribute('class') || '';

      element.setAttribute('class', pre.replace(classNameRegex, '').replace(/^\s+|\s+$/g, ''));
    } else {
      element.className = element.className.replace(classNameRegex, '').replace(/^\s+|\s+$/g, '');
=======
      let pre = element.getAttribute("class") || "";

      element.setAttribute(
        "class",
        pre.replace(classNameRegex, "").replace(/^\s+|\s+$/g, "")
      );
    } else {
      element.className = element.className
        .replace(classNameRegex, "")
        .replace(/^\s+|\s+$/g, "");
>>>>>>> main
    }
  }

  /**
   * Get an element CSS property on the page
   * Thanks to JavaScript Kit: http://www.javascriptkit.com/dhtmltutors/dhtmlcascade4.shtml
   *
   * @api private
   * @method _getPropValue
   * @param {Object} element
   * @param {String} propName
   * @returns Element's property value
   */
<<<<<<< HEAD
  function _getPropValue (element, propName) {
    var propValue = '';
    if (element.currentStyle) { //IE
      propValue = element.currentStyle[propName];
    } else if (document.defaultView && document.defaultView.getComputedStyle) { //Others
      propValue = document.defaultView.getComputedStyle(element, null).getPropertyValue(propName);
=======
  function _getPropValue(element, propName) {
    let propValue = "";
    if (element.currentStyle) {
      //IE
      propValue = element.currentStyle[propName];
    } else if (document.defaultView && document.defaultView.getComputedStyle) {
      //Others
      propValue = document.defaultView
        .getComputedStyle(element, null)
        .getPropertyValue(propName);
>>>>>>> main
    }

    //Prevent exception in IE
    if (propValue && propValue.toLowerCase) {
      return propValue.toLowerCase();
    } else {
      return propValue;
    }
  }

  /**
   * Checks to see if target element (or parents) position is fixed or not
   *
   * @api private
   * @method _isFixed
   * @param {Object} element
   * @returns Boolean
   */
<<<<<<< HEAD
  function _isFixed (element) {
    var p = element.parentNode;

    if (!p || p.nodeName === 'HTML') {
      return false;
    }

    if (_getPropValue(element, 'position') === 'fixed') {
=======
  function _isFixed(element) {
    let p = element.parentNode;

    if (!p || p.nodeName === "HTML") {
      return false;
    }

    if (_getPropValue(element, "position") === "fixed") {
>>>>>>> main
      return true;
    }

    return _isFixed(p);
  }

  /**
   * Provides a cross-browser way to get the screen dimensions
   * via: http://stackoverflow.com/questions/5864467/internet-explorer-innerheight
   *
   * @api private
   * @method _getWinSize
   * @returns {Object} width and height attributes
   */
  function _getWinSize() {
    if (window.innerWidth !== undefined) {
      return { width: window.innerWidth, height: window.innerHeight };
    } else {
<<<<<<< HEAD
      var D = document.documentElement;
=======
      let D = document.documentElement;
>>>>>>> main
      return { width: D.clientWidth, height: D.clientHeight };
    }
  }

  /**
   * Check to see if the element is in the viewport or not
   * http://stackoverflow.com/questions/123999/how-to-tell-if-a-dom-element-is-visible-in-the-current-viewport
   *
   * @api private
   * @method _elementInViewport
   * @param {Object} el
   */
  function _elementInViewport(el) {
<<<<<<< HEAD
    var rect = el.getBoundingClientRect();
=======
    let rect = el.getBoundingClientRect();
>>>>>>> main

    return (
      rect.top >= 0 &&
      rect.left >= 0 &&
<<<<<<< HEAD
      (rect.bottom+80) <= window.innerHeight && // add 80 to get the text right
=======
      rect.bottom + 80 <= window.innerHeight && // add 80 to get the text right
>>>>>>> main
      rect.right <= window.innerWidth
    );
  }

  /**
   * Add overlay layer to the page
   *
   * @api private
   * @method _addOverlayLayer
   * @param {Object} targetElm
   */
  function _addOverlayLayer(targetElm) {
<<<<<<< HEAD
    var overlayLayer = document.createElement('div'),
        styleText = '',
        self = this;

    //set css class name
    overlayLayer.className = 'introjs-overlay';

    //check if the target element is body, we should calculate the size of overlay layer in a better way
    if (!targetElm.tagName || targetElm.tagName.toLowerCase() === 'body') {
      styleText += 'top: 0;bottom: 0; left: 0;right: 0;position: fixed;';
      overlayLayer.style.cssText = styleText;
    } else {
      //set overlay layer position
      var elementPosition = _getOffset(targetElm);
      if (elementPosition) {
        styleText += 'width: ' + elementPosition.width + 'px; height:' + elementPosition.height + 'px; top:' + elementPosition.top + 'px;left: ' + elementPosition.left + 'px;';
=======
    let overlayLayer = document.createElement("div"),
      styleText = "",
      self = this;

    //set css class name
    overlayLayer.className = "introjs-overlay";

    //check if the target element is body, we should calculate the size of overlay layer in a better way
    if (!targetElm.tagName || targetElm.tagName.toLowerCase() === "body") {
      styleText += "top: 0;bottom: 0; left: 0;right: 0;position: fixed;";
      overlayLayer.style.cssText = styleText;
    } else {
      //set overlay layer position
      let elementPosition = _getOffset(targetElm);
      if (elementPosition) {
        styleText +=
          "width: " +
          elementPosition.width +
          "px; height:" +
          elementPosition.height +
          "px; top:" +
          elementPosition.top +
          "px;left: " +
          elementPosition.left +
          "px;";
>>>>>>> main
        overlayLayer.style.cssText = styleText;
      }
    }

    targetElm.appendChild(overlayLayer);

<<<<<<< HEAD
    overlayLayer.onclick = function() {
=======
    overlayLayer.onclick = function () {
>>>>>>> main
      if (self._options.exitOnOverlayClick === true) {
        _exitIntro.call(self, targetElm);
      }
    };

<<<<<<< HEAD
    window.setTimeout(function() {
      styleText += 'opacity: ' + self._options.overlayOpacity.toString() + ';';
=======
    window.setTimeout(function () {
      styleText += "opacity: " + self._options.overlayOpacity.toString() + ";";
>>>>>>> main
      overlayLayer.style.cssText = styleText;
    }, 10);

    return true;
  }

  /**
   * Removes open hint (tooltip hint)
   *
   * @api private
   * @method _removeHintTooltip
   */
  function _removeHintTooltip() {
<<<<<<< HEAD
    var tooltip = document.querySelector('.introjs-hintReference');

    if (tooltip) {
      var step = tooltip.getAttribute('data-step');
=======
    let tooltip = document.querySelector(".introjs-hintReference");

    if (tooltip) {
      let step = tooltip.getAttribute("data-step");
>>>>>>> main
      tooltip.parentNode.removeChild(tooltip);
      return step;
    }
  }

  /**
   * Start parsing hint items
   *
   * @api private
   * @param {Object} targetElm
   * @method _startHint
   */
  function _populateHints(targetElm) {
<<<<<<< HEAD

    this._introItems = [];

    if (this._options.hints) {
      _forEach(this._options.hints, function (hint) {
        var currentItem = _cloneObject(hint);

        if (typeof(currentItem.element) === 'string') {
          //grab the element with given selector from the page
          currentItem.element = document.querySelector(currentItem.element);
        }

        currentItem.hintPosition = currentItem.hintPosition || this._options.hintPosition;
        currentItem.hintAnimation = currentItem.hintAnimation || this._options.hintAnimation;

        if (currentItem.element !== null) {
          this._introItems.push(currentItem);
        }
      }.bind(this));
    } else {
      var hints = targetElm.querySelectorAll('*[data-hint]');
=======
    this._introItems = [];

    if (this._options.hints) {
      _forEach(
        this._options.hints,
        function (hint) {
          let currentItem = _cloneObject(hint);

          if (typeof currentItem.element === "string") {
            //grab the element with given selector from the page
            currentItem.element = document.querySelector(currentItem.element);
          }

          currentItem.hintPosition =
            currentItem.hintPosition || this._options.hintPosition;
          currentItem.hintAnimation =
            currentItem.hintAnimation || this._options.hintAnimation;

          if (currentItem.element !== null) {
            this._introItems.push(currentItem);
          }
        }.bind(this)
      );
    } else {
      let hints = targetElm.querySelectorAll("*[data-hint]");
>>>>>>> main

      if (!hints || !hints.length) {
        return false;
      }

      //first add intro items with data-step
<<<<<<< HEAD
      _forEach(hints, function (currentElement) {
        // hint animation
        var hintAnimation = currentElement.getAttribute('data-hintanimation');

        if (hintAnimation) {
          hintAnimation = (hintAnimation === 'true');
        } else {
          hintAnimation = this._options.hintAnimation;
        }

        this._introItems.push({
          element: currentElement,
          hint: currentElement.getAttribute('data-hint'),
          hintPosition: currentElement.getAttribute('data-hintposition') || this._options.hintPosition,
          hintAnimation: hintAnimation,
          tooltipClass: currentElement.getAttribute('data-tooltipclass'),
          position: currentElement.getAttribute('data-position') || this._options.tooltipPosition
        });
      }.bind(this));
=======
      _forEach(
        hints,
        function (currentElement) {
          // hint animation
          let hintAnimation = currentElement.getAttribute("data-hintanimation");

          if (hintAnimation) {
            hintAnimation = hintAnimation === "true";
          } else {
            hintAnimation = this._options.hintAnimation;
          }

          this._introItems.push({
            element: currentElement,
            hint: currentElement.getAttribute("data-hint"),
            hintPosition:
              currentElement.getAttribute("data-hintposition") ||
              this._options.hintPosition,
            hintAnimation: hintAnimation,
            tooltipClass: currentElement.getAttribute("data-tooltipclass"),
            position:
              currentElement.getAttribute("data-position") ||
              this._options.tooltipPosition,
          });
        }.bind(this)
      );
>>>>>>> main
    }

    _addHints.call(this);

    /*
    todo:
    these events should be removed at some point
    */
<<<<<<< HEAD
    DOMEvent.on(document, 'click', _removeHintTooltip, this, false);
    DOMEvent.on(window, 'resize', _reAlignHints, this, true);
=======
    DOMEvent.on(document, "click", _removeHintTooltip, this, false);
    DOMEvent.on(window, "resize", _reAlignHints, this, true);
>>>>>>> main
  }

  /**
   * Re-aligns all hint elements
   *
   * @api private
   * @method _reAlignHints
   */
  function _reAlignHints() {
<<<<<<< HEAD
    _forEach(this._introItems, function (item) {
      if (typeof(item.targetElement) === 'undefined') {
        return;
      }

      _alignHintPosition.call(this, item.hintPosition, item.element, item.targetElement);
    }.bind(this));
  }

  /**
  * Get a queryselector within the hint wrapper
  *
  * @param {String} selector
  * @return {NodeList|Array}
  */
  function _hintQuerySelectorAll(selector) {
    var hintsWrapper = document.querySelector('.introjs-hints');
    return (hintsWrapper) ? hintsWrapper.querySelectorAll(selector) : [];
=======
    _forEach(
      this._introItems,
      function (item) {
        if (typeof item.targetElement === "undefined") {
          return;
        }

        _alignHintPosition.call(
          this,
          item.hintPosition,
          item.element,
          item.targetElement
        );
      }.bind(this)
    );
  }

  /**
   * Get a queryselector within the hint wrapper
   *
   * @param {String} selector
   * @return {NodeList|Array}
   */
  function _hintQuerySelectorAll(selector) {
    let hintsWrapper = document.querySelector(".introjs-hints");
    return hintsWrapper ? hintsWrapper.querySelectorAll(selector) : [];
>>>>>>> main
  }

  /**
   * Hide a hint
   *
   * @api private
   * @method _hideHint
   */
  function _hideHint(stepId) {
<<<<<<< HEAD
    var hint = _hintQuerySelectorAll('.introjs-hint[data-step="' + stepId + '"]')[0];
=======
    let hint = _hintQuerySelectorAll(
      '.introjs-hint[data-step="' + stepId + '"]'
    )[0];
>>>>>>> main

    _removeHintTooltip.call(this);

    if (hint) {
<<<<<<< HEAD
      _addClass(hint, 'introjs-hidehint');
    }

    // call the callback function (if any)
    if (typeof (this._hintCloseCallback) !== 'undefined') {
=======
      _addClass(hint, "introjs-hidehint");
    }

    // call the callback function (if any)
    if (typeof this._hintCloseCallback !== "undefined") {
>>>>>>> main
      this._hintCloseCallback.call(this, stepId);
    }
  }

  /**
   * Hide all hints
   *
   * @api private
   * @method _hideHints
   */
  function _hideHints() {
<<<<<<< HEAD
    var hints = _hintQuerySelectorAll('.introjs-hint');

    _forEach(hints, function (hint) {
      _hideHint.call(this, hint.getAttribute('data-step'));
    }.bind(this));
=======
    let hints = _hintQuerySelectorAll(".introjs-hint");

    _forEach(
      hints,
      function (hint) {
        _hideHint.call(this, hint.getAttribute("data-step"));
      }.bind(this)
    );
>>>>>>> main
  }

  /**
   * Show all hints
   *
   * @api private
   * @method _showHints
   */
  function _showHints() {
<<<<<<< HEAD
    var hints = _hintQuerySelectorAll('.introjs-hint');

    if (hints && hints.length) {
      _forEach(hints, function (hint) {
        _showHint.call(this, hint.getAttribute('data-step'));
      }.bind(this));
=======
    let hints = _hintQuerySelectorAll(".introjs-hint");

    if (hints && hints.length) {
      _forEach(
        hints,
        function (hint) {
          _showHint.call(this, hint.getAttribute("data-step"));
        }.bind(this)
      );
>>>>>>> main
    } else {
      _populateHints.call(this, this._targetElement);
    }
  }

  /**
   * Show a hint
   *
   * @api private
   * @method _showHint
   */
  function _showHint(stepId) {
<<<<<<< HEAD
    var hint = _hintQuerySelectorAll('.introjs-hint[data-step="' + stepId + '"]')[0];
=======
    let hint = _hintQuerySelectorAll(
      '.introjs-hint[data-step="' + stepId + '"]'
    )[0];
>>>>>>> main

    if (hint) {
      _removeClass(hint, /introjs-hidehint/g);
    }
  }

  /**
   * Removes all hint elements on the page
   * Useful when you want to destroy the elements and add them again (e.g. a modal or popup)
   *
   * @api private
   * @method _removeHints
   */
  function _removeHints() {
<<<<<<< HEAD
    var hints = _hintQuerySelectorAll('.introjs-hint');

    _forEach(hints, function (hint) {
      _removeHint.call(this, hint.getAttribute('data-step'));
    }.bind(this));
=======
    let hints = _hintQuerySelectorAll(".introjs-hint");

    _forEach(
      hints,
      function (hint) {
        _removeHint.call(this, hint.getAttribute("data-step"));
      }.bind(this)
    );
>>>>>>> main
  }

  /**
   * Remove one single hint element from the page
   * Useful when you want to destroy the element and add them again (e.g. a modal or popup)
   * Use removeHints if you want to remove all elements.
   *
   * @api private
   * @method _removeHint
   */
  function _removeHint(stepId) {
<<<<<<< HEAD
    var hint = _hintQuerySelectorAll('.introjs-hint[data-step="' + stepId + '"]')[0];
=======
    let hint = _hintQuerySelectorAll(
      '.introjs-hint[data-step="' + stepId + '"]'
    )[0];
>>>>>>> main

    if (hint) {
      hint.parentNode.removeChild(hint);
    }
  }

  /**
   * Add all available hints to the page
   *
   * @api private
   * @method _addHints
   */
  function _addHints() {
<<<<<<< HEAD
    var self = this;

    var hintsWrapper = document.querySelector('.introjs-hints');

    if (hintsWrapper === null) {
      hintsWrapper = document.createElement('div');
      hintsWrapper.className = 'introjs-hints';
    }

    /**
    * Returns an event handler unique to the hint iteration
    *
    * @param {Integer} i
    * @return {Function}
    */
    var getHintClick = function (i) {
      return function(e) {
        var evt = e ? e : window.event;
=======
    let self = this;

    let hintsWrapper = document.querySelector(".introjs-hints");

    if (hintsWrapper === null) {
      hintsWrapper = document.createElement("div");
      hintsWrapper.className = "introjs-hints";
    }

    /**
     * Returns an event handler unique to the hint iteration
     *
     * @param {Integer} i
     * @return {Function}
     */
    let getHintClick = function (i) {
      return function (e) {
        let evt = e ? e : window.event;
>>>>>>> main

        if (evt.stopPropagation) {
          evt.stopPropagation();
        }

        if (evt.cancelBubble !== null) {
          evt.cancelBubble = true;
        }

        _showHintDialog.call(self, i);
      };
    };

<<<<<<< HEAD
    _forEach(this._introItems, function(item, i) {
      // avoid append a hint twice
      if (document.querySelector('.introjs-hint[data-step="' + i + '"]')) {
        return;
      }

      var hint = document.createElement('a');
      _setAnchorAsButton(hint);

      hint.onclick = getHintClick(i);

      hint.className = 'introjs-hint';

      if (!item.hintAnimation) {
        _addClass(hint, 'introjs-hint-no-anim');
      }

      // hint's position should be fixed if the target element's position is fixed
      if (_isFixed(item.element)) {
        _addClass(hint, 'introjs-fixedhint');
      }

      var hintDot = document.createElement('div');
      hintDot.className = 'introjs-hint-dot';
      var hintPulse = document.createElement('div');
      hintPulse.className = 'introjs-hint-pulse';

      hint.appendChild(hintDot);
      hint.appendChild(hintPulse);
      hint.setAttribute('data-step', i);

      // we swap the hint element with target element
      // because _setHelperLayerPosition uses `element` property
      item.targetElement = item.element;
      item.element = hint;

      // align the hint position
      _alignHintPosition.call(this, item.hintPosition, hint, item.targetElement);

      hintsWrapper.appendChild(hint);
    }.bind(this));
=======
    _forEach(
      this._introItems,
      function (item, i) {
        // avoid append a hint twice
        if (document.querySelector('.introjs-hint[data-step="' + i + '"]')) {
          return;
        }

        let hint = document.createElement("a");
        _setAnchorAsButton(hint);

        hint.onclick = getHintClick(i);

        hint.className = "introjs-hint";

        if (!item.hintAnimation) {
          _addClass(hint, "introjs-hint-no-anim");
        }

        // hint's position should be fixed if the target element's position is fixed
        if (_isFixed(item.element)) {
          _addClass(hint, "introjs-fixedhint");
        }

        let hintDot = document.createElement("div");
        hintDot.className = "introjs-hint-dot";
        let hintPulse = document.createElement("div");
        hintPulse.className = "introjs-hint-pulse";

        hint.appendChild(hintDot);
        hint.appendChild(hintPulse);
        hint.setAttribute("data-step", i);

        // we swap the hint element with target element
        // because _setHelperLayerPosition uses `element` property
        item.targetElement = item.element;
        item.element = hint;

        // align the hint position
        _alignHintPosition.call(
          this,
          item.hintPosition,
          hint,
          item.targetElement
        );

        hintsWrapper.appendChild(hint);
      }.bind(this)
    );
>>>>>>> main

    // adding the hints wrapper
    document.body.appendChild(hintsWrapper);

    // call the callback function (if any)
<<<<<<< HEAD
    if (typeof (this._hintsAddedCallback) !== 'undefined') {
=======
    if (typeof this._hintsAddedCallback !== "undefined") {
>>>>>>> main
      this._hintsAddedCallback.call(this);
    }
  }

  /**
   * Aligns hint position
   *
   * @api private
   * @method _alignHintPosition
   * @param {String} position
   * @param {Object} hint
   * @param {Object} element
   */
  function _alignHintPosition(position, hint, element) {
    // get/calculate offset of target element
<<<<<<< HEAD
    var offset = _getOffset.call(this, element);
    var iconWidth = 20;
    var iconHeight = 20;
=======
    let offset = _getOffset.call(this, element);
    let iconWidth = 20;
    let iconHeight = 20;
>>>>>>> main

    // align the hint element
    switch (position) {
      default:
<<<<<<< HEAD
      case 'top-left':
        hint.style.left = offset.left + 'px';
        hint.style.top = offset.top + 'px';
        break;
      case 'top-right':
        hint.style.left = (offset.left + offset.width - iconWidth) + 'px';
        hint.style.top = offset.top + 'px';
        break;
      case 'bottom-left':
        hint.style.left = offset.left + 'px';
        hint.style.top = (offset.top + offset.height - iconHeight) + 'px';
        break;
      case 'bottom-right':
        hint.style.left = (offset.left + offset.width - iconWidth) + 'px';
        hint.style.top = (offset.top + offset.height - iconHeight) + 'px';
        break;
      case 'middle-left':
        hint.style.left = offset.left + 'px';
        hint.style.top = (offset.top + (offset.height - iconHeight) / 2) + 'px';
        break;
      case 'middle-right':
        hint.style.left = (offset.left + offset.width - iconWidth) + 'px';
        hint.style.top = (offset.top + (offset.height - iconHeight) / 2) + 'px';
        break;
      case 'middle-middle':
        hint.style.left = (offset.left + (offset.width - iconWidth) / 2) + 'px';
        hint.style.top = (offset.top + (offset.height - iconHeight) / 2) + 'px';
        break;
      case 'bottom-middle':
        hint.style.left = (offset.left + (offset.width - iconWidth) / 2) + 'px';
        hint.style.top = (offset.top + offset.height - iconHeight) + 'px';
        break;
      case 'top-middle':
        hint.style.left = (offset.left + (offset.width - iconWidth) / 2) + 'px';
        hint.style.top = offset.top + 'px';
=======
      case "top-left":
        hint.style.left = offset.left + "px";
        hint.style.top = offset.top + "px";
        break;
      case "top-right":
        hint.style.left = offset.left + offset.width - iconWidth + "px";
        hint.style.top = offset.top + "px";
        break;
      case "bottom-left":
        hint.style.left = offset.left + "px";
        hint.style.top = offset.top + offset.height - iconHeight + "px";
        break;
      case "bottom-right":
        hint.style.left = offset.left + offset.width - iconWidth + "px";
        hint.style.top = offset.top + offset.height - iconHeight + "px";
        break;
      case "middle-left":
        hint.style.left = offset.left + "px";
        hint.style.top = offset.top + (offset.height - iconHeight) / 2 + "px";
        break;
      case "middle-right":
        hint.style.left = offset.left + offset.width - iconWidth + "px";
        hint.style.top = offset.top + (offset.height - iconHeight) / 2 + "px";
        break;
      case "middle-middle":
        hint.style.left = offset.left + (offset.width - iconWidth) / 2 + "px";
        hint.style.top = offset.top + (offset.height - iconHeight) / 2 + "px";
        break;
      case "bottom-middle":
        hint.style.left = offset.left + (offset.width - iconWidth) / 2 + "px";
        hint.style.top = offset.top + offset.height - iconHeight + "px";
        break;
      case "top-middle":
        hint.style.left = offset.left + (offset.width - iconWidth) / 2 + "px";
        hint.style.top = offset.top + "px";
>>>>>>> main
        break;
    }
  }

  /**
   * Triggers when user clicks on the hint element
   *
   * @api private
   * @method _showHintDialog
   * @param {Number} stepId
   */
  function _showHintDialog(stepId) {
<<<<<<< HEAD
    var hintElement = document.querySelector('.introjs-hint[data-step="' + stepId + '"]');
    var item = this._introItems[stepId];

    // call the callback function (if any)
    if (typeof (this._hintClickCallback) !== 'undefined') {
=======
    let hintElement = document.querySelector(
      '.introjs-hint[data-step="' + stepId + '"]'
    );
    let item = this._introItems[stepId];

    // call the callback function (if any)
    if (typeof this._hintClickCallback !== "undefined") {
>>>>>>> main
      this._hintClickCallback.call(this, hintElement, item, stepId);
    }

    // remove all open tooltips
<<<<<<< HEAD
    var removedStep = _removeHintTooltip.call(this);
=======
    let removedStep = _removeHintTooltip.call(this);
>>>>>>> main

    // to toggle the tooltip
    if (parseInt(removedStep, 10) === stepId) {
      return;
    }

<<<<<<< HEAD
    var tooltipLayer = document.createElement('div');
    var tooltipTextLayer = document.createElement('div');
    var arrowLayer = document.createElement('div');
    var referenceLayer = document.createElement('div');

    tooltipLayer.className = 'introjs-tooltip';
=======
    let tooltipLayer = document.createElement("div");
    let tooltipTextLayer = document.createElement("div");
    let arrowLayer = document.createElement("div");
    let referenceLayer = document.createElement("div");

    tooltipLayer.className = "introjs-tooltip";
>>>>>>> main

    tooltipLayer.onclick = function (e) {
      //IE9 & Other Browsers
      if (e.stopPropagation) {
        e.stopPropagation();
      }
      //IE8 and Lower
      else {
        e.cancelBubble = true;
      }
    };

<<<<<<< HEAD
    tooltipTextLayer.className = 'introjs-tooltiptext';

    var tooltipWrapper = document.createElement('p');
    tooltipWrapper.innerHTML = item.hint;

    var closeButton = document.createElement('a');
    closeButton.className = this._options.buttonClass;
    closeButton.setAttribute('role', 'button');
=======
    tooltipTextLayer.className = "introjs-tooltiptext";

    let tooltipWrapper = document.createElement("p");
    tooltipWrapper.innerHTML = item.hint;

    let closeButton = document.createElement("a");
    closeButton.className = this._options.buttonClass;
    closeButton.setAttribute("role", "button");
>>>>>>> main
    closeButton.innerHTML = this._options.hintButtonLabel;
    closeButton.onclick = _hideHint.bind(this, stepId);

    tooltipTextLayer.appendChild(tooltipWrapper);
    tooltipTextLayer.appendChild(closeButton);

<<<<<<< HEAD
    arrowLayer.className = 'introjs-arrow';
=======
    arrowLayer.className = "introjs-arrow";
>>>>>>> main
    tooltipLayer.appendChild(arrowLayer);

    tooltipLayer.appendChild(tooltipTextLayer);

    // set current step for _placeTooltip function
<<<<<<< HEAD
    this._currentStep = hintElement.getAttribute('data-step');

    // align reference layer position
    referenceLayer.className = 'introjs-tooltipReferenceLayer introjs-hintReference';
    referenceLayer.setAttribute('data-step', hintElement.getAttribute('data-step'));
=======
    this._currentStep = hintElement.getAttribute("data-step");

    // align reference layer position
    referenceLayer.className =
      "introjs-tooltipReferenceLayer introjs-hintReference";
    referenceLayer.setAttribute(
      "data-step",
      hintElement.getAttribute("data-step")
    );
>>>>>>> main
    _setHelperLayerPosition.call(this, referenceLayer);

    referenceLayer.appendChild(tooltipLayer);
    document.body.appendChild(referenceLayer);

    //set proper position
    _placeTooltip.call(this, hintElement, tooltipLayer, arrowLayer, null, true);
  }

  /**
   * Get an element position on the page
   * Thanks to `meouw`: http://stackoverflow.com/a/442474/375966
   *
   * @api private
   * @method _getOffset
   * @param {Object} element
   * @returns Element's position info
   */
  function _getOffset(element) {
<<<<<<< HEAD
    var body = document.body;
    var docEl = document.documentElement;
    var scrollTop = window.pageYOffset || docEl.scrollTop || body.scrollTop;
    var scrollLeft = window.pageXOffset || docEl.scrollLeft || body.scrollLeft;
    var x = element.getBoundingClientRect();
=======
    let body = document.body;
    let docEl = document.documentElement;
    let scrollTop = window.pageYOffset || docEl.scrollTop || body.scrollTop;
    let scrollLeft = window.pageXOffset || docEl.scrollLeft || body.scrollLeft;
    let x = element.getBoundingClientRect();
>>>>>>> main
    return {
      top: x.top + scrollTop,
      width: x.width,
      height: x.height,
<<<<<<< HEAD
      left: x.left + scrollLeft
=======
      left: x.left + scrollLeft,
>>>>>>> main
    };
  }

  /**
<<<<<<< HEAD
  * Find the nearest scrollable parent
  * copied from https://stackoverflow.com/questions/35939886/find-first-scrollable-parent
  *
  * @param Element element
  * @return Element
  */
  function _getScrollParent(element) {
    var style = window.getComputedStyle(element);
    var excludeStaticParent = (style.position === "absolute");
    var overflowRegex = /(auto|scroll)/;

    if (style.position === "fixed") return document.body;

    for (var parent = element; (parent = parent.parentElement);) {
=======
   * Find the nearest scrollable parent
   * copied from https://stackoverflow.com/questions/35939886/find-first-scrollable-parent
   *
   * @param Element element
   * @return Element
   */
  function _getScrollParent(element) {
    let style = window.getComputedStyle(element);
    let excludeStaticParent = style.position === "absolute";
    let overflowRegex = /(auto|scroll)/;

    if (style.position === "fixed") return document.body;

    for (let parent = element; (parent = parent.parentElement); ) {
>>>>>>> main
      style = window.getComputedStyle(parent);
      if (excludeStaticParent && style.position === "static") {
        continue;
      }
<<<<<<< HEAD
      if (overflowRegex.test(style.overflow + style.overflowY + style.overflowX)) return parent;
=======
      if (
        overflowRegex.test(style.overflow + style.overflowY + style.overflowX)
      )
        return parent;
>>>>>>> main
    }

    return document.body;
  }

  /**
<<<<<<< HEAD
  * scroll a scrollable element to a child element
  *
  * @param Element parent
  * @param Element element
  * @return Null
  */
  function _scrollParentToElement (parent, element) {
=======
   * scroll a scrollable element to a child element
   *
   * @param Element parent
   * @param Element element
   * @return Null
   */
  function _scrollParentToElement(parent, element) {
>>>>>>> main
    parent.scrollTop = element.offsetTop - parent.offsetTop;
  }

  /**
   * Gets the current progress percentage
   *
   * @api private
   * @method _getProgress
   * @returns current progress percentage
   */
  function _getProgress() {
    // Steps are 0 indexed
<<<<<<< HEAD
    var currentStep = parseInt((this._currentStep + 1), 10);
    return ((currentStep / this._introItems.length) * 100);
=======
    let currentStep = parseInt(this._currentStep + 1, 10);
    return (currentStep / this._introItems.length) * 100;
>>>>>>> main
  }

  /**
   * Overwrites obj1's values with obj2's and adds obj2's if non existent in obj1
   * via: http://stackoverflow.com/questions/171251/how-can-i-merge-properties-of-two-javascript-objects-dynamically
   *
   * @param obj1
   * @param obj2
   * @returns obj3 a new object based on obj1 and obj2
   */
<<<<<<< HEAD
  function _mergeOptions(obj1,obj2) {
    var obj3 = {},
      attrname;
    for (attrname in obj1) { obj3[attrname] = obj1[attrname]; }
    for (attrname in obj2) { obj3[attrname] = obj2[attrname]; }
    return obj3;
  }

  var introJs = function (targetElm) {
    var instance;

    if (typeof (targetElm) === 'object') {
      //Ok, create a new instance
      instance = new IntroJs(targetElm);

    } else if (typeof (targetElm) === 'string') {
      //select the target element with query selector
      var targetElement = document.querySelector(targetElm);
=======
  function _mergeOptions(obj1, obj2) {
    let obj3 = {},
      attrname;
    for (attrname in obj1) {
      obj3[attrname] = obj1[attrname];
    }
    for (attrname in obj2) {
      obj3[attrname] = obj2[attrname];
    }
    return obj3;
  }

  let introJs = function (targetElm) {
    let instance;

    if (typeof targetElm === "object") {
      //Ok, create a new instance
      instance = new IntroJs(targetElm);
    } else if (typeof targetElm === "string") {
      //select the target element with query selector
      let targetElement = document.querySelector(targetElm);
>>>>>>> main

      if (targetElement) {
        instance = new IntroJs(targetElement);
      } else {
<<<<<<< HEAD
        throw new Error('There is no element with given selector.');
=======
        throw new Error("There is no element with given selector.");
>>>>>>> main
      }
    } else {
      instance = new IntroJs(document.body);
    }
    // add instance to list of _instances
    // passing group to _stamp to increment
    // from 0 onward somewhat reliably
<<<<<<< HEAD
    introJs.instances[ _stamp(instance, 'introjs-instance') ] = instance;
=======
    introJs.instances[_stamp(instance, "introjs-instance")] = instance;
>>>>>>> main

    return instance;
  };

  /**
   * Current IntroJs version
   *
   * @property version
   * @type String
   */
  introJs.version = VERSION;

  /**
<<<<<<< HEAD
  * key-val object helper for introJs instances
  *
  * @property instances
  * @type Object
  */
=======
   * key-val object helper for introJs instances
   *
   * @property instances
   * @type Object
   */
>>>>>>> main
  introJs.instances = {};

  //Prototype
  introJs.fn = IntroJs.prototype = {
    clone: function () {
      return new IntroJs(this);
    },
<<<<<<< HEAD
    setOption: function(option, value) {
      this._options[option] = value;
      return this;
    },
    setOptions: function(options) {
=======
    setOption: function (option, value) {
      this._options[option] = value;
      return this;
    },
    setOptions: function (options) {
>>>>>>> main
      this._options = _mergeOptions(this._options, options);
      return this;
    },
    start: function (group) {
      _introForElement.call(this, this._targetElement, group);
      return this;
    },
<<<<<<< HEAD
    goToStep: function(step) {
      _goToStep.call(this, step);
      return this;
    },
    addStep: function(options) {
=======
    goToStep: function (step) {
      _goToStep.call(this, step);
      return this;
    },
    addStep: function (options) {
>>>>>>> main
      if (!this._options.steps) {
        this._options.steps = [];
      }

      this._options.steps.push(options);

      return this;
    },
<<<<<<< HEAD
    addSteps: function(steps) {
      if (!steps.length) return;

      for(var index = 0; index < steps.length; index++) {
=======
    addSteps: function (steps) {
      if (!steps.length) return;

      for (let index = 0; index < steps.length; index++) {
>>>>>>> main
        this.addStep(steps[index]);
      }

      return this;
    },
<<<<<<< HEAD
    goToStepNumber: function(step) {
=======
    goToStepNumber: function (step) {
>>>>>>> main
      _goToStepNumber.call(this, step);

      return this;
    },
<<<<<<< HEAD
    nextStep: function() {
      _nextStep.call(this);
      return this;
    },
    previousStep: function() {
      _previousStep.call(this);
      return this;
    },
    exit: function(force) {
      _exitIntro.call(this, this._targetElement, force);
      return this;
    },
    refresh: function() {
      _refresh.call(this);
      return this;
    },
    onbeforechange: function(providedCallback) {
      if (typeof (providedCallback) === 'function') {
        this._introBeforeChangeCallback = providedCallback;
      } else {
        throw new Error('Provided callback for onbeforechange was not a function');
      }
      return this;
    },
    onchange: function(providedCallback) {
      if (typeof (providedCallback) === 'function') {
        this._introChangeCallback = providedCallback;
      } else {
        throw new Error('Provided callback for onchange was not a function.');
      }
      return this;
    },
    onafterchange: function(providedCallback) {
      if (typeof (providedCallback) === 'function') {
        this._introAfterChangeCallback = providedCallback;
      } else {
        throw new Error('Provided callback for onafterchange was not a function');
      }
      return this;
    },
    oncomplete: function(providedCallback) {
      if (typeof (providedCallback) === 'function') {
        this._introCompleteCallback = providedCallback;
      } else {
        throw new Error('Provided callback for oncomplete was not a function.');
      }
      return this;
    },
    onhintsadded: function(providedCallback) {
      if (typeof (providedCallback) === 'function') {
        this._hintsAddedCallback = providedCallback;
      } else {
        throw new Error('Provided callback for onhintsadded was not a function.');
      }
      return this;
    },
    onhintclick: function(providedCallback) {
      if (typeof (providedCallback) === 'function') {
        this._hintClickCallback = providedCallback;
      } else {
        throw new Error('Provided callback for onhintclick was not a function.');
      }
      return this;
    },
    onhintclose: function(providedCallback) {
      if (typeof (providedCallback) === 'function') {
        this._hintCloseCallback = providedCallback;
      } else {
        throw new Error('Provided callback for onhintclose was not a function.');
      }
      return this;
    },
    onexit: function(providedCallback) {
      if (typeof (providedCallback) === 'function') {
        this._introExitCallback = providedCallback;
      } else {
        throw new Error('Provided callback for onexit was not a function.');
      }
      return this;
    },
    onskip: function(providedCallback) {
      if (typeof (providedCallback) === 'function') {
        this._introSkipCallback = providedCallback;
      } else {
        throw new Error('Provided callback for onskip was not a function.');
      }
      return this;
    },
    onbeforeexit: function(providedCallback) {
      if (typeof (providedCallback) === 'function') {
        this._introBeforeExitCallback = providedCallback;
      } else {
        throw new Error('Provided callback for onbeforeexit was not a function.');
      }
      return this;
    },
    addHints: function() {
=======
    nextStep: function () {
      _nextStep.call(this);
      return this;
    },
    previousStep: function () {
      _previousStep.call(this);
      return this;
    },
    exit: function (force) {
      _exitIntro.call(this, this._targetElement, force);
      return this;
    },
    refresh: function () {
      _refresh.call(this);
      return this;
    },
    onbeforechange: function (providedCallback) {
      if (typeof providedCallback === "function") {
        this._introBeforeChangeCallback = providedCallback;
      } else {
        throw new Error(
          "Provided callback for onbeforechange was not a function"
        );
      }
      return this;
    },
    onchange: function (providedCallback) {
      if (typeof providedCallback === "function") {
        this._introChangeCallback = providedCallback;
      } else {
        throw new Error("Provided callback for onchange was not a function.");
      }
      return this;
    },
    onafterchange: function (providedCallback) {
      if (typeof providedCallback === "function") {
        this._introAfterChangeCallback = providedCallback;
      } else {
        throw new Error(
          "Provided callback for onafterchange was not a function"
        );
      }
      return this;
    },
    oncomplete: function (providedCallback) {
      if (typeof providedCallback === "function") {
        this._introCompleteCallback = providedCallback;
      } else {
        throw new Error("Provided callback for oncomplete was not a function.");
      }
      return this;
    },
    onhintsadded: function (providedCallback) {
      if (typeof providedCallback === "function") {
        this._hintsAddedCallback = providedCallback;
      } else {
        throw new Error(
          "Provided callback for onhintsadded was not a function."
        );
      }
      return this;
    },
    onhintclick: function (providedCallback) {
      if (typeof providedCallback === "function") {
        this._hintClickCallback = providedCallback;
      } else {
        throw new Error(
          "Provided callback for onhintclick was not a function."
        );
      }
      return this;
    },
    onhintclose: function (providedCallback) {
      if (typeof providedCallback === "function") {
        this._hintCloseCallback = providedCallback;
      } else {
        throw new Error(
          "Provided callback for onhintclose was not a function."
        );
      }
      return this;
    },
    onexit: function (providedCallback) {
      if (typeof providedCallback === "function") {
        this._introExitCallback = providedCallback;
      } else {
        throw new Error("Provided callback for onexit was not a function.");
      }
      return this;
    },
    onskip: function (providedCallback) {
      if (typeof providedCallback === "function") {
        this._introSkipCallback = providedCallback;
      } else {
        throw new Error("Provided callback for onskip was not a function.");
      }
      return this;
    },
    onbeforeexit: function (providedCallback) {
      if (typeof providedCallback === "function") {
        this._introBeforeExitCallback = providedCallback;
      } else {
        throw new Error(
          "Provided callback for onbeforeexit was not a function."
        );
      }
      return this;
    },
    addHints: function () {
>>>>>>> main
      _populateHints.call(this, this._targetElement);
      return this;
    },
    hideHint: function (stepId) {
      _hideHint.call(this, stepId);
      return this;
    },
    hideHints: function () {
      _hideHints.call(this);
      return this;
    },
    showHint: function (stepId) {
      _showHint.call(this, stepId);
      return this;
    },
    showHints: function () {
      _showHints.call(this);
      return this;
    },
    removeHints: function () {
      _removeHints.call(this);
      return this;
    },
    removeHint: function (stepId) {
      _removeHint.call(this, stepId);
      return this;
    },
    showHintDialog: function (stepId) {
      _showHintDialog.call(this, stepId);
      return this;
<<<<<<< HEAD
    }
=======
    },
>>>>>>> main
  };

  return introJs;
});
