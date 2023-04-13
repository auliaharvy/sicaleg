<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Add New desa</h3>
            </div>
            <div class="panel-body">
                <desa-form></desa-form>
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
    import Formdesa from './Form.vue'
    export default {
        name: 'Adddesa',
        data() {
            return {
                
            }
        },
        methods: {
            ...mapActions('desa', ['submitdesa']),
            submit() {
                this.submitdesa().then(() => {
                    this.$router.push({ name: 'desas.data' })
                })
            }
        },
        components: {
            'desa-form': Formdesa
        }
    }
</script>
