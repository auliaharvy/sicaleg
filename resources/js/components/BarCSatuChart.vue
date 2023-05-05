<script>
    import store from '../store'
    import { Bar } from 'vue-chartjs'
    import { mapActions, mapState } from 'vuex'

    export default {
        extends: Bar,
        props: ['dataChart', 'options', 'labels'],
        mounted() {
            this.lineRenderChart()
        },
        created(){
            this.getChartTps(1)
        },
        watch: {
            data: {
                handler() {
                    this._data._chart.destroy()
                    this.lineRenderChart()
                },
                deep: true
            }
        },
        computed: {
            ...mapState('tps', {
                chart: state => state.chart
            })
        },
        methods: {
            ...mapActions('tps', ['getChartTps']),
            lineRenderChart() {
                this.renderChart({
                    labels: this.labels,
                    datasets: [
                        {
                            label: 'Data',
                            data: this.dataChart,
                            backgroundColor: 
                                'rgba(255, 99, 132, 0.2)'
                            ,
                            borderColor: 
                                'rgba(255,99,132,1)'
                            ,
                            borderWidth: 1
                        },
                    ]
                }, this.options)
            }
        }
    }
</script>