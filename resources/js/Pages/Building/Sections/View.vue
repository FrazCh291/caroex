<template>
  <admin-layout>
    <div>
      <section id="basic-horizontal-layouts">
        <div class="row match-height">
          <div class="col-md-9 col-12">
            <div class="card">
              <div class="card-header pb-0 mb-0">
                <h6>
                  <img src="/img/section1.svg" alt="Section" class="building-icons">Section: {{section.code}}
                </h6>
                <div class=" pb-1">
                  <hr class="line" />
                </div>
                <div class="row">
                  <div class="col-md-8 col-12">
                    <h6 v-if="section.name">Name</h6>
                    <p title="length-height-width" v-if="section.name">{{(section.name)}}</p>
                    <h6>Dimension</h6>
                    <p title="length-height-width">{{roundValue(section.length)}}m x {{roundValue(section.height)}}m x
                      {{roundValue(section.width)}}m
                    </p>
                    <h6>Volume</h6>
                    <p>{{roundValue(section.volume)}} m<sup>3</sup> </p>
                    <h6>Active</h6>
                    <p v-if='section.is_active'>Yes</p>
                    <p v-else>No</p>
                    <h6>Occupied</h6>
                    <p v-if='section.is_occupied'>Yes</p>
                    <p v-else>No</p>
                  </div>
                  <div
                    class="user-profile-images col-md-4 col-12 d-flex align-items-center justify-content-center mb-0 flex-column">
                    <div>
                      <qrcode-vue :value="value" :size="150" level="H" foreground="#0000FF" />
                    </div>
                    <div :style="myBackgroundColor" class="mt-1">
                      <h6 class="text-white" style="padding: 8px 55px 0px 55px;">{{building.code+"-"+section.code}}</h6>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-11 px-0">
                <inertia-link :href="route('building.show',building.code)" type="button"
                  class="btn btn-light-secondary mb-2 ml-2 mt-1">
                  Back
                </inertia-link>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-12">
            <div class="border">
              <div class="invoice-action-btn p-1">
                <inertia-link :href="route('section.edit',section.id)" class="btn btn-light-primary btn-block"
                  data-repeater-create="">
                  Edit
                </inertia-link>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </admin-layout>
</template>

<script>
import moment from 'moment';
  import AdminLayout from "../../../Layouts/AdminLayout";
  import QrcodeVue from 'qrcode.vue';

  export default {
    name: "View",
    props: ["section", 'building'],
    components: {
      AdminLayout,
      QrcodeVue
    },

    data() {
      return {
        value: '',
        myBackgroundColor: {
          backgroundColor: "#0000FF"
        }
      };
    },

    beforeMount() {
      document.title = process.env.MIX_APP_NAME + " - Section Details";
      this.value = window.location.href
    },

    methods: {
      submit() { },
      roundValue(val) {
        let num = val;
        if ((num / Math.round(val)) == 1) {
          return Math.round(val);
        } else {
          return val;
        }
      }
    },
  };
</script>

<style scoped>
  .line {
    border-top: 1px dashed #c7cfd6;
    width: 100%;
  }

  .error {
    margin-top: 0px !important;
  }
</style>