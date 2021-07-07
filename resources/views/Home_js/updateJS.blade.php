<script type="text/javascript">

    // update tab statistical value in each tab
    function change_4div_value(total_data) {
        var total_data = total_data;
        
        var total_profit = total_data['total_profit'];
        var total_impression = total_data['total_impression'];
        var total_click = total_data['total_click'];
        var total_click_rate = total_data['total_click_rate'];

        document.getElementById("likr_tab_total_profit").innerHTML = total_profit;
        document.getElementById("likr_tab_total_impression").innerHTML = total_impression;
        document.getElementById("likr_tab_total_click").innerHTML = total_click;
        document.getElementById("likr_tab_total_click_rate").innerHTML = total_click_rate;
    }

    // update tabs according to date-picker
    function return_data_select(clicked_id, clicked_value) 
  {
    // we set clicked_id as select_mode use for determining filtering mode,
    // clicked_value as number of year or month
    if (clicked_id == 'year')
    {
      var year = clicked_value;
      var month = 1;
    }
    else if (clicked_id == 'month')
    {
      var year = get_text("year_picker");
      var month = clicked_value;
    }
    else // choose '近七日', hidden year and month picker
    {
        show_date_manu(clicked_id, 'xxx')
    }



    $.ajax({
        type: 'get',
        url: '/home/get_chart_total_data',
        dateType: 'json',
        data: 
        {
          select_mode: clicked_id,
          year: year,
          month: month,
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

            // change picker to that value
            if (clicked_id == 'year')
            {
                update_text("year_picker", year+"年");
            }
            else if (clicked_id == 'month')
            {
                update_text("month_picker", month+"月");
            }
            // else
            // {

            // }
            
        }
    });
  }

    // update inner text of element
    function update_text(id, text) 
    {
    document.getElementById(id).innerHTML = text;
    }

    // get inner text of element
    function get_text(id) 
    {
        text = document.getElementById(id).innerHTML;
        value = text.slice(0, -1)
        return value;
    }


    // show year or month sub-menu by click mode-picker, get oldest year from DB using ajax
    function show_date_manu(select_mode, id) 
    {
        // get chart data from url:/home/get_chart
        $.ajax(
        {
            type: 'get',
            url: '/home/get_chart_total_data',
            dateType: 'json',
            // data: 
            // {
            // select_mode: select_mode,
            // year: year,
            // month: month,
            // },
            success: function(chart_total_data_json)
            {                
                
                $(document).ready(function(){
                    var myHTML = '';
                    if (select_mode == 'year')
                    {          
                        show_div(id) // display that div(year, month or week) first
        
                        // for selecting year
                        var total_data = JSON.parse(chart_total_data_json)[1]
                        var year_now = new Date().getFullYear();
                        var year_smallest = total_data['year_smallest']
                        // console.log(year_smallest)

                        // var total_data = JSON.parse(chart_total_data_json)[1]
                        // var year_now = new Date().getFullYear();
                        // var year_smallest = total_data['year_smallest']
                        for (var i = 0; i < year_now-year_smallest+1; i++) 
                        {
                            myHTML += '<li id="year" value='+(year_now-i)+' onClick="return_data_select(this.id, this.value)"><a id="drop_item" class="dropdown-item">' + (year_now-i) + '</a></li>';
                        }
                        $("#year_li").html(myHTML);
                    }
                    else if (select_mode == 'month')
                    {
                        show_div(id) // display that div(year, month or week) first

                        // for selecting month
                        for (var i = 1; i < 13; i++) 
                        {
                            myHTML += '<li id="month" value='+(i)+' onClick="return_data_select(this.id, this.value)"><a id="drop_item" class="dropdown-item">' + (i) + '月</a></li>';
                        }
                        $("#month_li").html(myHTML);
                    }

                    else
                    {
                        const year = document.getElementById('div_filter_year');
                        const month = document.getElementById('div_filter_month');
                        year.style.display = "none";
                        month.style.display = "none";

                    }

                    // else
                    // {
                    //   // for selecting year
                    //   var total_data = JSON.parse(total_data_json)
                    //   var year_now = new Date().getFullYear();
                    //   var year_smallest = total_data['year_smallest']
                    //   for (var i = 0; i < year_now-year_smallest+1; i++) {
                    //     myHTML += '<li id="year" value='+(year_now-i)+' onClick="return_data_select(this.id, this.value)"><a id="drop_item" class="dropdown-item">' + (year_now-i) + '</a></li>';
                    //   }
                    //   $("#year_li").html(myHTML);
                    // }

            });
            },
            error: function()
            {
            console.log("發生錯誤: ");
            }
        });
    }

    // show or hidden div by click
    function show_div(id) 
    {
        var x = document.getElementById(id);
        if (x.style.display === "none")
        {
        x.style.display = "block";
        }
        else
        {
        x.style.display = "none";
        }
    }
</script>