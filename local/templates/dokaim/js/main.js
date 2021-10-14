"use strict";

function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

var Calendar = /*#__PURE__*/function () {
  function Calendar(container) {
    var obj = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};

    _classCallCheck(this, Calendar);

    this.container = document.querySelector(container);
    this.parent = this.container.parentNode;
    this.selectedDay = '';
    this.scrollX = 28;
    this.data = obj;
  }

  _createClass(Calendar, [{
    key: "prepare",
    value: function prepare() {
      var date = new Date();
      this.selectedMonthNum = date.getMonth();
      this.year = date.getFullYear();
      this.printCalendar();
      this.months = this.container.querySelector('.calentar-months');
      this.month = this.months.querySelectorAll('[data-type="month"]');
      this.screen = this.container.querySelector('[data-type="screen"]');
      this.mobMonth = this.months.querySelector('[data-type="mobile-month"]');
      this.screen.innerHTML = this.createCalendarDays(date.getMonth());
    }
  }, {
    key: "init",
    value: function init() {
      this.prepare();
      this.listeners();
    }
  }, {
    key: "listeners",
    value: function listeners() {
      var _this = this;

      this.container.addEventListener('click', function (e) {
        var el = e.target;

        if (el.dataset.controls) {
          var elWidth = _this.screen.offsetWidth;
          var elScrollWidth = _this.screen.scrollWidth;
          var elScrollLeft = _this.screen.scrollLeft;
          var control = el.dataset.controls;

          switch (control) {
            case 'prev':
              if (elScrollLeft > 0) {
                _this.screen.scrollLeft = _this.screen.scrollLeft - _this.scrollX;
              }

              break;

            case 'next':
              if (elWidth + elScrollLeft < elScrollWidth) {
                _this.screen.scrollLeft = _this.screen.scrollLeft + _this.scrollX;
              }

              break;
          }
        }
      });
      this.screen.addEventListener('wheel', function (event) {
        if (event.deltaMode == event.DOM_DELTA_PIXEL) {
          var modifier = 1; // иные режимы возможны в Firefox
        } else if (event.deltaMode == event.DOM_DELTA_LINE) {
          //   var modifier = parseInt(getComputedStyle(this).lineHeight);
          var modifier = 4;
        } else if (event.deltaMode == event.DOM_DELTA_PAGE) {
          var modifier = this.clientHeight;
        }

        if (event.deltaY != 0) {
          // замена вертикальной прокрутки горизонтальной
          this.scrollLeft += modifier * event.deltaY;
          event.preventDefault();
        }
      });
      this.month.forEach(function (month) {
        month.addEventListener('click', function (e) {
          var current = e.target;
          var currentText = current.innerHTML;

          _this.month.forEach(function (m) {
            return m.classList.contains('active') && m.classList.remove('active');
          });

          current.classList.contains('active') || current.classList.add('active');
          _this.mobMonth.innerHTML = currentText;
          _this.mobMonth.classList.contains('open') && _this.mobMonth.classList.remove('open');
          _this.selectedMonthNum = current.dataset.month;
          _this.screen.innerHTML = _this.createCalendarDays(_this.selectedMonthNum);
          _this.screen.scrollLeft = 0;
        });
      });
      this.screen.addEventListener('click', function (e) {
        var el = e.target;

        if (el.classList.contains('busy') || el.parentNode.classList.contains('busy')) {
          var current = el.classList.contains('busy') ? el : el.parentNode;

          _this.screen.querySelectorAll('[data-type="date"]').forEach(function (d) {
            if (d !== current) d.classList.contains('active') && d.classList.remove('active');
          });

          current.classList.contains('active') ? current.classList.remove('active') : current.classList.add('active');
          _this.selectedDay = current.dataset.day;
        }
      });
      this.mobMonth.addEventListener('click', function (e) {
        var el = e.target;

        if (el.classList.contains('open')) {
          e.target.classList.remove('open');
        } else {
          el.classList.add('open');
        }
      });
    }
  }, {
    key: "createCalendarHeader",
    value: function createCalendarHeader() {
      var _this2 = this;

      var months = {
        0: 'январь',
        1: 'февраль',
        2: 'март',
        3: 'апрель',
        4: 'май',
        5: 'июнь',
        6: 'июль',
        7: 'август',
        8: 'сентябрь',
        9: 'октябрь',
        10: 'ноябрь',
        11: 'декабрь'
      };
      var div = document.createElement('div');
      div.classList.add('calentar-months');
      var ul = [];
      Object.values(months).forEach(function (m, i) {
        var active = _this2.selectedMonthNum === i ? ' active' : '';
        var li = "<li class=\"month".concat(active, "\" data-type=\"month\" data-month=\"").concat(i, "\">").concat(m, "</li>");
        ul.push(li);
      });
      var html = "\n            <p class=\"month month__mobile\" data-type=\"mobile-month\">".concat(months[this.selectedMonthNum], "</p>\n            <ul class=\"months\" data-type=\"months\">").concat(ul.join(''), "</ul>\n            <p class=\"year\" data-type=\"year\">").concat(this.year, "</p>\n        ");
      div.innerHTML = html;
      return div;
    }
  }, {
    key: "createCalendarScreen",
    value: function createCalendarScreen() {
      var div = document.createElement('div');
      div.classList.add('calendar-dates');
      div.id = 'dates';
      div.dataset.type = 'dates';
      div.innerHTML = "<div class=\"dates-wrapper\" data-type=\"screen\"></div>";
      return div;
    }
  }, {
    key: "createCalendarDays",
    value: function createCalendarDays(month) {
      var activeDays = this.data[+month + 1] ? this.data[+month + 1] : '';
      var days = ['вс', 'пн', 'вт', 'ср', 'чт', 'пт', 'сб'];
      var items = [];
      var daysInMonth = 32 - new Date(this.year, month, 32).getDate();
      var dayInWeek = new Date(this.year, month).getDay();

      for (var i = 1; i < daysInMonth + 1; i++) {
        var busy = activeDays.includes(i) ? ' busy' : '';
        var weeked = dayInWeek === 6 || dayInWeek === 0 ? ' weekend' : '';
        var item = "\n            <div class=\"date__item".concat(busy, "\" data-type=\"date\" data-day=\"").concat(i, "\">\n                <p class=\"date__number\">").concat(i, "</p>\n                <p class=\"date__letter").concat(weeked, "\">").concat(days[dayInWeek], "</p>\n            </div>\n            ");
        dayInWeek === 6 ? dayInWeek = 0 : dayInWeek++;
        items.push(item);
      }

      return items.join('');
    }
  }, {
    key: "createCalendarNav",
    value: function createCalendarNav() {
      return "\n            <button type=\"button\" class=\"dates__nav\" data-controls=\"prev\" tabindex=\"-1\" aria-controls=\"dates\">\n                <svg width=\"7\" height=\"12\" viewBox=\"0 0 7 12\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\" data-controls=\"prev\"><path d=\"M6 1L1 6L6 11\" stroke=\"#7B7B7B\" data-controls=\"prev\"/></svg>\n            </button>\n            <button type=\"button\" class=\"dates__nav\" data-controls=\"next\" tabindex=\"-1\" aria-controls=\"dates\">\n                <svg width=\"7\" height=\"12\" viewBox=\"0 0 7 12\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\" data-controls=\"next\"><path d=\"M1 11L6 6L1 1\" stroke=\"#7B7B7B\" data-controls=\"next\"/></svg>\n            </button>\n        ";
    }
  }, {
    key: "printCalendar",
    value: function printCalendar() {
      this.container.insertAdjacentHTML('beforeend', this.createCalendarNav());
      this.container.insertAdjacentElement('afterbegin', this.createCalendarScreen());
      this.container.insertAdjacentElement('afterbegin', this.createCalendarHeader());
    }
  }]);

  return Calendar;
}();

document.addEventListener('DOMContentLoaded', function () {
  // Calendar
  if (document.querySelector('#calendar')) {
    var calendar = new Calendar('#calendar', allEvents);
    calendar.init();
  } // Init sliders


  if (document.getElementById('mainSlider')) {
    var mainSlider = tns({
      container: '#mainSlider',
      items: 1,
      slideBy: 1,
      autoplay: false,
      autoplayTimeout: 10000,
      autoplayText: ['', ''],
      controlsText: ["\n                <svg width=\"9\" height=\"16\" viewBox=\"0 0 9 16\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">\n                <path d=\"M8.38114 1.33331L1.23828 8.47617L8.38114 15.619\" stroke=\"white\"/></svg>", "\n                <svg width=\"9\" height=\"16\" viewBox=\"0 0 9 16\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">\n                <path d=\"M0.618862 14.6667L7.76172 7.52383L0.61886 0.380973\" stroke=\"white\"/>\n                </svg>\n            "],
      controls: false,
      autoWidth: true,
      autoplayButton: false,
      gutter: 20,
      nav: true,
      arrowKeys: true,
      autoplayHoverPause: true,
      preventScrollOnTouch: 'auto',
      touch: true,
      mouseDrag: true,
      swipeAngle: 45,
      center: false,
      loop: true,
      responsive: {
        610: {
          items: 3,
          nav: false,
          controls: true,
          slideBy: 'page',
          center: true,
          gutter: 20
        },
        991: {
          center: false,
          gutter: 20
        }
      },
      useLocalStorage: false
    }); // Fix mobile slider last slide change

    mainSlider.events.on('touchEnd', function (info) {
      if (info.index === info.slideCountNew - 1) {
        for (var i = 0; i < info.cloneCount; i++) {
          mainSlider.goTo('prev');
        }
      }
    });
  }

  if (document.getElementById('eventsSlider')) {
    var eventsSlider = initSlider('#eventsSlider');
  }

  if (document.getElementById('signedEventsSlider')) {
    var signedEventsSlider = initSlider('#signedEventsSlider');
  }

  if (document.getElementById('attendedEventsSlider')) {
    var attendedEventsSlider = initSlider('#attendedEventsSlider');
  }

  if (document.getElementById('speakerEventsSlider')) {
    var eventsSlider = initSlider('#speakerEventsSlider');
  }

  if (document.getElementById('speakersSlider')) {
    var eventsSlider = tns({
      container: '#speakersSlider',
      items: 1,
      slideBy: 1,
      autoplay: false,
      autoplayText: ['', ''],
      controlsText: ["\n                <svg width=\"7\" height=\"12\" viewBox=\"0 0 7 12\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">\n                <path d=\"M6 1L1 6L6 11\" stroke=\"#7B7B7B\"/>\n                </svg>", "\n                <svg width=\"7\" height=\"12\" viewBox=\"0 0 7 12\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">\n                <path d=\"M1 11L6 6L1 1\" stroke=\"#7B7B7B\"/>\n                </svg>\n            "],
      autoWidth: false,
      autoplayButton: false,
      gutter: 20,
      nav: false,
      arrowKeys: true,
      autoplayHoverPause: true,
      mouseDrag: true,
      touch: true,
      preventScrollOnTouch: 'auto',
      swipeAngle: 45,
      edgePadding: 15,
      responsive: {
        610: {
          disable: true
        }
      }
    });
  }

  if (document.querySelectorAll('.monthSlider').length > 0) {
    window.monthSliders = [];
    document.querySelectorAll('.monthSlider').forEach(function (sl, i) {
      window.monthSliders.push(initSlider(sl));
      if (window.monthSliders[i] !== undefined && window.monthSliders[i].getInfo().slideCount === 1) window.monthSliders[i].destroy();
    });
  } // Listen resize window


  window.addEventListener('resize', function () {
    if (window.innerWidth < 610) {
      if (burger && burger.classList.contains('open')) {
        toggleOpen([burger, headerTop], 'open');
      }
    }

    if (window.innerWidth < 610 && mainSlider) {
      mainSlider.refresh();
    }
  }); // Listen change orientation

  window.addEventListener("orientationchange", function (e) {
    var orientation = e.target.screen.orientation; // if (window.monthSliders && window.monthSliders.length > 0) {
    //     if (orientation.angle === 0 && orientation.type.indexOf('portrait') !== -1) window.monthSliders.forEach(sl => sl.destroy())
    //     else if (orientation.angle === 90 && orientation.type.indexOf('landscape') !== -1) window.monthSliders.forEach(sl => sl.rebuild())
    // }
  }); // Click on main container

  var mainContainer = document.querySelector('.main');
  var changedTitle = false;
  var currentMonth = document.querySelector('.active[data-month]') !== null ? document.querySelector('.active[data-month]').dataset.month : 0;

  if (mainContainer) {
    mainContainer.addEventListener('click', function (e) {
      var el = e.target; // button follow

      if (el.dataset.type === 'follow') {
        e.preventDefault();

        if (mainContainer.dataset.type === 'profile') {
          add_to_data_profile(el.dataset.type, el).then(function () {
            change_events('follow', signedEventsSlider);
          });
        } else {
          add_to_data_profile(el.dataset.type, el);
        }
      } // button favorite


      if (el.dataset.type === 'favourite') {
        e.preventDefault();

        if (mainContainer.dataset.type === 'profile') {
          add_to_data_profile(el.dataset.type, el).then(function () {
            change_events('favorite', eventsSlider);
          });
        } else {
          add_to_data_profile(el.dataset.type, el);
        }
      } // button visit


      if (el.dataset.type === 'visit') {
        e.preventDefault();
        if (el.dataset.href) window.open(el.dataset.href, '_blank');
      } // Slider btns head


      if (el.classList.contains('.slider__head')) {
        e.preventDefault();
      } // calendar day


      if (el.dataset.type === 'date' && el.classList.contains('busy') || el.parentNode.dataset.type === 'date' && el.parentNode.classList.contains('busy')) {
        var keyEvents = mainContainer.querySelector('[data-type="key-events"]');
        var mainEvents = mainContainer.querySelector('.main__events');

        if (el.classList.contains('active') || el.parentNode.classList.contains('active')) {
          var data = {
            parent: calendar.parent,
            day: calendar.selectedDay,
            month: calendar.selectedMonthNum,
            year: calendar.year
          };
          currentDateEvents(data).then(function (status) {
            if (status) {
              if (keyEvents) {
                !keyEvents.classList.contains('hidden') && keyEvents.classList.add('hidden');
              }

              if (mainEvents && mainEvents.querySelector('.section__title') && !changedTitle) {
                mainEvents.querySelector('.section__title').innerHTML = "\u0412\u0430\u0441 \u043C\u043E\u0436\u0435\u0442 \u0437\u0430\u0438\u043D\u0442\u0435\u0440\u0435\u0441\u043E\u0432\u0430\u0442\u044C";
                changedTitle = true;
              }
            }
          });
        } else {
          if (document.querySelector('section[data-date]')) {
            document.querySelector('section[data-date]').remove();
          }

          if (keyEvents) {
            keyEvents.classList.contains('hidden') && keyEvents.classList.remove('hidden');
          }

          if (mainEvents && mainEvents.querySelector('.section__title') && changedTitle) {
            mainEvents.querySelector('.section__title').innerHTML = "\u041A\u043B\u044E\u0447\u0435\u0432\u044B\u0435 \u043C\u0435\u0440\u043E\u043F\u0440\u0438\u044F\u0442\u0438\u044F";
            changedTitle = false;
          }
        }
      } // calendar month 


      if (el.dataset.month && el.dataset.type === 'month' && currentMonth !== el.dataset.month) {
        currentMonth = el.dataset.month;

        var _mainEvents = mainContainer.querySelector('.main__events');

        var post_data = {
          'month': el.dataset.month
        };

        if ((typeof BX === "undefined" ? "undefined" : _typeof(BX)) !== undefined) {
          var wait = BX.showWait(_mainEvents.previousElementSibling);
          BX.ajax.post('/', post_data, function (data) {
            var newDoc = new DOMParser().parseFromString(data, "text/html");
            var elements = newDoc.querySelector('[data-type="key-events"]');

            if (document.querySelector('section[data-date]')) {
              document.querySelector('section[data-date]').remove();
            }

            if (document.querySelector('[data-type="key-events"]')) {
              document.querySelector('[data-type="key-events"]').replaceWith(elements);

              if (document.querySelector('#eventsSlider')) {
                var eventsSlider = initSlider('#eventsSlider');
              }
            }

            if (_mainEvents && _mainEvents.querySelector('.section__title') && changedTitle) {
              _mainEvents.querySelector('.section__title').innerHTML = "\u041A\u043B\u044E\u0447\u0435\u0432\u044B\u0435 \u043C\u0435\u0440\u043E\u043F\u0440\u0438\u044F\u0442\u0438\u044F";
              changedTitle = false;
            }

            BX.closeWait(_mainEvents.previousElementSibling, wait);
          });
        }
      } // play on video


      if (el.dataset.type === 'play') {
        var eventVideo = el.nextElementSibling;
        eventVideo.play();
        eventVideo.controls = true;
        el.classList.contains('hidden') || el.classList.add('hidden');

        if (!el.dataset.action && el.dataset.event) {
          videoCheck(eventVideo).then(function (res) {
            if (res === 1) {
              add_to_data_profile(el.dataset.type, el);
            }
          });
        }
      } // More ajax


      if (el.dataset.type === 'more') {
        var targetSection = el.closest('section');
        var targetContainer = targetSection.querySelector('[data-type="list"]');

        if (targetSection.querySelector('.tns-outer')) {
          sliderContainer = targetSection.querySelector("#".concat(targetSection.querySelector('.tns-outer').id));

          if (targetContainer.dataset.id) {
            if (window.monthSliders && window.monthSliders.length > 0) {
              window.monthSliders.forEach(function (sl, i) {
                if (sl.getInfo().container.dataset.id === targetContainer.dataset.id) {
                  sl.destroy();
                  window.monthSliders.splice(i, 1);
                }
              });
            }
          }
        }

        if (targetContainer.dataset.id) targetContainer = targetSection.querySelector("[data-id=\"".concat(targetContainer.dataset.id, "\"]"));
        var url = el.dataset.url;

        if (url !== undefined) {
          load_more_results(targetContainer, url);
        }
      } // More by months


      if (el.dataset.type === 'more-months' && !el.classList.contains('all')) {
        var _targetContainer = el.closest('[data-type="key-events"]');

        var pages = +el.dataset.pages;
        var current = +el.dataset.current;
        current++;

        if (pages > 1) {
          var elements = _targetContainer.querySelectorAll("[data-page=\"".concat(current, "\"]"));

          elements.forEach(function (el) {
            return removeClass([el], 'hidden');
          });

          if (current === pages) {
            el.classList.add('all');
            el.innerHTML = 'Загружено все';
          }

          el.dataset.current = current;
        }
      } // Full news


      if (el.dataset.type === 'show_full') {
        var hiddenElement = el.closest('.news__item').querySelector('.news__body__hidden');

        if (hiddenElement) {
          toggleClass(hiddenElement, 'show');

          if (hiddenElement.classList.contains('show')) {
            el.innerHTML = "\u0441\u0432\u0435\u0440\u043D\u0443\u0442\u044C \u043D\u043E\u0432\u043E\u0441\u0442\u044C";
          } else {
            el.innerHTML = "\u0447\u0438\u0442\u0430\u0442\u044C \u0434\u0430\u043B\u044C\u0448\u0435";
          }
        }
      }
    });
  } // SubscribeBtn


  var subscribeBtn = document.querySelector('.subscription-form .form__btn[type="submit"]');

  if (subscribeBtn) {
    subscribeBtn.addEventListener('click', function (e) {
      e.preventDefault();
      var subWrapper = e.target.closest('.sub-form-wrapper');
      var form = e.target.closest('form');
      var errMessage = form.querySelector('[data-type="error"]');
      var form_data = {
        email: form.querySelector('input[name="email"]').value,
        company: form.querySelector('input[name="company"]').value,
        name: form.querySelector('input[name="name"]').value,
        text: form.querySelector('input[name="text"]').value,
        token: form.querySelector('input[name="recaptcha_token"]').value
      };

      if (validateForm(form, ['name', 'email', 'check', 'text'])) {
        subscribe(form_data);
        !form.classList.contains('hidden') && form.classList.add('hidden');
        var subText = document.createElement('p');
        subText.classList.add('sub__text');
        subText.innerHTML = "\u0422\u0435\u043F\u0435\u0440\u044C \u0412\u044B \u043F\u043E\u0434\u043F\u0438\u0441\u0430\u043D\u044B \u043D\u0430 \u0440\u0430\u0441\u0441\u044B\u043B\u043A\u0443 \u043F\u043E\u043B\u0435\u0437\u043D\u043E\u0439 \u0438 \u0430\u043A\u0442\u0443\u0430\u043B\u044C\u043D\u043E\u0439 \u0438\u043D\u0444\u043E\u0440\u043C\u0430\u0446\u0438\u0438.";
        subWrapper.insertAdjacentElement('afterBegin', subText);
        addClass([errMessage], 'hidden');
      } else {
        removeClass([errMessage], 'hidden');
        showBundle('Ошибка при заполнении формы.', 'attention');
      }
    });
  } // Checkbox with agreement


  var allChecks = document.querySelectorAll('input[name="check"]');

  if (allChecks.length > 0) {
    allChecks.forEach(function (check) {
      check.addEventListener('change', function (e) {
        var input = e.target;
        var submit = input.closest('form').querySelector('[type="submit"]');

        if (input.checked && submit) {
          if (submit.disabled) {
            removeClass([submit], 'disabled');
            submit.disabled = false;
          }
        } else {
          if (!submit.disabled) {
            addClass([submit], 'disabled');
            submit.disabled = true;
          }
        }
      });
    });
  } // Header


  var burger = document.querySelector('.burger');
  var headerTop = burger.closest('.header-top');
  var mobileNav = headerTop.querySelector('.mobile-nav');

  if (burger) {
    burger.addEventListener('click', function () {
      if (burger.classList.contains('open')) {
        burger.classList.remove('open');
        headerTop.classList.remove('open');
      } else {
        burger.classList.add('open');
        headerTop.classList.add('open');
      }
    });
    window.addEventListener('scroll', function () {
      if (window.scrollY > 100 && burger.classList.contains('open')) {
        toggleOpen([burger, headerTop], 'open');
      }
    });
    mobileNav.addEventListener('click', function (e) {
      if (e.target.classList.contains('mobile-nav')) {
        toggleOpen([burger, headerTop], 'open');
      }
    });
  } // Load avatar


  var loadAvatar = document.querySelectorAll('[data-type="files"]');
  var avatarInput = document.querySelector('input[type="file"]');

  if (loadAvatar.length > 0 && avatarInput) {
    loadAvatar.forEach(function (btn) {
      btn.addEventListener('click', function (e) {
        e.preventDefault();
        var fileInput = e.currentTarget.parentNode.querySelector('.form__file');
        fileInput.click();
      });
    });
    avatarInput.addEventListener('change', function (e) {
      var avatar = e.target.files[0];
      console.log(avatar);

      if (avatar.type.startsWith('image/') && avatar.size <= 5000000) {
        var avatarSrc = window.URL.createObjectURL(avatar);
        var photoContainer = e.target.nextElementSibling;
        photoContainer.style.backgroundImage = "url(".concat(avatarSrc, ")");
        photoContainer.classList.contains('no__avatar') && photoContainer.classList.remove('no__avatar');
      } else console.warn('Image type error!');
    });
  } // Lightgallery


  if (document.getElementById('animated-thumbnials')) {
    lightGallery(document.getElementById('animated-thumbnials'), {
      selector: '.gallery__image',
      thumbnail: true,
      animateThumb: false,
      showThumbByDefault: false
    });
  } // More Images


  var moreImg = document.querySelector('[data-type="more__img"]');

  if (moreImg) {
    moreImg.addEventListener('click', function (e) {
      var container = e.target.closest('.gallery__wrapper');
      toggleClass(container, 'all');
    });
  } // Show password icon


  var pwdWrapper = document.querySelectorAll('.password-wrapper');

  if (pwdWrapper.length !== 0) {
    pwdWrapper.forEach(function (item) {
      item.addEventListener('click', function (e) {
        var eye = e.target;

        if (eye.dataset.type === 'show-pwd') {
          var input = e.target.parentNode.querySelector('input');

          if (!input.classList.contains('show__pwd')) {
            input.type = 'text';
            addClass([input], 'show__pwd');
          } else {
            input.type = 'password';
            removeClass([input], 'show__pwd');
          }
        }
      });
    });
  } // Ya.Metriks goals Register


  if (typeof BX !== 'undefined' && typeof ym !== 'undefined') {
    if (BX.getCookie('BITRIX_SM_USER_REG')) {
      ym(80017873, 'reachGoal', 'registration');
      BX.setCookie('BITRIX_SM_USER_REG', '', {
        path: '/',
        expires: -100
      });
    }
  }
});
not_auth_user(); // Functions

function add_to_data_profile() {
  var method = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 'none';
  var el = arguments.length > 1 ? arguments[1] : undefined;
  var elId = _typeof(el) === 'object' ? el.dataset.event : el;
  var event = {
    id: elId,
    method: method
  };

  if (method !== 'none' && el) {
    return new Promise(function (resolve, reject) {
      fetch('/local/ajax/profileHandlers.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify(event)
      }).then(function (response) {
        return response.json();
      }).then(function (status) {
        if (status === 1) {
          if (method === 'favourite') {
            el.classList.contains('full') || el.classList.add('full');
            addClass(document.querySelectorAll("[data-type=\"favourite\"][data-event=\"".concat(event.id, "\"]")), 'full');
            if (document.querySelector("button[data-type=\"favourite\"][data-event=\"".concat(event.id, "\"]"))) document.querySelector("button[data-type=\"favourite\"][data-event=\"".concat(event.id, "\"]")).innerHTML = 'Убрать из избранного';
            if (typeof ym !== 'undefined') ym(80017873, 'reachGoal', 'favorite');
          } else if (method === 'follow') {
            document.querySelectorAll("[data-type=\"follow\"][data-event=\"".concat(event.id, "\"]")).forEach(function (btn) {
              btn.innerHTML = 'Отменить запись';
              btn.classList.contains('unfollow') || btn.classList.add('unfollow');
            });
            showBundle("\u0412\u044B \u0443\u0441\u043F\u0435\u0448\u043D\u043E \u0437\u0430\u043F\u0438\u0441\u0430\u043B\u0438\u0441\u044C \u043D\u0430 \u043C\u0435\u0440\u043E\u043F\u0440\u0438\u044F\u0442\u0438\u0435.<br>\u0422\u0435\u043F\u0435\u0440\u044C \u043E\u043D\u043E \u043F\u043E\u044F\u0432\u0438\u0442\u0441\u044F \u0432 \u043B\u0438\u0447\u043D\u043E\u043C \u043A\u0430\u0431\u0438\u043D\u0435\u0442\u0435<br>\u0438 \u043C\u044B \u043D\u0430\u043F\u043E\u043C\u043D\u0438\u043C \u0412\u0430\u043C \u043E \u043D\u0435\u043C.");
          } else if (method === 'play') {
            el.dataset.action = 'played';
            addClass(document.querySelectorAll("[data-type=\"visit\"][data-event=\"".concat(event.id, "\"]")), 'full');
          }
        } else if (status === 2) {
          if (method === 'favourite') {
            el.classList.contains('full') && el.classList.remove('full');
            removeClass(document.querySelectorAll("[data-type=\"favourite\"][data-event=\"".concat(event.id, "\"]")), 'full');
            if (document.querySelector("button[data-type=\"favourite\"][data-event=\"".concat(event.id, "\"]"))) document.querySelector("button[data-type=\"favourite\"][data-event=\"".concat(event.id, "\"]")).innerHTML = 'в избранное';
          } else if (method === 'follow') {
            document.querySelectorAll("[data-type=\"follow\"][data-event=\"".concat(event.id, "\"]")).forEach(function (btn) {
              btn.innerHTML = 'Записаться';
              btn.classList.contains('unfollow') && btn.classList.remove('unfollow');
            });
            showBundle("\u0412\u044B \u043E\u0442\u043C\u0435\u043D\u0438\u043B\u0438 \u0437\u0430\u043F\u0438\u0441\u044C \u043D\u0430 \u043C\u0435\u0440\u043E\u043F\u0440\u0438\u044F\u0442\u0438\u0435.", 'attention');
          }
        } else if (status === 3) {
          var ref = encodeURIComponent(window.location.pathname);
          window.open("/login/?backurl=".concat(ref, "&method=new").concat(method, "&event=").concat(event.id, "#noauth"), '_blank');
        }

        resolve(status);
      });
    });
  }
}

add_to_data_profile = debouncePromise(add_to_data_profile, 200);

function showBundle(txt) {
  var type = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : '';
  var div = document.createElement('div');
  div.classList.add('popup-bundle');
  var icon = document.createElement('div');
  icon.classList.add('bundle__icon');
  type !== '' && icon.classList.add(type);
  var text = document.createElement('p');
  text.classList.add('bundle__text');
  text.innerHTML = txt;
  div.appendChild(icon);
  div.appendChild(text);
  var body = document.querySelector('body');
  body.insertAdjacentElement('beforeend', div);
  setTimeout(function () {
    div.classList.add('closing');
    setTimeout(function () {
      div.remove();
    }, 1000);
  }, 3000);
}

function subscribe(obj) {
  if (obj) {
    fetch('/local/ajax/subscribe.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json;charset=utf-8'
      },
      body: JSON.stringify(obj)
    }).then(function (response) {
      return response.json();
    }).then(function (status) {
      if (status === 1) {
        showBundle("\u041C\u044B \u043E\u0442\u043F\u0440\u0430\u0432\u0438\u043B\u0438 \u0432\u0430\u043C \u043F\u0438\u0441\u044C\u043C\u043E.<br>\u041F\u043E\u0436\u0430\u043B\u0443\u0439\u0441\u0442\u0430, \u043F\u0440\u043E\u0432\u0435\u0440\u044C\u0442\u0435 \u0432\u0430\u0448\u0443 \u043F\u043E\u0447\u0442\u0443.");
        if (typeof ym !== 'undefined') ym(80017873, 'reachGoal', 'subscribe');
      } else if (status === 2) {
        showBundle("\u0412\u0430\u0448 e-mail \u0443\u0436\u0435 \u0435\u0441\u0442\u044C \u0432 \u0431\u0430\u0437\u0435.", 'error');
      }
    });
  }
}

function toggleOpen() {
  var array = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : [];
  var className = arguments.length > 1 ? arguments[1] : undefined;

  if (array.length > 0 && className != '') {
    array.forEach(function (element) {
      element.classList.contains(className) && element.classList.remove(className);
    });
  } else {
    return false;
  }
}

function addClass() {
  var array = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : [];
  var className = arguments.length > 1 ? arguments[1] : undefined;

  if (array.length > 0 && className != '') {
    array.forEach(function (element) {
      element.classList.contains(className) || element.classList.add(className);
    });
  } else {
    return false;
  }
}

function removeClass() {
  var array = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : [];
  var className = arguments.length > 1 ? arguments[1] : undefined;

  if (array.length > 0 && className != '') {
    array.forEach(function (element) {
      element.classList.contains(className) && element.classList.remove(className);
    });
  } else {
    return false;
  }
}

function toggleClass(element, className) {
  if (element.length !== undefined) {
    element.forEach(function (el) {
      return el.classList.contains(className) ? el.classList.remove(className) : el.classList.add(className);
    });
  } else {
    element.classList.contains(className) ? element.classList.remove(className) : element.classList.add(className);
  }
}

function currentDateEvents(config) {
  var section = document.createElement('section');
  section.classList.add('section', 'month-events');
  section.dataset.date = "".concat(config.day, ".").concat(config.month + 1, ".").concat(config.year);
  var day = new Date(config.year, config.month, config.day);
  var date = day.toLocaleString('ru', {
    month: 'long',
    day: 'numeric'
  });
  var post_data = {
    'day': day.toLocaleDateString('ru')
  };

  if (typeof BX !== 'undefined') {
    return new Promise(function (resolve, reject) {
      var wait = BX.showWait(config.parent);
      BX.ajax.post('/local/ajax/currentDayEvents.php', post_data, function (events) {
        section.innerHTML = "\n                        <h2 class=\"section__title\">\u041C\u0435\u0440\u043E\u043F\u0440\u0438\u044F\u0442\u0438\u044F ".concat(date, "</h2>\n                        <div class=\"events__wrapper\">").concat(events, "</div>\n                    ");

        if (document.querySelector('[data-date]')) {
          document.querySelector('[data-date]').replaceWith(section);
        } else {
          config.parent.insertAdjacentElement('afterEnd', section);
        }

        BX.closeWait(config.parent, wait);
        resolve(true);
      });
    });
  }
}

currentDateEvents = debouncePromise(currentDateEvents, 300);

function load_more_results(container, url) {
  if (typeof BX !== 'undefined') {
    var wait = BX.showWait(container.parentNode);
    var className = '[data-type="list"]';

    if (container.dataset.id) {
      className = "[data-id=\"".concat(container.dataset.id, "\"]");
    }

    BX.ajax({
      type: 'GET',
      url: url,
      dataType: 'html',
      onsuccess: function onsuccess(data) {
        if (container.nextElementSibling.dataset.type === 'more') container.nextElementSibling.remove();
        var newDoc = new DOMParser().parseFromString(data, "text/html");

        var elements = _toConsumableArray(newDoc.querySelector(className).children);

        var html = '';
        elements.forEach(function (el) {
          return html += el.outerHTML;
        });
        var pagination = newDoc.querySelector(className).nextElementSibling;
        container.insertAdjacentHTML('beforeEnd', html);
        container.insertAdjacentElement('afterEnd', pagination);

        if (container.dataset.id) {
          window.monthSliders.push(initSlider(container));
        }

        BX.closeWait(container.parentNode, wait);
      }
    });
  }
}

function change_events(type, slider) {
  if (typeof BX !== 'undefined') {
    BX.ajax({
      type: 'GET',
      url: '/personal/',
      dataType: 'html',
      onsuccess: function onsuccess(data) {
        var newDoc = new DOMParser().parseFromString(data, "text/html");
        var container = '';
        var elements = '';
        var reInitSlider = false;

        switch (type) {
          case 'follow':
            elements = newDoc.querySelector('#signedEventsSlider');

            if (!elements) {
              reInitSlider = true;
              elements = newDoc.querySelector('[data-type="no-signed-events"]');
            }

            container = document.querySelector('[data-type="signed-events"]');
            break;

          case 'favorite':
            elements = newDoc.querySelector('#eventsSlider');

            if (!elements) {
              reInitSlider = true;
              elements = newDoc.querySelector('[data-type="no-favorite-events"]');
            }

            container = document.querySelector('[data-type="favorite-events"]');
            break;
        }

        var curentElements = container.lastElementChild;
        curentElements.replaceWith(elements);

        if (!reInitSlider && slider !== undefined) {
          slider.rebuild();
        }

        if (slider === undefined && !reInitSlider) {
          if (type === 'follow') {
            var signedEventsSlider = initSlider('#signedEventsSlider');
          } else if (type === 'favorite') {
            var eventsSlider = initSlider('#eventsSlider');
          }
        }
      }
    });
  }
} // Init events slider


function initSlider(name) {
  return tns({
    container: name,
    items: 1,
    slideBy: 1,
    autoplay: false,
    autoplayText: ['', ''],
    controlsText: ["\n            <svg width=\"7\" height=\"12\" viewBox=\"0 0 7 12\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">\n            <path d=\"M6 1L1 6L6 11\" stroke=\"#7B7B7B\"/>\n            </svg>", "\n            <svg width=\"7\" height=\"12\" viewBox=\"0 0 7 12\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">\n            <path d=\"M1 11L6 6L1 1\" stroke=\"#7B7B7B\"/>\n            </svg>\n        "],
    autoWidth: false,
    autoplayButton: false,
    gutter: 20,
    nav: false,
    arrowKeys: true,
    autoplayHoverPause: true,
    mouseDrag: true,
    touch: true,
    preventScrollOnTouch: 'auto',
    swipeAngle: 45,
    edgePadding: 15,
    responsive: {
      475: {
        items: 2
      },
      561: {
        disable: true
      }
    }
  });
} // Form validate


function validateForm(form) {
  var inputs = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : [];

  if (!form || _typeof(inputs) !== 'object' || inputs.length === 0) {
    return false;
  }

  var result = true;
  var emailReg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
  inputs.forEach(function (name) {
    var input = form.querySelector("input[name=\"".concat(name, "\"]"));

    if (input) {
      switch (name) {
        case 'name':
          if (input.value == '' || input.value.length < 2) {
            result = false;
            addClass([input], 'error__input');
          } else {
            removeClass([input], 'error__input');
          }

          break;

        case 'company':
          if (input.value == '' || input.value.length < 3) {
            result = false;
            addClass([input], 'error__input');
          } else {
            removeClass([input], 'error__input');
          }

          break;

        case 'email':
          if (emailReg.test(input.value) == false) {
            result = false;
            addClass([input], 'error__input');
          } else {
            removeClass([input], 'error__input');
          }

          break;

        case 'check':
          if (input.checked === false) {
            result = false;
            addClass([input], 'error__input');
          } else {
            removeClass([input], 'error__input');
          }

          break;

        case 'text':
          if (input.value !== '' && input.value.length !== 0) {
            result = false;
          }

          break;
      }
    }
  });
  return result;
} // Debounce


function debounce(func, wait, immediate) {
  var timeout;
  return function executedFunction() {
    var context = this;
    var args = arguments;

    var later = function later() {
      timeout = null;
      if (!immediate) func.apply(context, args);
    };

    var callNow = immediate && !timeout;
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
    if (callNow) func.apply(context, args);
  };
}

; // DebouncePromise

function debouncePromise(fn) {
  var _this3 = this;

  var ms = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 0;
  var timeoutId;
  var pending = [];
  return function () {
    for (var _len = arguments.length, args = new Array(_len), _key = 0; _key < _len; _key++) {
      args[_key] = arguments[_key];
    }

    return new Promise(function (res, rej) {
      clearTimeout(timeoutId);
      timeoutId = setTimeout(function () {
        var currentPending = [].concat(pending);
        pending.length = 0;
        Promise.resolve(fn.apply(_this3, args)).then(function (data) {
          currentPending.forEach(function (_ref) {
            var resolve = _ref.resolve;
            return resolve(data);
          });
        }, function (error) {
          currentPending.forEach(function (_ref2) {
            var reject = _ref2.reject;
            return reject(error);
          });
        });
      }, ms);
      pending.push({
        resolve: res,
        reject: rej
      });
    });
  };
}

; // Validate Reg Form

function validate_reg_form(errorKeys) {
  var regForm = document.querySelector('form[name="regform"]');
  if (!regForm) return false;
  var regMail = regForm.querySelector('input[name="REGISTER[EMAIL]"]');
  var regPass = regForm.querySelector('input[name="REGISTER[PASSWORD]"]');
  var regConfirm = regForm.querySelector('input[name="REGISTER[CONFIRM_PASSWORD]"]');
  var regName = regForm.querySelector('input[name="REGISTER[NAME]"]');
  var regCaptcha = regForm.querySelector('input[name="captcha_word"]');
  var errorMsg = document.querySelector('[data-type="error"]');

  if (errorKeys && errorKeys !== '') {
    errorKeys = errorKeys.split(',');
    errorKeys.forEach(function (key) {
      switch (key) {
        case 'EMAIL':
          if (regMail) addClass([regMail], 'error__input');
          break;

        case 'PASSWORD':
          if (regPass) addClass([regPass], 'error__input');
          break;

        case 'CONFIRM_PASSWORD':
          if (regConfirm) addClass([regConfirm], 'error__input');
          break;

        case 'DIFFERENT':
          if (regConfirm && regPass) {
            addClass([regConfirm], 'error__input');
            addClass([regPass], 'error__input');
          }

          break;

        case 'NAME':
          if (regName) addClass([regName], 'error__input');
          break;

        case 'CAPTCHA':
          if (regCaptcha) addClass([regCaptcha], 'error__input');
          break;
      }
    });
    if (errorMsg) removeClass([errorMsg], 'hidden');
  } else return false;

  return true;
} // Change webp background


function changeBackground() {
  var images = document.querySelectorAll('[data-bg]');

  if (images && images.length > 0) {
    for (var i = 0; i < images.length; i++) {
      var image = images[i].getAttribute('data-bg');
      images[i].style.backgroundImage = 'url(' + image + ')';
    }
  }
} // Video duration check


function videoCheck(video) {
  if (!video || video.tagName !== 'VIDEO') {
    return false;
  }

  return new Promise(function (res, rej) {
    // Video duration length check
    function videoDurationCheck(e) {
      var duration = e.target.duration;
      var activeLength = duration / 2;
      var played = e.target.currentTime;
      var status = 0;

      if (played > activeLength) {
        e.target.removeEventListener('timeupdate', videoDurationCheck);
        status = 1;
        res(status);
      }
    }

    video.addEventListener('timeupdate', videoDurationCheck);
  });
} // Бандл о регистрации в новом окне


function not_auth_user() {
  if (window.location.hash.indexOf('noauth') !== -1) {
    showBundle('Пожалуйста авторизуйтесь на сайте!', 'error');
    window.location.hash = '';
  }
}

function testWebP(callback) {
  var webP = new Image();

  webP.onload = webP.onerror = function () {
    callback(webP.height == 2);
  };

  webP.src = "data:image/webp;base64,UklGRjoAAABXRUJQVlA4IC4AAACyAgCdASoCAAIALmk0mk0iIiIiIgBoSygABc6WWgAA/veff/0PP8bA//LwYAAA";
}

testWebP(function (support) {
  if (document.querySelector('body')) {
    if (support == true) {
      document.querySelector('body').classList.add('webp');
    } else {
      document.querySelector('body').classList.add('no-webp');
      changeBackground();
    }
  }
});