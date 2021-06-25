
    <script type="text/javascript">
        //載入Visualization API，括號裡第一個參數是版本名稱或數字
        google.charts.load("current", {
            packages: ["corechart", "bar"], //第二個packages是要顯示的圖表類型
            "language": "zh-cn"      //第三個是語言，有時會影響日期格式等等
        });

        // 當Visualization API載入後用Callback呼叫下面的drawChart function
        google.charts.setOnLoadCallback(drawAxisTickColors);


        function drawAxisTickColors() {

            // get chart data from url:/home/get_chart
            $.ajax({
                type: 'get',
                url: '/home/get_chart_data',
                dateType: 'json',
                success: function(chart_data)
                {
                    show_chart(chart_data, 'profit', 'tab_total_profit')
                    show_chart(chart_data, 'impression', 'tab_total_impression')

                    show_chart(chart_data, 'click_rate', 'tab_click_rate')


                },
            });
        }

        function show_chart(chart_data, query, id) {

            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Month of Year');
            data.addColumn('number', query);

            var x_axis = JSON.parse(chart_data)['day'];
            var y_axis = JSON.parse(chart_data)[query];
            // var x_axis = ['1','2','3','4'];
            // var y_axis = [15,36,12,10];
            for (let i = 0; i < x_axis.length; i++) {
                data.addRow([x_axis[i], y_axis[i]]);
            } 
            
            // set figure style
            var options = {
                // width:'100%',
                height:500,
                width:1600, 
                // max-width: calc(100% - 20px),
            }

            // var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
            var chart = new google.visualization.ColumnChart(document.getElementById(id));

            
            chart.draw(data, options);
        }


        function get_chart_type(data, chart_data) {
            
        }


    </script>