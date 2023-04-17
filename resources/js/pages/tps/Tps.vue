<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <router-link :to="{ name: 'tps.add' }" class="btn btn-primary btn-sm btn-flat">Tambah</router-link>
                <div class="pull-right">
                    <input type="text" class="form-control" placeholder="Cari..." v-model="search">
                </div>
            </div>
            <div class="panel-body">
                <b-table striped hover bordered :items="allTps.data" :fields="fields" show-empty>
                    <template slot="desa_id" slot-scope="row">
                        <p><strong>{{ row.item.nama_desa}}</strong></p>
                    </template>
                    <template slot="no_tps" slot-scope="row">
                        <p><strong>{{ row.item.no_tps}}</strong></p>
                    </template>
                    <template slot="jml_pemilih" slot-scope="row">
                        <p><strong>{{ row.item.jml_pemilih}}</strong></p>
                    </template>
                    <template slot="jumlah_konstituen" slot-scope="row">
                        <p><strong>{{ row.item.jumlah_konstituen}}</strong></p>
                    </template>
                    <template slot="pencapaian" slot-scope="row">
                        <div v-if="$root.pencapaian(row.item.jml_pemilih, row.item.jumlah_konstituen) <= 20" style="color: red; text-align: center;">
                            <p><strong>{{ $root.pencapaian(row.item.jml_pemilih, row.item.jumlah_konstituen) }}%</strong></p>
                        </div>
                        <div v-else-if="$root.pencapaian(row.item.jml_pemilih, row.item.jumlah_konstituen) <= 50" style="color: orange; text-align: center;">
                            <p><strong>{{ $root.pencapaian(row.item.jml_pemilih, row.item.jumlah_konstituen) }}%</strong></p>
                        </div> 
                        <div v-else-if="$root.pencapaian(row.item.jml_pemilih, row.item.jumlah_konstituen) <= 80" style="color: green; text-align: center;">
                            <p><strong>{{ $root.pencapaian(row.item.jml_pemilih, row.item.jumlah_konstituen) }}%</strong></p>
                        </div> 
                        <div v-else-if="$root.pencapaian(row.item.jml_pemilih, row.item.jumlah_konstituen) <= 100" style="color: blue; text-align: center;">
                            <p><strong>{{ $root.pencapaian(row.item.jml_pemilih, row.item.jumlah_konstituen) }}%</strong></p>
                        </div> 
                    </template>
                    <template slot="actions" slot-scope="row">
                        <router-link :to="{ name: 'tps.edit', params: { id: row.item.id }}" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i></router-link>
                        <button class="btn btn-danger btn-sm" @click="deleteTps(row.item.id)"><i class="fa fa-trash"></i></button>
                    </template>
               </b-table>
                <div class="row">
                    <div class="col-md-6">
                        <p v-if="allTps.data"><i class="fa fa-bars"></i> {{ allTps.data.length }} item dari {{ allTps.meta.total }} total data</p>
                    </div>
                    <div class="col-md-6">
                        <div class="pull-right">
                            <b-pagination
                                v-model="page"
                                :total-rows="allTps.meta.total"
                                :per-page="allTps.meta.per_page"
                                aria-controls="allTps"
                                v-if="allTps.data && allTps.data.length > 0"
                                ></b-pagination>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import { mapActions, mapState } from "vuex"
    export default {
        name: 'DataTps',
        data(){
            return {
                fields: [
                    { key: "desa_id", label: "Nama Desa" },
                    { key: "jml_pemilih", label: "Jumlah Pemilih" },
                    { key: "no_tps", label: "Nomor TPS" },
                    { key: "jumlah_konstituen", label: "Konstituen" },
                    { key: "pencapaian", label: "Pencapaian" },
                    { key: "actions", label: "Aksi" },
                ],
                search: '',
            }
        },
        created(){
            this.getAllTps()
        },
        computed: {
            ...mapState('tps', {
                allTps: state => state.allTps,
            }),
            page: {
                get(){
                    return this.$store.state.tps.page
                },
                set(val){
                    this.$store.commit("tps/SET_PAGE")
                }
            }
        },
        watch: {
            page(){
                return this.getAllTps()
            },
            search(){
                return this.getAllTps(this.search)
            }
        },
        methods: {
            ...mapActions('tps', ["getAllTps", "removeTps"]),
            deleteTps(id){
                this.$swal({
                    title: 'Kamu Yakin?',
                    text: "Tindakan ini akan menghapus secara permanent!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Iya, Lanjutkan!'
                }).then((result) => {
                    if(result.value){
                        this.removeTps(id)
                    }
                })
            }
        }
    }
</script>