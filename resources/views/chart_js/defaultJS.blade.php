
<!-- default script -->
<script type="text/javascript">


    // get chart data from url:/home/get_chart_total_data
    // default views
    $.ajax({
        type: 'get',
        url: '/home/get_chart_total_data',
        dateType: 'json',
        data:
        {
            select_mode: "default", // default is to show latest 7 days
            year: '2020'
            // month: '6'
		}, 
        success: function(chart_total_data_json)
        {
            var chart_total_data = JSON.parse(chart_total_data_json)
            var chart_data = chart_total_data[0]
            var total_data = chart_total_data[1]
            // four statistical values
            change_4div_value(total_data)

            // four Google Charts
            show_chart(chart_data, ['profit'], ['總收益（含稅）'], 'tab_total_profit')
            show_chart(chart_data, ['impression'], ['總露出'], 'tab_total_impression')
            show_chart(chart_data, ['direct_click', 'clip_click', 'clicks'], ['直推點擊', '夾報點擊', '總點擊'], 'tab_total_click')
            show_chart(chart_data, ['click_rate'], ['點擊率'], 'tab_total_click_rate')
        },
    });

</script>
