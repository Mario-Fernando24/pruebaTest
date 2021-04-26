<template>
<main class="main">
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
            </ol>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                
            </div>
            <div class="car-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-chart">
                            <div class="card-header">
                                <h4>Informe diario</h4>
                            </div>
                            <div class="card-content">
                                <div class="ct-chart">
                                    <canvas id="ingresos">                                                
                                    </canvas>
                                </div>
                            </div>
                            <div class="card-footer">
                                <p>Compras de los últimos meses.</p>
                            </div>
                        </div>
                    </div>
                </div>



                

            </div>
        </div>
    </div>

</main>
</template>
<script>
    export default {
        data (){
            return {
                varIngreso:null,
                charIngreso:null,

                ventaTotal:0,
                numVenta:0,
                MenorVenta:0, 
                mayorVenta:0
                
            }
        },
        methods : {
            getIngresos(){
                let me=this;
                var url= '/informes/grafica';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    
                      me.ventaTotal = respuesta.ventaTotal[0].total;
                      me.numVenta = respuesta.numVenta[0].total;
                      me.MenorVenta = respuesta.MenorVenta;
                      me.mayorVenta = respuesta.mayorVenta;

                    console.log(respuesta);
                    //cargamos los datos del chart
                    me.loadIngresos();
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
           
            
            loadIngresos(){
               var ctx = document.getElementById('ingresos').getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ['Venta Total', 'Venta de mayor valor', 'Venta de menor valor', 'Venta promedio', 'Numero de factura'],
                            datasets: [{
                                label: '# prueba',
                                data: [this.ventaTotal, this.mayorVenta, this.MenorVenta, this.ventaTotal/this.numVenta, this.numVenta],
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(255, 206, 86, 0.2)',
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(153, 102, 255, 0.2)',
                                    'rgba(255, 159, 64, 0.2)'
                                ],
                                borderColor: [
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 159, 64, 1)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });

            },
           
            
           
        },
        mounted() {
            this.getIngresos();
        }
    }
</script>
© 2021 GitHu