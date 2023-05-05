<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Add New Dpt</h3>
            </div>
            <div class="panel-body">
                <dpt-form></dpt-form>
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
    import FormDpt from './Form.vue'
    export default {
        name: 'AddDpt',
        data() {
            return {
                
            }
        },
        methods: {
            ...mapActions('dpt', ['submitDpt']),
            submit() {
                this.submitDpt().then(() => {
                    this.$router.push({ name: 'dpt.data' })
                })
            }
        },
        components: {
            'dpt-form': FormDpt
        }
    }
</script>
