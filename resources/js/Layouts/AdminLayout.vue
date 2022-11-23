<template>
  <div>
    <Header></Header>
    <SideBar></SideBar>
    <div class="app-content content">
      <div class="content-overlay"></div>
      <div class="content-wrapper">
        <div class="content-header row">
          <slot name="breadcrumb"></slot>
        </div>
        <div class="content-body">
          <slot></slot>
        </div>
      </div>
    </div>
    <!-- demo chat-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <div class="customizer d-none d-md-block">
      <span class="customizer-toggle">
        <i class="bx bx-cog bx bx-spin white"></i>
      </span>
      <Customizer></Customizer>
    </div>

    <!-- BEGIN: Footer-->
    <Footer></Footer>
  </div>
</template>

<script>
 import Header from "./../admin/Header";
 import SideBar from "../admin/SideBar";
 import Customizer from "./../admin/Customizer";
 import Footer from "./../admin/Footer";
 import components from "../../../public/frest/js/scripts/components.js";
 import footer from "../../../public/frest/js/scripts/footer.js";
 import scripts from "../../../public/assets/js/scripts.js";

export default {
  name: "AdminLayout",
  components: {
   Header,
   SideBar,
   Customizer,
   Footer,
  },
  computed: {
    permissions(){
      return this.$page.props.auth.permissions;
    }
  },
    beforeMount() {
      window.permissions = this.permissions
  },
  mounted() {
     let obj = this;
      setTimeout(function () {
          obj.flash = '';
      }, 5100)
    //popover configuration;
    $('[data-toggle="popover"]').popover();
    $('body').on('click', function (e) {
      if ($(e.target).data('toggle') !== 'popover'
        && !$(e.target).hasClass('popover-body')
        && $(e.target).parents('[data-toggle="popover"]').length === 0
        && $(e.target).parents('.popover.in').length === 0) {
        $('[data-toggle="popover"]').popover('hide');
      }
    });
  }
};

</script>
<style lang="css" scoped>

@import "../../../public/frest/css/bootstrap.css";
@import "../../../public/frest/css/bootstrap-extended.css";
@import "../../../public/frest/css/colors.css";
@import "../../../public/frest/css/components.css";
@import "../../../public/frest/vendors/css/extensions/sweetalert2.min.css";
@import "../../../public/frest/vendors/css/extensions/toastr.css";
@import "../../../public/frest/css/pages/app-email.css";
@import "../../../public/frest/vendors/css/charts/apexcharts.css";
@import "../../../public/frest/vendors/css/extensions/swiper.min.css";
@import "../../../public/frest/css/themes/dark-layout.css";
@import "../../../public/frest/css/themes/semi-dark-layout.css";
@import "../../../public/frest/css/core/menu/menu-types/vertical-menu.css";
@import "../../../public/frest/css/pages/dashboard-ecommerce.css";
@import "../../../public/assets/css/style.css";



</style>


