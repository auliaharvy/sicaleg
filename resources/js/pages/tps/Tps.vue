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
                    <template slot="jumlah_dpt" slot-scope="row">
                        <p><strong>{{ row.item.jumlah_pemilih}}</strong></p>
                    </template>
                    <template slot="jumlah_konstituen" slot-scope="row">
                        <p><strong>{{ row.item.jumlah_konstituens}}</strong></p>
                    </template>
                    <template slot="pencapaian" slot-scope="row">
                        <div v-if="$root.pencapaian(row.item.jumlah_pemilih, row.item.jumlah_konstituens) <= 20" style="color: red; text-align: center;">
                            <p><strong>{{ $root.pencapaian(row.item.jumlah_pemilih, row.item.jumlah_konstituens) }}%</strong></p>
                        </div>
                        <div v-else-if="$root.pencapaian(row.item.jumlah_pemilih, row.item.jumlah_konstituens) <= 50" style="color: orange; text-align: center;">
                            <p><strong>{{ $root.pencapaian(row.item.jumlah_pemilih, row.item.jumlah_konstituens) }}%</strong></p>
                        </div> 
                        <div v-else-if="$root.pencapaian(row.item.jumlah_pemilih, row.item.jumlah_konstituens) <= 80" style="color: green; text-align: center;">
                            <p><strong>{{ $root.pencapaian(row.item.jumlah_pemilih, row.item.jumlah_konstituens) }}%</strong></p>
                        </div> 
                        <div v-else-if="$root.pencapaian(row.item.jumlah_pemilih, row.item.jumlah_konstituens) <= 100" style="color: blue; text-align: center;">
                            <p><strong>{{ $root.pencapaian(row.item.jumlah_pemilih, row.item.jumlah_konstituens) }}%</strong></p>
                        </div> 
                    </template>
                    <template slot="c1" slot-scope="row">
                        <router-link v-if="row.item.foto == null" :to="{ name: 'tps.cSatu.add', params: {id: row.item.id}}" class="btn btn-info btn-sm"><i class="fa fa-plus"></i></router-link>
                        <b-button v-b-tooltip.hover title="Lihat C1" class="btn btn-primary btn-sm" @click="readCSatu(row.item.id_cSatu, row.item.foto, row.item.jml_suara)"><i class="fa fa-eye"></i></b-button>
                        <!-- <b-modal v-model="modal">Hello From Modal!</b-modal> -->
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
                <div>{{ chart }}</div>
                <bar-c-satu-chart v-show="showBarChart" :dataChart="dataChart" :options="chartOptions" :labels="labels"/>
            </div>
        </div>
    </div>
</template>
<script>
    import { mapActions, mapState } from "vuex"
    import moment from 'moment'
    import _ from 'lodash'
    import router from '../../router'
    import BarCSatuChart from '../../components/BarCSatuChart.vue'
    export default {
        name: 'DataTps',
        data(){
            return {
                fields: [
                    { key: "no_tps", label: "Nomor TPS" },
                    { key: "jumlah_pemilih", label: "Jumlah Pemilih" },
                    { key: "desa_id", label: "Nama Desa" },
                    { key: "jumlah_konstituens", label: "Konstituen" },
                    { key: "pencapaian", label: "Pencapaian" },
                    { key: "c1", label: "C1" },
                    { key: "actions", label: "Aksi" },
                ],
                search: '',
                modal: false,
                modalShow: false,
                showBarChart: false,
                chartOptions: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                    yAxes: [
                        {
                            ticks: {
                                beginAtZero: true
                            }
                        }
                    ]
                }
            },
            }
        },
        created(){
            this.getAllTps()
            this.getChartDataDesa()
            this.getChartTps(1)
        },
        computed: {
            ...mapState('tps', {
                allTps: state => state.allTps,
            }),
            ...mapState('desa', {
                desas: state => state.desas,
            }),
            ...mapState('tps', {
                chart: state => state.chart,
            }),
            ...mapState('dashboard', {
                transactions: state => state.transactions,
            }),
            page: {
                get(){
                    return this.$store.state.tps.page
                },
                set(val){
                    this.$store.commit("tps/SET_PAGE")
                }
            },
            labels(){
                return ['Jumlah DPT', 'Jumlah Konstituen', 'Jumlah Suara']
            },
            dataDesa(){
                return _.map(this.desas, function(o){
                    return o.pemilih_pria
                })
            },
            dataChart(){
                // return [30, 40, 50]
                // console.log(this.chart)
                // return _.map(this.chart, function(o){
                //     console.log(o.jumlah_pemilih)
                //     console.log(o.jumlah_konstituens)
                //     console.log(o.jumlah_suara)
                //     return [ 
                //         o.jumlah_pemilih,
                //         o.jumlah_konstituens,
                //         o.jumlah_suara,
                //     ] 
                // })
                // console.log(this.chart)
                // return [this.chart[0].jumlah_pemilih, this.chart[0].jumlah_konstituens, this.chart[0].jumlah_suara]
                // return [this.chart.jumlah_pemilih, this.chart.jumlah_konstituens, this.chart.jumlah_suara]
                // return [20, 20, this.chart.jumlah_pemilih]
                // return this.chart
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
            ...mapActions('tps', ["getAllTps", "editTps", "removeTps", 'getChartTps']),
            ...mapActions('dashboard', ["getChartDataDesa"]),
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
            },
           readCSatu(id, foto, jumlah_pemilih) {
                // this.showBarChart = true;
                this.$swal({
                    title: `Jumlah suara pada C1 : ${jumlah_pemilih}`,
                    imageUrl: `/storage/cSatu/${foto}`,
                    imageWidth: 400,
                    imageHeight: 200,
                    imageAlt: 'Custom image',
                    animation: false,
                    html: '<bar-c-satu-chart :data="data" :options="chartOptions" :labels="labels"/>',
                    showCloseButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Edit!',
                    onOpen: () => {
                      // Membuat grafik ketika SweetAlert2 dibuka
                      this.$nextTick(() => {
                      });
                    }
                }).then((result) => {
                    if(result.value){
                        router.push(`/tps/c1/edit/` + id)
                    }
                });
            },
        },
        components: {
            'bar-c-satu-chart':BarCSatuChart 
        }
    }
</script>