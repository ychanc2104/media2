


<!doctype html>
<html>
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/dateRangePicker/monthPicker.css')}}" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{ asset('/js/dateRangePicker/monthPicker.js') }}"></script>


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



<style type="text/css">
  .page-link{
    cursor: pointer;
  }

  </style>

</head>




<script type="text/javascript">

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
        success: function(daily_report_data_json)
        {
          // console.log('success')
          // var daily_report_data = JSON.parse(daily_report_data_json)[0];
          // var n_page = JSON.parse(daily_report_data_json)[1];
          // var n_data = JSON.parse(daily_report_data_json)[2];
          var n_option = $('#n_option').children(':selected').text();
          var daily_report_data = JSON.parse(daily_report_data_json)[0];
          var n_data = JSON.parse(daily_report_data_json)[1];
          var n_option = correct_option(n_option, n_data);
          var n_page = Math.ceil(n_data/n_option);
          
          // update tables
          myHTML = '';
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
</script>





<body>

<div class="container">
  <div class="row">

    <div>
            <img src="{{ asset('/img/horizon_line.png') }}">
        <h4></h4>
    </div>
    <br>

    <div>
      <!-- Brand and toggle get grouped for better mobile display -->

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <div id="sla-data-range" class="mrp-container nav navbar-nav">
            <span class="mrp-icon"><i class="fa fa-calendar"></i></span>
            <div class="mrp-monthdisplay">
              <span class="mrp-lowerMonth" id="show_start">xxxxx</span>
              <span class="mrp-to"> to </span>
              <span class="mrp-upperMonth" id="show_end">xxxxx</span>
            </div>
          <input id="date_start" type="hidden" value="201407" id="mrp-lowerDate" />
          <input id="date_end" type="hidden" value="201408" id="mrp-upperDate" />
        </div>

      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->

    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <select id="n_option" class="form-control" width="200" style="width: 200px">
            <option class="placeholder" selected disabled value="-1">選擇</option>
            <option onclick="transmit_query(1)" value="5">5</option>
            <option onclick="transmit_query(1)" value="10">10</option>
            <option onclick="transmit_query(1)" value="15">15</option>
            <option onclick="transmit_query(1)" value="20">20</option>
            <option onclick="transmit_query(1)" value="-1">All</option>
          </select>
        </div>
        <div class="col-md-4">
          <h4 id="page_indicator">目前有30筆資料，目前在第1頁，共有1頁</h4>
        </div>
      </div>
    </div>



    <table id="daily_table" class="table" border = "1">
    <thead>
    <tr>
    <td><b>日期       </b></td>
    <td><b>收益（含稅）</b></td>
    <td><b>露出數     </b></td>
    <td><b>點擊數     </b></td>
    <td><b>點擊率(%)  </b></td>
    </tr>
    </thead>
    <tbody id="daily_report_table">
    </tbody>
    </table>
    

    <!-- page url -->
    <div class="col align-self-center">
      <nav aria-label="Page navigation">
        <ul onclick="" id="page_navigator" class="pagination">
          <!-- place to display page navigator by js -->
        </ul>
      </nav>
    </div>

  </div> <!-- /row -->

</div> <!-- /container -->



</body>


<script type="text/javascript">

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

  
  // get how many pages in navigator
  function build_page_index(page, n_page)
  {
    var page_index = [];
    var page_state = []
    for (i=0;i<n_page+2;i++)
    {
      if (i == 0)
      {
        page_index.push('Previous');
        if (page == 1)
        {
          page_state.push('disabled');
        }
        else
        {
          page_state.push('');
        }
      }
      else if (i == n_page+1)
      {
        page_index.push('Next');
        if (n_page == 1 || page == n_page)
        {
          page_state.push('disabled');
        }
        else
        {
          page_state.push('');
        }
      }
      else
      {        
        page_index.push(i);
        if (i == page)
        {
          page_state.push('active');
        }
        else
        {
          page_state.push('');
        }
      }
    }
    return [page_index, page_state];
  }




</script>
