<!DOCTYPE html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="<?php echo siteAdresi;?>/temalar/webmasterPanel/css/style.css">
  <!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
  <title><?php echo baslik; ?></title>
  <?php 
  echo $this -> html_head; /// @warning head kapanmadan önce bu kodu mutlaka ekleyin
  ?>
</head>
<body>
  <div class="container">
<?php require('header.php');?>