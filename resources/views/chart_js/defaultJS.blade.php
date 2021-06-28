
<!-- default script -->
<script type="text/javascript">

    //載入Visualization API，括號裡第一個參數是版本名稱或數字
    google.charts.load("current", {
        packages: ["corechart", "bar"], //第二個packages是要顯示的圖表類型
        "language": "zh-cn"      //第三個是語言，有時會影響日期格式等等
    });

    // 當Visualization API載入後用Callback呼叫下面的drawChart function
    google.charts.setOnLoadCallback(draw_4_charts);

    // get chart data from url:/home/get_chart 
    // default views
    $.ajax({
        type: 'get',
        url: '/home/get_chart_total_data',
        dateType: 'json',
        data: 
        {
          year: 2020,
          select_mode: 'year'
		}, 
        success: function(chart_total_data_json)
        {
            change_4div_value(JSON.parse(chart_total_data_json)[1])
        },
    });

</script>
