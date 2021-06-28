
    <script type="text/javascript">
        // //載入Visualization API，括號裡第一個參數是版本名稱或數字
        // google.charts.load("current", {
        //     packages: ["corechart", "bar"], //第二個packages是要顯示的圖表類型
        //     "language": "zh-cn"      //第三個是語言，有時會影響日期格式等等
        // });

        // // 當Visualization API載入後用Callback呼叫下面的drawChart function
        // google.charts.setOnLoadCallback(drawAxisTickColors);
        function draw_4_charts2(chart_data) 
        {
            // var chart_data = JSON.parse(chart_total_data_json)[0]
            console.log(chart_data)
            show_chart(chart_data, ['profit'], ['總收益（含稅）'], 'tab_total_profit')
            show_chart(chart_data, ['impression'], ['總露出'], 'tab_total_impression')
            show_chart(chart_data, ['direct_click', 'clip_click', 'clicks'], ['直推點擊', '夾報點擊', '總點擊'], 'tab_total_click')
            show_chart(chart_data, ['click_rate'], ['點擊率'], 'tab_total_click_rate')

        }

        function draw_4_charts(clicked_id, clicked_value) 
        {
            // get chart data from url:/home/get_chart
            $.ajax({
                type: 'get',
                url: '/home/get_chart_total_data',
                data:         
                {
                    select_mode: clicked_id,
                    year: clicked_value,
                },
                dateType: 'json',
                success: function(chart_total_data_json)
                {
                    // console.log(chart_total_data_json)
                    var chart_data = JSON.parse(chart_total_data_json)[0]
                    show_chart(chart_data, ['profit'], ['總收益（含稅）'], 'tab_total_profit')
                    show_chart(chart_data, ['impression'], ['總露出'], 'tab_total_impression')
                    show_chart(chart_data, ['direct_click', 'clip_click', 'clicks'], ['直推點擊', '夾報點擊', '總點擊'], 'tab_total_click')
                    show_chart(chart_data, ['click_rate'], ['點擊率'], 'tab_total_click_rate')
                },
            });
        }

        function show_chart(chart_data, keys, col_name, id) {

            var data = new google.visualization.DataTable();
            var chart_data = chart_data
            console.log(chart_data['x_axis'][0])
            console.log(chart_data[keys[0]][0])
            // var x_axis = JSON.parse(chart_data)['day'];
            data.addColumn('string', 'Day or Month');
            keys.forEach(function(item, i) {
                data.addColumn('number', col_name[i])
            });

            // for (let i = 0; i < chart_data.length; i++) {
            //     // only deal with click charts with three input
            //     if (keys.length == 3){
            //         data.addRow([String(chart_data[i]['x_axis']), chart_data[i][keys[0]], chart_data[i][keys[1]], chart_data[i][keys[2]] ]);
            //     } else {
            //         data.addRow([String(chart_data[i]['x_axis']), Number(chart_data[i][keys[0]])]);
            //     }
            // } 

            // var data = new google.visualization.DataTable();
            // var x_axis = JSON.parse(chart_data)['day'];
            // data.addColumn('string', 'Month of Year');
            // keys.forEach(function(item, i) {
            //     data.addColumn('number', col_name[i])
            // });


            for (let i = 0; i < chart_data['x_axis'].length; i++) 
            {
                // only deal with click charts with three input
                if (keys.length == 3)
                {
                    data.addRow([String(chart_data['x_axis'][i]), chart_data[keys[0]][i], chart_data[keys[1]][i], chart_data[keys[2]][i]]);
                } 
                else 
                {
                    data.addRow([String(chart_data['x_axis'][i]), chart_data[keys[0]][i] ]);
                }
            } 
            
            // set figure style
            var options = {
                height:500,
                width:1600, 
            }

            var chart = new google.visualization.ColumnChart(document.getElementById(id));
            chart.draw(data, options);
        }


    </script>