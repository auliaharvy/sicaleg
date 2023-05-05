<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Edit C Satu</h3>
            </div>
            <div class="panel-body">
                <cSatu-form ref="formCSatu"></cSatu-form>
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
    import FormCSatu from './Form.vue'
    export default {
        name: 'EditCSatu',
        methods: {
            submit() {
                this.$refs.formCSatu.submit()
            }
        },
        components: {
            'cSatu-form': FormCSatu
        }
    }
</script>
