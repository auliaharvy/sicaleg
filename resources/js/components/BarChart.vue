<script>
    import { Bar } from 'vue-chartjs'

    export default {
        extends: Bar,
        props: ['dataTarget', 'dataActual', 'options', 'labels'],
        mounted() {
            this.lineRenderChart()
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
        methods: {
            lineRenderChart() {
                this.renderChart({
                    labels: this.labels,
                    datasets: [
                        {
                            label: 'Target',
                            data: this.dataTarget,
                            backgroundColor: 
                                'rgba(255, 99, 132, 0.2)'
                            ,
                            borderColor: 
                                'rgba(255,99,132,1)'
                            ,
                            borderWidth: 1
                        },
                        {
                            label: 'Actual',
                            data: this.dataActual,
                            backgroundColor: 
                                'rgba(20, 99, 20, 0.2)'
                            ,
                            borderColor: 
                                'rgba(20,99,20,1)'
                            ,
                            borderWidth: 1
                        }
                ]
                }, this.options)
            }
        }
    }
</script>