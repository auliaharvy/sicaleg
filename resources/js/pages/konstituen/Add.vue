<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Add New Konstituen</h3>
            </div>
            <div class="panel-body">
                <konstituen-form ref="formKonstituen"></konstituen-form>
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
    import FormKonstituen from './Form.vue'
    export default {
        name: 'AddKonstituen',
        methods: {
            submit() {
                this.$refs.formKonstituen.submit()
            }
        },
        components: {
            'konstituen-form': FormKonstituen
        }
    }
</script>
