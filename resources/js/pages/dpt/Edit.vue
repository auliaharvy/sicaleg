<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Edit Dpt</h3>
            </div>
            <div class="panel-body">
                <dpt-form></dpt-form>
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
    import FormDpt from './Form.vue'
    export default {
        name: 'EditDpt',
        created() {
            this.editDpt(this.$route.params.id)
        },
        methods: {
            ...mapActions('dpt', ['editDpt', 'updateDpt']),
            submit() {
                this.updateDpt(this.$route.params.id).then(() => {
                    this.$router.push({ name: 'dpt.data' })
                })
            }
        },
        components: {
            'dpt-form': FormDpt
        },
    }
</script>
