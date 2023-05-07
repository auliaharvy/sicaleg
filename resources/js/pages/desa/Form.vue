<template>
    <div>
        <div class="form-group" :class="{ 'has-error': errors.nama }">
            <label for="">Nama desa</label>
            <input type="text" class="form-control" v-model="desa.nama" />
            <p class="text-danger" v-if="errors.nama">{{ errors.nama[0] }}</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.id_kecamatan }">
            <label for="">Kecamatan</label>
            <select v-model="desa.id_kecamatan" class="form-control">
                <option value="">Pilih</option>
                <option v-for="(row, index) in kecamatans.data" :key="index" :value="row.id">{{ row.nama}}</option>
            </select>
           <p class="text-danger" v-if="errors.id_kecamatan">
                {{ errors.id_kecamatan[0] }}
            </p>
        </div>
   </div>
</template>

<script>
import { mapState, mapMutations, mapActions } from "vuex";
import vSelect from 'vue-select';
import _ from 'lodash';
import 'vue-select/dist/vue-select.css';

export default {
    name: "Formdesa",
    created() {
        this.getKecamatans();
    },
    computed: {
        ...mapState(["errors"]),
        ...mapState("desa", {
            desa: state => state.desa,
        }),
        ...mapState("kecamatan", {
            kecamatans: state => state.kecamatans,
        }),
    },
    methods: {
        ...mapMutations("desa", ["CLEAR_FORM"]),
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
