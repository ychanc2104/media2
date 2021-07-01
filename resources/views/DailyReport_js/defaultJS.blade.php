  <!-- default script to show latest month -->
  <script type="text/javascript">
  
  $.ajax
  ({
    type: 'get',
    url: '/daily_report/data',
    dateType: 'json',
    data: 
    {
      y_start: new Date().getFullYear(),
      y_end: new Date().getFullYear(),
      m_start: new Date().getMonth(),              
      m_end: new Date().getMonth(),
      n_option: 'All',
      page: 1
    },
    success: function(daily_report_data_json)
    {
      var daily_report_data = JSON.parse(daily_report_data_json)[0];
      var n_data = JSON.parse(daily_report_data_json)[1];
      // var n_option = correct_option(n_option, n_data);
      // var n_page = Math.ceil(n_data/n_option);

      myHTML = ''
      daily_report_data.forEach(function(item, i) 
      {
        myHTML += '<tr>' +
                  '<td>' + item['date']       + '</td>' +
                  '<td>' + item['profit']     + '</td>' +
                  '<td>' + item['impression'] + '</td>' +
                  '<td>' + item['clicks']     + '</td>' +
                  '<td>' + item['click_rate'] + '</td>' +
                  '</tr>';
      });
      $("#daily_report_table").html(myHTML);
      
      update_page_indicator(n_data, 1, 1)
      update_page_navigator(1)

    },
    error: function()
    {
      console.log("發生錯誤: ");
    }
  });
  </script>