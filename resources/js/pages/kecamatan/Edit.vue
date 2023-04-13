<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Edit Kecamatan</h3>
            </div>
            <div class="panel-body">
                <kecamatan-form></kecamatan-form>
                <div class="form-group">
                    <button class="btn btn-primary btn-sm btn-flat" @click.prevent="submit">
                        <i class="fa fa-save"></i> Update
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import { mapActions, mapState } from 'vuex'
    import FormKecamatan from './Form.vue'
    export default {
        name: 'EditKecamatan',
        created() {
            this.editKecamatan(this.$route.params.id)
        },
        methods: {
            ...mapActions('kecamatan', ['editKecamatan', 'updateKecamatan']),
            submit() {
                this.updateKecamatan(this.$route.params.id).then(() => {
                    this.$router.push({ name: 'kecamatans.data' })
                })
            }
        },
        components: {
            'kecamatan-form': FormKecamatan
        },
    }
</script>
