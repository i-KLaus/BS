<?php
$this->title='首页';
use yii\helpers\Url;
?>
<div class="m-content m-content-home">
    <div class="qgj-menu">
        <ul class="row">
            <li class="col-xs-2 blue">
                <h5>服务商数</h5>
                <div class="number"><a href="<?php echo Url::to(['/fws/list']); ?>" class="text-white"><span><?php echo $service['service_num'] ?></span></a></div>
                <h5><?php echo $service['service_nopass'] ?>个待审核</h5>
            </li>
            <li class="col-xs-2 green-light">
                <h5>需求方数</h5>
                <div class="number"><a href="<?php echo Url::to(['/demand/list']); ?>" class="text-white"><span><?php echo $demand['demand_num'] ?></span></a></div>
                <h5><?php echo $demand['demand_nopass'] ?>个待审核</h5>
            </li>
            <li class="col-xs-2 green-dark">
                <h5>商户总数</h5>
                <div class="number"><a href="<?php echo Url::to(['/contract/list']); ?>" class="text-white"><span><?php echo $merchant ?></span></a></div>
            </li>
            <li class="col-xs-2 yellow">
                <h5>服务商品数</h5>
                <div class="number"><a href="<?php echo Url::to(['/goods/list']); ?>" class="text-white"><span><?php echo $goods ?></span></a></div>
            </li>
            <li class="col-xs-2 orange">
                <h5>完成订单数</h5>
                <div class="number"><a href="<?php echo Url::to(['/order/list']); ?>" class="text-white"><span><?php echo $order['order_finish'] ?></span></a></div>
                <h5><?php echo $order['order_readconfirm'] ?>个待审核</h5>
            </li>
        </ul>
    </div>
    <form action="<?php echo Url::to(['datachart']) ?>">
        <div class="qgj-chart">
            <div class="qgj-chart_title">
                <input type="text" class="form-control form-control-inline mr15" id="time1" value="<?php echo $time['min'];?> - <?php echo $time['max'];?>">
                <dl class="qgj-time-range mr15">
                    <dt>最近</dt>
                    <dd>
                        <a href="javascript:;" class="active js-seven-days">7日</a>
                        <a href="javascript:;" class="js-thirty-days">30日</a>
                    </dd>
                </dl>
                <input type="button" class="btn btn-primary" value="查询" onclick="ajaxRefreshReportChart()">
            </div>
            <div class="qgj-chart_body">
                <div id="echart1" class="height-lg wper100"></div>
            </div>
        </div>
        <div class="qgj-chart">
            <div class="qgj-chart_title">
                <input type="text" class="form-control form-control-inline mr15" id="time2" value="<?php echo $time['min'];?> - <?php echo $time['max'];?>">
                <dl class="qgj-time-range mr15">
                    <dt>最近</dt>
                    <dd>
                        <a href="javascript:;" class="active js-seven-days">7日</a>
                        <a href="javascript:;" class="js-thirty-days">30日</a>
                    </dd>
                </dl>
                <input type="button" class="btn btn-primary" value="查询" onclick="ajaxRefreshReportChart2()">
            </div>
            <div class="qgj-chart_body">
                <div id="echart2" class="height-lg wper100"></div>
            </div>
        </div>
    </form>
</div>


<script src="../../js/function/home/home.js"></script>
<script>
    $(function () {
        init_outline1();
        init_outline2();

        //时间插件选择日期
//        $("#time1").on('apply.daterangepicker',function() {
//            $('.form-search').find('a').siblings().removeClass('btn-primary');
//            var time = $(this).val();
//            ajaxRefreshReportChart(time);
//        });
    });

    var visit_data = <?php echo !empty($date) ? json_encode($date) : '[]'; ?>;
    var order_data = <?php echo !empty($date2) ? json_encode($date2) : '[]'; ?>;
    var visit = <?php echo !empty($visit_num) ? json_encode($visit_num) : '[]'; ?>;//访客量
    var order= <?php echo !empty($order_num) ? json_encode($order_num) : '[]'; ?>;//订单

    // 图表
    function init_outline1() {
        // 交易统计
        charts.line(
            'echart1',
            ['访问量'],
            '时间',
            visit_data,
            '访问量',
            [
                {
                    name: '访问量',
                    type: 'line',
                    data: visit
                }
            ],
            ["#469DF7"]
        );
    }

    function init_outline2() {
        // 交易统计
        charts.line(
            'echart2',
            ['订单数量'],
            '时间',
            order_data,
            '订单数量',
            [
                {
                    name: '订单数量',
                    type: 'line',
                    data: order
                }
            ],
            ["#469DF7"]
        );
    }

    /**
     * 访问量走势
     */

    function ajaxRefreshReportChart() {
        var time = $("#time1").val();
        $.ajax({
            'type': 'get',
            'url': '<?php echo Url::to(['datachart']); ?>',
            'async': true,
            'data': {time: time},
            'success': function (data) {
                var obj = eval('(' + data + ')');
                visit_data = obj.date;
                console.log(obj);
                visit = obj.visit_num;
                init_outline1();
            }
        });
    }

    /**
     * 订单走势
     */

    function ajaxRefreshReportChart2() {
        var time = $("#time2").val();
        $.ajax({
            'type': 'get',
            'url': '<?php echo Url::to(['datacharttwo']); ?>',
            'async': true,
            'data': {time: time},
            'success': function (data) {
                var obj = eval('(' + data + ')');
                order_data = obj.date;
                console.log(obj);
                order = obj.order_num;
                init_outline2();
            }
        });
    }

</script>