<?php
	session_start();
	include "../functions/init.php";


	if(isset($_COOKIE['user_id'])) {
		$account_id = $_COOKIE['user_id'];	
	} else {
		$account_id = $_SESSION['user_id'];
	}

    $stm  = $pdo->query("SELECT * FROM links WHERE is_active = '1' and account_id = ".$account_id." ORDER BY 6 DESC");
    $datas =  $stm->fetchAll(PDO::FETCH_ASSOC);
	
	
	$var = '';
	foreach ($datas as $value) {

		$linkId = $value['id'];

		//Getting information for the chart
        $getClickFromLastMonth = $functions->getClickFromLastMonth($linkId, 'custom_links_clicks');

        //Getting chart
        if(!empty($getClickFromLastMonth)) {
            $table = "
            <div class='table-responsive'>
                <table class='table table-sm table-bordered table-striped table-hover mt-2 mb-4'>
                    <thead class='thead-dark'>
                        <tr>
                            <th>Date</th>
                            <th>Clicks</th>
                        </tr>
                    </thead>
                    <tbody>
                        ".$getClickFromLastMonth."
                    </tbody>
                </table>
            </div>";
        } else {
            $table = "";
        }

		$clicks = $functions->showCustomLinksClickCounter($account_id, $linkId);

		$var .= "
		<li class='list-group-item bg-white noselect' id='order-".$value['id']."'>	
			<div id='accordion-".$linkId."'>	
				<span class='h5 font-weight-bold'>".$value['title']."</span><br>
				<a href='".$value['link']."' target='_blank'>".$value['link']."</a>
				<div class='row mt-3'>
					<i class='col-2 col-md-1 fa fa-edit cursor-pointer' id='img-".$value['id']."' data='".$value['title']."'></i>
					<i class='col-2 col-md-1 fa fa-trash text-danger cursor-pointer' id='img-".$value['id']."' data='".$value['title']."'></i>
			        <i class='col-2 col-md-1 fas fa-chart-pie cursor-pointer link' href='#collapse-".$linkId."' data-parent='#accordion-".$linkId."' data-toggle='collapse' aria-expanded='true'></i>	
				</div>
				<div class='collapse mt-4' id='collapse-".$linkId."'>
					<span class='small-font py-0'>This link has been clicked <span class='font-weight-bold'>".$clicks."</span> times.</span>
					".$table."
				</div> 
			</div>
		</li>";
	}

	echo $var;
