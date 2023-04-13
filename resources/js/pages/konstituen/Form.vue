<template>
    <div>
        <div class="form-group" :class="{ 'has-error': errors.nama }">
            <label for="">Nama konstituen</label>
            <input type="text" class="form-control" v-model="konstituen.nama" />
            <p class="text-danger" v-if="errors.nama">{{ errors.nama[0] }}</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.id_kecamatan }">
            <label for="">Kecamatan</label>
            <v-select
                :options="kecamatans.data"
                v-model="konstituen.id_kecamatan"
                @search="onSearch"
                label="nama"
                placeholder="Masukkan Kata Kunci"
                :filterable="false"
            >
                <template slot="no-options">
                    Masukkan Kata Kunci
                </template>
                <template slot="option" slot-scope="option">
                    {{ option.nama }}
                </template>
            </v-select>
            <p class="text-danger" v-if="errors.id_kecamatan">
                {{ errors.id_kecamatan[0] }}
            </p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.pemilih_pria }">
            <label for="">Pemilih Pria</label>
            <input type="number" class="form-control" v-model="konstituen.pemilih_pria" />
            <p class="text-danger" v-if="errors.pemilih_pria">{{ errors.pemilih_pria[0] }}</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.pemilih_wanita }">
            <label for="">Pemilih Wanita</label>
            <input type="number" class="form-control" v-model="konstituen.pemilih_wanita" />
            <p class="text-danger" v-if="errors.pemilih_wanita">{{ errors.pemilih_wanita[0] }}</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.jumlah_tps }">
            <label for="">Jumlah TPS</label>
            <input type="number" class="form-control" v-model="konstituen.jumlah_tps" />
            <p class="text-danger" v-if="errors.jumlah_tps">{{ errors.jumlah_tps[0] }}</p>
        </div>
    </div>
</template>

<script>
import { mapState, mapMutations, mapActions } from "vuex";
import vSelect from 'vue-select';
import _ from 'lodash';
import 'vue-select/dist/vue-select.css';

export default {
    name: "Formkonstituen",
    created() {
        this.getKecamatans();
    },
    computed: {
        ...mapState(["errors"]),
        ...mapState("konstituen", {
            konstituen: state => state.konstituen,
        }),
        ...mapState("kecamatan", {
            kecamatans: state => state.kecamatans,
        }),
    },
    methods: {
        ...mapMutations("konstituen", ["CLEAR_FORM"]),
        ...mapActions("kecamatan", ["getKecamatans"]),
        onSearch() {
            this.getKecamatans({
                search: search,
                loading: loading
            })
        },
    },
    destroyed() {
        this.CLEAR_FORM();
    },
    components: {
        vSelect,
    }
};
</script>
