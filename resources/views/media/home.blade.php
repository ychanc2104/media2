<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Google Charts -->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>

    <!-- jQuery, ajax -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Custom script -->
    @include('chart_js.draw')
  </head>
    
    <body>
    

    <table class="table" border = "1">
    <tr>
    <td>Id</td>
    <td>Date</td>
    <td>Total incomes</td>
    <td>Total exposures</td>
    <td>Total clicks</td>
    <td>Click rate (%)</td>


    </tr>
    @foreach ($media_data as $data)
    <tr>
    <td>{{ $data->id }}</td>
    <td>{{ $data->Date }}</td>
    <td>{{ $data->incomes }}</td>
    <td>{{ $data->exposures }}</td>
    <td>{{ $data->total_clicks }}</td>
    <td>{{ $data->click_rate }}</td>

    </tr>
    @endforeach
    </table>


    <div id="chart_div">
        xxxxxxxxxxxxx
    </div>




    </body>
</html>

 
 



