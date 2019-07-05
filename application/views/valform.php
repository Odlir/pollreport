<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?php echo base_url();?>assets/ico/favicon.png">
    <link href="<?php echo base_url();?>assets/css/bootstrap.css" rel="stylesheet" media="screen">
    <link href="<?php echo base_url();?>assets/css/custom_fischman.css" rel="stylesheet">  
    <link href="<?php echo base_url();?>assets/css/font.css" rel="stylesheet">  

    <link href="<?php echo base_url();?>assets/css/sticky-footer-navbar.css" rel="stylesheet">  
    <link href="<?php echo base_url();?>assets/css/styles.css" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="/assets/js/html5shiv.js"></script>
      <script src="/assets/js/respond.min.js"></script>
    <![endif]-->
    <?php if (isset($head_content)) echo $head_content; ?>

	<style type="text/css">

	::selection{ background-color: #E13300; color: white; }
	::moz-selection{ background-color: #E13300; color: white; }
	::webkit-selection{ background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body{
		margin: 0 15px 0 15px;
	}
	
	p.footer{
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}
	
	#container{
		margin: 10px;
		border: 1px solid #D0D0D0;
		-webkit-box-shadow: 0 0 8px #D0D0D0;
	}
    
    .error{
        color: red;
        font-size: 13px;
        margin-bottom: -15px;
    }
	</style>
</head>
<body>
        <div id="container">
        <?php echo form_open('welcome'); ?>
        <h1>Validating form fields using CodeIgniter</h1><hr/> 
        
        <?php echo form_label('Student Name :'); ?> <?php echo form_error('dname'); ?><br />
        <?php echo form_input(array('id' => 'dname', 'name' => 'dname')); ?><br />

        <?php echo form_label('Student Email :'); ?> <?php echo form_error('demail'); ?><br />
        <?php echo form_input(array('id' => 'demail', 'name' => 'demail')); ?><br />

        <?php echo form_label('Student Mobile No. :'); ?> <?php echo form_error('dmobile'); ?><br />
        <?php echo form_input(array('id' => 'dmobile', 'name' => 'dmobile','placeholder'=>'10 Digit Mobile No.')); ?><br />

        <?php echo form_label('Student Address :'); ?> <?php echo form_error('daddress'); ?><br />
        <?php echo form_input(array('id' => 'daddress', 'name' => 'daddress')); ?><br />

        <?php echo form_submit(array('id' => 'submit', 'value' => 'Submit')); ?>

        <?php echo form_close(); ?>
        
       </div>
    </body>
</html>
