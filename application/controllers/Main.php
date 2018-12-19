<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Main extends CI_Controller {
	public function __construct()
	{
		parent::__construct();		
		$this->load->helper('url');
		require('application/libraries/simple_html_dom.php');
	}
	public function index()
	{	
		$this->load->view('index');		
	}
		
	public function indeed_crawl()
	{				
		//Variables with Target URL
		$show_results_count = 50;
		$page = 0;
		$url = "https://www.indeed.com/jobs?as_and=software+developer+software+engineer&radius=0&l=San+Jose,+CA&fromage=30&limit={$show_results_count}&sort=date&psf=advsrch";
		set_time_limit(0);
		//Get Search Count
		$html = file_get_html($url);
		foreach($html->find('div') as $result_count){
			if($result_count->getattribute('id') == 'searchCount'){
				$data['result_current_page'] = preg_replace("/[^0-9]/",'',(substr ($result_count->plaintext, 0,10)));
				$data['total_result_count'] = preg_replace("/[^0-9]/",'',(substr ($result_count->plaintext, 10)));
			}			
		}

		// Loop through per page and get all company names with jobs
		for($index = 0; $index < ceil($data['total_result_count']/$show_results_count);$index++){
			$data['process'] = $index;
			$loop_url = "https://www.indeed.com/jobs?as_and=software+developer+software+engineer&radius=0&l=San+Jose,+CA&fromage=30&limit={$show_results_count}&sort=date&psf=advsrch&start={$page}";
			$page = $index * $show_results_count;	
			$get_html = file_get_html($loop_url);
		
			//Scan every company
			foreach($get_html->find('span') as $company_name){
				if($company_name->getattribute('class') == 'company'){
					$data['company_name'][] = $company_name->plaintext;
				}		
			}	

			//Scan every jobtitle
			foreach($get_html->find('h2') as $job_name){
				if($job_name->getattribute('class') == 'jobtitle'){
					$data['job_title'][] = $job_name->plaintext;				
				}
			}			
		}
	
		// Process Duplicates due to page and server updates per html request

		for($i = 0; $i < count($data['company_name']); $i++){
			$data['merge_company_name_and_job_title'][] = $data['company_name'][$i].'*'.$data['job_title'][$i];
		}

		// Duplicate Removal
			$data['duplicate_removal'] = array_unique($data['merge_company_name_and_job_title']);
		// Refine $data['duplicate_removal'] values
			foreach($data['duplicate_removal'] as $company_name_refined){
				$data['refined_duplicate_removal'][] = substr($company_name_refined, 0, strpos($company_name_refined, "*"));
			}
			
		// Count Job Ads Group By Company
		$data['count_job_ads_per_company'] = array_count_values($data['refined_duplicate_removal']);

		$this->load->view('partials/result', array('data' => $data));
	}

	public function simplyhired_crawl()
	{				
		//Variables with Target URL
		$show_results_count = 20;
		// $page = 0;
		$url = "https://www.simplyhired.com/search?q=software+developer+software+engineer&l=san+jose%2C+ca&mi=exact&fdb=30&sb=dd&pp=ABQAAAAAAAAAAAAAAAFTW2oqAQEBBwz5rdrmLTIKr0mySbraBZnj99zDQMzcuzOnRInVXIlYlWnEJVDjjMNCxQ&job=zT1BDWHnru85fvJkn-QFbdrVPkqJBwQgJeXKli0Tonw4diYBYW3wvQ";
		set_time_limit(0);

		//Get Search Count
		$html = file_get_html($url);
		foreach($html->find('span') as $result_count){
			if($result_count->getattribute('class') == 'posting-total'){
				$data['total_result_count'] = preg_replace("/[^0-9]/",'',$result_count);
			}			
		}

		// Loop through per page and get all company names with jobs
		for($index = 0 , $page = 1;$index < ceil($data['total_result_count']/$show_results_count);$index++, $page++){
			$loop_url = "https://www.simplyhired.com/search?q=software+developer+software+engineer&l=san+jose%2C+ca&mi=exact&fdb=30&sb=dd&pn={$page}&pp=ABQAAAAAAAAAAAAAAAFTW2oqAQEBBwz5rdrmLTIKr0mySbraBZnj99zDQMzcuzOnRInVXIlYlWnEJVDjjMNCxQ&job=zT1BDWHnru85fvJkn-QFbdrVPkqJBwQgJeXKli0Tonw4diYBYW3wvQ";
			$get_html = file_get_html($loop_url);
		
			//Scan every company
			foreach($get_html->find('span') as $company_name){
				if($company_name->getattribute('class') == 'jobposting-company'){
					$data['company_name'][] = $company_name->plaintext;
				}		
			}	

			//Scan every jobtitle
			foreach($get_html->find('h2') as $job_name){
				if($job_name->getattribute('class') == 'jobposting-title'){
					$data['job_title'][] = $job_name->plaintext;				
				}
			}			
		}
	
		// Process Duplicates due to page and server updates per html request

		for($i = 0; $i < count($data['company_name']); $i++){
			$data['merge_company_name_and_job_title'][] = $data['company_name'][$i].'*'.$data['job_title'][$i];
		}

		// Duplicate Removal
			$data['duplicate_removal'] = array_unique($data['merge_company_name_and_job_title']);
		// Refine $data['duplicate_removal'] values
			foreach($data['duplicate_removal'] as $company_name_refined){
				$data['refined_duplicate_removal'][] = substr($company_name_refined, 0, strpos($company_name_refined, "*"));
			}
			
		// Count Job Ads Group By Company
		$data['count_job_ads_per_company'] = array_count_values($data['refined_duplicate_removal']);

		$this->load->view('partials/result', array('data' => $data));
	}

	public function snagajob_crawl()
	{				
		//Variables with Target URL
		$show_results_count = 15;
		$url = "https://www.snagajob.com/job-search/s-california/l-san+jose/w-san+jose,+ca/q-web+engineer/page-1?ui=true&sort=date";
		set_time_limit(0);
		
		//Get Search Count
		$html = file_get_html($url);
		foreach($html->find('span') as $result_count){
			if($result_count->getattribute('itemprop') == 'numberOfItems'){
				$data['total_result_count'] = preg_replace("/[^0-9]/",'',$result_count);
			}			
		}
		
		// Loop through per page and get all company names with jobs
		for($index = 0, $page = 1; $index < ceil($data['total_result_count']/$show_results_count);$index++, $page++){
			$loop_url = "https://www.snagajob.com/job-search/s-california/l-san+jose/w-san+jose,+ca/q-web+engineer/page-{$page}?ui=true&sort=date";
			$get_html = file_get_html($loop_url);
		
			//Scan every company
			foreach($get_html->find('h2') as $company_name){
				if($company_name->getattribute('class') == 'result-title'){	
					$data['company_name'][] = substr((substr($company_name->next_sibling()->plaintext,0,strpos($company_name->next_sibling()->plaintext, "-"))),0,strpos((substr($company_name->next_sibling()->plaintext,0,strpos($company_name->next_sibling()->plaintext, "-"))),"."));
				}		
			}	

			//Scan every jobtitle
			foreach($get_html->find('h2') as $job_name){
				if($job_name->getattribute('class') == 'result-title'){
					$data['job_title'][] = $job_name->plaintext;				
				}
			}			
		}	
	
		// Process Duplicates due to page and server updates per html request

		for($i = 0; $i < count($data['company_name']); $i++){
			$data['merge_company_name_and_job_title'][] = $data['company_name'][$i].'*'.$data['job_title'][$i];
		}

		// Duplicate Removal
			$data['duplicate_removal'] = array_unique($data['merge_company_name_and_job_title']);
		
			// Refine $data['duplicate_removal'] values
			foreach($data['duplicate_removal'] as $company_name_refined){
				$data['refined_duplicate_removal'][] = substr($company_name_refined, 0, strpos($company_name_refined, "*"));
			}
			
		// // Count Job Ads Group By Company
		$data['count_job_ads_per_company'] = array_count_values($data['company_name']);

		$this->load->view('partials/result', array('data' => $data));
	}

	public function dice_crawl()
	{				
		//Variables with Target URL
		$show_results_count = 30;
		$url = "https://www.dice.com/jobs/q-%28software_OR_developer_OR_software_OR_engineer%29-sort-date-l-San_Jose%2C_CA-radius-El-startPage-1-jobs";
		set_time_limit(0);
		
		//Get Search Count 	
		$html = file_get_html($url);
		foreach($html->find('span') as $result_count){
			if($result_count->getattribute('id') == 'posiCountId'){
				$data['total_result_count'] = preg_replace("/[^0-9]/",'',$result_count);
			}			
		}

		// Loop through per page and get all company names with jobs
		for($index = 0, $page = 1; $index < ceil($data['total_result_count']/$show_results_count);$index++, $page++){
			$loop_url = "https://www.dice.com/jobs/q-%28software_OR_developer_OR_software_OR_engineer%29-sort-date-l-San_Jose%2C_CA-radius-El-startPage-{$page}-jobs";
			$get_html = file_get_html($loop_url);
		
			//Scan every company
			foreach($get_html->find('span') as $company_name){
				if($company_name->getattribute('class') == 'hidden-xs'){	
					$data['company_name'][] = $company_name->getattribute('title');
				}		
			}
		}
			
		// Count Job Ads Group By Company
		$data['count_job_ads_per_company_for_dice'] = array_count_values($data['company_name']);
	
		$this->load->view('partials/result', array('data' => $data));
	}

	public function techcareers_crawl()
	{				
		//Variables with Target URL
		$show_results_count = 20;
		$url = "https://www.techcareers.com/jobs/search?k=Software%20Developer%20Software%20Engineer&l=San%20Jose%2C%20CA&r=5&p=2&ps=20&s=1&dp=30";
		set_time_limit(0);

		//Get Search Count
		$html = file_get_html($url);
		foreach($html->find('div') as $result_count){
			if($result_count->getattribute('class') == 'col-sm-4 text-right-sm'){
				$total_result_count = preg_replace("/[^0-9]/",'',$result_count);
				$data['total_result_count'] = substr($total_result_count, -3, strpos($total_result_count, "0"));
			}			
		}

		// Loop through per page and get all company names with jobs
		for($index = 0 , $page = 1;$index < ceil($data['total_result_count']/$show_results_count);$index++, $page++){
			$loop_url = "https://www.techcareers.com/jobs/search?k=Software%20Developer%20Software%20Engineer&l=San%20Jose%2C%20CA&r=5&p={$page}&ps=20&s=1&dp=30";
			$get_html = file_get_html($loop_url);
		
		// 	//Scan every company
			foreach($get_html->find('span') as $company_name){
				if($company_name->getattribute('class') == 'job-title-company'){
					$data['company_name'][] = $company_name->plaintext;
				}		
			}			
		}
	
		//Clean up $data['company_name']
		foreach (array_keys($data['company_name'], '') as $key) {
			unset($data['company_name'][$key]);
		}
			
		// Count Job Ads Group By Company
		$data['count_job_ads_per_company'] = array_count_values($data['company_name']);

		$this->load->view('partials/result', array('data' => $data));
	}
	public function careerbuilder_crawl()
	{				
		//Variables with Target URL
		$show_results_count = 25;
		$url = "https://www.careerbuilder.com/jobs-software-developer-software-engineer-in-san-jose,ca?keywords=software+developer+software+engineer&location=san+jose%2Cca&radius=5&cat1=JN008&cat2=JN021&cat3=JN004";
		set_time_limit(0);

		//Get Search Count
		$html = file_get_html($url);
		// var_dump($html->find('div'));
		foreach($html->find('div') as $result_count){
			if($result_count->getattribute('class') == 'count'){
				$data['total_result_count'] = preg_replace('/[^0-9]/','',$result_count->plaintext);
			}			
		}

		for($index = 0 , $page = 1;$index < ceil($data['total_result_count']/$show_results_count);$index++, $page++){
			$loop_url = "https://www.careerbuilder.com/jobs-software-developer-software-engineer-in-san-jose,ca?cat1=JN008&cat2=JN021&cat3=JN004&page_number={$page}radius=0";
			$get_html = file_get_html($loop_url);
		
		//Scan every company		
			foreach($get_html->find('h4') as $company_name){
				if(($company_name->getattribute('class') == 'job-text') && ($company_name->plaintext != '') && ($company_name->plaintext == preg_match('/CA/', $company_name->plaintext)) && ($company_name->plaintext == preg_match('/Menlo/', $company_name->plaintext)) && ($company_name->plaintext == preg_match('/Sunnyvale /', $company_name->plaintext)) && ($company_name->plaintext == preg_match('/San Jose/', $company_name->plaintext)) && ($company_name->plaintext == preg_match('/California/', $company_name->plaintext)) && ($company_name->plaintext == preg_match('/Las Positas Blvd/', $company_name->plaintext)) && ($company_name->plaintext == preg_match('/Milpitas/', $company_name->plaintext)) && ($company_name->plaintext == preg_match('/Another Source/', $company_name->plaintext)) && ($company_name->plaintext == preg_match('/Houston, TX/', $company_name->plaintext)) ){
					$data['company_name'][] = $company_name->plaintext;
				
				}		
			}			
		}
		
		// // Count Job Ads Group By Company
		$data['count_job_ads_per_company'] = array_count_values($data['company_name']);

		$this->load->view('partials/result', array('data' => $data));
	}
}