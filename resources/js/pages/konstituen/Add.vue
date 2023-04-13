<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Add New konstituen</h3>
            </div>
            <div class="panel-body">
                <konstituen-form></konstituen-form>
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
    import Formkonstituen from './Form.vue'
    export default {
        name: 'Addkonstituen',
        data() {
            return {
                
            }
        },
        methods: {
            ...mapActions('konstituen', ['submitkonstituen']),
            submit() {
                this.submitkonstituen().then(() => {
                    this.$router.push({ name: 'konstituens.data' })
                })
            }
        },
        components: {
            'konstituen-form': Formkonstituen
        }
    }
</script>
