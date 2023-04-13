<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <router-link :to="{ name: 'kecamatans.add' }" class="btn btn-primary btn-sm btn-flat">Tambah</router-link>
                <div class="pull-right">
                    <input type="text" class="form-control" placeholder="Cari..." v-model="search">
                </div>
            </div>
            <div class="panel-body">
                <b-table striped hover bordered :items="kecamatans.data" :fields="fields" show-empty>
                    <template slot="pemilih_pria" slot-scope="row">
                        <p><strong>{{ $root.formatPrice(row.item.pemilih_pria) }}</strong></p>
                    </template>
                    <template slot="pemilih_wanita" slot-scope="row">
                        <p><strong>{{ $root.formatPrice(row.item.pemilih_wanita) }}</strong></p>
                    </template>
                    <template slot="total_pemilih" slot-scope="row">
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
                        <router-link :to="{ name: 'kecamatans.edit', params: {id: row.item.code} }" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i></router-link>
                        <button class="btn btn-danger btn-sm" @click="deleteData(row.item.id)"><i class="fa fa-trash"></i></button>
                    </template>
                </b-table>

                <div class="row">
                    <div class="col-md-6">
                        <p v-if="kecamatans.data"><i class="fa fa-bars"></i> {{ kecamatans.data.length }} item dari {{ kecamatans.meta.total }} total data</p>
                    </div>
                    <div class="col-md-6">
                        <div class="pull-right">
                            <b-pagination
                                v-model="page"
                                :total-rows="kecamatans.meta.total"
                                :per-page="kecamatans.meta.per_page"
                                aria-controls="kecamatans"
                                v-if="kecamatans.data && kecamatans.data.length > 0"
                                ></b-pagination>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { pencapaian } from "../../utils/helper"
import { mapActions, mapState } from 'vuex'

export default {
    name: 'DataKecamatan',
    created() {
        this.getKecamatans()
    },
    data() {
        return {
            fields: [
                { key: 'nama', label: 'Nama Kecamatan' },
                { key: 'dapil', label: 'Dapil' },
                { key: 'pemilih_pria', label: 'Pemilih Pria' },
                { key: 'pemilih_wanita', label: 'Pemilih Wanita' },
                { key: 'total_pemilih', label: 'Total Pemilih' },
                { key: 'total_konstituen', label: 'Total Konstituen' },
                { key: 'pencapaian', label: 'Pencapaian' },
                { key: 'total_tps', label: 'Jumlah TPS' },
            ],
            search: ''
        }
    },
    computed: {
        ...mapState('kecamatan', {
            kecamatans: state => state.kecamatans
        }),
        page: {
            get() {
                return this.$store.state.kecamatan.page
            },
            set(val) {
                this.$store.commit('kecamatan/SET_PAGE', val)
            }
        }
    },
    watch: {
        page() {
            this.getKecamatans()
        },
        search() {
            this.getKecamatans(this.search)
        }
    },
    methods: {
        ...mapActions('kecamatan', ['getKecamatans', 'removeKecamatan']),
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
                    this.removeKecamatan(id)
                }
            })
        }
    }
}
</script>
