<template>
  <admin-layout>
    <div>
      <section id="basic-horizontal-layouts">
        <div class="row match-height">
          <div class="col-md-9 col-12">
            <div class="card">
              <div class="card-header pb-0 mb-0">
                <h4 class="card-title" v-if="event">Edit Event</h4>
                <h4 class="card-title" v-else>Add Event</h4>
              </div>
              <div class="px-2 pb-1">
                <hr class="line" />
              </div>
              <div class="card-content">
                <div class="card-body">
                  <form @submit.prevent="submit" class="form form-horizontal">
                    <div class="form-body">
                      <div class="row pt-1 pb-0 mb-0">
                        <div class="col-md-3">
                          <label>Title* </label>
                        </div>
                        <div class="col-md-6">
                          <input
                            type="text"
                            id="title"
                            v-model="form.title"
                            class="form-control"
                            name="title"
                          />
                          <ErrorComponent input="title"></ErrorComponent>
                        </div>
                      </div>
                      <div class="row form-group pt-2 mt-1.5 pb-0 mb-0">
                        <div class="col-md-3">
                          <label>Start*</label>
                        </div>
                        <div class="col-md-6 form-group">
                          <input
                            type="datetime-local"
                            id="start"
                            v-model="form.start"
                            class="form-control"
                            name="start"
                          />
                          <ErrorComponent input="start"></ErrorComponent>
                        </div>
                      </div>
                      <div class="row form-group pt-1 pb-0 mb-0">
                        <div class="col-md-3">
                          <label>End*</label>
                        </div>
                        <div class="col-md-6 form-group">
                          <input
                            type="datetime-local"
                            id="end"
                            v-model="form.end"
                            class="form-control"
                            name="end"
                          />
                          <ErrorComponent input="end"></ErrorComponent>
                        </div>
                      </div>
                      <div class="col-sm-11 d-flex justify-content-start px-0">
                        <button type="submit" class="btn btn-primary mr-1 mb-1">
                          Save
                        </button>
                        <inertia-link
                          :href="route('calendar.index')"
                          type="button"
                          class="btn btn-light-secondary mr-1 mb-1"
                        >
                          Back
                        </inertia-link>
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
import AdminLayout from "../../Layouts/AdminLayout";
import Label from "../../Jetstream/Label";
import JetInputError from "./../../Jetstream/InputError";
import { useForm } from "@inertiajs/inertia-vue3";
import ErrorComponent from "../../components/ErrorComponent";
import Input from "../../Jetstream/Input.vue";

export default {
  name: "Create",
  props: ["event"],
  components: {
    Label,
    AdminLayout,
    JetInputError,
    ErrorComponent,
  },
  setup() {
    const form = useForm({
      supplier_id: "",
      title: "",
      start: "",
      end: "",
      background_color: "",
      description: "",
    });
    return { form };
  },
  data() {
    return {};
  },
  beforeMount() {
    document.title = process.env.MIX_APP_NAME + " - Create Event";
    if (this.event) {
      this.update = true;
      let data = this.event;
      Object.assign(data, {
        _method: "PUT",
      });
      this.form = this.$inertia.form(data);
      data.start = data.start
        ? moment(data.start).format("YYYY-MM-DDThh:mm")
        : Null;

      data.end = data.end ? moment(data.end).format("YYYY-MM-DDThh:mm") : Null;


      this.form = this.$inertia.form(Object.assign(this.form.data(), data));
    }
  },
  formatDate(date) {
    return moment(date).format("DD/MM/YYYY");
  },
  methods: {
    submit() {
      if (this.update) {
        this.form.post(route("calendar.update", this.event.id));
      } else {
        this.form.post("/calendar");
      }
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
