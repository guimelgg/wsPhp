<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>

<link href="<?= $assets ?>dist/css/dashboard.css" rel="stylesheet" type="text/css" />
<script src="<?= $assets ?>plugins/highchart/highcharts.js"></script>

<?php
if ($chartData) {
    foreach ($chartData as $month_sale) {
        $months[] = date('M-Y', strtotime($month_sale->month));
        $sales[] = $month_sale->total;
        $tax[] = $month_sale->tax;
        $discount[] = $month_sale->discount;
    }
} else {
    $months[] = '';
    $sales[] = '';
    $tax[] = '';
    $discount[] = '';
}
?>

<script type="text/javascript">

    $(document).ready(function () {
        Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function (color) {
            return {
                radialGradient: {cx: 0.5, cy: 0.3, r: 0.7},
                stops: [[0, color], [1, Highcharts.Color(color).brighten(-0.3).get('rgb')]]
            };
        });
        <?php if ($chartData) { ?>
        $('#chart').highcharts({
            chart: { },
            credits: { enabled: false },
            exporting: { enabled: false },
            title: { text: '' },
            xAxis: { categories: [<?php foreach($months as $month) { echo "'".$month."', "; } ?>] },
            yAxis: { min: 0, title: "" },
            tooltip: {
                shared: true,
                followPointer: true,
                headerFormat: '<div class="well well-sm" style="margin-bottom:0;"><span style="font-size:12px">{point.key}</span><table class="table table-striped" style="margin-bottom:0;">',
                pointFormat: '<tr><td style="color:{series.color};padding:4px">{series.name}: </td>' +
                '<td style="color:{series.color};padding:4px;text-align:right;"> <b>{point.y}</b></td></tr>',
                footerFormat: '</table></div>',
                useHTML: true, borderWidth: 0, shadow: false,
                style: {fontSize: '14px', padding: '0', color: '#000000'}
            },
            plotOptions: {
                series: { stacking: 'normal' }
            },
            series: [{
                type: 'column',
                name: '<?= $this->lang->line("tax"); ?>',
                data: [<?= implode(', ', $tax); ?>]
            },
            {
                type: 'column',
                name: '<?= $this->lang->line("discount"); ?>',
                data: [<?= implode(', ', $discount); ?>]
            },
            {
                type: 'column',
                name: '<?= $this->lang->line("sales"); ?>',
                data: [<?= implode(', ', $sales); ?>]
            }
            ]
        });
        <?php } ?>
        <?php if ($topProducts) { ?>
$('#chart2').highcharts({
    chart: { },
    title: { text: '' },
    credits: { enabled: false },
    exporting: { enabled: false },
    tooltip: {
        shared: true,
        followPointer: true,
        headerFormat: '<div class="well well-sm" style="margin-bottom:0;"><span style="font-size:12px">{point.key}</span><table class="table table-striped" style="margin-bottom:0;">',
        pointFormat: '<tr><td style="color:{series.color};padding:4px">{series.name}: </td>' +
        '<td style="color:{series.color};padding:4px;text-align:right;"> <b>{point.y}</b></td></tr>',
        footerFormat: '</table></div>',
        useHTML: true, borderWidth: 0, shadow: false,
        style: {fontSize: '14px', padding: '0', color: '#000000'}
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: false
            },
            showInLegend: false
        }
    },

    series: [{
        type: 'pie',
        name: '<?=$this->lang->line('total_sold')?>',
        data: [
        <?php
        foreach($topProducts as $tp) {
            echo "['".$tp->product_name." (".$tp->product_code.")', ".$tp->quantity."],";

        } ?>
        ]
    }]
});
<?php } ?>
});

</script>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-success">
                <div class="box-header">
                    <h3 class="box-title"><?= lang('quick_links'); ?></h3>
                </div>
                <div class="box-body">

                    <?php if ($this->session->userdata('store_id')) { ?>
                    <div class="content">
                        <div class="row">
                                <div class="col-lg-3 col-xs-12">
                                    <div class="small-box">
                                      <a class="small-box-footer bg-red-cl" href="<?= site_url('pos'); ?>">
                                        <div class="icon color-icon" style="padding: 9.5px 18px 8px 18px;">
                                            <i class="fa fa-th"></i>
                                        </div>
                                        <div class="inner">
                                            <h3 class="text-white">3</h3>
                                            <p class="text-white"><?= lang('pos'); ?></p>
                                        </div>
                                      </a>
                                    </div>
                                </div>
                        <?php } ?>
                                <div class="col-lg-3 col-xs-12">
                                    <div class="small-box">
                                      <a class="small-box-footer bg-pumpkin-cl" href="<?= site_url('products'); ?>">
                                        <div class="icon color-icon" style="padding: 9.5px 18px 8px 18px;">
                                            <i class="fa fa-barcode"></i>
                                        </div>
                                        <div class="inner">
                                            <h3 class="text-white"><?php echo $this->db->count_all_results('mon_products'); ?></h3>
                                           <p class="text-white"><?= lang('products'); ?></p>
                                        </div>
                                      </a>
                                    </div>
                                </div>

                        <?php if ($this->session->userdata('store_id')) { ?>

                                <div class="col-lg-3 col-xs-12">
                                    <div class="small-box">
                                      <a class="small-box-footer bg-orange-cl" href="<?= site_url('sales'); ?>">
                                        <div class="icon color-icon" style="padding: 9.5px 18px 8px 18px;">
                                            <i class="fa fa-shopping-cart"></i>
                                        </div>
                                        <div class="inner">
                                            <h3 class="text-white">524</h3>
                                            <p class="text-white"><?= lang('sales'); ?></p>
                                        </div>
                                      </a>
                                    </div>
                                </div>


                                <div class="col-lg-3 col-xs-12">
                                    <div class="small-box">
                                      <a class="small-box-footer bg-green-cl" href="<?= site_url('sales/opened'); ?>">
                                        <div class="icon color-icon" style="padding: 9.5px 18px 8px 18px;">
                                            <i class="fa fa-bell-o"></i>
                                        </div>
                                        <div class="inner">
                                            <h3 class="text-white"><?php echo $this->db->count_all_results('mon_sales'); ?></h3>
                                            <p class="text-white"><?= lang('opened_bills'); ?></p>
                                        </div>
                                      </a>
                                    </div>
                                </div>

                        <?php } ?>

                                <div class="col-lg-3 col-xs-12">
                                    <div class="small-box">
                                      <a class="small-box-footer bg-sky-cl" href="<?= site_url('categories'); ?>">
                                        <div class="icon color-icon" style="padding: 9.5px 18px 8px 18px;">
                                            <i class="fa fa-folder-open"></i>
                                        </div>
                                        <div class="inner">
                                            <h3 class="text-white"><?php echo $this->db->count_all_results('mon_categories'); ?></h3>
                                            <p class="text-white"><?= lang('categories'); ?></p>
                                        </div>
                                      </a>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-xs-12">
                                    <div class="small-box">
                                      <a class="small-box-footer bg-purple-cl" href="<?= site_url('gift_cards'); ?>">
                                        <div class="icon color-icon" style="padding: 9.5px 18px 8px 18px;">
                                            <i class="fa fa-credit-card"></i>
                                        </div>
                                        <div class="inner">
                                            <h3 class="text-white"><?php echo $this->db->count_all_results('mon_gift_cards'); ?></h3>
                                            <p class="text-white"><?= lang('gift_cards'); ?></p>
                                        </div>
                                      </a>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-xs-12">
                                    <div class="small-box">
                                      <a class="small-box-footer bg-red-cl" href="<?= site_url('customers'); ?>">
                                        <div class="icon color-icon" style="padding: 9.5px 18px 8px 18px;">
                                            <i class="fa fa-users"></i>
                                        </div>
                                        <div class="inner">
                                            <h3 class="text-white"><?php echo $this->db->count_all_results('mon_customers'); ?></h3>
                                            <p class="text-white"><?= lang('customers'); ?></p>
                                        </div>
                                      </a>
                                    </div>
                                </div>

                        <?php if ($Admin) { ?>
                        <div class="col-lg-3 col-xs-12">
                            <div class="small-box">
                                <a class="small-box-footer bg-lima-cl" href="<?= site_url('settings'); ?>">
                                    <div class="icon color-icon" style="padding: 9.5px 18px 8px 18px;">
                                        <i class="fa fa-cogs"></i>
                                    </div>
                                    <div class="inner">
                                        <h3 class="text-white">.</h3>
                                        <p class="text-white"><?= lang('settings'); ?></p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xs-12">
                            <div class="small-box">
                                <a class="small-box-footer bg-asbesto-cl" href="<?= site_url('reports'); ?>">
                                    <div class="icon color-icon" style="padding: 9.5px 18px 8px 18px;">
                                        <i class="fa fa-bar-chart-o"></i>
                                    </div>
                                    <div class="inner">
                                        <h3 class="text-white">.</h3>
                                        <p class="text-white"><?= lang('reports'); ?></p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xs-12">
                            <div class="small-box">
                                <a class="small-box-footer bg-blue-cl" href="<?= site_url('users'); ?>">
                                    <div class="icon color-icon" style="padding: 9.5px 18px 8px 18px;">
                                        <i class="fa fa-users"></i>
                                    </div>
                                    <div class="inner">
                                        <h3 class="text-white"><?php echo $this->db->count_all_results('mon_users'); ?></h3>
                                        <p class="text-white"><?= lang('users'); ?></p>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <?php if ($this->db->dbdriver != 'sqlite3') { ?>
                        <div class="col-lg-3 col-xs-12">
                            <div class="small-box">
                                <a class="small-box-footer bg-midnight-cl" href="<?= site_url('settings/backups'); ?>">
                                    <div class="icon color-icon" style="padding: 9.5px 18px 8px 18px;">
                                        <i class="fa fa-database"></i>
                                    </div>
                                    <div class="inner">
                                        <h3 class="text-white">.</h3>
                                        <p class="text-white"><?= lang('backups'); ?></p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    

                        <?php } ?>
                        <div class="col-lg-3 col-xs-12">
                            <div class="small-box">
                                <a class="small-box-footer bg-lemon-cl" href="<?= site_url('settings/stores'); ?>">
                                    <div class="icon color-icon" style="padding: 9.5px 18px 8px 18px;">
                                        <i class="fa fa-home"></i>
                                    </div>
                                    <div class="inner">
                                        <h3 class="text-white">.</h3>
                                        <p class="text-white"><?= lang('stores'); ?></p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title"><?= lang('sales_chart'); ?></h3>
                        </div>
                        <div class="box-body">
                            <div id="chart" style="height:300px;"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title"><?= lang('top_products').' ('.date('F Y').')'; ?></h3>
                        </div>
                        <div class="box-body">
                            <div id="chart2" style="height:300px;"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
