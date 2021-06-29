
<script type="text/javascript">
    function show_chart(chart_data, keys, col_name, id) {
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
            // else if (keys.length == 2) 
            // {
            //     data.addRow([String(x_axis[i]), chart_data[keys[0]][i], chart_data[keys[1]][i]);
            // } 
            else 
            {
                data.addRow([String(x_axis[i]), chart_data[keys[0]][i]] );
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