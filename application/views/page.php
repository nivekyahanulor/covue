<?php
$data['external_page']  = $external_page;

if ($external_page == 1) {
	$this->load->view('assets/header-external', $data);
} else if ($external_page == 2) {
	$this->load->view('assets/header-japan-ior', $data);
} else if ($external_page == 3) {
	$this->load->view('assets/header-partner', $data);
} else if ($external_page == 5) {
	$this->load->view('assets/header-consultant', $data);
} else {
	$this->load->view('assets/header', $data);
}

if ($external_page == 2) {
	$data['active_page'] = $active_page;
	$data['active_url'] = !empty($active_url) ? $active_url : '';
	$this->load->view('assets/sidebar-japan-ior', $data);
}

if ($external_page == 0) {
	$data['active_page'] = $active_page;
	$data['active_url'] = !empty($active_url) ? $active_url : '';
	$this->load->view('assets/sidebar', $data);
}

$this->load->view($page_view);

if ($external_page == 1) {
	$this->load->view('assets/footer-external', $data);
} else if ($external_page == 2) {
	$this->load->view('assets/footer-japan-ior', $data);
} else if ($external_page == 3) {
	$this->load->view('assets/footer-partner', $data);
} else if ($external_page == 5) {
	$this->load->view('assets/footer-consultant', $data);
} else {
	$this->load->view('assets/footer', $data);
}
