<script type="text/javascript">

    // get chart data from url:/home/get_chart
    $.ajax({
        type: 'get',
        url: '/home/get_total_data',
        dateType: 'json',
        success: function(total_data_json)
        {
            change_4div_value(total_data_json)
        },
    });

    function change_4div_value(total_data_json) {
        var total_data = JSON.parse(total_data_json)

        var total_profit = total_data['total_profit']
        var total_impression = total_data['total_impression']
        var total_click = total_data['total_click']
        var total_click_rate = total_data['total_click_rate']

        document.getElementById("likr_tab_total_profit").innerHTML = total_profit;
        document.getElementById("likr_tab_total_impression").innerHTML = total_impression;
        document.getElementById("likr_tab_total_click").innerHTML = total_click;
        document.getElementById("likr_tab_total_click_rate").innerHTML = total_click_rate;

    }

</script>