<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <router-link :to="{ name: 'desas.add' }" class="btn btn-primary btn-sm btn-flat">Tambah</router-link>
                <div class="pull-right">
                    <input type="text" class="form-control" placeholder="Cari..." v-model="search">
                </div>
            </div>
            <div class="panel-body">
                <b-table striped hover bordered :items="desas.data" :fields="fields" show-empty>
                    <template slot="pemilih_pria" slot-scope="row">
                        <p><strong>{{ $root.formatPrice(row.item.pemilih_pria) }}</strong></p>
                    </template>
                    <template slot="pemilih_wanita" slot-scope="row">
                        <p><strong>{{ $root.formatPrice(row.item.pemilih_wanita) }}</strong></p>
                    </template>
                    <template slot="total" slot-scope="row">
                        <p><strong>{{ $root.formatPrice(row.item.pemilih_pria + row.item.pemilih_wanita) }}</strong></p>
                    </template>
                    <template slot="total_konstituen" slot-scope="row">
                        <p><strong>{{ $root.formatPrice(row.item.jumlah_konstituen) }}</strong></p>
                    </template>
                    <template slot="pencapaian" slot-scope="row">
                        <div v-if="$root.pencapaian((row.item.pemilih_pria + row.item.pemilih_wanita), row.item.jumlah_konstituen) <= 20" style="color: red; text-align: center;">
                            <p><strong>{{ $root.pencapaian((row.item.pemilih_pria + row.item.pemilih_wanita), row.item.jumlah_konstituen) }}%</strong></p>
                        </div>
                        <div v-else-if="$root.pencapaian((row.item.pemilih_pria + row.item.pemilih_wanita), row.item.jumlah_konstituen) <= 50" style="color: orange; text-align: center;">
                            <p><strong>{{ $root.pencapaian((row.item.pemilih_pria + row.item.pemilih_wanita), row.item.jumlah_konstituen) }}%</strong></p>
                        </div> 
                        <div v-else-if="$root.pencapaian((row.item.pemilih_pria + row.item.pemilih_wanita), row.item.jumlah_konstituen) <= 80" style="color: green; text-align: center;">
                            <p><strong>{{ $root.pencapaian((row.item.pemilih_pria + row.item.pemilih_wanita), row.item.jumlah_konstituen) }}%</strong></p>
                        </div> 
                        <div v-else-if="$root.pencapaian((row.item.pemilih_pria + row.item.pemilih_wanita), row.item.jumlah_konstituen) <= 100" style="color: blue; text-align: center;">
                            <p><strong>{{ $root.pencapaian((row.item.pemilih_pria + row.item.pemilih_wanita), row.item.jumlah_konstituen) }}%</strong></p>
                        </div> 
                    </template>
                    <template slot="actions" slot-scope="row">
                        <router-link :to="{ name: 'desas.edit', params: {id: row.item.code} }" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i></router-link>
                        <button class="btn btn-danger btn-sm" @click="deleteData(row.item.id)"><i class="fa fa-trash"></i></button>
                    </template>
                </b-table>

                <div class="row">
                    <div class="col-md-6">
                        <p v-if="desas.data"><i class="fa fa-bars"></i> {{ desas.data.length }} item dari {{ desas.meta.total }} total data</p>
                    </div>
                    <div class="col-md-6">
                        <div class="pull-right">
                            <b-pagination
                                v-model="page"
                                :total-rows="desas.meta.total"
                                :per-page="desas.meta.per_page"
                                aria-controls="desas"
                                v-if="desas.data && desas.data.length > 0"
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
    name: 'Datadesa',
    created() {
        this.getdesas()
    },
    data() {
        return {
            fields: [
                { key: 'nama', label: 'Nama desa' },
                { key: 'nama_kecamatan', label: 'Kecamatan' },
                { key: 'pemilih_pria', label: 'Pemilih Pria' },
                { key: 'pemilih_wanita', label: 'Pemilih Wanita' },
                { key: 'total', label: 'Total Pemilih' },
                { key: 'jumlah_konstituen', label: 'Konstituen' },
                { key: 'pencapaian', label: 'Pencapaian' },
                { key: 'total_tps', label: 'Jumlah TPS' },
            ],
            search: ''
        }
    },
    computed: {
        ...mapState('desa', {
            desas: state => state.desas
        }),
        page: {
            get() {
                return this.$store.state.desa.page
            },
            set(val) {
                this.$store.commit('desa/SET_PAGE', val)
            }
        }
    },
    watch: {
        page() {
            this.getdesas()
        },
        search() {
            this.getdesas(this.search)
        }
    },
    methods: {
        ...mapActions('desa', ['getdesas', 'removedesa']),
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
                    this.removedesa(id)
                }
            })
        }
    }
}
</script>