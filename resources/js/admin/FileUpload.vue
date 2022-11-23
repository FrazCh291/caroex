<template>

    <div class="card my-0">
        <div class="card-header pl-0">
            <h4 class="card-title">Import</h4>
        </div>
        <div class="card-content py-0">
            <div class="card-body p-0 m-0">
                <vue-dropzone ref="myVueDropzone" :id="'dropzone'" :options="dropzoneOptions"
                              @vdropzone-error="error"></vue-dropzone>
                <button class="btn btn-primary float-right my-2" @click="upload()">Save</button>
            </div>
        </div>
    </div>

</template>
<script>
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'

export default {
    name: "FileUpload",
    components: {
        vueDropzone: vue2Dropzone
    },
    props: {
        url: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            dropzoneOptions: {
                autoProcessQueue: false,
                addRemoveLinks: true,
                url: this.url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            },
            id: null,
            myDropZone: null,
            supervisorError: ''
        }
    },
    beforeMount() {
        this.id = this._uid;

        console.log(this.id,'uid');
    },
    methods: {
        upload() {
            this.$refs.myVueDropzone.processQueue()
        },
        error(files, message, xhr) {
            if (message.errors && message.errors.supervisor) {
                this.supervisorError = message.errors.supervisor[0];
                this.$emit('supervisor_error', this.supervisorError);
                this.$emit('fileError', message.errors.supervisor[0]);
            }
            if (message.errors && message.errors.extension) {
                $('.dz-error-message').html(`<span data-dz-errormessage="">${message.errors.extension[0]}</span>`)
                this.$emit('fileError', message.errors.extension[0]);
            } else {
                $('.dz-error-message').html(`<span data-dz-errormessage="">${message}</span>`)
            }
        }
    }
}
</script>

<style scoped>
.dropzone {
    border: 1px dashed;
}

</style>
