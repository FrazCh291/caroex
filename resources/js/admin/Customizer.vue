<template>

  <div class="customizer-content p-2">
  <h4 class="text-uppercase mb-0">Theme Customizer</h4>
  <small>Customize & Preview in Real Time</small>
  <a class="customizer-close" href="#"><i class="bx bx-x"></i></a>
  <hr>
  <!-- Theme options starts -->
  <h5 class="mt-1">Theme Layout</h5>
  <div class="theme-layouts">
    <div class="d-flex justify-content-start">
      <div class="mx-50">
        <fieldset>
          <div class="radio">
            <input type="radio" name="layoutOptions" value="false" id="radio-light" class="layout-name" data-layout=""
              checked>
            <label for="radio-light">Light</label>
          </div>
        </fieldset>
      </div>
      <div class="mx-50">
        <fieldset>
          <div class="radio">
            <input type="radio" name="layoutOptions" value="false" id="radio-dark" class="layout-name"
              data-layout="dark-layout">
            <label for="radio-dark">Dark</label>
          </div>
        </fieldset>
      </div>
      <div class="mx-50">
        <fieldset>
          <div class="radio">
            <input type="radio" name="layoutOptions" value="false" id="radio-semi-dark" class="layout-name"
              data-layout="semi-dark-layout">
            <label for="radio-semi-dark">Semi Dark</label>
          </div>
        </fieldset>
      </div>
    </div>
  </div>
  <!-- Theme options starts -->
  <hr>

  <!-- Menu Colors Starts -->
  <div id="customizer-theme-colors">
    <h5>Menu Colors</h5>
    <ul class="list-inline unstyled-list">
      <li class="color-box bg-primary selected" data-color="theme-primary"></li>
      <li class="color-box bg-success" data-color="theme-success"></li>
      <li class="color-box bg-danger" data-color="theme-danger"></li>
      <li class="color-box bg-info" data-color="theme-info"></li>
      <li class="color-box bg-warning" data-color="theme-warning"></li>
      <li class="color-box bg-dark" data-color="theme-dark"></li>
    </ul>
    <hr>
  </div>
  <!-- Menu Colors Ends -->
  <!-- Menu Icon Animation Starts -->
  <div id="menu-icon-animation">
    <div class="d-flex justify-content-between align-items-center">
      <div class="icon-animation-title">
        <h5 class="pt-25">Icon Animation</h5>
      </div>
      <div class="icon-animation-switch">
        <div class="custom-control custom-switch">
          <input type="checkbox" class="custom-control-input" checked id="icon-animation-switch">
          <label class="custom-control-label" for="icon-animation-switch"></label>
        </div>
      </div>
    </div>
    <hr>
  </div>
  <!-- Menu Icon Animation Ends -->
  <!-- Collapse sidebar switch starts -->
  <div class="collapse-sidebar d-flex justify-content-between align-items-center">
    <div class="collapse-option-title">
      <h5 class="pt-25">Collapse Menu</h5>
    </div>
    <div class="collapse-option-switch">
      <div class="custom-control custom-switch">
        <input type="checkbox" class="custom-control-input" id="collapse-sidebar-switch">
        <label class="custom-control-label" for="collapse-sidebar-switch"></label>
      </div>
    </div>
  </div>
  <!-- Collapse sidebar switch Ends -->
  <hr>

  <!-- Navbar colors starts -->
<div id="customizer-navbar-colors">
    <h5>Navbar Colors</h5>
    <ul class="list-inline unstyled-list">
      <li class="color-box bg-white border selected" data-navbar-default=""></li>
      <li class="color-box bg-primary" data-navbar-color="bg-primary"></li>
      <li class="color-box bg-success" data-navbar-color="bg-success"></li>
      <li class="color-box bg-danger" data-navbar-color="bg-danger"></li>
      <li class="color-box bg-info" data-navbar-color="bg-info"></li>
      <li class="color-box bg-warning" data-navbar-color="bg-warning"></li>
      <li class="color-box bg-dark" data-navbar-color="bg-dark"></li>
    </ul>
    <small><strong>Note :</strong> This option with work only on sticky navbar when you scroll page.</small>
    <hr>
  </div>
  <!-- Navbar colors starts -->
  <!-- Navbar Type Starts -->
  <h5>Navbar Type</h5>
  <div class="navbar-type d-flex justify-content-start">
    <div class="hidden-ele mx-50">
      <fieldset>
        <div class="radio">
          <input type="radio" name="navbarType" value="false" id="navbar-hidden">
          <label for="navbar-hidden">Hidden</label>
        </div>
      </fieldset>
    </div>
    <div class="mx-50">
      <fieldset>
        <div class="radio">
          <input type="radio" name="navbarType" value="false" id="navbar-static">
          <label for="navbar-static">Static</label>
        </div>
      </fieldset>
    </div>
    <div class="mx-50">
      <fieldset>
        <div class="radio">
          <input type="radio" name="navbarType" value="false" id="navbar-sticky" checked>
          <label for="navbar-sticky">Fixed</label>
        </div>
      </fieldset>
    </div>
  </div>
  <hr>
  <!-- Navbar Type Starts -->

  <!-- Footer Type Starts -->
  <h5>Footer Type</h5>
  <div class="footer-type d-flex justify-content-start">
    <div class="mx-50">
      <fieldset>
        <div class="radio">
          <input type="radio" name="footerType" value="false" id="footer-hidden">
          <label for="footer-hidden">Hidden</label>
        </div>
      </fieldset>
    </div>
    <div class="mx-50">
      <fieldset>
        <div class="radio">
          <input type="radio" name="footerType" value="false" id="footer-static" checked>
          <label for="footer-static">Static</label>
        </div>
      </fieldset>
    </div>
    <div class="mx-50">
      <fieldset>
        <div class="radio">
          <input type="radio" name="footerType" value="false" id="footer-sticky">
          <label for="footer-sticky" class="">Sticky</label>
        </div>
      </fieldset>
    </div>
  </div>
  <!-- Footer Type Ends -->
  <hr>

  <!-- Card Shadow Starts-->
  <div class="card-shadow d-flex justify-content-between py-25 align-items-center">
    <div class="hide-scroll-title">
      <h5 class="pt-25">Card Shadow</h5>
    </div>
    <div class="card-shadow-switch">
      <div class="custom-control custom-switch">
        <input type="checkbox" class="custom-control-input" checked id="card-shadow-switch">
        <label class="custom-control-label" for="card-shadow-switch"></label>
      </div>
    </div>
  </div>
  <!-- Card Shadow Ends-->
  <hr>

  <!-- Hide Scroll To Top Starts-->
  <div class="hide-scroll-to-top d-flex justify-content-between align-items-center py-25">
    <div class="hide-scroll-title">
      <h5 class="pt-25">Hide Scroll To Top</h5>
    </div>
    <div class="hide-scroll-top-switch">
      <div class="custom-control custom-switch">
        <input type="checkbox" class="custom-control-input" id="hide-scroll-top-switch">
        <label class="custom-control-label" for="hide-scroll-top-switch"></label>
      </div>
    </div>
  </div>
  <!-- Hide Scroll To Top Ends-->
</div>



</template>
<script>

export default {
    name: "Customizer",
  mounted(){

    var themeColor = {
      "theme-primary": "rgba(90, 141, 238, 0.2)",
      "theme-success": "rgba(57, 218, 138, 0.2)",
      "theme-danger": "rgba(255, 91, 92, 0.2)",
      "theme-info": "rgba(0, 207, 221, 0.2)",
      "theme-warning": "rgba(253, 172, 65, 0.2)",
      "theme-dark": "rgba(57, 76, 98, 0.2)",
    };
    // main menu active box shadow object
    var themeBoxShadow = {
      "theme-primary": "0 0 10px 1px rgba(90, 141, 238, 0.2)",
      "theme-success": "0 0 10px 1px rgba(57, 218, 138, 0.2)",
      "theme-danger": "0 0 10px 1px rgba(255, 91, 92, 0.2)",
      "theme-info": "0 0 10px 1px rgba(0, 207, 221, 0.2)",
      "theme-warning": "0 0 10px 1px rgba(253, 172, 65, 0.2)",
      "theme-dark": "0 0 10px 1px rgba(57, 76, 98, 0.2)",
    };
    // colors for navbar header text of main menu
    var currentColor = {
      "theme-default": "#FFFFFF",
      "theme-primary": "#5A8DEE",
      "theme-success": "#39DA8A",
      "theme-danger": "#FF5B5C",
      "theme-info": "#00CFDD",
      "theme-warning": "#FDAC41",
      "theme-dark": "#394C62",
    };
    // Brand Logo Poisitons
    var LogoPosition = {
      "theme-primary": "-65px -54px",
      "theme-success": "-120px -10px",
      "theme-danger": "-10px -10px",
      "theme-info": "-10px -54px",
      "theme-warning": "-120px -54px",
      "theme-dark": "-65px -10px",
    };

    var body = $("body"),
        mainMenu = $(".main-menu"),
        mainMenuContent = $(".menu-content"),
        footer = $(".footer"),
        navbar = $(".header-navbar"),
        mainHeaderNavbar = $(".main-header-navbar"),
        navBarShadow = $(".header-navbar-shadow"),
        toggleIcon = $(".toggle-icon"),
        collapseSidebar = $("#collapse-sidebar-switch"),
        iconAnimation = $("#icon-animation-switch"),
        customizer = $(".customizer");

    // Customizer toggle & close button click events  [Remove customizer code from production]
    $(".customizer-toggle").on("click", function (e) {
      e.preventDefault();
      $(customizer).toggleClass("open");
    });
    $(".customizer-close").on("click", function () {
      $(customizer).removeClass("open");
    });

    // perfect scrollbar for customizer
    if ($(".customizer-content").length > 0) {
      var customizer_content = new PerfectScrollbar(".customizer-content", {
        wheelPropagation: false,
      });
    }

    /***** Theme Colors Options *****/
    $(document).on("click", "#customizer-theme-colors .color-box", function () {
      var $this = $(this);
      $this.siblings().removeClass("selected");
      $this.addClass("selected");
      var selectedColor = $(this).data("color"),
          changeColor = themeColor[selectedColor],
          selectedShadow = themeBoxShadow[selectedColor],
          selectedTextColor = currentColor[selectedColor],
          selectedLogo = LogoPosition[selectedColor];

      // Update livicon colors
      function updateLivicon(el) {
        el.updateLiviconEvo({
          strokeColor: selectedTextColor,
          solidColor: selectedTextColor,
          fillColor: selectedTextColor,
          strokeColorAlt: selectedTextColor,
        });
      }

      // main-menu
      if (mainMenuContent.find("li.active").length) {
        mainMenuContent.find("li.active a").css({
          color: selectedTextColor,
        });
        mainMenuContent.find("li.active a > i").css({
          color: selectedTextColor,
        });
        mainMenuContent.find("li.active a span.menu-item").css({
          color: selectedTextColor,
        });
        mainMenuContent.find("li.active").css({
          background: changeColor,
          "border-color": selectedTextColor,
        });
        // Update Active Menu item Icon with active color
        if ($("li.sidebar-group-active .menu-livicon").length) {
          updateLivicon($("li.sidebar-group-active .menu-livicon"));
        }
      } else {
        mainMenu.find(".nav-item.active a").css({
          background: changeColor,
          color: selectedTextColor,
        });
        mainMenu.find(".nav-item.active a .menu-title").css({
          color: selectedTextColor,
        });
        // Update Active Menu item Icon with active color
        if ($(".nav-item.active .menu-livicon").length) {
          updateLivicon($(".nav-item.active .menu-livicon"));
        }
      }
    });

    /***** Theme Layout Options *****/
    $(".layout-name").on("click", function () {
      var $this = $(this);
      var currentLayout = $this.data("layout"),
          mainMenu = $(".main-menu");
      body.removeClass("dark-layout semi-dark-layout").addClass(currentLayout);
      if (currentLayout === "") {
        mainMenu.removeClass("menu-dark").addClass("menu-light");
        navbar.removeClass("navbar-dark").addClass("navbar-light");
      }
      if (body.hasClass("dark-layout")) {
        mainMenu.removeClass("menu-light").addClass("menu-dark");
        navbar.removeClass("navbar-light").addClass("navbar-dark");
      }
      if (body.hasClass("semi-dark-layout")) {
        mainMenu.removeClass("menu-light").addClass("menu-dark");
        navbar.removeClass("navbar-dark").addClass("navbar-light");
      }
    });

    // checks right radio if layout type matches
    var layout = body.data("layout");
    $(".layout-name[data-layout='" + layout + "']").prop("checked", true);

    /***** icon animation switch *****/
    iconAnimation.on("click", function () {
      if ($(this).is(":checked")) {
        $("#main-menu-navigation .menu-livicon").updateLiviconEvo({
          animated: true,
        });
      } else {
        $("#main-menu-navigation .menu-livicon").updateLiviconEvo({
          animated: false,
        });
      }
    });

    /***** Collapse menu switch *****/
    collapseSidebar.on("click", function () {
      if ($(body).hasClass("menu-expanded")) {
        body.removeClass("menu-expanded").addClass("menu-collapsed");
        mainMenu.removeClass("expanded");
        mainMenu
            .find(".sidebar-group-active")
            .removeClass("open")
            .addClass("menu-collapsed-open");
        toggleIcon.removeClass("bx bx-disc").addClass("bx bx-circle");
      } else {
        body.removeClass("menu-collapsed").addClass("menu-expanded");
        mainMenu.find(".sidebar-group-active").addClass("open");
        toggleIcon.removeClass("bx bx-circle").addClass("bx bx-disc");
      }
    });
    // connects toggle icon with collapse sidebar switch
    toggleIcon.on("click", function () {
      collapseSidebar.prop("checked", !collapseSidebar.prop("checked"));
    });

    // checks if main menu is collapsed by default
    if (body.hasClass("menu-collapsed")) {
      collapseSidebar.prop("checked", true);
    } else {
      collapseSidebar.prop("checked", false);
    }

    /***** Navbar Color Options *****/
    if ($(body).hasClass("horizontal-layout")) {
      $("#customizer-navbar-colors .color-box.bg-white")
          .removeClass("selected")
          .hide();
      $("#customizer-navbar-colors .color-box.bg-primary").addClass("selected");
      $("#customizer-theme-colors").hide();
      $(".navbar-type .hidden-ele").hide();
    }
    if ($(body).hasClass("navbar-static")) {
      $("#navbar-static").attr("checked", "true");
    }
    if ($(body).hasClass("boxicon-layout")) {
      $("#menu-icon-animation").hide();
    }
    $("#customizer-navbar-colors .color-box").on("click", function () {
      var $this = $(this);
      $this.siblings().removeClass("selected");
      $this.addClass("selected");
      var navbarColor = $this.data("navbar-color");
      if ($(body).hasClass("vertical-layout")) {
        if ($(window).scrollTop() > 20) {
          // changes navbar colors
          if (navbarColor) {
            $(".vertical-layout")
                .find(navbar)
                .removeClass(
                    "bg-primary bg-success bg-danger bg-info bg-warning bg-dark navbar-light"
                )
                .addClass(navbarColor + " navbar-dark");
          } else {
            $(".vertical-layout.navbar-sticky")
                .find(navbar)
                .addClass("navbar-light")
                .removeClass("navbar-dark")
                .removeClass(
                    "bg-primary bg-success bg-danger bg-info bg-warning bg-white bg-dark navbar-dark"
                );
          }
          if (body.hasClass("dark-layout")) {
            navbar.addClass("navbar-dark");
          }
        }
      } else {
        if (navbarColor) {
          $(".horizontal-layout")
              .find(".navbar-with-menu")
              .removeClass(
                  "bg-primary bg-success bg-danger bg-info bg-warning bg-dark"
              )
              .addClass(navbarColor);
        }
      }
    });

    /***** Navbar Color On Scroll *****/
    $(window).scroll(function () {
      var navbarActiveColor = $(
          "#customizer-navbar-colors .color-box.selected"
      ).data("navbar-color");
      if ($(this).scrollTop() < 20) {
        $(".vertical-layout.navbar-sticky")
            .find(mainHeaderNavbar)
            .removeClass(
                "bg-primary bg-success bg-danger bg-info bg-warning bg-white bg-dark navbar-dark"
            );
      } else {
        if (navbarActiveColor) {
          $(".vertical-layout.navbar-sticky")
              .find(mainHeaderNavbar)
              .removeClass(
                  "bg-primary bg-success bg-danger bg-info bg-warning bg-white bg-dark navbar-dark"
              )
              .addClass(navbarActiveColor + " navbar-dark");
        }
      }
    });

    /***** Navbar Type *****/
    if ($(body).hasClass("horizontal-layout")) {
      navbar = $(".header-navbar.navbar-with-menu");
      var navbarHorizontal = $(".header-navbar.navbar-horizontal");

      // changes to Static navbar
      $("#navbar-static").on("click", function () {
        navBarShadow.addClass("d-none");
        navbar
            .removeClass("d-none floating-nav fixed-top navbar-fixed")
            .addClass("navbar-static-top");
        body
            .removeClass("navbar-hidden navbar-floating navbar-sticky")
            .addClass("navbar-static");
        navbarHorizontal
            .removeClass("d-none floating-nav fixed-top navbar-fixed")
            .addClass("navbar-sticky");
      });
      // changes to Static navbar
      $("#navbar-sticky").on("click", function () {
        navBarShadow.addClass("d-none");
        navbar
            .removeClass("d-none floating-nav navbar-static-top")
            .addClass("fixed-top");
        body
            .removeClass("navbar-static navbar-floating navbar-hidden")
            .addClass("navbar-sticky");
      });
    } else {
      // Hides Navbar
      $("#navbar-hidden").on("click", function () {
        navbar.addClass("d-none");
        navBarShadow.addClass("d-none");
        body
            .removeClass("navbar-static navbar-floating navbar-sticky")
            .addClass("navbar-hidden");
      });
      // changes to Static navbar
      $("#navbar-static").on("click", function () {
        navBarShadow.addClass("d-none");
        navbar
            .removeClass(
                "bg-primary bg-success bg-danger bg-info bg-warning bg-white bg-dark navbar-dark"
            )
            .removeClass("d-none floating-nav fixed-top")
            .addClass("navbar-static-top");
        body
            .removeClass("navbar-hidden navbar-floating navbar-sticky")
            .addClass("navbar-static");
      });
      // changes to Static navbar
      $("#navbar-sticky").on("click", function () {
        navBarShadow.addClass("d-none");
        navbar
            .removeClass("d-none floating-nav navbar-static-top")
            .addClass("fixed-top");
        body
            .removeClass("navbar-static navbar-floating navbar-hidden")
            .addClass("navbar-sticky");
      });
    }

    /***** Footer Type *****/
    // Hides footer
    $("#footer-hidden").on("click", function () {
      footer.addClass("d-none");
      body.removeClass("footer-static fixed-footer").addClass("footer-hidden");
    });
    // changes to Static footer
    $("#footer-static").on("click", function () {
      body.removeClass("fixed-footer");
      footer.removeClass("d-none").addClass("footer-static");
      body.removeClass("footer-hidden fixed-footer").addClass("footer-static");
    });
    // changes to Sticky footer
    $("#footer-sticky").on("click", function () {
      body.removeClass("footer-static footer-hidden").addClass("fixed-footer");
      footer.removeClass("d-none footer-static");
    });

    /***** Card Shadow Starts *****/
    $("#card-shadow-switch").on("click", function () {
      body.toggleClass("no-card-shadow");
    });

    /***** Hide Scroll To Top *****/
    $("#hide-scroll-top-switch").on("click", function () {
      var scrollTopBtn = $(".scroll-top");
      if ($(this).prop("checked")) {
        scrollTopBtn.addClass("d-none");
      } else {
        scrollTopBtn.removeClass("d-none");
      }
    });
  }
}
</script>
