<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Add New TPS</h3>
            </div>
            <div class="panel-body">
                <tps-form></tps-form>
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
    import FormTps from './Form.vue'
    export default {
        name: 'AddTps',
        data() {
            return {
                
            }
        },
        methods: {
            ...mapActions('tps', ['submitTps']),
            ...mapActions('cSatu', ['submitCSatu']),
            submit() {
                if(this.$route.name == 'tps.add' || this.$route.name == 'tps.edit'){
                    this.submitTps().then(() => {
                        this.$router.push({ name: 'tps.data' })
                    })
                }else if(this.$route.name == 'tps.cSatu.add' || this.$route.name == 'tps.cSatu.edit'){
                    this.submitCSatu().then(() => {
                        this.$router.push({ name: 'tps.data'})
                    })
                }
            }
        },
        components: {
            'tps-form': FormTps
        }
    }
</script>
