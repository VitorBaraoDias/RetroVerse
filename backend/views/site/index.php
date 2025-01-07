<?php
$this->title = 'Home';
$this->params['breadcrumbs'] = [['label' => $this->title]];
$this->registerJsFile('https://cdn.jsdelivr.net/npm/chart.js', ['position' => \yii\web\View::POS_HEAD]);

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3><?= $lojaSalesCount ?></h3>

                    <p>New Orders</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3><?= $marketplaceSalesCount ?></h3>
                    <p>MarketPlace Orders</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3><?= $userCount ?></h3>

                    <p>User Registrations</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="<?= Yii::$app->urlManager->createUrl(['user/index']) ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>65</h3>

                    <p>Reports</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- Gráfico de Barras -->
        <div class="col-md-8">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Marketplace vs Store</h3>
                </div>
                <div class="box-body">
                    <!-- Gráfico de Barras com duas séries: Marketplace e Loja -->
                    <canvas id="comparisonChart" style="height: 230px;"></canvas>

                    <?php // Código para gerar o gráfico de barras com duas séries
                    $script = <<<JS

                    var ctx = document.getElementById('comparisonChart').getContext('2d');
                    var comparisonChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],  // Labels dos meses ou dados
                            datasets: [{
                                label: 'Marketplace',
                                data: $marketplaceSales,  // Dados para Marketplace
                                backgroundColor: 'rgba(60, 141, 188, 0.9)', // Cor de fundo das barras do Marketplace
                                borderColor: 'rgba(60, 141, 188, 0.8)',
                                borderWidth: 1
                            },
                            {
                                label: 'Loja',
                                data: $lojaSales,  // Dados para Loja
                                backgroundColor: 'rgba(255, 159, 64, 0.9)',  // Cor de fundo das barras da Loja
                                borderColor: 'rgba(255, 159, 64, 0.8)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            },
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(tooltipItem) {
                                            return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
                                        }
                                    }
                                }
                            }
                        }
                    });
                    JS;
                    $this->registerJs($script);
                    ?>
                </div>
            </div>
        </div>
        <!-- Gráfico Pie Chart em uma coluna de 4 -->
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Best-selling brands</h3>
                </div>
                <div class="box-body">
                    <!-- Gráfico Pie -->
                    <canvas id="pieChart" style="height: 230px;"></canvas>

                    <?php // Código para gerar o gráfico Pie Chart
                    $script = <<<JS

                    var ctx = document.getElementById('pieChart').getContext('2d');
                    var pieChart = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: $marcas, // Exemplo de categorias
                            datasets: [{
                                label: 'Category Distribution',
                                data: $quantidadeVendas, // Dados para as categorias
                                backgroundColor: [
                                    'rgba(60, 141, 188, 0.9)',
                                    'rgba(255, 159, 64, 0.9)',
                                    'rgba(0, 204, 0, 0.9)',
                                    'rgba(255, 99, 132, 0.9)'
                                ],
                                borderColor: [
                                    'rgba(60, 141, 188, 0.8)',
                                    'rgba(255, 159, 64, 0.8)',
                                    'rgba(0, 204, 0, 0.8)',
                                    'rgba(255, 99, 132, 0.8)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(tooltipItem) {
                                            return tooltipItem.dataset.label + ': ' + tooltipItem.raw + '%';
                                        }
                                    }
                                }
                            }
                        }
                    });
                    JS;
                    $this->registerJs($script);
                    ?>
                </div>
            </div>
        </div>
        <!-- ./col -->
    </div>
</div>
