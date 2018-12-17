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
        // if(!empty($data['job_ads'])){ 
        //     for($i=0, $counter = 1; $i < count($data['job_ads']); $i++, $counter++){
        //         if($data['job_ads'][$i]['company_name'] != '')
        //         echo "<tr><th scope='row'>{$counter}</th><th>{$data['job_ads'][$i]['company_name']}</th><td>{$data['job_ads'][$i]['number_of_job_ads']}</td></tr>";
        //     }
        // }

    ?>

    <?php
        if(!empty($data['count_job_ads_per_company'])){   
            $row_number = 1;
            foreach($data['count_job_ads_per_company'] as $key => $value){
                echo "<tr><th scope='row'>{$row_number}</th><th>{$key}</th><td>{$value}</td></tr>";
                $row_number++;
            }                     
        }
        // }
        // if(!empty($data['job_title'])){   
        //     for($i=0, $counter = 1; $i < count($data['job_title']); $i++, $counter++){
        //         if($data['company_name'][$i] != '')
        //         echo "<tr><th scope='row'>{$counter}</th><th>{$data['company_name'][$i]}</th><td>{$data['job_title'][$i]}</td></tr>";
        //     }                  

        // }
        // if(!empty($data['duplicate_removal'])){   
        //     for($i=0, $counter = 1; $i < count($data['duplicate_removal']); $i++, $counter++){
        //         if($data['duplicate_removal'][$i] != '')
                // echo "<tr><th scope='row'>{$counter}</th><th>{$data['duplicate_removal'][$i]}</th><td> </td></tr>";
        //     }                  

        // }

        //TESTER
        // $row_number = 1;
        // foreach($data['duplicate_removal'] as $jobs){
        //     if($jobs == ''){
        //         echo "<tr><th scope='row'>$row_number</th><th>******************************</th></tr>";
        //     } else {
        //         echo "<tr><th scope='row'>$row_number</th><th>$jobs</th></tr>";
        //     }
        //     $row_number++;
        // }

        // var_dump($data['total_result_count']);
        var_dump($data['total_result_count']);
        // var_dump($data['count_job_ads_per_company']);
        // var_dump($data['process']);
?>
    </tbody>
</table>

