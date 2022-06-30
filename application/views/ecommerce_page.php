<?php 
	$data['external_page'] = $external_page;

	if($external_page == 1){
		$this->load->view('assets/header-external',$data);
	} else {
		$this->load->view('assets/header',$data);
	}
	
	if($external_page == 0){
		$data['active_page'] = $active_page;
		$data['active_url'] = !empty($active_url) ? $active_url : '';
		$this->load->view('assets/sidebar',$data);		
	}

	$this->load->view($page_view);
	// $this->load->view('assets/footer-ecommerce', $data);
	if($external_page == 1){
		$this->load->view('assets/footer-external', $data);
	} else {
		$this->load->view('assets/footer', $data);
	}
?>