<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Add New Kecamatan</h3>
            </div>
            <div class="panel-body">
                <kecamatan-form></kecamatan-form>
                <div class="form-group">
                    <button class="btn btn-primary btn-sm btn-flat" @click.prevent="submit">
                        <i class="fa fa-save"></i> Add New
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import { mapActions, mapState, mapMutations } from 'vuex'
    import FormKecamatan from './Form.vue'
    export default {
        name: 'AddKecamatan',
        data() {
            return {
                
            }
        },
        methods: {
            ...mapActions('kecamatan', ['submitKecamatan']),
            submit() {
                this.submitKecamatan().then(() => {
                    this.$router.push({ name: 'kecamatans.data' })
                })
            }
        },
        components: {
            'kecamatan-form': FormKecamatan
        }
    }
</script>
