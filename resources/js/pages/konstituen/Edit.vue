<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Edit konstituen</h3>
            </div>
            <div class="panel-body">
                <konstituen-form></konstituen-form>
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
    import Formkonstituen from './Form.vue'
    export default {
        name: 'Editkonstituen',
        created() {
            this.editkonstituen(this.$route.params.id)
        },
        methods: {
            ...mapActions('konstituen', ['editkonstituen', 'updatekonstituen']),
            submit() {
                this.updatekonstituen(this.$route.params.id).then(() => {
                    this.$router.push({ name: 'konstituens.data' })
                })
            }
        },
        components: {
            'konstituen-form': Formkonstituen
        },
    }
</script>
