
<script type="text/javascript">

    function draw_four_charts(chart_data) 
    {
        // four Google Charts
        show_chart(chart_data, ['profit'], ['總收益（含稅）'], 'tab_total_profit');
        show_chart(chart_data, ['impression'], ['總露出'], 'tab_total_impression');
        show_chart(chart_data, ['direct_click', 'clip_click', 'clicks'], ['直推點擊', '夾報點擊', '總點擊'], 'tab_total_click');
        show_chart(chart_data, ['click_rate'], ['點擊率'], 'tab_total_click_rate');
    }

    function show_chart(chart_data, keys, col_name, id) 
    {
        // //載入Visualization API，括號裡第一個參數是版本名稱或數字
        // google.charts.load("current", {
        //     packages: ["corechart", "bar"], //第二個packages是要顯示的圖表類型
        //     "language": "zh-cn"      //第三個是語言，有時會影響日期格式等等
        // });

        // Load the Visualization API and the corechart package.
        google.charts.load('current', {'packages':['corechart']});

        var data = new google.visualization.DataTable();
        var x_axis = chart_data['x_axis'];
        data.addColumn('string', 'Day or Month');
        keys.forEach(function(item, i) {
            data.addColumn('number', col_name[i])
        });

        for (let i = 0; i < x_axis.length; i++) 
        {
            if (keys.length == 3)
            {
                data.addRow([String(x_axis[i]), chart_data[keys[0]][i], chart_data[keys[1]][i], chart_data[keys[2]][i]]);
            }
            else if (keys.length == 2) 
            {
                data.addRow([String(x_axis[i]), chart_data[keys[0]][i], chart_data[keys[1]][i]]);
            } 
            else 
            {
                data.addRow([String(x_axis[i]), chart_data[keys[0]][i]] );
            }

        } 
        
        // set figure style
        var options = {
            height:500,
            width:1250, 
        }

        var chart = new google.visualization.ColumnChart(document.getElementById(id));
        chart.draw(data, options);
    }


</script>