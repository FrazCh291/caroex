<template>
  <admin-layout>
    <div>
      <section id="basic-horizontal-layouts">
        <div class="row match-height">
          <div class="col-md-9 col-12">
            <div class="card">
              <div class="card-header pb-0 mb-0">
                <h4 class="card-title">Edit Attendence</h4>
                <div class="header mt-1" v-if="Object.keys(errors).length > 0">
                </div>
              </div>
              <div class="px-2 pb-1">
                <hr class="line" />
              </div>
              <div class="card-content">
                <div class="card-body">
                  <form @submit.prevent="submit" class="form form-horizontal">
                    <div class="form-body">
                      <div class="row form-group pt-1 pb-0 mb-0">
                        <div class="col-md-3">
                          <label>Name </label>
                        </div>
                        <div class="col-md-6 form-group">
                          <input
                            type="text"
                            id="name"
                            v-model="form.name"
                            class="form-control"
                            name="name"
                            disabled
                          />
                          <ErrorComponent input="name"></ErrorComponent>
                        </div>
                      </div>
                      <div class="row form-group pt-1 pb-0 mb-0">
                        <div class="col-md-3">
                          <label>Employee Id </label>
                        </div>
                        <div class="col-md-6 form-group">
                          <input
                            type="number"
                            id="employee_number"
                            v-model="form.employee_number"
                            class="form-control"
                            name="employee_number"
                            disabled
                          />
                          <ErrorComponent
                            input="employee_number"
                          ></ErrorComponent>
                        </div>
                      </div>
                      <div class="row form-group pt-1 pb-0 mb-0">
                        <div class="col-md-3">
                          <label>Date </label>
                        </div>
                        <div class="col-md-6 form-group">
                          <input
                            type="date"
                            id="date"
                            v-model="form.date"
                            class="form-control"
                            name="date"
                            disabled
                          />
                          <ErrorComponent input="date"></ErrorComponent>
                        </div>
                      </div>
                      <div class="row form-group pt-1 pb-0 mb-0">
                        <div class="col-md-3">
                          <label>Check In</label>
                        </div>
                        <div class="col-md-6 form-group">
                          <input
                            type="time"
                            id="clock_in_at"
                            v-model="form.clock_in_at"
                            class="form-control"
                            name="clock_in_at"
                          />
                          <ErrorComponent input="clock_in_at"></ErrorComponent>
                        </div>
                      </div>
                      <div class="row form-group pt-1 pb-0 mb-0">
                        <div class="col-md-3">
                          <label>Check Out</label>
                        </div>
                        <div class="col-md-6 form-group">
                          <input
                            type="time"
                            id="clock_out_at"
                            v-model="form.clock_out_at"
                            class="form-control"
                            name="clock_out_at"
                          />
                          <ErrorComponent input="clock_out_at"></ErrorComponent>
                        </div>
                      </div>

                      <div class="col-sm-11 d-flex justify-content-start px-0">
                        <button type="submit" class="btn btn-primary mr-1 mb-1">
                          Save
                        </button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </admin-layout>
</template>

<script>
import { useForm } from "@inertiajs/inertia-vue3";
import AdminLayout from "../../Layouts/AdminLayout.vue";
import JetInputError from "./../../Jetstream/InputError";
import ErrorComponent from "../../components/ErrorComponent.vue";
import ConfirmatiomModal from "../SweetAlert/ConfirmatiomModal.vue";

export default {
  name: "Create",
  props: ["errors", "attendence", "employeeId"],
  components: {
    AdminLayout,
    ErrorComponent,
    ConfirmatiomModal,
    JetInputError,
  },
  setup() {
    const form = useForm({
      name: "",
      employee_number: "",
      date: "",
      clock_in_at: "",
      clock_out_at: "",
    });
    return {form};
  },
  data() {
    return {};
  },
  beforeMount() {
    document.title = process.env.MIX_APP_NAME + " - Create Module";
    if (this.attendence) {
      this.update = true;
      let data = this.attendence;
      Object.assign(data, {
        _method: "PUT",
      });
      this.form = this.$inertia.form(data);
    }
  },
  methods: {
    submit() {
      this.form.post(route("attendence.update", this.attendence.id));
    },
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
