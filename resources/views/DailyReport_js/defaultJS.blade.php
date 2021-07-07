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
      m_start: new Date().getMonth()+1, // current month Jan = 0              
      m_end: new Date().getMonth()+1,
      n_option: 'All',
      page: 1
    },
    success: function(daily_report_data_json)
    {

      var daily_report_data = JSON.parse(daily_report_data_json)[0];
      var n_data = JSON.parse(daily_report_data_json)[1];


      myHTML = '';
      for (i=0; i<n_data; i++)
      {
        myHTML += '<tr>' +
                  '<td>' + daily_report_data['date'][i]       + '</td>' +
                  '<td>' + daily_report_data['profit'][i]     + '</td>' +
                  '<td>' + daily_report_data['impression'][i] + '</td>' +
                  '<td>' + daily_report_data['clicks'][i]     + '</td>' +
                  '<td>' + daily_report_data['click_rate'][i] + '</td>' +
                  '</tr>';
      }
      // });
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