<template>
    <div>
        <div class="form-group" :class="{ 'has-error': errors.desa_id}">
            <label for="">Desa</label>
            <select v-model="tps.desa_id" class="form-control">
                <option value="">Pilih</option>
                <option v-for="(row, index) in desas.data" :key="index" :value="row.id">{{ row.nama}}</option>
            </select>
 
            <!-- <v-select 
                v-model="tps.desa_id" 
                :options="desas.data" 
                filled 
                return-object 
            >
                <template slot="option" slot-scope="option">
                    {{ option.nama }}
                </template>
            </v-select> -->

            <!-- <v-select
                v-model="tps.desa_id"
                :options="desas.data"
                @search="onSearch"
                label="nama"
                placeholder="Masukkan Kata Kunci"
                :filterable="false"
            >
                <template slot="no-options">
                    Masukkan Kata Kunci
                </template>
                <template slot="option" slot-scope="option">
                    {{ option.nama}}
                </template>
            </v-select> -->
            <p class="text-danger" v-if="errors.desa_id">
                {{ errors.desa_id[0] }}
            </p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.no_tps}">
            <label for="">Nomor Tps</label>
            <input type="text" class="form-control" v-model="tps.no_tps" />
            <p class="text-danger" v-if="errors.no_tps">{{ errors.no_tps[0] }}</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.jml_pemilih}">
            <label for="">Jumlah pemilih</label>
            <input type="number" class="form-control" v-model="tps.jml_pemilih" />
            <p class="text-danger" v-if="errors.jml_pemilih">
                {{ errors.jml_pemilih[0] }}
            </p>
        </div>
    </div>
</template>
<script>
    import { mapActions, mapState, mapMutations}from "vuex"
    import vSelect from 'vue-select';
    import _ from 'lodash'
    import 'vue-select/dist/vue-select.css';

    export default {
        name: "FormTps",
        created(){
            this.getdesas();
        },
        data(){
            return {
                search: '',
                nama_desa: ''
            }
        },
        computed: {
            ...mapState(["errors"]),
            ...mapState("desa", {
                desas: state => state.desas
            }),
            ...mapState("tps", {
                tps: state => state.tps
            })
        },
        methods: {
            ...mapMutations("tps", ["CLEAR_FORM"]),
            ...mapActions("desa", ["getdesas"]),
            onSearch() {
                // return this.desas.filter((desa) => this.search == desa.nama)
                this.getdesas({
                    search: this.search,
                })
            },
        },
        destroyed(){
            this.CLEAR_FORM()
        },
        components: {
            vSelect
        }
    }
</script>