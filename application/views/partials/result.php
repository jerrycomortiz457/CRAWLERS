<table id="myTable" class="tablesorter table table-hover table-dark table-sm w-50">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Company Name</th>
            <th scope="col"># of Job Ads <br>for Sofware Developer<br> in the last 30days</th>           
        </tr>
    </thead>
    <tbody>

    <?php
        if(!empty($data['count_job_ads_per_company'])){   
            $row_number = 1;
            foreach($data['count_job_ads_per_company'] as $key => $value){
                echo "<tr><th scope='row'>{$row_number}</th><th>{$key}</th><td>{$value}</td></tr>";
                $row_number++;
            }                     
        } else if(!empty($data['count_job_ads_per_company_for_dice'])){   
             // For Dice.com-------------------^
                $row_number = 1;
                foreach($data['count_job_ads_per_company_for_dice'] as $key => $value){
                    $value /= 2;
                    echo "<tr><th scope='row'>{$row_number}</th><th>{$key}</th><td>{$value}</td></tr>";
                    $row_number++;
                }                     
            }
       

        //TESTER
        // $row_number = 1;
        // foreach($data['company_name'] as $jobs){
        //     if($jobs == ''){
        //         echo "<tr><th scope='row'>$row_number</th><th>******************************</th></tr>";
        //     } else {
        //         echo "<tr><th scope='row'>$row_number</th><th>$jobs</th></tr>";
        //     }
        //     $row_number++;
        // }

        // var_dump($data['company_name']);
        // var_dump($data['total_result_count']);
        // var_dump($data['post_per_page']);
        // var_dump($data['process']);
?>
    </tbody>
</table>

