<template>
    <div>
        <div class="form-group" :class="{ 'has-error': errors.id_tps}">
            <label for="">Tps</label>
            <select v-model="dpt.id_tps" class="form-control">
                <option value="">Pilih</option>
                <option v-for="(row, index) in allTps.data" :key="index" :value="row.id">TPS {{ row.no_tps}} DESA {{ row.nama_desa }}</option>
            </select>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.nik}">
            <label for="">NIK</label>
            <input type="text" class="form-control" v-model="dpt.nik" :readonly="$route.name == 'dpt.edit'">
            <p class="text-danger" v-if="errors.nik">{{ errors.nik[0] }}</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.nama}">
            <label for="">Nama</label>
            <input type="text" class="form-control" v-model="dpt.nama">
            <p class="text-danger" v-if="errors.nama">{{ errors.nama[0] }}</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.jenis_kelamin}">
            <label for="">Jenis Kelamin</label>
            <select v-model="dpt.jenis_kelamin" class="form-control">
                <option value="">Pilih</option>
                <option v-for="(row, index) in allKelamin.data" :key="index" :value="row.jenis_kelamin">{{ row.jenis_kelamin}}</option>
            </select>
            <p class="text-danger" v-if="errors.jenis_kelamin">{{ errors.jenis_kelamin[0] }}</p>
        </div>
   </div>
</template>

<script>
import { mapState, mapMutations, mapActions} from 'vuex'
export default {
    name: 'FormDpt',
    data(){
        return {
            allKelamin:{
                data: [ 
                   {jenis_kelamin: 'Pria'}, 
                   {jenis_kelamin: 'Wanita'}, 
                ] 
            },
        }
    },
    created(){
        this.getAllTps()
    },
    computed: {
        ...mapState(['errors']),
        ...mapState('dpt', {
            dpt: state => state.dpt
        }),
        ...mapState('tps', {
            allTps: state => state.allTps
        })
    },
    methods: {
        ...mapMutations('dpt', ['CLEAR_FORM']),
        ...mapActions('tps', ['getAllTps']),
    },
    destroyed() {
        this.CLEAR_FORM()
    }
}
</script>
