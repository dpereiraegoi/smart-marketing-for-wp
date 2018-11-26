<?php

if ( ! defined( 'ABSPATH' ) ) { die();}

$lists = $this->smsnf_get_form_subscriber_total_by('list');

$lists_chart = $this->smsnf_get_form_subscribers_list(null, 12);
$chart_months = "\"".implode("\",\"", $lists_chart['months'])."\"";

if (!isset($this->options_list['list']) || $this->options_list['list'] == "") {
    $options_list = $lists[0]->list_id;
} else {
    $options_list = $this->options_list['list'];
}

$last_subscribers = $this->smsnf_get_form_subscribers_last(5);

$forms = $this->smsnf_get_form_subscriber_total_by('form');


// AJAX
$client = $this->smsnf_get_account_info();

$campaigns = $this->smsnf_last_campaigns_reports();

$campaign_email = implode(",", $campaigns['email']['chart']);
$campaign_sms = implode(",", $campaigns['sms_premium']['chart']);

?>
<!-- Header -->
<div class="container">
  <div class="columns">
    <div class="column">
        <div class="smsnf-header">
            <span class="smsnf-header__logo"></span>
            <h1>Smart Marketing - <?php _e( 'Dashboard', 'egoi-for-wp' ); ?></h1>
        </div>
        <div class="smsnf-header__breadcrumbs">
            <span class="prefix">
                <?php echo __( 'You are here: ', 'egoi-for-wp' ); ?>
            </span>    
                <strong>Smart Marketing</a> &rsaquo;
                    <a href="#">
                        <span class="current-crumb">
                        <?php _e( 'Dashboard', 'egoi-for-wp' ); ?>
                    </a>
                </strong>
            </span>
        </div>
        <hr/>
    </div>
  </div>
</div><!-- /header -->

<!-- Wrap -->
<div class="smsnf-dashboard">
    <div class="container">
        <div class="columns">

            <!-- Notifications | Upgrade Account -->
            <?php if ($this->smsnf_show_notification('upgrade-account') == true) { ?>
            <div class="column col-12">
                <div class="smsnf-dashboard-notifications notice is-dismissible">
                    <div class="smsnf-dashboard-notifications__img">
                        <figure class="avatar avatar-xl smsnf-dashboard-notifications__img--upgrade"></figure>
                    </div>
                    <div class="smsnf-dashboard-notifications__copy">
                        <h3>Upgrade da Conta</h3>
                        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt</p>
                    </div>
                    <div class="smsnf-dashboard-notifications__btn">
                        <a class="hide-sm hide-xs hide-notification-button" type="button" data-notification="upgrade-account">
						    <?php echo __('Hide notification', 'egoi-for-wp');?>
						</a>
                        <a type="button" id="" class="button-smsnf-primary"> 
						    <?php echo __('Upgrade', 'egoi-for-wp');?>
						</a>
                    </div>
                </div>
            </div>
            <?php } ?>

            <?php if ($this->smsnf_show_notification('account-limit') == true) { ?>
            <!-- Notifications | Account -->
            <div class="column col-12">
                <div class="smsnf-dashboard-notifications notice is-dismissible">
                    <div class="smsnf-dashboard-notifications__img">
                        <figure class="avatar avatar-xl smsnf-dashboard-notifications__img--limit"></figure>
                    </div>
                    <div class="smsnf-dashboard-notifications__copy">
                        <h3>Já atingiu 80% do seu saldo disponível</h3>
                        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt</p>
                    </div>
                    <div class="smsnf-dashboard-notifications__btn">
                        <a class="hide-sm hide-xs hide-notification-button" type="button" data-notification="account-limit">
						    <?php echo __('Hide notification', 'egoi-for-wp');?>
						</a>
                        <a type="button" id="" class="button-smsnf-primary"> 
						    <?php echo __('Upgrade', 'egoi-for-wp');?>
						</a>
                    </div>
                </div>
            </div>
            <?php } ?>

            <!-- Column Left Start -->
            <!-- Last Subscribers table / Subscribers by List / Subscribers by Form / Last Email Campaign /  Last SMS Campaign  -->
            <div class="column col-8 col-md-12 col-xs-12 mt-3">
                <div class="columns">
                    <!-- Registrations made today -->
                    <div class="column col-4 col-md-12 col-xs-12">
                        <div class="smsnf-dashboard-subs-stats">
                            <div class="smsnf-dashboard-subs-stats__content">
                                <h3>Registos<br>Hoje
                                    <span class="smsnf-dashboard-subs-stats__content--result">
                                        <?php echo $this->smsnf_get_form_susbcribers_total('today')->total; ?>
                                    </span>
                                </h3>
                            </div>
                            <div>
                                <img src="<?php echo plugins_url().'/smart-marketing-for-wp/admin/img/subscribers-today.png'; ?>"/>
                            </div>
                        </div>
                    </div>

                    <!-- Total Subscribers -->
                    <div class="column col-4 col-md-12 col-xs-12">
                        <div class="smsnf-dashboard-subs-stats">
                            <div class="smsnf-dashboard-subs-stats__content">
                                <h3>Total<br>Subscritores
                                    <span class="smsnf-dashboard-subs-stats__content--result e-goi-tooltip">
                                        <?php echo $this->smsnf_get_form_susbcribers_total('ever')->total; ?>
                                            <span class="e-goi-tooltiptext e-goi-tooltiptext--active">
                                                Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy
                                            </span>
                                    </span>
                                </h3>
                            </div>
                            <div>
                                <img src="<?php echo plugins_url().'/smart-marketing-for-wp/admin/img/total-subscribers.png'; ?>"/>
                            </div>
                        </div>
                    </div>

                    <!-- Best day -->
                    <div class="column col-4 col-md-12 col-xs-12">
                        <div class="smsnf-dashboard-subs-stats">
                            <div class="smsnf-dashboard-subs-stats__content">
                                <h3>Melhor<br>Dia
                                    <span class="smsnf-dashboard-subs-stats__content--result bestday e-goi-tooltip">
                                        <?php echo date('d M Y', strtotime($this->smsnf_get_form_subscribers_best_day()->date)); ?>
                                            <span class="e-goi-tooltiptext e-goi-tooltiptext--active">
                                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy
                                            </span>
                                    </span>
                                </h3>
                            </div>
                            <div>
                                <img src="<?php echo plugins_url().'/smart-marketing-for-wp/admin/img/bestday.png'; ?>"/>
                            </div>
                        </div>
                    </div>


                </div>
                <!-- Last Subscribers table -->
                <div class="smsnf-dashboard-last-subscribers mt-3">
                    <div class="smsnf-dashboard-last-subscribers__title">
                        Últimos subscritores
                    </div>
                    <div class="smsnf-dashboard-last-subscribers__empty <?php echo count($last_subscribers) > 0 ? 'd-none' : null;?>">
                         <p>Ainda não tem subscritores</p>
                         <div></div>
                    </div>
                    <table class="table <?php echo count($last_subscribers) == 0 ? 'd-none' : null;?>">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th class="hide-xs">Email</th>
                                <th>Formulário ID</th>
                                <th>Formulário</th>
                                <th class="hide-xs">Data</th>
                                <th>Lista</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($last_subscribers as $subscriber) { ?>
                            <tr>
                                <td><?php echo $subscriber->subscriber_name; ?></td>
                                <td class="hide-xs"><?php echo $subscriber->subscriber_email; ?></td>
                                <td><?php echo $subscriber->form_id; ?></td>
                                <td><?php echo $subscriber->form_title; ?></td>
                                <td class="hide-xs"><?php echo date('Y/m/d H\hm', strtotime($subscriber->created_at)); ?></td>
                                <td><?php echo $subscriber->list_title; ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="columns">
                    <div class="column col-6 col-xl-12 col-xs-12">
                        <!-- Subscribers by List -->
                        <div class="smsnf-dashboard-subscribers-by-lists mt-3">
                            <div class="smsnf-dashboard-subscribers-by-lists__title">
                                Subscritores por Listas
                            </div>
                            <div class="smsnf-dashboard-subscribers-by-lists__empty <?php echo count($lists) > 0 ? 'd-none' : null;?>">
                                <p>Ainda não tem registos</p>
                            </div>
                            <div class="smsnf-dashboard-subscribers-by-lists__chart <?php echo count($lists) == 0 ? 'd-none' : null;?>">
                                <div class="smsnf-dashboard-subscribers-by-lists__content">
                                    
                                    <div>
                                        <!-- <p style="font-size: 11px; margin: 0;">Seleccione a Lista</p> -->
                                        <select id="chart_list">
                                            <?php foreach ($lists as $list) { ?>
                                                <option value="<?php echo implode(",", $lists_chart[$list->list_id]['totals']);?>" <?php selected($list->list_id, $options_list);?> >
                                                    <?=$list->title?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    
                                    <div>Total:
                                        <span class="smsnf-dashboard-subscribers-by-lists__content--total" id="list_subscribers_total">
                                            <?php
                                            $total = 0;
                                            foreach ($lists as $list) {
                                                $total = $list->list_id == $options_list ? $list->total : null;
                                            }
                                            echo $total == 0 ? $lists[0]->total : $total;
                                            ?>
                                        </span>
                                    </div>

                                </div>
                                <canvas id="smsnf-dsbl__lineChart" height="120"></canvas>
                            </div>
                        </div>
                        <!-- Last SMS Campaign -->
                        <div class="smsnf-dashboard-last-sms-campaign mt-3">
                            <div class="smsnf-dashboard-last-sms-campaign__title">
                                Última campanha de SMS Enviada
                            </div>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>Nome</td>
                                        <td><?=$campaigns['sms_premium']['name']?></td>
                                    </tr>
                                    <tr>
                                        <td>Nome Interno</td>
                                        <td><?=$campaigns['sms_premium']['internal_name']?></td>
                                    </tr>
                                    <tr>
                                        <td>ID</td>
                                        <td><?php echo $campaigns['sms_premium']['id'];?></td>
                                    </tr>
                                    <tr>
                                        <td>Total de Envios</td>
                                        <td class="smsnf-dashboard-last-sms-campaign__totalsend"><?=$campaigns['sms_premium']['sent']?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <?php if ($campaigns['sms_premium']['sent'] > 0) { ?>
                            <div class="smsnf-dashboard-last-sms-campaign__chart">
                                <canvas id="smsnf-dlsc__doughnutChart" height="120"></canvas>
                            </div>
                            <?php } else { ?>
                            <div>A guardar resultados</div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="column col-6 col-xl-12 col-xs-12">
                        <!-- Subscribers by Form -->
                        <div class="smsnf-dashboard-last-subscribers-by-form mt-3">
                            <div class="smsnf-dashboard-last-subscribers-by-form__title">
                                Subscritores por Formulário
                            </div>
                            <div class="smsnf-dashboard-last-subscribers-by-form__empty <?php echo count($forms) > 0 ? 'd-none' : null;?>">
                                <p>Ainda não tem registos</p>
                            </div>
                            <div class="smsnf-dashboard-last-subscribers-by-form__table <?php echo count($forms) == 0 ? 'd-none' : null;?>">
                                <table class="table">
                                    <tbody>
                                        <th>ID do Formulário</th>
                                        <th>Nome do Formulário</th>
                                        <th>Nº de subscritores</th>
                                    <?php foreach ($forms as $form) { ?>
                                        <tr>
                                            <td class="smsnf-dashboard-last-subscribers-by-form__table__ltd"><?=$form->form_id?></td>
                                            <td class="smsnf-dashboard-last-subscribers-by-form__table__ltd"><?=$form->title?></td>
                                            <td class="smsnf-dashboard-last-subscribers-by-form__table__rtd"><?=$form->total?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- Last Email Campaign --> 
                        <div class="smsnf-dashboard-last-email-campaign mt-3">
                            <div class="smsnf-dashboard-last-email-campaign__title">
                                Última campanha de Email Enviada
                            </div>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>Nome</td>
                                        <td><?=$campaigns['email']['name']?></td>
                                    </tr>
                                    <tr>
                                        <td>Nome Interno</td>
                                        <td><?=$campaigns['email']['internal_name']?></td>
                                    </tr>
                                    <tr>
                                        <td>ID</td>
                                        <td><?php echo $campaigns['email']['id'];?></td>
                                    </tr>
                                    <tr>
                                        <td>Total de Envios</td>
                                        <td class="smsnf-dashboard-last-email-campaign__totalsend"><?=$campaigns['email']['sent']?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <?php if ($campaigns['email']['sent'] > 0) { ?>
                            <div class="smsnf-dashboard-last-email-campaign__chart">
                                <canvas id="smsnf-dlec__doughnutChart" height="120"></canvas>
                            </div>
                            <?php } else { ?>
                            <div>A aguardar resultado</div>
                            <?php } ?>
                        </div>
                    </div>
                </div><!-- /columns -->
            </div> <!-- /col-8 -->

            <!-- Column Right Start -->
            <div class="column col-4 col-md-12 col-xs-12 mt-3">
                <!-- Account -->
                <div class="smsnf-dashboard-account">
                    <!-- If the sms addon is active -->
                    <div style="display: inherit;">
                        <div class="smsnf-dashboard-account__title">
                            <div>A sua conta</div>
                            <div class="smsnf-dashboard-account__title__cta">
                                <a href="#" target="_blank">Atualizar dados da conta<span class="dashicons dashicons-external"></span></a>
                            </div>
                        </div>
                        <div class="smsnf-dashboard-account__content p-0">
                            <div class="smsnf-dashboard-account__content__table">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td><span class="smsnf-dashboard-account__content__table--total">Saldo Atual</span></td>
                                            <td><span class="smsnf-dashboard-account__content__table--cash"><?=$client->CREDITS?></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="smsnf-dashboard-account__content__table--total">Plano</span></td>
                                            <td><span class="smsnf-dashboard-account__content__table--cash"><?=$client->CONTRACT?></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="smsnf-dashboard-account__content__table--total">Expira em</span></td>
                                            <td><span class="smsnf-dashboard-account__content__table--cash"><?=$client->CONTRACT_EXPIRE_DATE?></span></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <hr>
                                <p class="smsnf-dashboard-account__content__table--subtitle">O seu plano atual inclui</p>
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>Email/Push</td>
                                            <td><span class=""><?=$client->PLAN_EMAIL_LIMIT?></span></td>
                                        </tr>
                                        <tr>
                                            <td>SMS</td>
                                            <td><span class=""><?=$client->PLAN_SMS_LIMIT?></span></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <hr>
                                <p class="smsnf-dashboard-account__content__table--subtitle">Total de envios efetuados</p>
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>Email/Push</td>
                                            <td><span class=""><?=$client->PLAN_EMAIL_SENT?></span></td>
                                        </tr>
                                        <tr>
                                            <td>SMS</td>
                                            <td><span class=""><?=$client->PLAN_SMS_SENT?></span></td>
                                        </tr>
                                    </tbody>
                                </table>
                                
                            </div>
                        </div>
                    </div>
                    <!-- If sms addon is NOT active -->
                    <div style="display: none;">
                        <div class="smsnf-dashboard-account__title">
                            <div>A sua conta</div>
                        </div>
                        <div class="smsnf-dashboard-account__content">
                            <div class="smsnf-dashboard-account__install-addon"></div>
                            <p class="smsnf-dashboard-account__install-addon__text">Envie notificações SMS aos seus clientes e 
                            administradores por cada alteração ao estado da encomenda no
                            seu wooCommerce</p>
                            <a type="button" id="" class="button-smsnf-primary"> 
                                <?php echo __('Install', 'egoi-for-wp');?>
                            </a>
                        </div>
                    </div>
                </div><!-- /Account -->

                <!-- Blog Post's -->
                <div class="smsnf-dashboard-blog-last-post mt-3">
                    <div class="smsnf-dashboard-blog-last-post__title">Últimos Post's do Blog</div>
                    <div class="smsnf-dashboard-blog-last-post__content">
                        <div>
                            <div id="blog_post_0_date"></div>
                            <a class="blog_post_0_link" href=""><small id="blog_post_0_category"></small></a>
                        </div>
                        <a class="blog_post_0_link" href="" target="_blank">
                            <h4 class="smsnf-dashboard-blog-last-post__content__title" id="blog_post_0_title"></h4>
                        </a>
                        <a class="blog_post_0_link" href="" target="_blank">
                            <p class="smsnf-dashboard-blog-last-post__content__description" id="blog_post_0_excerpt"></p>
                        </a>
                        <hr>
                    </div>
                    <div class="smsnf-dashboard-blog-last-post__content">
                        <div>
                            <div id="blog_post_1_date"></div>
                            <a class="blog_post_1_link" href=""><small id="blog_post_1_category"></small></a>
                        </div>
                        <a class="blog_post_1_link" href="" target="_blank">
                            <h4 class="smsnf-dashboard-blog-last-post__content__title" id="blog_post_1_title"></h4>
                        </a>
                        <a class="blog_post_1_link" href="" target="_blank">
                            <p class="smsnf-dashboard-blog-last-post__content__description" id="blog_post_1_excerpt"></p>
                        </a>
                    </div>
                </div><!-- /Blog Post's -->
            </div>

        </div><!-- / Columns -->
    </div><!-- / Container -->
</div><!-- / Wrap -->


<script>

</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>

<!-- Total of subscribers Chart JS -->
<script>

    let listChartLabels = [<?php echo $chart_months; ?>];
    let listChartData = [<?php echo implode(",", $lists_chart[$options_list]['totals']);?>];

    myListChartParams = {
        type: 'bar',
        data: {
            labels: listChartLabels,
            datasets: [
                {
                    label: "Nº de Subscritores",
                    backgroundColor: [
                        "rgba(0, 174, 218, 0.4)",
                        "rgba(0, 174, 218, 0.4)",
                        "rgba(0, 174, 218, 0.4)",
                        "rgba(0, 174, 218, 0.4)",
                        "rgba(0, 174, 218, 0.4)",
                        "rgba(0, 174, 218, 0.4)",
                        "rgba(0, 174, 218, 0.4)",
                        "rgba(0, 174, 218, 0.4)",
                        "rgba(0, 174, 218, 0.4)",
                        "rgba(0, 174, 218, 0.4)",
                        "rgba(0, 174, 218, 0.4)",
                        "rgba(0, 174, 218, 0.4)"
                    ],
                    hoverBackgroundColor: [
                        "rgba(0, 174, 218, 0.5)",
                        "rgba(0, 174, 218, 0.5)",
                        "rgba(0, 174, 218, 0.5)",
                        "rgba(0, 174, 218, 0.5)",
                        "rgba(0, 174, 218, 0.5)",
                        "rgba(0, 174, 218, 0.5)",
                        "rgba(0, 174, 218, 0.5)",
                        "rgba(0, 174, 218, 0.5)",
                        "rgba(0, 174, 218, 0.5)",
                        "rgba(0, 174, 218, 0.5)",
                        "rgba(0, 174, 218, 0.5)",
                        "rgba(0, 174, 218, 0.5)"
                    ],
                    data: listChartData,
                    borderWidth: 0,
                    hoverBorderWidth: 0
                }
            ]
        },
        options: {
            legend: {
                display: false
            },
            title: {
                fontColor: 'blue',
                fontFamily: "Helvetica, Arial, serif",
                fontSize: 16,
                position: "top",
                beginAtZero: true,
                min: 20,
                text: 'Nº total de subscritores',
                display: false,
            },
            scales: {
                yAxes:[{
                    ticks: {
                        fontSize: 12,
                        padding: 20,
                        beginAtZero: true,
                        userCallback: function(label, index, labels) {
                            if (Math.floor(label) === label) {
                            return label;
                            }
                        },
                    }
                }],
                xAxes: [{
                    barPercentage: 1,
                    categoryPercentage: 1,
                    ticks: {
                        autoSkip: false,
                        beginAtZero: true,
                        maxRotation: 0,
                        minRotation: 0,
                        padding: 10,
                        fontFamily: "Helvetica, Arial, serif",
                        fontColor: "#aaaaaa",
                    }
                }]
            }
        }
    };


    

    var ctx = document.getElementById('smsnf-dsbl__lineChart');
    var myListChart = new Chart(ctx, myListChartParams);

    var list = document.getElementById("chart_list");
    list.addEventListener("change", changeChartData);

    function changeChartData() {
        var data = list.value.split(",");
        myListChartParams.data.datasets[0].data = data;

        var sum = 0;
        data.forEach(function (e) {
            sum = sum + parseInt(e);
        });

        myListChart.update();
        document.getElementById("list_subscribers_total").innerHTML = sum;
    }
</script>

<!-- Last Campaign Email Chart JS -->
<?php if ($campaigns['email']['sent'] > 0) { ?>
<script>
    Chart.defaults.global.legend.labels.usePointStyle = true;
    var ctx = document.getElementById("smsnf-dlec__doughnutChart").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ["Aberturas", "Cliques", "Bounces", "Remoções", "Queixas"],
            datasets: [{
                label: '# of Votes',
                data: [<?php echo $campaign_email; ?>],
                backgroundColor: [
                    'rgba(0, 174, 218, 0.4)',
                    'rgba(147, 189, 77, 0.3)',
                    'rgba(246, 116, 73, 0.3)',
                    'rgba(250, 70, 19, 0.4)',
                    'rgba(237, 60, 47, 0.6)'
                ],
                borderColor: [
                    'rgba(0, 174, 218, 0.5)',
                    'rgba(147, 189, 77, 0.4)',
                    'rgba(246, 116, 73, 0.4)',
                    'rgba(242, 91, 41, 0.5)',
                    'rgba(237, 60, 47, 0.7)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            legend: {
                display: true,
                position: 'right',
                labels: {
                    fontColor: '#333',
                }
            },
            layout: {
                padding: {
                    left: 0,
                    right: 0,
                    top: 0,
                    bottom: 0
                }
            }
        }
    });
</script>
<?php } ?>

<!-- Last Campaign SMS Chart JS -->

<?php if ($campaigns['sms_premium']['sent'] > 0) { ?>
<script>
    Chart.defaults.global.legend.labels.usePointStyle = true;
    var ctx = document.getElementById("smsnf-dlsc__doughnutChart").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ["Entregues", "Não Entregues"],
            datasets: [{
                label: '# of Votes',
                data: [<?php echo $campaign_sms; ?>],
                backgroundColor: [
                    'rgba(147, 189, 77, 0.3)',
                    'rgba(250, 70, 19, 0.4)'
                ],
                borderColor: [
                    'rgba(147, 189, 77, 0.4)',
                    'rgba(250, 70, 19, 0.5)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            legend: {
                display: true,
                position: 'right',
                labels: {
                    fontColor: '#333',
                }
            },
            layout: {
                padding: {
                    left: 0,
                    right: 0,
                    top: 0,
                    bottom: 0
                }
            }
        }
    });
</script>
<?php } ?>




