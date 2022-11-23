<template>
  <admin-layout>
    <div>
      <section id="basic-horizontal-layouts">
        <div class="row match-height">
          
          <div class="col-md-9 col-12 ">
            <div class="card">
              <div class="card-header pb-0 mb-0">
                <h6>
                  <img src="/img/level1.svg" alt="Level" class="building-icons">Level: {{level.code}} 
                </h6>
                <div class=" pb-1">
                  <hr class="line" />
                </div>
                <div class="row">
                  <div class="col-md-8 col-12">
                    <h6 v-if="level.name">Name</h6>
                    <p title="length-height-width" v-if="level.name">{{(level.name)}}</p>
                    <h6>Dimension</h6>
                    <p title="length-height-width">{{roundValue(level.length)}}m x {{roundValue(level.height)}}m x {{roundValue(level.width)}}m</p>
                    <h6>Volume</h6>
                    <p>{{roundValue(level.volume)}} m<sup>3</sup> </p>
                    <h6>Max Weight</h6>
                    <p>{{level.max_weight}} kg</p>
                    <h6>Occupied</h6>
                    <p v-if='level.is_occupied'>Yes</p>
                    <p v-else>No</p>
                  </div>
                  <div
                    class="user-profile-images col-md-4 col-12 d-flex align-items-center justify-content-center mb-0 flex-column">
                    <div>
                    <qrcode-vue :value="value" :size="150" level="H" foreground="#F47000"  />
                    </div>
                    <div :style="myBackgroundColor" class="mt-1">
                      <h6 class="text-white" style="padding: 8px 15px 0px 15px;">{{context}}</h6>
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
              <inertia-link :href="route('level.edit',level.id)" class="btn btn-light-primary btn-block"
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
    props: ["level", 'building', 'context'],
    components: {
      AdminLayout,
      QrcodeVue
    },
    data() {
      return {
        value: '',
        myBackgroundColor: {
        backgroundColor:"#F47000"
         }
      };
    },
    beforeMount() {
      document.title = process.env.MIX_APP_NAME + " - level Details";
      this.value = window.location.href
    },
    methods: {
      submit() { },
      roundValue(val)
      {
        let num = val;
      if ((num/Math.round(val))==1){
      return Math.round(val);
      } else {
        return val; }
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