
<!-- default script -->
<script type="text/javascript">
    // //載入Visualization API，括號裡第一個參數是版本名稱或數字
    // google.charts.load("current", {
    //     packages: ["corechart", "bar"], //第二個packages是要顯示的圖表類型
    //     "language": "zh-cn"      //第三個是語言，有時會影響日期格式等等
    // });

    // get chart data from url:/home/get_chart_total_data
    // default views
    $.ajax({
        type: 'get',
        url: '/home/get_chart_total_data',
        dateType: 'json',
        data:
        {
            select_mode: "default", // default is to show latest 7 days, three mode:1.default, 2.year, 3.month
            year: '2021',
            month: '1'
		}, 
        success: function(chart_total_data_json)
        {

            var chart_total_data = JSON.parse(chart_total_data_json);
            var chart_data = chart_total_data[0];
            var total_data = chart_total_data[1];
            // four statistical values
            change_4div_value(total_data);

            // four Google Charts
            draw_four_charts(chart_data);

        },
    });

</script>
