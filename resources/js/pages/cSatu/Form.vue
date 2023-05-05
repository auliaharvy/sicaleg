<template>
    <div>
       <div class="form-group" :class="{ 'has-error': errors.no_tps}">
            <label for="">Nomor Tps</label>
            <input v-show="false" type="text" class="form-control" v-model="cSatu.id_tps" :readonly="true"/>
            <input type="text" class="form-control" v-model="cSatu.no_tps" :readonly="true"/>
            <p class="text-danger" v-if="errors.no_tps">{{ errors.no_tps[0] }}</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.foto}">
            <div class="form-group" :class="{ 'has-error': errors.foto}">
                <label for="">Foto</label>
                <input type="file" class="form-control" accept="image/*" @change="uploadImage($event)" id="file-input">
                <p class="text-warning">Leave blank if you don't want to change photo</p>
                <p class="text-danger" v-if="errors.foto">{{ errors.foto[0] }}</p>
            </div>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.jml_suara}">
            <div class="form-group" :class="{ 'has-error': errors.jml_suara}">
                <label for="">Jumlah Suara</label>
                <input type="text" class="form-control" v-model="cSatu.jml_suara"/>
                <p class="text-danger" v-if="errors.jml_suara">{{ errors.jml_suara[0] }}</p>
            </div>
        </div>
   </div>
</template>

<script>
import { mapState, mapMutations, mapActions } from "vuex";
import vSelect from 'vue-select';
import _ from 'lodash';
import 'vue-select/dist/vue-select.css';

export default {
    name: "FormCSatu",
    data(){
        return {
            cSatu: {
                id_tps: '',
                no_tps: '',
                foto: '',
                jml_suara: ''
            }
        }
    },
    created() {
    //    if (this.$route.name == 'tps.cSatu.edit') {
    //         this.editCSatu(this.$route.params.id).then((res) => {
    //             this.cSatu = {
    //                 id_tps: res.id_tps,
    //                 foto: res.foto,
    //                 jml_suara: res.jml_suara,
    //             }
    //        })
    //     }
        if(this.$route.name == 'tps.cSatu.edit'){
            this.editCSatu(this.$route.params.id).then((resCSatu) => {
                this.editTps(resCSatu.data.id_tps).then((resTps) => {
                    this.cSatu = {
                        id_tps: resTps.data.id,
                        no_tps: resTps.data.no_tps,
                        foto: resCSatu.data.foto,
                        jml_suara: resCSatu.data.jml_suara,
                    }
                })
            })
        }else if(this.$route.name == 'tps.cSatu.add'){
            this.editTps(this.$route.params.id).then((resTps) => {
                this.editCSatu(resTps.data.id).then((resCSatu) => {
                    this.cSatu = {
                        id_tps: resTps.data.id,
                        no_tps: resTps.data.no_tps,
                        foto: resCSatu.data.foto,
                        jml_suara: resCSatu.data.jml_suara,
                    }
                })
            })
        }
    },
    computed: {
        ...mapState(['errors']),
   },
    methods: {
        ...mapMutations("cSatu", ['CLEAR_FORM', 'SET_ID_UPDATE']),
        ...mapActions("cSatu", ['submitCSatu', 'addCSatu', 'updateCSatu', 'editCSatu']),
        ...mapActions("tps", ['editTps']),
       onSearch() {
            this.getCSatu({
                search: search,
                loading: loading
            })
        },
        uploadImage(event) {
            this.cSatu.foto = event.target.files[0]
        },
        submit() {
            let form = new FormData()
            form.append('id_tps', this.cSatu.id_tps)
            form.append('foto', this.cSatu.foto)
            form.append('jml_suara', this.cSatu.jml_suara)

            if (this.$route.name == 'tps.cSatu.add') {
                this.submitCSatu(form).then(() => {
                    this.cSatu = {
                        id_tps: '',
                        foto: '',
                        jml_suara: '',
                    }
                    this.$router.push({ name: 'tps.data' })
                })
            } else if (this.$route.name == 'tps.cSatu.edit') {
                this.SET_ID_UPDATE(this.$route.params.id)
                this.updateCSatu(form).then(() => {
                    this.cSatu = {
                        id_tps: '',
                        foto: '',
                        jml_suara: '',
                    }
                    this.$router.push({ name: 'tps.data' })
                })
            }
        }
    },
    components: {
        vSelect,
    }
};
</script>