<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Edit tps</h3>
            </div>
            <div class="panel-body">
                <tps-form></tps-form>
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
    import FormTps from './Form.vue'
    export default {
        name: 'EditTps',
        created() {
            this.editTps(this.$route.params.id)
        },
        methods: {
            ...mapActions('tps', ['editTps', 'updateTps']),
            submit() {
                this.updateTps(this.$route.params.id).then(() => {
                    this.$router.push({ name: 'tps.data' })
                })
            }
        },
        components: {
            'tps-form': FormTps
        },
    }
</script>
