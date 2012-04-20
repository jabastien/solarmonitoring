<?php 

	if (isset($api))
	{
		$data['api'] = $api;
		$this->load->view('includes/header', $data);
		
	}
	else
	{
		$this->load->view('includes/header'); 
	}

?>
<?php $this->load->view('includes/nav'); ?>
<?php 

	if (isset($message))
	{
		$data['message'] = $message;
		$this->load->view($page, $data);
	}
	else
	{
		$this->load->view($page); 
	}
	
	?>
<?php 
	if (isset($widgets))
	{
		$data['w'] = $widgets;
		$this->load->view('includes/sidebar', $data);
		
	}
	else
	{
		$this->load->view('includes/sidebar'); 
	}
	

	?>
<?php $this->load->view('includes/footer'); ?>