
    <script type="text/javascript">
        //載入Visualization API，括號裡第一個參數是版本名稱或數字
        google.charts.load("current", {
            packages: ["corechart", "bar"], //第二個packages是要顯示的圖表類型
            "language": "zh-cn"      //第三個是語言，有時會影響日期格式等等
        });

        // 當Visualization API載入後用Callback呼叫下面的drawChart function
        google.charts.setOnLoadCallback(drawAxisTickColors);


        function drawAxisTickColors() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Month of Year');
            data.addColumn('number', 'Incomes');

            // get chart data from url:/home/get_chart
            $.ajax({
                type: 'get',
                url: '/home/get_chart_data',
                dateType: 'json',
                success: function(chart_data)
                {
                    show_chart(data, chart_data)
                },
            });
        }

        function show_chart(data, chart_data) {

            var x_axis = JSON.parse(chart_data)['day'];
            var y_axis = JSON.parse(chart_data)['profit'];
            // var x_axis = ['1','2','3','4'];
            // var y_axis = [15,36,12,10];
            for (let i = 0; i < x_axis.length; i++) {
                data.addRow([x_axis[i], y_axis[i]]);
            } 
            
            // set figure style
            var options = {
                // width:'100%',
                height:500,
            }

            var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }
    </script>