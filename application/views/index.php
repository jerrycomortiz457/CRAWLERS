<?php
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Credentials: true');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>JAS Crawler</title>
    <link rel="stylesheet" href="../assets/css/test.css">
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script> -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script  src="https://code.jquery.com/jquery-3.3.1.js"  integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="  crossorigin="anonymous"></script>
    <script  src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.9.1/underscore.js"></script> 
    <script type="text/javascript" src="../assets/js/jquery.tablesorter.js"></script>
    <script type="text/javascript" src="../assets/js/jquery.tablesorter.widgets.js"></script>

</head>
<body>

    <fieldset>
        <legend>Crawlers</legend>        
        <form action="/main/indeed_crawl" method="post" align="center">
            <input type="submit" value="Crawl Indeed.com" id="submit" class="btn btn-info ml-5 mt-5">
        </form>
        <form action="/main/simplyhired_crawl" method="post" align="center">
            <input type="submit" value="Crawl SimplyHired.com" id="submit" class="btn btn-info ml-5 mt-5">
        </form>
        <form action="/main/careerbuilder_crawl" method="post" align="center" disabled>
            <input disabled type="submit" value="Crawl CareerBuilder.com" id="submit" class="btn btn-info ml-5 mt-5">
        </form>
        <form action="/main/snagajob_crawl" method="post" align="center">
            <input type="submit" value="Crawl SnagAJob.com" id="submit" class="btn btn-info ml-5 mt-5">
        </form>
        <form action="/main/monster_crawl" method="post" align="center">
            <input type="submit" value="Crawl Monster.com" id="submit" class="btn btn-info ml-5 mt-5">
        </form>
        <div id="results" class="container">         
            <!-- result -->
        </div>
    </fieldset>
   
    <script> 
      $(document).ready(function() {
        $('form').submit(function() {
            $('#results').html("<img style='opacity: 0.8; width: 77px; position: absolute; left: 50% ; top: 50%;' src='../assets/images/spider.gif'>");
            $(':input[type="submit"]').prop('disabled', true);
            $.post($(this).attr('action'), $(this).serialize(), function(res){
                    $('#results').html(res);
                    $(':input[type="submit"]').prop('disabled', false);
            });
            return false;
        });
        $(document).on('click', 'thead tr th', function(){
            $(function() {
                $("#myTable").tablesorter();
             });
             $(function() {
                $("#myTable").tablesorter({ sortList: [[0,0], [1,0]] });
            });
        });       
    });
    </script>
</body>
</html>