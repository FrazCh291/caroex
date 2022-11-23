export default class SidebarConfig {
  constructor() {

  }

  applyInitialConfiguration() {
    $.app = $.app || {};
    var $body = $("body");
    var $window = $(window);
    var menuWrapper_el = $('div[data-menu="menu-wrapper"]').html();
    var menuWrapperClasses = $('div[data-menu="menu-wrapper"]').attr("class"); // Main menu
    $.app.menu = {
      expanded: null,
      collapsed: null,
      hidden: null,
      container: null,
      horizontalMenu: false,
      manualScroller: {
        obj: null,
        init: function init() {
          var scroll_theme = $(".main-menu").hasClass("menu-dark") ? "light" : "dark";
          this.obj = new PerfectScrollbar(".main-menu-content", {
            suppressScrollX: true,
            wheelPropagation: false
          });
        },
        update: function update() {
          if (this.obj) {
            // Scroll to currently active menu on page load if data-scroll-to-active is true
            if ($(".main-menu").data("scroll-to-active") === true) {
              var activeEl, menu, activeElHeight;
              activeEl = document.querySelector(".main-menu-content li.active");
              menu = document.querySelector(".main-menu-content");

              if ($body.hasClass("menu-collapsed")) {
                if ($(".main-menu-content li.sidebar-group-active").length) {
                  activeEl = document.querySelector(".main-menu-content li.sidebar-group-active");
                }
              }

              if (activeEl) {
                activeElHeight = activeEl.getBoundingClientRect().top + menu.scrollTop;
              } // If active element's top position is less than 2/3 (66%) of menu height than do not scroll


              if (activeElHeight > parseInt(menu.clientHeight * 2 / 3)) {
                var start = menu.scrollTop,
                  change = activeElHeight - start - parseInt(menu.clientHeight / 2);
              }

              setTimeout(function () {
                $.app.menu.container = $(".main-menu-content");
                $.app.menu.container.stop().animate({
                  scrollTop: change
                }, 300);
                $(".main-menu").data("scroll-to-active", "false");
              }, 300);
            }

            this.obj.update();
          }
        },
        enable: function enable() {
          if (!$(".main-menu-content").hasClass("ps")) {
            this.init();
          }
        },
        disable: function disable() {
          if (this.obj) {
            this.obj.destroy();
          }
        },
        updateHeight: function updateHeight() {
          if (($body.data("menu") == "vertical-menu" || $body.data("menu") == "vertical-menu-modern" || $body.data("menu") == "vertical-overlay-menu") && $(".main-menu").hasClass("menu-fixed")) {
            $(".main-menu-content").css("height", $(window).height() - $(".header-navbar").height() - $(".main-menu-header").outerHeight() - $(".main-menu-footer").outerHeight());
            this.update();
          }
        }
      },
      init: function init(compactMenu) {
        if ($(".main-menu-content").length > 0) {
          this.container = $(".main-menu-content");
          var menuObj = this;
          var defMenu = "";

          if (compactMenu === true) {
            defMenu = "collapsed";
          }

          if ($body.data("menu") == "vertical-menu-modern") {
            var menuToggle = "";
            if (menuToggle === "false") {
              this.change("collapsed");
            } else {
              this.change(defMenu);
            }
          } else {
            this.change(defMenu);
          }
        }
      },
      drillDownMenu: function drillDownMenu(screenSize) {
        if ($(".drilldown-menu").length) {
          if (screenSize == "sm" || screenSize == "xs") {
            if ($("#navbar-mobile").attr("aria-expanded") == "true") {
              $(".drilldown-menu").slidingMenu({
                backLabel: true
              });
            }
          } else {
            $(".drilldown-menu").slidingMenu({
              backLabel: true
            });
          }
        }
      },
      change: function change(defMenu, menuIconColorsObj) {
        let currentBreakpoint = {name: '', width: ''};
        if (window.innerWidth >= 1200) {
          currentBreakpoint.name = 'xl';
          currentBreakpoint.width = '1200px';
        }
        if (window.innerWidth >= 992 && window.innerWidth < 1200) {
          currentBreakpoint.name = 'lg';
          currentBreakpoint.width = '992px';
        }
        if (window.innerWidth >= 768 && window.innerWidth < 992) {
          this.hidden = true;
          currentBreakpoint.name = 'md';
          currentBreakpoint.width = '768px';
        }

        if (window.innerWidth >= 576 && window.innerWidth < 768) {
          this.hidden = true;
          currentBreakpoint.name = 'sm';
          currentBreakpoint.width = '300px';
        }
        if (window.innerWidth >= 300 && window.innerWidth < 576) {
          this.hidden = true;
          currentBreakpoint.name = 'xs';
          currentBreakpoint.width = '576px';
        }


        this.reset();
        var menuType = $body.data("menu");

        if (currentBreakpoint) {
          switch (currentBreakpoint.name) {
            case "xl":
              if (menuType === "vertical-overlay-menu") {
                this.hide();
              } else {
                if (defMenu === "collapsed") this.collapse(defMenu); else this.expand();
              }

              break;

            case "lg":
              if (menuType === "vertical-overlay-menu" || menuType === "vertical-menu-modern" || menuType === "horizontal-menu") {
                this.hide();
              } else {
                this.collapse();
              }

              break;

            case "md":
            case "sm":
              this.hide();
              break;

            case "xs":
              this.hide();
              break;
          }
        } // On the small and extra small screen make them overlay menu


        if (menuType === "vertical-menu" || menuType === "vertical-menu-modern") {
          this.toOverlayMenu(currentBreakpoint.name, menuType);
        }

        if ($body.is(".horizontal-layout") && !$body.hasClass(".horizontal-menu-demo")) {
          this.changeMenu(currentBreakpoint.name);
          $(".menu-toggle").removeClass("is-active");
        } // Initialize drill down menu for vertical layouts, for horizontal layouts drilldown menu is intitialized in changemenu function


        if (menuType != "horizontal-menu") {
          // Drill down menu
          // ------------------------------
          this.drillDownMenu(currentBreakpoint.name);
        } // Dropdown submenu on large screen on hover For Large screen only
        // ---------------------------------------------------------------


        if (currentBreakpoint.name == "xl") {
          $('body[data-open="hover"] .dropdown').on("mouseenter", function () {
            if (!$(this).hasClass("show")) {
              $(this).addClass("show");
            } else {
              $(this).removeClass("show");
            }
          }).on("mouseleave", function (event) {
            $(this).removeClass("show");
          });
          $('body[data-open="hover"] .dropdown a').on("click", function (e) {
            if (menuType == "horizontal-menu") {
              var $this = $(this);

              if ($this.hasClass("dropdown-toggle")) {
                return false;
              }
            }
          });
        } // Added data attribute brand-center for navbar-brand-center
        // TODO:AJ: Shift this feature in JADE.


        if ($(".header-navbar").hasClass("navbar-brand-center")) {
          $(".header-navbar").attr("data-nav", "brand-center");
        }

        if (currentBreakpoint.name == "sm" || currentBreakpoint.name == "xs") {
          $(".header-navbar[data-nav=brand-center]").removeClass("navbar-brand-center");
        } else {
          $(".header-navbar[data-nav=brand-center]").addClass("navbar-brand-center");
        } // Dropdown submenu on small screen on click
        // --------------------------------------------------


        $("ul.dropdown-menu [data-toggle=dropdown]").on("click", function (event) {
          if ($(this).siblings("ul.dropdown-menu").length > 0) {
            event.preventDefault();
          }

          event.stopPropagation();
          $(this).parent().siblings().removeClass("show");
          $(this).parent().toggleClass("show");
        }); // Horizontal layout submenu drawer scrollbar

        if (menuType == "horizontal-menu") {
          $("li.dropdown-submenu").on("mouseenter", function () {
            if (!$(this).parent(".dropdown").hasClass("show")) {
              $(this).removeClass("openLeft");
            }

            var dd = $(this).find(".dropdown-menu");

            if (dd) {
              var pageHeight = $(window).height(),
                // ddTop = dd.offset().top,
                ddTop = $(this).position().top,
                ddLeft = dd.offset().left,
                ddWidth = dd.width(),
                ddHeight = dd.height();

              if (pageHeight - ddTop - ddHeight - 28 < 1) {
                var maxHeight = pageHeight - ddTop - 170;
                $(this).find(".dropdown-menu").css({
                  "max-height": maxHeight + "px",
                  "overflow-y": "auto",
                  "overflow-x": "hidden"
                });
              } // Add class to horizontal sub menu if screen width is small


              if (ddLeft + ddWidth - (window.innerWidth - 16) >= 0) {
                $(this).addClass("openLeft");
              }
            }
          });
        }

        /********************************************
         *             Searchable Menu               *
         ********************************************/


        function searchMenu(list) {
          var input = $(".menu-search");
          $(input).change(function () {
            var filter = $(this).val();

            if (filter) {
              // Hide Main Navigation Headers
              $(".navigation-header").hide(); // this finds all links in a list that contain the input,
              // and hide the ones not containing the input while showing the ones that do

              $(list).find("li a:not(:Contains(" + filter + "))").hide().parent().hide(); // $(list).find("li a:Contains(" + filter + ")").show().parents('li').show().addClass('open').closest('li').children('a').show();

              var searchFilter = $(list).find("li a:Contains(" + filter + ")");

              if (searchFilter.parent().hasClass("has-sub")) {
                searchFilter.show().parents("li").show().addClass("open").closest("li").children("a").show().children("li").show(); // searchFilter.parents('li').find('li').show().children('a').show();

                if (searchFilter.siblings("ul").length > 0) {
                  searchFilter.siblings("ul").children("li").show().children("a").show();
                }
              } else {
                searchFilter.show().parents("li").show().addClass("open").closest("li").children("a").show();
              }
            } else {
              // return to default
              $(".navigation-header").show();
              $(list).find("li a").show().parent().show().removeClass("open");
            }

            $.app.menu.manualScroller.update();
            return false;
          }).keyup(function () {
            // fire the above change event after every letter
            $(this).change();
          });
        }

        if (menuType === "vertical-menu" || menuType === "vertical-overlay-menu") {
          // custom css expression for a case-insensitive contains()
          jQuery.expr[":"].Contains = function (a, i, m) {
            return (a.textContent || a.innerText || "").toUpperCase().indexOf(m[3].toUpperCase()) >= 0;
          };

          searchMenu($("#main-menu-navigation"));
        }
      },
      transit: function transit(callback1, callback2) {
        var menuObj = this;
        $body.addClass("changing-menu");
        callback1.call(menuObj);

        if ($body.hasClass("vertical-layout")) {
          if ($body.hasClass("menu-open") || $body.hasClass("menu-expanded")) {
            $(".menu-toggle").addClass("is-active"); // Show menu header search when menu is normally visible

            if ($body.data("menu") === "vertical-menu") {
              if ($(".main-menu-header")) {
                $(".main-menu-header").show();
              }
            }
          } else {
            $(".menu-toggle").removeClass("is-active"); // Hide menu header search when only menu icons are visible

            if ($body.data("menu") === "vertical-menu") {
              if ($(".main-menu-header")) {
                $(".main-menu-header").hide();
              }
            }
          }
        }

        setTimeout(function () {
          callback2.call(menuObj);
          $body.removeClass("changing-menu");
          menuObj.update();
        }, 500);
      },
      open: function open() {
        this.transit(function () {
          $body.removeClass("menu-hide menu-collapsed").addClass("menu-open");
          this.hidden = false;
          this.expanded = true;

          if ($body.hasClass("vertical-overlay-menu")) {
            $(".sidenav-overlay").removeClass("d-none").addClass("d-block");
            $("body").css("overflow", "hidden");
          }
        }, function () {
          if (!$(".main-menu").hasClass("menu-native-scroll") && $(".main-menu").hasClass("menu-fixed")) {
            this.manualScroller.enable();
            $(".main-menu-content").css("height", $(window).height() - $(".header-navbar").height() - $(".main-menu-header").outerHeight() - $(".main-menu-footer").outerHeight()); // this.manualScroller.update();
          }

          if (!$body.hasClass("vertical-overlay-menu")) {
            $(".sidenav-overlay").removeClass("d-block d-none");
            $("body").css("overflow", "auto");
          }
        });
      },
      hide: function hide() {

        this.transit(function () {
          $body.removeClass("menu-open menu-expanded").addClass("menu-hide");
          this.hidden = true;
          this.expanded = false;

          if ($body.hasClass("vertical-overlay-menu")) {
            $(".sidenav-overlay").removeClass("d-block").addClass("d-none");
            $("body").css("overflow", "auto");
          }
        }, function () {
          if (!$(".main-menu").hasClass("menu-native-scroll") && $(".main-menu").hasClass("menu-fixed")) {
            this.manualScroller.enable();
          }

          if (!$body.hasClass("vertical-overlay-menu")) {
            $(".sidenav-overlay").removeClass("d-block d-none");
            $("body").css("overflow", "auto");
          }
        });
      },
      expand: function expand() {
        if (this.expanded === false) {
          if ($body.data("menu") == "vertical-menu-modern") {
            $(".modern-nav-toggle").find(".toggle-icon").removeClass("bx bx-circle").addClass("bx bx-disc");
          }
          this.transit(function () {
            $body.removeClass("menu-collapsed").addClass("menu-expanded");
            this.collapsed = false;
            this.expanded = true;
            $(".sidenav-overlay").removeClass("d-block d-none");
          }, function () {
            if ($(".main-menu").hasClass("menu-native-scroll") || $body.data("menu") == "horizontal-menu") {
              this.manualScroller.disable();
            } else {
              if ($(".main-menu").hasClass("menu-fixed")) this.manualScroller.enable();
            }

            if (($body.data("menu") == "vertical-menu" || $body.data("menu") == "vertical-menu-modern") && $(".main-menu").hasClass("menu-fixed")) {
              $(".main-menu-content").css("height", $(window).height() - $(".header-navbar").height() - $(".main-menu-header").outerHeight() - $(".main-menu-footer").outerHeight()); // this.manualScroller.update();
            }
          });
        }
      },
      collapse: function collapse(defMenu) {

        if (this.collapsed === false) {
          if ($body.data("menu") == "vertical-menu-modern") {
            $(".modern-nav-toggle").find(".toggle-icon").removeClass("bx bx-disc").addClass("bx bx-circle");
          }

          this.transit(function () {
            $body.removeClass("menu-expanded").addClass("menu-collapsed");
            this.collapsed = true;
            this.expanded = false;
            $(".content-overlay").removeClass("d-block d-none");
          }, function () {
            if ($body.data("menu") == "horizontal-menu" && $body.hasClass("vertical-overlay-menu")) {
              if ($(".main-menu").hasClass("menu-fixed")) this.manualScroller.enable();
            }

            if (($body.data("menu") == "vertical-menu" || $body.data("menu") == "vertical-menu-modern") && $(".main-menu").hasClass("menu-fixed")) {
              $(".main-menu-content").css("height", $(window).height() - $(".header-navbar").height()); // this.manualScroller.update();
            }

            if ($body.data("menu") == "vertical-menu-modern") {
              if ($(".main-menu").hasClass("menu-fixed")) this.manualScroller.enable();
            }
          });
        }
      },
      toOverlayMenu: function toOverlayMenu(screen, menuType) {
        var menu = $body.data("menu");

        if (menuType == "vertical-menu-modern") {
          if (screen == "lg" || screen == "md" || screen == "sm" || screen == "xs") {
            if ($body.hasClass(menu)) {
              $body.removeClass(menu).addClass("vertical-overlay-menu");
            }
          } else {
            if ($body.hasClass("vertical-overlay-menu")) {
              $body.removeClass("vertical-overlay-menu").addClass(menu);
            }
          }
        } else {
          if (screen == "sm" || screen == "xs") {
            if ($body.hasClass(menu)) {
              $body.removeClass(menu).addClass("vertical-overlay-menu");
            }
          } else {
            if ($body.hasClass("vertical-overlay-menu")) {
              $body.removeClass("vertical-overlay-menu").addClass(menu);
            }
          }
        }
      },
      changeMenu: function changeMenu(screen) {
        // Replace menu html
        $('div[data-menu="menu-wrapper"]').html("");
        $('div[data-menu="menu-wrapper"]').html(menuWrapper_el); // Destroy Icons when screen size changes

        $(".menu-livicon").removeLiviconEvo(); // Initialize Menu Icons with configs

        $.each($(".menu-livicon"), function (i) {
          var $this = $(this),
            icon = $this.data("icon"),
            iconStyle = $("#main-menu-navigation").data("icon-style");
          $this.addLiviconEvo({
            name: icon,
            style: iconStyle,
            duration: 0.85,
            strokeWidth: "1.3px",
            eventOn: "parent",
            strokeColor: menuIconColorsObj.iconStrokeColor,
            solidColor: menuIconColorsObj.iconSolidColor,
            fillColor: menuIconColorsObj.iconFillColor,
            strokeColorAlt: menuIconColorsObj.iconStrokeColorAlt,
            afterAdd: function afterAdd() {
              if (i === $(".main-menu-content .menu-livicon").length - 1) {
                // When hover over any menu item, start animation and stop all other animation
                $(".main-menu-content .nav-item a").on("mouseenter", function () {
                  if ($(".main-menu-content .menu-livicon").length) {
                    $(".main-menu-content .menu-livicon").stopLiviconEvo();
                    $(this).find(".menu-livicon").playLiviconEvo();
                  }
                });
              }
            }
          });
        });
        var menuWrapper = $('div[data-menu="menu-wrapper"]'),
          menuContainer = $('div[data-menu="menu-container"]'),
          menuNavigation = $('ul[data-menu="menu-navigation"]'),

          /*megaMenu           = $('li[data-menu="megamenu"]'),
          megaMenuCol        = $('li[data-mega-col]'),*/
          dropdownMenu = $('li[data-menu="dropdown"]'),
          dropdownSubMenu = $('li[data-menu="dropdown-submenu"]');

        if (screen === "xl") {
          // Change body classes
          $body.removeClass("vertical-layout vertical-overlay-menu fixed-navbar").addClass($body.data("menu")); // Remove navbar-fix-top class on large screens

          $("nav.header-navbar").removeClass("fixed-top"); // Change menu wrapper, menu container, menu navigation classes

          menuWrapper.removeClass().addClass(menuWrapperClasses); // Intitialize drill down menu for horizontal layouts
          // --------------------------------------------------

          this.drillDownMenu(screen);
          $("a.dropdown-item.nav-has-children").on("click", function () {
            event.preventDefault();
            event.stopPropagation();
          });
          $("a.dropdown-item.nav-has-parent").on("click", function () {
            event.preventDefault();
            event.stopPropagation();
          });
        } else {
          // Change body classes
          $body.removeClass($body.data("menu")).addClass("vertical-layout vertical-overlay-menu fixed-navbar"); // Add navbar-fix-top class on small screens

          $("nav.header-navbar").addClass("fixed-top"); // Change menu wrapper, menu container, menu navigation classes

          menuWrapper.removeClass().addClass("main-menu menu-fixed menu-shadow");

          if ($body.data("layout") === "dark-layout" || $body.data("layout") === "semi-dark-layout") {
            menuWrapper.addClass("menu-dark");
          } else {
            menuWrapper.addClass("menu-light");
          } // menuContainer.removeClass().addClass('main-menu-content');


          menuNavigation.removeClass().addClass("navigation navigation-main"); // If Dropdown Menu

          dropdownMenu.removeClass("dropdown").addClass("has-sub");
          dropdownMenu.find("a").removeClass("dropdown-toggle nav-link");
          dropdownMenu.children("ul").find("a").removeClass("dropdown-item");
          dropdownMenu.find("ul").removeClass("dropdown-menu");
          dropdownSubMenu.removeClass().addClass("has-sub");
          $.app.nav.init(); // Dropdown submenu on small screen on click
          // --------------------------------------------------

          $("ul.dropdown-menu [data-toggle=dropdown]").on("click", function (event) {
            event.preventDefault();
            event.stopPropagation();
            $(this).parent().siblings().removeClass("open");
            $(this).parent().toggleClass("open");
          }); // $('.shadow-bottom').css('display', 'block');
        }

        $(".main-menu-content").find("li.active").parents("li").addClass("sidebar-group-active");

        function updateLivicon(el) {
          el.updateLiviconEvo({
            strokeColor: menuActiveIconColorsObj.iconStrokeColor,
            solidColor: menuActiveIconColorsObj.iconSolidColor,
            fillColor: menuActiveIconColorsObj.iconFillColor,
            strokeColorAlt: menuActiveIconColorsObj.iconStrokeColorAlt
          });
        } // Update Active Menu item Icon with active color


        if ($(".nav-item.active .menu-livicon").length) {
          updateLivicon($(".nav-item.active .menu-livicon"));
        } // Update Active sidebar group menu icon with active ccolor


        if ($(".main-menu-content li.sidebar-group-active .menu-livicon").length) {
          updateLivicon($(".main-menu-content li.sidebar-group-active .menu-livicon"));
        }
      },
      toggle: function toggle() {
        let currentBreakpoint = {name: '', width: ''};
        if (window.innerWidth >= 1200) {
          currentBreakpoint.name = 'xl';
          currentBreakpoint.width = '1200px';
        }
        if (window.innerWidth >= 992 && window.innerWidth < 1200) {
          currentBreakpoint.name = 'lg';
          currentBreakpoint.width = '992px';
        }
        if (window.innerWidth >= 768 && window.innerWidth < 992) {
          currentBreakpoint.name = 'md';
          currentBreakpoint.width = '768px';
        }

        if (window.innerWidth >= 576 && window.innerWidth < 768) {
          currentBreakpoint.name = 'sm';
          currentBreakpoint.width = '576px';
        }
        if (window.innerWidth >= 300 && window.innerWidth < 576) {
          currentBreakpoint.name = 'xs';
          currentBreakpoint.width = '300px';
        }

        var collapsed = this.collapsed;
        var expanded = this.expanded;
        var hidden = this.hidden;
        var menu = $body.data("menu");
        if (expanded === true) {
          if (menu == "vertical-overlay-menu") {
            this.hide();
          } else {
            this.collapse();
          }
        } else {
          if (menu == "vertical-overlay-menu") {
            this.open();
          } else {
            this.expand();
          }
        }
        switch (currentBreakpoint.name) {
          case "xl":
            if (expanded === true) {
              if (menu == "vertical-overlay-menu") {
                this.hide();
              } else {
                this.collapse();
              }
            } else {
              if (menu == "vertical-overlay-menu") {
                this.open();
              } else {
                this.expand();
              }
            }

            break;

          case "lg":
            if (expanded === true) {
              if (menu == "vertical-overlay-menu" || menu == "vertical-menu-modern" || menu == "horizontal-menu") {
                this.hide();
              } else {
                this.collapse();
              }
            } else {
              if (menu == "vertical-overlay-menu" || menu == "vertical-menu-modern" || menu == "horizontal-menu") {
                this.open();
              } else {
                this.expand();
              }
            }

            break;

          case "md":
          case "sm":
            if (hidden === true) {
              this.open();
            } else {
              this.hide();
            }

            break;

          case "xs":
            if (hidden === true) {
              this.open();
            } else {
              this.hide();
            }

            break;
        } // Re-init sliding menu to update width


        this.drillDownMenu(currentBreakpoint.name);
      },
      update: function update() {
        this.manualScroller.update();
      },
      reset: function reset() {
        this.expanded = false;
        this.collapsed = false;
        this.hidden = false;
        $body.removeClass("menu-hide menu-open menu-collapsed menu-expanded");
      }
    }; // Navigation Menu
    $.app.nav = {
      container: $(".navigation-main"),
      initialized: false,
      navItem: $(".navigation-main").find("li").not(".navigation-category"),
      config: {
        speed: 300
      },
      init: function init(config) {
        this.initialized = true; // Set to true when initialized

        $.extend(this.config, config);
        this.bind_events();
      },
      bind_events: function bind_events() {
        var menuObj = this;
        $(".navigation-main").on("mouseenter.app.menu", "li", function () {
          var $this = $(this);
          $(".hover", ".navigation-main").removeClass("hover");

          if ($body.hasClass("menu-collapsed") && $body.data("menu") != "vertical-menu-modern") {
            $(".main-menu-content").children("span.menu-title").remove();
            $(".main-menu-content").children("a.menu-title").remove();
            $(".main-menu-content").children("ul.menu-content").remove(); // Title

            var menuTitle = $this.find("span.menu-title").clone(),
              tempTitle,
              tempLink;

            if (!$this.hasClass("has-sub")) {
              tempTitle = $this.find("span.menu-title").text();
              tempLink = $this.children("a").attr("href");

              if (tempTitle !== "") {
                menuTitle = $("<a>");
                menuTitle.attr("href", tempLink);
                menuTitle.attr("title", tempTitle);
                menuTitle.text(tempTitle);
                menuTitle.addClass("menu-title");
              }
            } // menu_header_height = ($('.main-menu-header').length) ? $('.main-menu-header').height() : 0,
            // fromTop = menu_header_height + $this.position().top + parseInt($this.css( "border-top" ),10);
            var fromTop;

            if ($this.css("border-top")) {
              fromTop = $this.position().top + parseInt($this.css("border-top"), 10);
            } else {
              fromTop = $this.position().top;
            }

            if ($body.data("menu") !== "vertical-compact-menu") {
              menuTitle.appendTo(".main-menu-content").css({
                position: "fixed",
                top: fromTop
              });
            } // Content


            if ($this.hasClass("has-sub") && $this.hasClass("nav-item")) {
              var menuContent = $this.children("ul:first");
              menuObj.adjustSubmenu($this);
            }
          }

          $this.addClass("hover");
        }).on("mouseleave.app.menu", "li", function () {// $(this).removeClass('hover');
        }).on("active.app.menu", "li", function (e) {
          $(this).addClass("active");
          e.stopPropagation();
          $('[data-toggle="popover"]').popover('hide');
        }).on("deactive.app.menu", "li.active", function (e) {
          $(this).removeClass("active");
          e.stopPropagation();
          $('[data-toggle="popover"]').popover('hide');
        }).on("open.app.menu", "li", function (e) {
          var $listItem = $(this);
          $listItem.addClass("open");
          menuObj.expand($listItem); // If menu collapsible then do not take any action

          if ($(".main-menu").hasClass("menu-collapsible")) {
            return false;
          } // If menu accordion then close all except clicked once
          else {
            $listItem.siblings(".open").find("li.open").trigger("close.app.menu");
            $listItem.siblings(".open").trigger("close.app.menu");
          }

          e.stopPropagation();
          $('[data-toggle="popover"]').popover('hide');
        }).on("close.app.menu", "li.open", function (e) {
          var $listItem = $(this);
          $listItem.removeClass("open");
          menuObj.collapse($listItem);
          e.stopPropagation();
          $('[data-toggle="popover"]').popover('hide');
        }).on("click.app.menu", "li", function (e) {
          var $listItem = $(this);

          if ($listItem.is(".disabled")) {
            e.preventDefault();
          } else {
            if ($body.hasClass("menu-collapsed") && $body.data("menu") != "vertical-menu-modern") {
              e.preventDefault();
            } else {
              if ($listItem.has("ul")) {
                if ($listItem.is(".open")) {
                  $listItem.trigger("close.app.menu");
                } else {
                  $listItem.trigger("open.app.menu");
                }
              } else {
                if (!$listItem.is(".active")) {
                  $listItem.siblings(".active").trigger("deactive.app.menu");
                  $listItem.trigger("active.app.menu");
                }
              }
            }
          }

          e.stopPropagation();
          $('[data-toggle="popover"]').popover('hide');
        });

        $(".main-menu-content").on("mouseleave", function () {
          if ($body.hasClass("menu-collapsed")) {
            $(".main-menu-content").children("span.menu-title").remove();
            $(".main-menu-content").children("a.menu-title").remove();
            $(".main-menu-content").children("ul.menu-content").remove();
          }

          $(".hover", ".navigation-main").removeClass("hover");
        }); // If list item has sub menu items then prevent redirection.

        $(".navigation-main li.has-sub > a").on("click", function (e) {
          e.preventDefault();
        });
        $("ul.menu-content").on("click", "li", function (e) {
          var $listItem = $(this);

          if ($listItem.is(".disabled")) {
            e.preventDefault();
          } else {
            if ($listItem.has("ul")) {
              if ($listItem.is(".open")) {
                $listItem.removeClass("open");
                menuObj.collapse($listItem);
              } else {
                $listItem.addClass("open");
                menuObj.expand($listItem); // If menu collapsible then do not take any action

                if ($(".main-menu").hasClass("menu-collapsible")) {
                  return false;
                } // If menu accordion then close all except clicked once
                else {
                  $listItem.siblings(".open").find("li.open").trigger("close.app.menu");
                  $listItem.siblings(".open").trigger("close.app.menu");
                }

                e.stopPropagation();
                $('[data-toggle="popover"]').popover('hide');
              }
            } else {
              if (!$listItem.is(".active")) {
                $listItem.siblings(".active").trigger("deactive.app.menu");
                $listItem.trigger("active.app.menu");
              }
            }
          }

          e.stopPropagation();
          $('[data-toggle="popover"]').popover('hide');
        });
      },


      /**
       * Ensure an admin submenu is within the visual viewport.
       * @param {jQuery} $menuItem The parent menu item containing the submenu.
       */
      adjustSubmenu: function adjustSubmenu($menuItem) {
        var menuHeaderHeight,
          menutop,
          topPos,
          winHeight,
          bottomOffset,
          subMenuHeight,
          popOutMenuHeight,
          borderWidth,
          scroll_theme,
          $submenu = $menuItem.children("ul:first"),
          ul = $submenu.clone(true);
        menuHeaderHeight = $(".main-menu-header").height();
        menutop = $menuItem.position().top;
        winHeight = $window.height() - $(".header-navbar").height();
        borderWidth = 0;
        subMenuHeight = $submenu.height();

        if (parseInt($menuItem.css("border-top"), 10) > 0) {
          borderWidth = parseInt($menuItem.css("border-top"), 10);
        }

        popOutMenuHeight = winHeight - menutop - $menuItem.height() - 30;
        scroll_theme = $(".main-menu").hasClass("menu-dark") ? "light" : "dark";
        topPos = menutop + $menuItem.height() + borderWidth;
        ul.addClass("menu-popout").appendTo(".main-menu-content").css({
          top: topPos,
          position: "fixed",
          "max-height": popOutMenuHeight
        });
        var menu_content = new PerfectScrollbar(".main-menu-content > ul.menu-content", {
          wheelPropagation: false
        });
      },
      collapse: function collapse($listItem, callback) {
        var $subList = $listItem.children("ul");
        $subList.show().slideUp($.app.nav.config.speed, function () {
          $(this).css("display", "");
          $(this).find("> li").removeClass("is-shown");

          if (callback) {
            callback();
          }

          $.app.nav.container.trigger("collapsed.app.menu");
        });
      },
      expand: function expand($listItem, callback) {
        var $subList = $listItem.children("ul");
        var $children = $subList.children("li").addClass("is-hidden");
        $subList.hide().slideDown($.app.nav.config.speed, function () {
          $(this).css("display", "");

          if (callback) {
            callback();
          }

          $.app.nav.container.trigger("expanded.app.menu");
        });
        setTimeout(function () {
          $children.addClass("is-shown");
          $children.removeClass("is-hidden");
        }, 0);
      },
      refresh: function refresh() {
        $.app.nav.container.find(".open").removeClass("open");
      }
    };

    window.addEventListener('resize', function () {
      //$.app.nav.bind_events();
      $.app.menu.manualScroller.updateHeight(); // To show shadow in main menu when menu scrolls

      var container = document.getElementsByClassName("main-menu-content");
      let compactMenu = false;
      if (container.length > 0) {
        container[0].addEventListener("ps-scroll-y", function () {
          if ($(this).find(".ps__thumb-y").position().top > 0) {
            $(".shadow-bottom").css("display", "block");
          } else {
            $(".shadow-bottom").css("display", "none");
          }
        });
      }
      $.app.menu.change(compactMenu);
    })
  }

  applyGeneralAppConfiguration() {
    window.dispatchEvent(new Event("resize"));
    var $body = $("body");
    var assetPath = '../../../app-assets/';
    if ($body.attr('data-framework') === 'laravel') {
      var assetPath = $('html').attr('data-asset-path');
    }

    function scrollTopFn() {
      var $scrollTop = $(window).scrollTop();
      if ($scrollTop > 20) {
        // laravel specific code
        if ($('.main-header-navbar').attr('data-bgcolor') !== 'bg-white') {
          $('.navbar-sticky .main-header-navbar').addClass($('.main-header-navbar').attr('data-bgcolor'));
        }

        $("body").addClass("page-scrolled navbar-scrolled");
      } else {
        $("body").removeClass("page-scrolled navbar-scrolled");
      }
    }

    $(window).on('scroll', function () {
      scrollTopFn();
    });
    $(document).on("click", ".sidenav-overlay", function (e) {
      // Hide menu
      $.app.menu.hide();
      return false;
    }); // Execute below code only if we find hammer js for touch swipe feature on small screen
    //.off()
    $(".menu-toggle, .modern-nav-toggle").off().on("click", function (e) {
      e.preventDefault()// Toggle menu
      $.app.menu.toggle();
      setTimeout(function () {
        //window.dispatchEvent(new Event("resize"));
      }, 200);

      if ($("#collapsed-sidebar").length > 0) {
        setTimeout(function () {
          if ($body.hasClass("menu-expanded") || $body.hasClass("menu-open")) {
            $("#collapsed-sidebar").prop("checked", false);
          } else {
            $("#collapsed-sidebar").prop("checked", true);
          }
        }, 1000);
      } // Hides dropdown on click of menu toggle
      // $('[data-toggle="dropdown"]').dropdown('hide');
      // Hides collapse dropdown on click of menu toggle


      if ($(".vertical-overlay-menu .navbar-with-menu .navbar-container .navbar-collapse").hasClass("show")) {
        $(".vertical-overlay-menu .navbar-with-menu .navbar-container .navbar-collapse").removeClass("show");
      }

      return false;
    }); // Add Children Class

    $(".navigation").find("li").has("ul").addClass("has-sub");
    $(".carousel").carousel({
      interval: 2000
    }); // Page full screen

    $(".nav-link-expand").on("click", function (e) {
      if (typeof screenfull != "undefined") {
        if (screenfull.isEnabled) {
          screenfull.toggle();
        }
      }
    });

    if (typeof screenfull != "undefined") {
      if (screenfull.isEnabled) {
        $(document).on(screenfull.raw.fullscreenchange, function () {
          if (screenfull.isFullscreen) {
            $(".nav-link-expand").find("i").toggleClass("bx-exit-fullscreen bx-fullscreen");
            $("html").addClass("full-screen");
          } else {
            $(".nav-link-expand").find("i").toggleClass("bx-fullscreen bx-exit-fullscreen");
            $("html").removeClass("full-screen");
          }
        });
      }
    }

    $(document).ready(function () {
      /**********************************
       *   Form Wizard Step Icon
       **********************************/
      $(".step-icon").each(function () {
        var $this = $(this);

        if ($this.siblings("span.step").length > 0) {
          $this.siblings("span.step").empty();
          $(this).appendTo($(this).siblings("span.step"));
        }
      });
    }); // Update manual scroller when window is resized

    $("#sidebar-page-navigation").on("click", "a.nav-link", function (e) {
      e.preventDefault();
      e.stopPropagation();
      $('[data-toggle="popover"]').popover('hide');
      var $this = $(this),
        href = $this.attr("href");
      var offset = $(href).offset();
      var scrollto = offset.top - 80; // minus fixed header height

      $("html, body").animate({
        scrollTop: scrollto
      }, 0);
      setTimeout(function () {
        $this.parent(".nav-item").siblings(".nav-item").children(".nav-link").removeClass("active");
        $this.addClass("active");
      }, 100);
    }); // main menu internationalization
    // init i18n and load language file

    /********************* Bookmark & Search ***********************/
      // This variable is used for mouseenter and mouseleave events of search list


    var $filename = $(".search-input input").data("search"); // Bookmark icon click

    $(".bookmark-wrapper .bookmark-star").on("click", function (e) {
      e.stopPropagation();
      $('[data-toggle="popover"]').popover('hide');
      $(".bookmark-wrapper .bookmark-input").toggleClass("show");
      $(".bookmark-wrapper .bookmark-input input").val("");
      $(".bookmark-wrapper .bookmark-input input").blur();
      $(".bookmark-wrapper .bookmark-input input").focus();
      $(".bookmark-wrapper .search-list").addClass("show");
      var arrList = $("ul.nav.navbar-nav.bookmark-icons li"),
        $arrList = "",
        $activeItemClass = "";
      $("ul.search-list li").remove();

      for (var i = 0; i < arrList.length; i++) {
        if (i === 0) {
          $activeItemClass = "current_item";
        } else {
          $activeItemClass = "";
        }

        $arrList += '<li class="auto-suggestion d-flex align-items-center justify-content-between cursor-pointer ' + $activeItemClass + '">' + '<a class="d-flex align-items-center justify-content-between w-100" href=' + arrList[i].firstChild.href + ">" + '<div class="d-flex justify-content-start">' + '<span class="mr-75 ' + arrList[i].firstChild.firstChild.className + '"  data-icon="' + arrList[i].firstChild.firstChild.className + '"></span>' + "<span>" + arrList[i].firstChild.dataset.originalTitle + "</span>" + "</div>" + '<span class="float-right bookmark-icon bx bx-star warning"></span>' + "</a>" + "</li>";
      }

      $("ul.search-list").append($arrList);
    }); // Navigation Search area Open

    $(".nav-link-search").on("click", function () {
      var $this = $(this);
      var searchInput = $(this).parent(".nav-search").find(".search-input");
      searchInput.val('');
      searchInput.addClass("open");
      $(".search-input input").focus();
      $(".search-input .search-list li").remove();
      $(".search-input .search-list").addClass("show");
      $(".bookmark-wrapper .bookmark-input").removeClass("show");
    }); // Navigation Search area Close

    $(".search-input-close i").on("click", function () {
      var $this = $(this),
        searchInput = $(this).closest(".search-input");

      if (searchInput.hasClass("open")) {
        searchInput.removeClass("open");
        $(".search-input input").val("");
        $(".search-input input").blur();
        $(".search-input .search-list").removeClass("show");

        if ($(".app-content").hasClass("show-overlay")) {
          $(".app-content").removeClass("show-overlay");
        }
      }
    }); // Navigation Search area Close on click of app-content

    $(".app-content").on("click", function () {
      var $this = $(".search-input-close"),
        searchInput = $($this).parent(".search-input");

      if (searchInput.hasClass("open")) {
        searchInput.removeClass("open");
      }
    }); // Filter

    // Header Notification Dropdown Remains Opened on click of switch Label

    $(".header-navbar .dropdown-notification label").on("click", function (e) {
      e.stopPropagation();
      $('[data-toggle="popover"]').popover('hide');
    });

    //////////////////////// window load event code in vue mounted hook//////////
    //var $body = $("body");
    //var $window = $(window);
    var $html = $("html");
    var rtl;
    var compactMenu = false; // Set it to true, if you want default menu to be compact

    if ($body.hasClass("menu-collapsed")) {
      compactMenu = true;
    }
    if ($("html").data("textdirection") == "rtl") {
      rtl = true;
    }

    setTimeout(function () {
      $html.removeClass("loading").addClass("loaded");
    }, 1200);
    $.app.menu.init(compactMenu); // Livioncs are initialized for vertical menu

    $.each($(".menu-livicon"), function (i) {
      var $this = $(this),
        icon = $this.data("icon"),
        iconStyle = $("#main-menu-navigation").data("icon-style");
      $this.addLiviconEvo({
        name: icon,
        style: iconStyle,
        duration: 0.85,
        strokeWidth: "1.3px",
        eventOn: "none",
        strokeColor: menuIconColorsObj.iconStrokeColor,
        solidColor: menuIconColorsObj.iconSolidColor,
        fillColor: menuIconColorsObj.iconFillColor,
        strokeColorAlt: menuIconColorsObj.iconStrokeColorAlt,
        afterAdd: function afterAdd() {
          if (i === $(".main-menu-content .menu-livicon").length - 1) {
            // When hover over any menu item, start animation and stop all other animation
            $(".main-menu-content .nav-item a").on("mouseenter", function () {
              if ($(".main-menu-content .menu-livicon").length) {
                $(".main-menu-content .menu-livicon").stopLiviconEvo();
                $(this).find(".menu-livicon").playLiviconEvo();
              }
            });
          }
        }
      });
    });

    function updateLivicon(el) {
      el.updateLiviconEvo({
        strokeColor: menuActiveIconColorsObj.iconStrokeColor,
        solidColor: menuActiveIconColorsObj.iconSolidColor,
        fillColor: menuActiveIconColorsObj.iconFillColor,
        strokeColorAlt: menuActiveIconColorsObj.iconStrokeColorAlt
      });
    } // Navigation configurations


    var config = {
      speed: 300 // set speed to expand / collpase menu

    };

    if ($.app.nav.initialized === false) {
      $.app.nav.init(config);
    }

    /* window.on("resize", function (bp) {

     });*/ // Tooltip Initialization

    $('[data-toggle="tooltip"]').tooltip({
      container: "body"
    }); // Tooltip For Horizontal Layout - Bookmark Icons

    /!* tooltip-horizontal-bookmark - Add Custom Class *!/

    $(".tooltip-horizontal-bookmark").tooltip({
      customClass: "tooltip-horizontal-bookmark"
    }); // Collapsible Card

    $('a[data-action="collapse"]').on("click", function (e) {
      e.preventDefault();
      $(this).closest(".card").children(".card-content").collapse("toggle"); // Adding bottom padding on card collapse

      $(this).closest(".card").children(".card-header").css("padding-bottom", "1.5rem");
      $(this).closest(".card").find('[data-action="collapse"]').toggleClass("rotate");
    }); // Toggle fullscreen

    $('a[data-action="expand"]').on("click", function (e) {
      e.preventDefault();
      $(this).closest(".card").find('[data-action="expand"] i').toggleClass("bx-fullscreen bx-exit-fullscreen");
      $(this).closest(".card").toggleClass("card-fullscreen");
    }); //  Notifications & messages scrollable

    $(".scrollable-container").each(function () {
      var scrollable_container = new PerfectScrollbar($(this)[0], {
        wheelPropagation: false
      });
    }); // Reload Card

    $('a[data-action="reload"]').on("click", function () {
      var block_ele = $(this).closest(".card").find(".card-content");
      var reloadActionOverlay;

      if ($body.hasClass("dark-layout")) {
        var reloadActionOverlay = "#10163a";
      } else {
        var reloadActionOverlay = "#fff";
      } // Block Element


      block_ele.block({
        message: '<div class="bx bx-sync icon-spin font-medium-2 text-primary"></div>',
        timeout: 2000,
        //unblock after 2 seconds
        overlayCSS: {
          backgroundColor: reloadActionOverlay,
          cursor: "wait"
        },
        css: {
          border: 0,
          padding: 0,
          backgroundColor: "none"
        }
      });
    }); // Close Card

    $('a[data-action="close"]').on("click", function () {
      $(this).closest(".card").removeClass().slideUp("fast");
    }); // Match the height of each card in a row

    setTimeout(function () {
      $(".row.match-height").each(function () {
        $(this).find(".card").not(".card .card").matchHeight(); // Not .card .card prevents collapsible cards from taking height
      });
    }, 500);
    $('.card .heading-elements a[data-action="collapse"]').on("click", function () {
      var $this = $(this),
        card = $this.closest(".card");
      var cardHeight;

      if (parseInt(card[0].style.height, 10) > 0) {
        cardHeight = card.css("height");
        card.css("height", "").attr("data-height", cardHeight);
      } else {
        if (card.data("height")) {
          cardHeight = card.data("height");
          card.css("height", cardHeight).attr("data-height", "");
        }
      }
    }); // Add sidebar group active class to active menu

    $(".main-menu-content").find("li.active").parents("li").addClass("sidebar-group-active"); // Update Active Menu item Icon with active color

    if ($(".nav-item.active .menu-livicon").length) {
      updateLivicon($(".nav-item.active .menu-livicon"));
    } // Update Active sidebar group menu icon with active ccolor


    if ($(".main-menu-content li.sidebar-group-active .menu-livicon").length) {
      updateLivicon($(".main-menu-content li.sidebar-group-active .menu-livicon"));
    } // Add open class to parent list item if subitem is active except compact menu


    var menuType = $body.data("menu");

    if (menuType != "horizontal-menu" && compactMenu === false) {
      $(".main-menu-content").find("li.active").parents("li").addClass("open");
    }

    if (menuType == "horizontal-menu") {
      $(".main-menu-content").find("li.active").parents("li:not(.nav-item)").addClass("open");
      $(".main-menu-content").find("li.active").parents("li").addClass("active");
    } //card heading actions buttons small screen support


    $(".heading-elements-toggle").on("click", function () {
      $(this).next(".heading-elements").toggleClass("visible");
    }); //  Dynamic height for the chartjs div for the chart animations to work

    var chartjsDiv = $(".chartjs"),
      canvasHeight = chartjsDiv.children("canvas").attr("height");
    chartjsDiv.css("height", canvasHeight);

    if ($body.hasClass("boxed-layout")) {
      if ($body.hasClass("vertical-overlay-menu")) {
        var menuWidth = $(".main-menu").width();
        var contentPosition = $(".app-content").position().left;
        var menuPositionAdjust = contentPosition - menuWidth;

        if ($body.hasClass("menu-flipped")) {
          $(".main-menu").css("right", menuPositionAdjust + "px");
        } else {
          $(".main-menu").css("left", menuPositionAdjust + "px");
        }
      }
    } //Custom File Input


    $(".custom-file input").change(function (e) {
      $(this).next(".custom-file-label").html(e.target.files[0].name);
    });
    /!* Text Area Counter Set Start *!/

    $(".char-textarea").on("keyup", function (event) {
      checkTextAreaMaxLength(this, event); // to later change text color in dark layout

      $(this).addClass("active");
    });

    // Checks the MaxLength of the Textarea
    // -----------------------------------------------------
    // @prerequisite:  textBox = textarea dom element
    //         e = textarea event
    //                 length = Max length of characters


    function checkTextAreaMaxLength(textBox, e) {
      var maxLength = parseInt($(textBox).data("length"));

      if (!checkSpecialKeys(e)) {
        if (textBox.value.length < maxLength - 1) textBox.value = textBox.value.substring(0, maxLength);
      }

      $(".char-count").html(textBox.value.length);

      if (textBox.value.length > maxLength) {
        $(".counter-value").css("background-color", $danger);
        $(".char-textarea").css("color", $danger); // to change text color after limit is maxedout out

        $(".char-textarea").addClass("max-limit");
      } else {
        $(".counter-value").css("background-color", $primary);
        $(".char-textarea").css("color", $textcolor);
        $(".char-textarea").removeClass("max-limit");
      }

      return true;
    }

    // Checks if the keyCode pressed is inside special chars
    // -------------------------------------------------------
    // @prerequisite:  e = e.keyCode object for the key pressed


    function checkSpecialKeys(e) {
      if (e.keyCode != 8 && e.keyCode != 46 && e.keyCode != 37 && e.keyCode != 38 && e.keyCode != 39 && e.keyCode != 40) return false; else return true;
    }

    $(".content-overlay").on("click", function () {
      $(".search-list").removeClass("show");
      $(".app-content").removeClass("show-overlay");
      $(".bookmark-wrapper .bookmark-input").removeClass("show");
    }); // To show shadow in main menu when menu scrolls

    var container = document.getElementsByClassName("main-menu-content");

    if (container.length > 0) {
      container[0].addEventListener("ps-scroll-y", function () {
        if ($(this).find(".ps__thumb-y").position().top > 0) {
          $(".shadow-bottom").css("display", "block");
        } else {
          $(".shadow-bottom").css("display", "none");
        }
      });
    }
  }

  init() {
    this.applyInitialConfiguration();
    this.applyGeneralAppConfiguration();
  }

  menuCollapse() {
    let $body = $('body');
    if ($body.hasClass("menu-collapsed") && $body.data("menu") == "vertical-menu-modern") {
      setTimeout(function () {
        if ($(".main-menu:hover").length === 0 && $(".navbar-header:hover").length === 0) {
          $(".main-menu, .navbar-header").removeClass("expanded");

          if ($body.hasClass("menu-collapsed")) {
            var $listItem = $(".main-menu li.open"),
              $subList = $listItem.children("ul");
            $listItem.addClass("menu-collapsed-open");
            $subList.show().slideUp(200, function () {
              $(this).css("display", "");
            });
            $listItem.removeClass("open"); // $.app.menu.changeLogo();
          }
        }
      }, 1);
    }
  }

  menuExpand() {
    let $body = $('body');
    if ($body.data("menu") == "vertical-menu-modern") {
      $(".main-menu, .navbar-header").addClass("expanded");

      if ($body.hasClass("menu-collapsed")) {
        if ($(".main-menu li.open").length === 0) {
          $(".main-menu-content").find("li.active").parents("li").addClass("open");
        }

        var $listItem = $(".main-menu li.menu-collapsed-open"),
          $subList = $listItem.children("ul");
        $subList.hide().slideDown(200, function () {
          $(this).css("display", "");
        });
        $listItem.addClass("open").removeClass("menu-collapsed-open"); // $.app.menu.changeLogo('expand');
      }
    }
  }

}
