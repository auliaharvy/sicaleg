<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Edit desa</h3>
            </div>
            <div class="panel-body">
                <desa-form></desa-form>
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
    import Formdesa from './Form.vue'
    export default {
        name: 'Editdesa',
        created() {
            this.editdesa(this.$route.params.id)
        },
        methods: {
            ...mapActions('desa', ['editdesa', 'updatedesa']),
            submit() {
                this.updatedesa(this.$route.params.id).then(() => {
                    this.$router.push({ name: 'desas.data' })
                })
            }
        },
        components: {
            'desa-form': Formdesa
        },
    }
</script>
