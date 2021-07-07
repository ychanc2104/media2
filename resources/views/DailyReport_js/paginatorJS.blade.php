
<script type="text/javascript">
  // Major function to submit query and get paginated daily report data
  function transmit_query(page) 
  {
    // var query_start = get_query();
    // var query_end = get_query("show_end");
      var query_start = document.getElementById("show_start").innerHTML.split("月");
      var query_end = document.getElementById("show_end").innerHTML.split("月");
      var n_option = $('#n_option').children(':selected').text();
      var page_indicator_str = parse_page_indicator()

      if (page == 'Previous')
      {
        page = Math.max(page_indicator_str[1] - 1, 1) // [n_data, page, n_page]
      }
      else if (page == 'Next')
      {
        page = Math.min(page_indicator_str[1] + 1, page_indicator_str[2]) // [n_data, page, n_page]
      }
      else
      {
        page = page
      }    
      // var page = parseInt(page);
      // const page = 1
      // console.log(query_start);
      $.ajax
      ({                
        type: 'get',
        url: '/daily_report/data',
        dateType: 'json',
        data: 
        {
          y_start: query_start[1],
          y_end: query_end[1],
          m_start: query_start[0],     
          m_end: query_end[0],
          n_option: n_option,
          page: page
        },
        success: function(daily_report_data_json) // send parameters(data) and then get daily report from server
        {
          var n_option = $('#n_option').children(':selected').text();
          var daily_report_data = JSON.parse(daily_report_data_json)[0];
          var n_data = JSON.parse(daily_report_data_json)[1];
          var n_option = correct_option(n_option, n_data);
          var n_page = Math.ceil(n_data/n_option);
          
          // update tables
          myHTML = '';
          for (i=0; i<daily_report_data['date'].length; i++)
          {
            myHTML += '<tr>' +
                      '<td>' + daily_report_data['date'][i]       + '</td>' +
                      '<td>' + daily_report_data['profit'][i]     + '</td>' +
                      '<td>' + daily_report_data['impression'][i] + '</td>' +
                      '<td>' + daily_report_data['clicks'][i]     + '</td>' +
                      '<td>' + daily_report_data['click_rate'][i] + '</td>' +
                      '</tr>';
          }
          $("#daily_report_table").html(myHTML);
          
          // update page indicator
          update_page_indicator(n_data, page, n_page)
          // update page navigator
          update_page_navigator(page)
        },
        error: function()
        {
          console.log("發生錯誤: ");
        }
      });
  }

  // update text of page indicator
  function update_page_indicator(n_data, page, n_page)
  { 
    document.getElementById("page_indicator").innerHTML = '目前有'+ n_data +'筆資料，目前在第'+ page +'頁，共有'+ n_page +'頁';
  }

  // read text of page indicator, and get [total rows of data, now page, total pages]
  function parse_page_indicator()
  { 
    var indicator_str = document.getElementById("page_indicator").innerHTML;
    var base_str = indicator_str.split("筆資料，目前在第")
    var n_data = parseInt(base_str[0].replace('目前有', '')); // total rows of data
    var page = parseInt(base_str[1].split("頁，共有")[0]); // now at "page"(int)
    var n_page = parseInt(base_str[1].split("頁，共有")[1].replace('頁', '')); // have n_page(int) in total
    
    return [n_data, page, n_page]
  }

  // correct non-numerical options, e.g. 'All' and '選擇'
  function correct_option(n_option, n_data)
  {
    if (n_option == 'All' || n_option == '選擇')
    {
      var n_option = n_data;
    }
    else
    {
      var n_option = n_option;
    }
    return parseInt(n_option)
  }


  // update page navigator status
  function update_page_navigator(page)
  {
    page_indicator = parse_page_indicator() //[n_data, n_page, page]
    var n_data = page_indicator[0]
    var n_page = page_indicator[2]

    var page_index = build_page_index(page, n_page)[0];
    var page_state = build_page_index(page, n_page)[1];
    var page_navigator = document.getElementById("page_navigator");
    myHTML = '';
    page_index.forEach(function(item, i)
    {
      if (item == "Previous")
      {
        myHTML += '<li onclick="transmit_query(this.id)" id="Previous" class='+ page_state[i] +'><a class="page-link">' + item + '</a></li>';
      }
      else if (item == "Next")
      {
        myHTML += '<li onclick="transmit_query(this.id)" id="Next" class='+ page_state[i] +'><a class="page-link">' + item + '</a></li>';
      }
      else
      {
        myHTML += '<li onclick="transmit_query(this.id)" id='+ i + ' class='+ page_state[i] +'><a class="page-link">' + item + '</a></li>';
      }
    });
    $("#page_navigator").html(myHTML);    
  }


  // get how many pages in navigator including Previous and Next
  function build_page_index(page, n_page)
  {
    var page_index = [];
    var page_state = [];

    for (i=0;i<n_page+2;i++)
    {
      if (i == 0) // "Previous" case
      {
        page_index.push('Previous');
        (page == 1 ? page_state.push('disabled') : page_state.push(''));

      }
      else if (i == n_page+1) // "Next" case
      {
        page_index.push('Next');
        (n_page == 1 || page == n_page ? page_state.push('disabled') : page_state.push(''));

      }
      else // page number case
      {        
        page_index.push(i);
        (i == page ? page_state.push('active') : page_state.push(''));

      }
    }
    return [page_index, page_state];
  }

</script>