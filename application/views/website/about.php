<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>POSAM</title>
	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/website/css/style.css'); ?>" >
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/website/css/mobile.css'); ?>" >
	<script type="text/javascript" src="<?php echo base_url('assets/website/js/mobile.js'); ?>"></script>

</head>



<!-----------------------------------------------------------------------------------------------------> 
<!--                                                                                                 --> 
<!--                                       M E N U                                                   -->  
<!--                                                                                                 -->  
<!-----------------------------------------------------------------------------------------------------> 



<body>
	<div id="page">
		<div id="header">
			<div>
				<a href="<?php echo base_url('website/index'); ?>" class="logo"><img  src="<?php echo base_url('assets/images/logo_posam_short.jpg'); ?>" height="100px" alt=""></a>
				<ul id="navigation">
					<li>
						<a href="<?php echo base_url('website/index'); ?>">HOME</a>
					</li>
					<li class="selected">
						<a href="<?php echo base_url('website/about'); ?>">ABOUT</a>						
					</li>
					<li>
						<a href="<?php echo base_url('website/contact'); ?>">CONTACT</a>
					</li>
				</ul>
			</div>
		</div>



<!-----------------------------------------------------------------------------------------------------> 
<!--                                                                                                 --> 
<!--                                       A B O U T                                                 -->  
<!--                                                                                                 -->  
<!-----------------------------------------------------------------------------------------------------> 


		<div id="body">
			<div class="header">
				<div>
					<h1></h1>
				</div>
			</div>

			<div class="footer">
				
				<div class="article2">

					<h1>What is POSAM?</h1>
					<span>POSAM is a software that helps to manage the orders, payment, customers and inventory of items and assets of the business.  The system standardizes the management process flow of the inventory and sales and provides a faster turnover time in the processing.  It also helps to manage the deliveries by areas with customers attached to a specific area.</span>

					<br><br>

					<h1>Main functions</h1>
					   <span>
						
							<li>Inventory of the items</li>
							<li>Movements of items (IN or OUT the POSAM)</li>
							<li>Orders of the customers</li>
							<li>Inventory of the assets of the business and their maintenance</li>
							<li>Managers can follow up the inventory, customers and orders</li>
							<li>Search is possible on different criteria</li>
							<li>Many reports available</li>
							<li>Format reports to Excel</li>
							<li>Deliveries of the items by area </li>
							<li>Tracking customer orders and payments</li> 
							<li>POSAM can be accessible on the web or on a local server</li>
						
						</span>


									
				</div>

				<div>
					<img  src="<?php echo base_url('assets/website/images/posam_main_process.png'); ?>" height="500px" width="370px" alt="">
					
				</div>

			</div>
		</div>
		<div id="footer" >
			<div>
				<p>© <?php echo date('Y') ?> POSAM Point of Sales Automated Management </p>
			</div>
		</div>
	</div>
</body>
</html>
