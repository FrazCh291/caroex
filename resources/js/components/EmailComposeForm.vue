<template>
    <div id="emailComposeModal" aria-hidden="true" aria-labelledby="myModalLabel33" class="modal fade text-left" role="dialog" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="myModalLabel33" class="modal-title font-weight-bold">
                        Compose Email
                    </h4>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button" @click="resetInput">
                        <i class="bx bx-x"></i>
                     </button>
                </div>
                <form class="form form-horizontal">
                        <div class="modal-body mb-1">
                            <div class="form-group py-0 my-0 mb-1">
                                <label>From *</label>
                                <select id="from" class="form-select" name="from" v-model="form.from" placeholder="From" required>
                                        <option v-for="emailSetting in emailSettings" :value="emailSetting.username">
                                                    {{ emailSetting.username }}
                                        </option>
                                </select>
                            </div>
                            <div class="form-group py-0 my-0 mb-1">
                                <label>To *</label>
                                <input id="to" class="form-control" name="to" v-model="form.to" placeholder="To" required type="text" @keyup="stringSpaceChecker('to')">
                            </div>
                            <div class="form-group py-0 my-0 mb-1">
                                <label>Cc </label>
                                <input id="cc" class="form-control" name="cc" v-model="form.cc" placeholder="Cc" type="text" @keyup="stringSpaceChecker('cc')">
                            </div>
                            <div class="form-group py-0 my-0 mb-1">
                                <label>Bcc </label>
                                <input id="bcc" class="form-control" name="bcc" v-model="form.bcc" placeholder="Bcc" type="text" @keyup="stringSpaceChecker('bcc')">
                            </div>
                            <div class="form-group py-0 my-0 mb-1">
                                <label>Subject *</label>
                                <input id="subject" class="form-control" name="subject" v-model="form.subject" placeholder="Subject" type="text" required>
                            </div>
                            <div class="form-group py-0 my-0 mb-1">
                                <label>Body *</label>
                                <textarea id="body" class="form-control" name="body" v-model="form.body" placeholder="Body" rows="8" type="text" required></textarea>
                            </div>
                            <div class="form-group py-0 my-0 mb-1">
                                <input id="filesUploaded" type="file" ref="myFileInput" multiple @input="form.attachments = $event.target.files"
                                    @change="uploadImage" accept="image/*">
                            </div>
                            <div class="form-group py-0 my-0 mb-1" v-if="this.images.length>0">
                                <div class="color" v-for="(image, key) in images" :key="key">
                                    <button class="close" @click.prevent="removeImage(key)">&times;</button>
                                    <div class="test br">
                                        {{ image.name }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group py-0 my-0">
                                <button class="btn btn-primary mr-2" data-dismiss="modal" type="submit" @click="submit">
                                    Send
                                </button>
                            </div>
                        </div>    
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import {reactive} from "vue";
import {useForm} from '@inertiajs/inertia-vue3'
import Label from "@/Jetstream/Label";

export default {
    name: "EmailComposeForm",
    components: {Label},
    props: ['emailSettings'],
    setup() {
        const form = useForm({
            from: '',
            to: '',
            subject: '',
            cc: '',
            bcc: '',
            reply_to: '',
            body: '',
            attachments: '',
        })
        return {form}
    },
    data() {
        return {
            attachments: null,
            images: [],
        }
    },
    created: function () {
    },
    beforeMount() {
        this.form.from = this.emailSettings[0].username;
    },
    methods: {
        stringSpaceChecker(fieldName) {
            if(fieldName === 'to') {
                if(this.form.to.charAt(0) === ' ') {
                this.form.to = this.form.to.trim();
                }
                if(this.form.to.charAt(this.form.to.length-1) === ' ') {
                    let count = 0;
                    let lastCharacterNotSpace = null;
                    for(let x=this.form.to.length-1; x>=0; x--) {
                        if(this.form.to.charAt(x) !== ' ') {
                            lastCharacterNotSpace = this.form.to.charAt(x);
                            break;
                        }
                        count++;
                    }
                    if(count==1 && lastCharacterNotSpace !== ';') {
                        this.form.to = this.form.to.trim().concat("; ");
                    }
                    if(count>1 && lastCharacterNotSpace !== ';') {
                        this.form.to = this.form.to.trim().concat("; ");
                    }
                    if(count==1 && lastCharacterNotSpace === ';') {
                        this.form.to = this.form.to.trim().concat(" ");
                    }
                    if(count>1 && lastCharacterNotSpace === ';') {
                        this.form.to = this.form.to.trim().concat(" ");
                    }
                }
            }
            else if(fieldName === 'cc') {
                if(this.form.cc.charAt(0) === ' ') {
                this.form.cc = this.form.cc.trim();
                }
                if(this.form.cc.charAt(this.form.cc.length-1) === ' ') {
                    let count = 0;
                    let lastCharacterNotSpace = null;
                    for(let x=this.form.cc.length-1; x>=0; x--) {
                        if(this.form.cc.charAt(x) !== ' ') {
                            lastCharacterNotSpace = this.form.cc.charAt(x);
                            break;
                        }
                        count++;
                    }
                    if(count==1 && lastCharacterNotSpace !== ';') {
                        this.form.cc = this.form.cc.trim().concat("; ");
                    }
                    if(count>1 && lastCharacterNotSpace !== ';') {
                        this.form.cc = this.form.cc.trim().concat("; ");
                    }
                    if(count==1 && lastCharacterNotSpace === ';') {
                        this.form.cc = this.form.cc.trim().concat(" ");
                    }
                    if(count>1 && lastCharacterNotSpace === ';') {
                        this.form.cc = this.form.cc.trim().concat(" ");
                    }
                }
            }
            else {
                if(this.form.bcc.charAt(0) === ' ') {
                this.form.bcc = this.form.bcc.trim();
                }
                if(this.form.bcc.charAt(this.form.bcc.length-1) === ' ') {
                    let count = 0;
                    let lastCharacterNotSpace = null;
                    for(let x=this.form.bcc.length-1; x>=0; x--) {
                        if(this.form.bcc.charAt(x) !== ' ') {
                            lastCharacterNotSpace = this.form.bcc.charAt(x);
                            break;
                        }
                        count++;
                    }
                    if(count==1 && lastCharacterNotSpace !== ';') {
                        this.form.bcc = this.form.bcc.trim().concat("; ");
                    }
                    if(count>1 && lastCharacterNotSpace !== ';') {
                        this.form.bcc = this.form.bcc.trim().concat("; ");
                    }
                    if(count==1 && lastCharacterNotSpace === ';') {
                        this.form.bcc = this.form.bcc.trim().concat(" ");
                    }
                    if(count>1 && lastCharacterNotSpace === ';') {
                        this.form.bcc = this.form.bcc.trim().concat(" ");
                    }
                }
            }
        },
        submit() {
            if(!this.form.from){
                event.stopPropagation()
            } else if(!this.form.to){
                event.stopPropagation()
            } else if(!this.form.subject){
                event.stopPropagation()
            } else if(!this.form.body){
                event.stopPropagation()
            } else {
            this.form.post(route('email.compose'));
            this.resetInput();
            }
        },
        resetInput(index) {
            if(this.form.from === '') {
                this.form.from= this.emailSettings[0].username;
            }
            this.form.to = "";
            this.form.cc = "";
            this.form.bcc = "";
            this.form.subject = "";
            this.form.body = "";
            this.$refs.myFileInput.value = '';
            this.images.splice(index, this.images.length);
        },
        onFileChange: function (event) {
            const file = event.target.files[0]
            if (!file) {
                return false
            }
            if (!file.type.match('image.*')) {
                return false
            }
            const reader = new FileReader()
            const that = this
            reader.onload = function (e) {
                that.previewUrl = e.target.result
            }
            reader.readAsDataURL(file)
        },

        uploadImage(e) {
            if (this.images.length === 20) {
                alert('You can only upload up to 2 images.')
            } else {
                let vm = this;
                var selectedFiles = e.target.files;

                for (let i = 0; i < selectedFiles.length; i++) {
                    this.images.push(selectedFiles[i]);
                }

                for (let i = 0; i < this.images.length; i++) {
                    let reader = new FileReader();
                    reader.onload = (e) => {
                        this.$refs.image[i].src = reader.result;
                    };
                    reader.readAsDataURL(this.images[i]);
                }
            }
        },
        removeImage(index) {
            var attachments = document.getElementById("filesUploaded").files;
            var fileBuffer = new DataTransfer();
            for (let i = 0; i < attachments.length; i++) {
                if (index !== i)
                    fileBuffer.items.add(attachments[i]);
            }
            document.getElementById("filesUploaded").files = fileBuffer.files;
            this.form.attachments = fileBuffer.files;
            this.images.splice(index, 1);
        },

        chooseFiles: function () {
            document.getElementById("fileUpload").click()
        },
    },
}
</script>

<style scoped>
* {
    box-sizing: border-box;
}

.container {
    padding: .5rem 2% 1rem 2%;
}

h1 {
    font-weight: normal;
}

input {
    border: 1px solid #e9e9e9;
    border-radius: 4px;
    font-size: .825rem;
    padding: .5rem;
    width: 100%;
}

.color {
    background-color: #F2F4F4;
    border-radius: 5px;
    background-position: left top;
    background-repeat: repeat;
    padding: 8px;
    margin-bottom: 4px;
    width: 60%;
}


output img {
    max-width: 100%;
}

output p {
    background: #bdc7d3;
    border-radius: 4px;
    padding: 2rem;
    text-align: center;
}

</style>
