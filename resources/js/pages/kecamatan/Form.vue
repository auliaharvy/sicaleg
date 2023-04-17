<template>
    <div>
        <div class="form-group" :class="{ 'has-error': errors.nama }">
            <label for="">Nama Kecamatan</label>
            <input type="text" class="form-control" v-model="kecamatan.nama">
            <p class="text-danger" v-if="errors.nama">{{ errors.nama[0] }}</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.dapil }">
            <label for="">Dapil</label>
            <input type="text" class="form-control" v-model="kecamatan.dapil">
            <p class="text-danger" v-if="errors.dapil">{{ errors.dapil[0] }}</p>
        </div>
    </div>
</template>

<script>
import { mapState, mapMutations } from 'vuex'
export default {
    name: 'FormKecamatan',
    computed: {
        ...mapState(['errors']),
        ...mapState('kecamatan', {
            kecamatan: state => state.kecamatan
        })
    },
    methods: {
        ...mapMutations('kecamatan', ['CLEAR_FORM']),
    },
    destroy() {
        this.CLEAR_FORM()
    }
}
</script>
