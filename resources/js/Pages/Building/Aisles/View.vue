<template>
  <admin-layout>
    <div>
      <section id="basic-horizontal-layouts">
        <div class="row match-height">
          <div class="col-md-9 col-12 ">
            <div class="card">
              <div class="card-header pb-0 mb-0">
                <h6>
                  <img src="/img/aisle1.svg" alt="Aisle" class="building-icons">Aisle: {{aisle.code}}
                </h6>
                <div class=" pb-1 px-2">
                  <hr class="line" />
                </div>
                <div class="row">
                  <div class="col-md-8 col-12 mt-1">
                    <h6 v-if="aisle.name">Name</h6>
                    <p title="length-height-width" v-if="aisle.name">{{(aisle.name)}}</p>
                    <h6>Dimension</h6>
                    <p title="length-height-width">{{roundValue(aisle.length)}}m x {{roundValue(aisle.height)}}m x
                      {{roundValue(aisle.width)}}m</p>
                    <h6>Volume</h6>
                    <p>{{roundValue(aisle.volume)}} m<sup>3</sup> </p>
                    <h6>Active</h6>
                    <p v-if='aisle.is_active'>Yes</p>
                    <p v-else>No</p>
                    <h6>Occupied</h6>
                    <p v-if='aisle.is_occupied'>Yes</p>
                    <p v-else>No</p>
                  </div>
                  <div
                    class="user-profile-images col-md-4 col-12 d-flex align-items-center justify-content-center mb-0 flex-column">
                    <div>
                      <qrcode-vue :value="value" :size="150" level="H" foreground="#126630" />
                    </div>
                    <div :style="myBackgroundColor" class="mt-1">
                      <h6 class="text-white" style="padding: 8px 36px 0px 36px;">{{context}}</h6>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-11 d-flex justify-content-start px-0">
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
                <inertia-link :href="route('aisle.edit',aisle.id)" class="btn btn-light-primary btn-block"
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
  import AdminLayout from "../../../Layouts/AdminLayout";
  import QrcodeVue from 'qrcode.vue';

  export default {
    name: "View",
    props: ["aisle", 'building', 'context'],
    components: {
      AdminLayout,
      QrcodeVue
    },

    data() {
      return {
        value: '',
        myBackgroundColor: {
          backgroundColor: "#126630"
        }
      };
    },

    beforeMount() {
      document.title = process.env.MIX_APP_NAME + " - Aisle Details";
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