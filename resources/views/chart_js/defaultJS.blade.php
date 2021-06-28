
<!-- default script -->
<script type="text/javascript">

    //載入Visualization API，括號裡第一個參數是版本名稱或數字
    google.charts.load("current", {
        packages: ["corechart", "bar"], //第二個packages是要顯示的圖表類型
        "language": "zh-cn"      //第三個是語言，有時會影響日期格式等等
    });

    // 當Visualization API載入後用Callback呼叫下面的drawChart function
    google.charts.setOnLoadCallback(draw_4_charts2);

    // get chart data from url:/home/get_chart 
    // default views
    $.ajax({
        type: 'get',
        url: '/home/get_chart_total_data',
        dateType: 'json',
        data:
        {
            select_mode: "year",
            year: '2020'
		}, 
        success: function(chart_total_data_json)
        {
            var chart_data = JSON.parse(chart_total_data_json)[0]
            // console.log(chart_data['x_axis'])
            change_4div_value(JSON.parse(chart_total_data_json)[1])

            show_chart(chart_data, ['profit'], ['總收益（含稅）'], 'tab_total_profit')
            show_chart(chart_data, ['impression'], ['總露出'], 'tab_total_impression')
            show_chart(chart_data, ['direct_click', 'clip_click', 'clicks'], ['直推點擊', '夾報點擊', '總點擊'], 'tab_total_click')
            show_chart(chart_data, ['click_rate'], ['點擊率'], 'tab_total_click_rate')
            // draw_4_charts2(JSON.parse(chart_total_data_json)[0])
        },
    });

</script>
