<style>
	body {
		font-family:Consolas;
	}

	.pass {
		color:green;
	}
	
	.fail {
		color:red;
	}
	
	.warning {
		color:orange;
	}
</style>

<a href='?phpinfo=true'>Run phpinfo()</a>
<?php if(isset($_GET['phpinfo'])): ?>
	<a href='diagnostics.php'>&larr; Go back</a>
	<?php die(phpinfo()); ?>
<?php endif; ?>
<br><br>

<?php
$ini         = ini_get_all();
$server_api  = php_sapi_name();
$app_path    = realpath(dirname(__FILE__)).'/';;
$doc_root    = $_SERVER['DOCUMENT_ROOT'].'/';
$environment = file_exists($doc_root."../environment.php");
$core        = file_exists($doc_root."../core/");
?>

Server API: <?php echo $server_api ?>
<br>
APP Path: <?php echo $app_path  ?>
<br>
Doc Root: <?php echo $doc_root; ?>
<br>
PHP Version: <?php echo phpversion(); ?>
<br>
<br>

<?php if(strstr($server_api,'apache')): ?>
	<div class='warning'>WARNING: Your server is using CGI PHP - If routing is not working, see instructions in fastcgi.htacces</div>
<?php endif; ?>

<?php if($environment): ?>
	<div class='pass'>PASS: environment.php exists</div>
<?php else: ?>
	<div class='fail'>FAIL: environment.php is missing</div>
<?php endif; ?>

<?php if($core): ?>
	<div class='pass'>PASS: core/ exists</div>
<?php else: ?>
	<div class='fail'>FAIL: core/ is missing</div>
<?php endif; ?>




