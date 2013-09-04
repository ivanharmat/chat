<?php 
$this->load->view('common/header');
$this->load->view('common/nav');?>
<?php $this->load->view($main_content);
$this->load->view('common/bottom_nav');
$this->load->view('common/login_modal');
$this->load->view('common/footer');
?>