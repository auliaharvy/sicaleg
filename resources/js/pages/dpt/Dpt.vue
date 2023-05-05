<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <router-link :to="{ name: 'dpt.add' }" class="btn btn-primary btn-sm btn-flat">Tambah</router-link>
                <div class="pull-right">
                    <input type="text" class="form-control" placeholder="Cari..." v-model="search">
                </div>
            </div>
            <div class="panel-body">
                <b-table striped hover bordered :items="allDpt.data" :fields="fields" show-empty>
                   <template slot="actions" slot-scope="row">
                        <router-link :to="{ name: 'dpt.edit', params: {id: row.item.id} }" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i></router-link>
                        <button class="btn btn-danger btn-sm" @click="deleteDpt(row.item.id)"><i class="fa fa-trash"></i></button>
                    </template>
                </b-table>
                <div class="row">
                    <div class="col-md-6">
                        <p v-if="allDpt.data"><i class="fa fa-bars"></i> {{ allDpt.data.length }} item dari {{ allDpt.meta.total }} total data</p>
                    </div>
                    <div class="col-md-6">
                        <div class="pull-right">
                            <b-pagination
                                v-model="page"
                                :total-rows="allDpt.meta.total"
                                :per-page="allDpt.meta.per_page"
                                aria-controls="allDpt"
                                v-if="allDpt.data && allDpt.data.length > 0"
                                ></b-pagination>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapState } from 'vuex'

export default {
    name: 'DataDpt',
    created() {
        this.getAllDpt()
    },
    data() {
        return {
            fields: [
                { key: 'no_tps', label: 'No Tps' },
                { key: 'nik', label: 'NIK' },
                { key: 'nama', label: 'Nama' },
                { key: 'actions', label: 'Action' },
            ],
            search: ''
        }
    },
    computed: {
        ...mapState('dpt', {
            allDpt: state => state.allDpt
        }),
        page: {
            get() {
                return this.$store.state.dpt.page
            },
            set(val) {
                this.$store.commit('dpt/SET_PAGE', val)
            }
        }
    },
    watch: {
        page() {
            this.getAllDpt()
        },
        search() {
            this.getAllDpt(this.search)
        }
    },
    methods: {
        ...mapActions('dpt', ['getAllDpt', 'removeDpt']),
        deleteDpt(id) {
            this.$swal({
                title: 'Kamu Yakin?',
                text: "Tindakan ini akan menghapus secara permanent!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Iya, Lanjutkan!'
            }).then((result) => {
                if (result.value) {
                    this.removeDpt(id)
                }
            })
        }
    }
}
</script>