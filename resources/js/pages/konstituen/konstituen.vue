<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <router-link :to="{ name: 'konstituens.add' }" class="btn btn-primary btn-sm btn-flat">Tambah</router-link>
                <div class="pull-right">
                    <input type="text" class="form-control" placeholder="Cari..." v-model="search">
                </div>
            </div>
            <div class="panel-body">
                <b-table striped hover bordered :items="konstituens.data" :fields="fields" show-empty>
                    <template slot="nama" slot-scope="row">
                        <p>
                            <strong>{{ row.item.nama }}</strong><br>
                            <small>{{ row.item.nik }}</small>
                        </p>
                    </template>
                    <template slot="actions" slot-scope="row">
                        <router-link :to="{ name: 'konstituens.edit', params: {id: row.item.code} }" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i></router-link>
                        <button class="btn btn-danger btn-sm" @click="deleteData(row.item.id)"><i class="fa fa-trash"></i></button>
                    </template>
                </b-table>

                <div class="row">
                    <div class="col-md-6">
                        <p v-if="konstituens.data"><i class="fa fa-bars"></i> {{ konstituens.data.length }} item dari {{ konstituens.meta.total }} total data</p>
                    </div>
                    <div class="col-md-6">
                        <div class="pull-right">
                            <b-pagination
                                v-model="page"
                                :total-rows="konstituens.meta.total"
                                :per-page="konstituens.meta.per_page"
                                aria-controls="konstituens"
                                v-if="konstituens.data && konstituens.data.length > 0"
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
    name: 'Datakonstituen',
    created() {
        this.getkonstituens()
    },
    data() {
        return {
            fields: [
                { key: 'nama', label: 'Nama konstituen' },
                { key: 'nama_desa', label: 'Desa' },
                { key: 'nama_kecamatan', label: 'Kecamatan' },
                { key: 'rekruter', label: 'Timses Perekrut' },
            ],
            search: ''
        }
    },
    computed: {
        ...mapState('konstituen', {
            konstituens: state => state.konstituens
        }),
        page: {
            get() {
                return this.$store.state.konstituen.page
            },
            set(val) {
                this.$store.commit('konstituen/SET_PAGE', val)
            }
        }
    },
    watch: {
        page() {
            this.getkonstituens()
        },
        search() {
            this.getkonstituens(this.search)
        }
    },
    methods: {
        ...mapActions('konstituen', ['getkonstituens', 'removekonstituen']),
        deleteData(id) {
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
                    this.removekonstituen(id)
                }
            })
        }
    }
}
</script>
