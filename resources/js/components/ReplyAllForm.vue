<template>
    <div id="replyAllModal" aria-hidden="true" aria-labelledby="myModalLabel33" class="modal fade text-left" role="dialog" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="myModalLabel33" class="modal-title font-weight-bold">
                        Reply
                    </h4>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button" @click="resetInput">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
                <form class="form form-horizontal">
                        <div class="modal-body mb-1">
                            <div class="form-group py-0 my-0 mb-1">
                                <label>From *</label>
                                <input id="from" class="form-control" name="from" v-model="form.from" placeholder="From" required type="text">
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
                                <div :id="'formBody'+email.id" contenteditable="true"  v-html="form.body" style="width: 100%; min-height: 300px; padding: 5px; border: 1px solid #e9e9e9; border-radius: 5px; outline: none;">
                                </div>
                            </div>
                            <div class="form-group py-0 my-0 mb-1">
                                <input id="replyAllfilesUploaded" type="file" ref="myFileInput" multiple @input="form.attachments = $event.target.files"
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
export default {
    name: "ReplyAllForm",
    props: ['email','to','replyType'],
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
            attachments: null,
            images: [],
            formStatus: false,
        }
    },
    created: function () {
    },
    beforeMount() {
        if (Object.keys(this.email).length > 0) {
            this.update = true;
            let data = Object.assign({}, this.email)
            Object.assign(data, {
                'attachments' : '',
                '_method': 'post',
            })

            data.email_id = this.email.id
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
            }
            else {
                this.form.body = body.concat("<br><br><pre>"+this.form.body+"</pre>");
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
        this.form.reply_to = this.email.reply_to ? this.email.reply_to.mail : '';
        if(this.form.cc && this.replyType==='replyAll') {
            this.form.cc = '';
            let cc = '';
            this.email.cc.forEach(function(singleCc, index){
                if(index===0) {
                    cc = cc.concat(singleCc.mail);                
                }
                else {
                    cc = cc.concat("; "+singleCc.mail);
                }
            });
            this.form.cc = cc.concat(";");
        }
        else {
            this.form.cc = '';
        }
        if(this.form.bcc && this.replyType==='replyAll') {
            this.form.bcc = '';
            let bcc = '';
            this.email.bcc.forEach(function(singleBcc, index){
                if(index===0) {
                    bcc = bcc.concat(singleBcc.mail);                
                }
                else {
                    bcc = bcc.concat("; "+singleBcc.mail);
                }
            });
            this.form.bcc = bcc.concat(";");
        }
        else {
           this.form.bcc = ''; 
        }
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
                this.form.body = document.getElementById('formBody'+this.email.id).innerHTML;
                this.form.post(route('email.reply'));
                this.resetInput();
            }
        },
        resetInput(index) {
            this.formStatus = !this.formStatus;
            this.form.body = "";
            this.$refs.myFileInput.value = '';
            this.images.splice(index, this.images.length);
            this.$emit('formStatus', this.formStatus);
            this.formStatus = !this.formStatus;

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
            var attachments = document.getElementById("replyAllfilesUploaded").files;
            var fileBuffer = new DataTransfer();
            for (let i = 0; i < attachments.length; i++) {
                if (index !== i)
                    fileBuffer.items.add(attachments[i]);
            }
            document.getElementById("replyAllfilesUploaded").files = fileBuffer.files;
            this.form.attachments = fileBuffer.files;
            this.images.splice(index, 1);
        },

        chooseFiles: function () {
            document.getElementById("replyAllfilesUploaded").click()
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
