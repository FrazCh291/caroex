<template>
    <div class="row px-2 mb-1">
        <div class="col-12 px-0">
            <form @submit.prevent="submit()"
                  class="form form-horizontal">
                <div class="emailBox mb-2 ">
                    <Label>FROM</Label>
                    <input id="from_email" type="text" v-model="form.from" class="form-control" size="64" maxLength="64" placeholder="From" readonly>
                </div>
                <div class="emailBox mb-2 ">
                    <Label>TO</Label>
                    <input id="to_email" type="text" v-model="form.to" class="form-control" size="64" maxLength="64" placeholder="To" @keyup="stringSpaceChecker('to')">
                </div>
                <Label>CC</Label>
                <div class="emailBox mb-2">
                    <input id="cc" type="text" class="form-control" v-model="form.cc" size="100" placeholder="Cc" @keyup="stringSpaceChecker('cc')">
                </div>
                <Label>BCC</Label>
                <div class="emailBox mb-2">
                    <input id="bcc" type="text" class="form-control" v-model="form.bcc" size="100" placeholder="Bcc" @keyup="stringSpaceChecker('bcc')">
                </div>
                <div class="emailBox mb-2 ">
                    <Label>SUBJECT</Label>
                    <input id="subject" type="text" v-model="form.subject" class="form-control" size="64" maxLength="64" placeholder="Subject">
                </div>
                <div class="messageBox mb-2">
                    <Label>BODY</Label>
                        <div :id="'formBody'+email.id" contenteditable="true"  v-html="form.body" style="width: 100%; min-height: 300px; padding: 5px; border: 1px solid #e9e9e9; border-radius: 5px; outline: none;">
                        </div>
                </div>
                <output class="output">
                    <div class="row px-1">
                        <div class="color mr-5 " v-for="(image, key) in images" :key="key">
                            <button class="close" @click.prevent="removeImage(key)">&times;</button>
                            <div class="test text-center mr-3 br">
                                {{ image.name }}
                            </div>
                        </div>
                    </div>
                </output>
                <div class="d-flex mt-2">
                    <div>
                        <button type="submit" class="btn btn-primary">send</button>
                    </div>
                    <div id="app" class="ml-2">
                        <input :id='"filesUploaded"+email.id' type="file" ref="myFileInput" multiple
                               @input="form.attachments = $event.target.files"
                               @change="uploadImage" accept="image/*">
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>

import moment from 'moment';
import {reactive} from "vue";
import {useForm} from '@inertiajs/inertia-vue3'
import Label from "@/Jetstream/Label";

export default {
    name: "EmailForm",
    components: {Label},
    props: ['email', 'to'],
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
            file: null,
            email_id: '',
        })
        return {form}
    },
    data() {
        return {
            from_email: this.email.from_email,
            to_email: this.email.to_email,
            subject: this.email.subject,
            body: '',
            cc: '',
            attachments: null,
            images: [],
        }
    },
    beforeMount() {
        document.title = process.env.MIX_APP_NAME + " - Create Core";
        if (this.email) {
            this.update = true;
            let data = Object.assign({}, this.email)
            Object.assign(data, {
                'replyBodyContent': '',
                'attachments': '',
                '_method': 'post',
            })

            data.email_id = this.email.id;
            this.form = this.$inertia.form(data);
        }
    },
    mounted() {
        if(this.form.body) {
            let body = "<br><br><br>-------- Original Message --------<br><strong>From:</strong>";
            body = body.concat(" &lt;"+this.email.from.mail+"&gt;");
            if(this.form.to) {
                this.email.to.forEach(function(singleTo, index){
                    if(index===0) {
                        body = body.concat("<br><strong>To:</strong> &lt;"+singleTo.mail);                
                    }
                    else {
                        body = body.concat(", "+singleTo.mail); 
                    }
                });
                body = body.concat("&gt;");
            }
            if(this.form.subject) {
                body = body.concat("<br><strong>Subject:</strong> "+this.form.subject);
            }
            if(this.form.date) {
                body = body.concat("<br><strong>Date:</strong> "+moment(this.form.date).format('dddd, MMMM Do YYYY, h:mm:ss a'));
            }
            if(this.form.has_html_body) {
                this.form.body = body.concat("<br><br>"+this.form.body);
                this.form.replyBodyContent = body.concat("<br><br>"+this.form.body); 
            }
            else {
                this.form.body = body.concat("<br><br><pre>"+this.form.body+"</pre>");
                this.form.replyBodyContent = body.concat("<br><br><pre>"+this.form.body+"</pre>");
            }
        }
        if(this.form.subject) {
            if(this.form.subject.slice(0, 3).toLowerCase() === 're:') {
                this.form.subject = "RE: "+this.form.subject.substring('3').trim();
            }
            else {
                this.form.subject = "RE: "+this.form.subject;
            }
        }
        this.form.from = this.to;
        this.form.to = this.email.from ? this.email.from.mail+';' : '';
        this.form.cc = '';
        this.form.bcc = '';
        this.form.reply_to = this.email.reply_to ? this.email.reply_to.mail : '';
    },
    created: function () {
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
            else if (fieldName === 'cc') {
                if (this.form.cc.charAt(0) === ' ') {
                    this.form.cc = this.form.cc.trim();
                }
                if (this.form.cc.charAt(this.form.cc.length - 1) === ' ') {
                    let count = 0;
                    let lastCharacterNotSpace = null;
                    for (let x = this.form.cc.length - 1; x >= 0; x--) {
                        if (this.form.cc.charAt(x) !== ' ') {
                            lastCharacterNotSpace = this.form.cc.charAt(x);
                            break;
                        }
                        count++;
                    }
                    if (count == 1 && lastCharacterNotSpace !== ';') {
                        this.form.cc = this.form.cc.trim().concat("; ");
                    }
                    if (count > 1 && lastCharacterNotSpace !== ';') {
                        this.form.cc = this.form.cc.trim().concat("; ");
                    }
                    if (count == 1 && lastCharacterNotSpace === ';') {
                        this.form.cc = this.form.cc.trim().concat(" ");
                    }
                    if (count > 1 && lastCharacterNotSpace === ';') {
                        this.form.cc = this.form.cc.trim().concat(" ");
                    }
                }
            } else {
                if (this.form.bcc.charAt(0) === ' ') {
                    this.form.bcc = this.form.bcc.trim();
                }
                if (this.form.bcc.charAt(this.form.bcc.length - 1) === ' ') {
                    let count = 0;
                    let lastCharacterNotSpace = null;
                    for (let x = this.form.bcc.length - 1; x >= 0; x--) {
                        if (this.form.bcc.charAt(x) !== ' ') {
                            lastCharacterNotSpace = this.form.bcc.charAt(x);
                            break;
                        }
                        count++;
                    }
                    if (count == 1 && lastCharacterNotSpace !== ';') {
                        this.form.bcc = this.form.bcc.trim().concat("; ");
                    }
                    if (count > 1 && lastCharacterNotSpace !== ';') {
                        this.form.bcc = this.form.bcc.trim().concat("; ");
                    }
                    if (count == 1 && lastCharacterNotSpace === ';') {
                        this.form.bcc = this.form.bcc.trim().concat(" ");
                    }
                    if (count > 1 && lastCharacterNotSpace === ';') {
                        this.form.bcc = this.form.bcc.trim().concat(" ");
                    }
                }
            }
        },
        submit() {
            this.form.replyBodyContent = document.getElementById('formBody'+this.email.id).innerHTML;
            this.form.post(route('email.reply'));
            this.resetInput();
        },
        resetInput(index) {
            this.form.replyBodyContent = this.form.body;
            document.getElementById('formBody'+this.email.id).innerHTML = this.form.body;
            this.form.to = this.email.from ? this.email.from.mail+';' : '';
            this.form.cc = '';
            this.form.bcc = '';
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
            var attachments = document.getElementById("filesUploaded" + this.email.id).files;
            var fileBuffer = new DataTransfer();
            for (let i = 0; i < attachments.length; i++) {
                if (index !== i)
                    fileBuffer.items.add(attachments[i]);
            }
            document.getElementById("filesUploaded" + this.email.id).files = fileBuffer.files;
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
    margin-bottom: .5rem;
    width: 100%;
}

.color {
    background-color: #F2F4F4;
    border-radius: 5px;
    background-position: left top;
    background-repeat: repeat;
    padding: 8px;
    width: 930px;
    margin-bottom: 4px;
}


output img {
    max-width: 100%;
}

output p {
    background: #f7f7f7;
    border-radius: 4px;
    padding: 2rem;
    text-align: center;
}

</style>
