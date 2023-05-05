<template>
    <div>
        <div class="form-group" :class="{ 'has-error': errors.id_dpt}">
            <label for="">DPT</label>
            <select v-model="konstituen.id_dpt" class="form-control">
                <option value="">Pilih</option>
                <option v-for="(row, index) in allDpt.data" :key="index" :value="row.id">{{ row.nama}}</option>
            </select>
            <p class="text-danger" v-if="errors.id_tps">{{ errors.id_tps[0] }}</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.nik}">
            <label for="">NIK</label>
            <input type="text" class="form-control" v-model="konstituen.nik" />
            <p class="text-danger" v-if="errors.nik">{{ errors.nik[0] }}</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.nama }">
            <label for="">Nama</label>
            <input type="text" class="form-control" v-model="konstituen.nama" />
            <p class="text-danger" v-if="errors.nama">{{ errors.nama[0] }}</p>
        </div>
         <div class="form-group" :class="{ 'has-error': errors.no_hp}">
            <label for="">Nomor Telephone</label>
            <input type="text" class="form-control" v-model="konstituen.no_hp" />
            <p class="text-danger" v-if="errors.no_hp">{{ errors.no_hp[0] }}</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.alamat}">
            <label for="">Alamat</label>
            <textarea v-model="konstituen.alamat" class="form-control" cols="30" rows="2"></textarea>
            <p class="text-danger" v-if="errors.alamat">{{ errors.alamat[0] }}</p>
        </div>
         <div class="form-group" :class="{ 'has-error': errors.rt}">
            <label for="">RT</label>
            <input type="text" class="form-control" v-model="konstituen.rt" />
            <p class="text-danger" v-if="errors.rt">{{ errors.rt[0] }}</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.rw}">
            <label for="">RW</label>
            <input type="text" class="form-control" v-model="konstituen.rw" />
            <p class="text-danger" v-if="errors.rw">{{ errors.rw[0] }}</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.id_tps}">
            <label for="">No TPS</label>
            <select v-model="konstituen.id_tps" class="form-control" :disabled="true">
                <option value="">Pilih</option>
                <option v-for="(row, index) in allTps.data" :key="index" :value="row.id">{{ row.no_tps}}</option>
            </select>
            <p class="text-danger" v-if="errors.id_tps">{{ errors.id_tps[0] }}</p>
        </div>
       <div class="form-group" :class="{ 'has-error': errors.id_desa}">
            <label for="">Desa</label>
            <select v-model="konstituen.id_desa" class="form-control" :disabled="true">
                <option value="">Pilih</option>
                <option v-for="(row, index) in nameDesa.data" :key="index" :value="row.id">{{ row.nama}}</option>
            </select>
            <p class="text-danger" v-if="errors.id_desa">{{ errors.id_desa[0] }}</p>
        </div>
       <div class="form-group" :class="{ 'has-error': errors.id_kecamatan}">
            <label for="">Kecamatan</label>
            <select v-model="konstituen.id_kecamatan" class="form-control" :disabled="true">
                <option value="">Pilih</option>
                <option v-for="(row, index) in kecamatans.data" :key="index" :value="row.id">{{ row.nama}}</option>
            </select>
            <p class="text-danger" v-if="errors.id_kecamatan">{{ errors.id_kecamatan[0] }}</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.agama}">
            <label for="">Agama</label>
            <select v-model="konstituen.agama" class="form-control">
                <option value="">Pilih</option>
                <option v-for="(row, index) in allAgama.data" :key="index" :value="row.nama">{{ row.nama}}</option>
            </select>
            <p class="text-danger" v-if="errors.agama">{{ errors.agama[0] }}</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.status_pernikahan}">
            <label for="">Status Pernikahan</label>
            <select v-model="konstituen.status_pernikahan" class="form-control">
                <option value="">Pilih</option>
                <option v-for="(row, index) in allStatusPernikahan.data" :key="index" :value="row.status">{{ row.status}}</option>
            </select>
            <p class="text-danger" v-if="errors.status_pernikahan">{{ errors.status_pernikahan[0] }}</p>
        </div>

        <div class="form-group" :class="{ 'has-error': errors.pekerjaan}">
            <label for="">Pekerjaan</label>
            <input type="text" class="form-control" v-model="konstituen.pekerjaan" />
            <p class="text-danger" v-if="errors.pekerjaan">{{ errors.pekerjaan[0] }}</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.kewarganegaraan}">
            <label for="">Kewarganegaraan</label>
            <input type="text" class="form-control" v-model="konstituen.kewarganegaraan" />
            <p class="text-danger" v-if="errors.kewarganegaraan">{{ errors.kewarganegaraan[0] }}</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.foto}">
            <label for="">Foto</label>
            <input type="file" class="form-control" accept="image/*" @change="uploadImage($event)" id="file-input">
            <p class="text-warning">Leave blank if you don't want to change photo</p>
            <p class="text-danger" v-if="errors.foto">{{ errors.foto[0] }}</p>
        </div>
        <div v-if="this.$route.name == 'konstituens.edit'" class="form-group" :class="{ 'has-error': errors.updated_by}">
            <label for="">Di updated oleh</label>
            <select v-model="konstituen.updated_by" class="form-control">
                <option value="">Pilih</option>
                <option v-for="(row, index) in rekruters.data" :key="index" :value="row.id">{{ row.name}}</option>
            </select>
            <p class="text-danger" v-if="errors.updated_by">{{ errors.updated_by[0] }}</p>
        </div>
        <!-- <div v-if="this.$route.name == 'konstituens.add'" class="form-group" :class="{ 'has-error': errors.submit_by}">
            <label for="">Di submit oleh</label>
            <input type="text" class="form-control" v-model="konstituen.submit_by" />
            <p class="text-danger" v-if="errors.submit_by">{{ errors.submit_by[0] }}</p>
        </div> -->

       <!-- <div class="form-group" :class="{ 'has-error': errors.updated_by}">
            <label for="">Di update oleh</label>
            <v-select
                v-model="konstituen.rekruter_updated_by"
                :options="rekruters.data"
                @search="onSearch"
                label="name"
                placeholder="Masukkan Kata Kunci"
                :filterable="false"
            >
                <template slot="option" slot-scope="option">
                    {{ option.name }}
                </template>
            </v-select>
            <p class="text-danger" v-if="errors.updated_by">{{ errors.updated_by[0] }}</p>
        </div> -->
   </div>
</template>

<script>
import { mapState, mapMutations, mapActions } from "vuex";
import vSelect from 'vue-select';
import _ from 'lodash';
import 'vue-select/dist/vue-select.css';

export default {
    name: "FormKonstituen",
    data(){
        return {
           konstituen: {
                nik: '',
                nama: '',
                no_hp: '',
                alamat: '',
                rt: '',
                rw: '',
                id_kecamatan: '',
                id_desa: '',
                id_tps: '',
                agama: '',
                status_pernikahan: '',
                pekerjaan: '',
                kewarganegaraan: 'WNI',
                foto: '',
                submit_by: '',
                updated_by: '',
            },
            allAgama:{
                data: [ 
                    {nama: 'Islam'}, 
                    {nama: 'Kristen'}, 
                    {nama: 'Hindu'}, 
                    {nama: 'Buddha'}, 
                    {nama: 'Kong Hu Chu'}, 
                ] 
            },
            allStatusPernikahan:{
                data: [ 
                    {status: 'Kawin'}, 
                    {status: 'Belum kawin'}, 
                    {status: 'Cerai hidup'}, 
                    {status: 'Cerai mati'}, 
                ] 
            },
        }
    },
    watch: {
        'konstituen.id_dpt': function(newValue, oldValue){
            const dpt = this.allDpt.data.find(d => d.id === newValue)
            const tps = this.allTps.data.find(d => d.id === dpt.id_tps)
            const desa = this.desas.data.find(d => d.id === tps.desa_id)
            this.konstituen.nama = dpt.nama
            this.konstituen.nik = dpt.nik
            this.konstituen.id_tps = dpt.id_tps
            this.konstituen.id_desa = desa.id
            console.log(desa)
            this.konstituen.id_kecamatan = desa.id_kecamatan 
        },
  },
    created() {
        this.getKecamatans();
        this.getdesas();
        this.getNameDesa();
        this.getAllTps();
        this.getAllDpt();
        this.getKonstituens();
        this.getRekruters();
        this.konstituen.submit_by = this.authenticated.name
        if (this.$route.name == 'konstituens.edit') {
            this.editKonstituen(this.$route.params.id).then((res1) => {
                this.konstituen = {
                    nik: res1.data.nik,
                    nama: res1.data.nama,
                    no_hp: res1.data.no_hp,
                    alamat: res1.data.alamat,
                    rt: res1.data.rt,
                    rw: res1.data.rw,
                    id_kecamatan: res1.data.id_kecamatan,
                    id_desa: res1.data.id_desa,
                    id_tps: res1.data.id_tps,
                    id_dpt: res1.data.id_dpt,
                    agama: res1.data.agama,
                    status_pernikahan: res1.data.status_pernikahan,
                    pekerjaan: res1.data.pekerjaan,
                    kewarganegaraan: res1.data.kewarganegaraan,
                    foto: '',
                    updated_by: res1.data.updated_by,
                }
           })
        }
    },
    computed: {
        ...mapState(['errors']),
        ...mapState("konstituen", {
            konstituens: state => state.konstituens,
        }),
        ...mapState("kecamatan", {
            kecamatans: state => state.kecamatans,
        }),
        ...mapState("desa", {
            desas : state => state.desas,
        }),
        ...mapState("tps", {
            allTps: state => state.allTps,
        }),
        ...mapState("dpt", {
            allDpt: state => state.allDpt,
        }),
        ...mapState("user", {
            rekruters: state => state.rekruters,
            authenticated: state => state.authenticated,
        }),
        ...mapState("desa", {
            nameDesa: state => state.nameDesa,
        }),
    },
    methods: {
        ...mapActions("konstituen", ["submitKonstituen", "editKonstituen", "updateKonstituen", "getKonstituens"]),
        ...mapMutations("konstituen", ['SET_ID_UPDATE']),
        ...mapActions("kecamatan", ["getKecamatans", "editKecamatan"]),
        ...mapActions("desa", ["getdesas"]),
        ...mapActions("tps", ["getAllTps"]),
        ...mapActions("dpt", ["getAllDpt"]),
        ...mapActions("user", ["getRekruters"]),
        ...mapActions("desa", ["getNameDesa"]),
        onSearch() {
            this.getKecamatans({
                search: search,
                loading: loading
            })
        },
        uploadImage(event) {
            this.konstituen.foto = event.target.files[0]
        },
        submit() {
            let form = new FormData()
            form.append('nik', this.konstituen.nik)
            form.append('nama', this.konstituen.nama)
            form.append('no_hp', this.konstituen.no_hp)
            form.append('alamat', this.konstituen.alamat)
            form.append('rt', this.konstituen.rt)
            form.append('rw', this.konstituen.rw)
            form.append('id_kecamatan', this.konstituen.id_kecamatan)
            form.append('id_desa', this.konstituen.id_desa)
            form.append('id_tps', this.konstituen.id_tps)
            form.append('id_dpt', this.konstituen.id_dpt)
            form.append('agama', this.konstituen.agama)
            form.append('status_pernikahan', this.konstituen.status_pernikahan)
            form.append('pekerjaan', this.konstituen.pekerjaan)
            form.append('kewarganegaraan', this.konstituen.kewarganegaraan)
            form.append('foto', this.konstituen.foto)

            if (this.$route.name == 'konstituens.add') {
                form.append('submit_by', this.authenticated.id)
                this.submitKonstituen(form).then(() => {
                    this.konstituen = {
                        nik: '',
                        nama: '',
                        no_hp: '',
                        alamat: '',
                        rt: '',
                        rw: '',
                        id_kecamatan: '',
                        id_desa: '',
                        id_tps: '',
                        id_dpt: '',
                        agama: '',
                        status_pernikahan: '',
                        pekerjaan: '',
                        kewarganegaraan: '',
                        foto: '',
                        submit_by: '',
                    }
                    this.$router.push({ name: 'konstituens.data' })
                })
            } else if (this.$route.name == 'konstituens.edit') {
                form.append('updated_by', this.authenticated.id)
                this.SET_ID_UPDATE(this.$route.params.id)
                console.log(this.errors)
                this.updateKonstituen(form).then(() => {
                    this.konstituen = {                        
                        nik: '',
                        nama: '',
                        no_hp: '',
                        alamat: '',
                        rt: '',
                        rw: '',
                        id_kecamatan: '',
                        id_desa: '',
                        id_tps: '',
                        id_dpt: '',
                        agama: '',
                        status_pernikahan: '',
                        pekerjaan: '',
                        kewarganegaraan: '',
                        foto: '',
                        updated_by: '',
                    }
                    this.$router.push({ name: 'konstituens.data' })
                })
            }
        }
    },
    components: {
        vSelect,
    }
};
</script>