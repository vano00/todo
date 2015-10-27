<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $title; ?></title>
	<?php echo Asset::css(array('bootstrap.css','website.css')); ?>
	<style>
		body { margin: 40px; }
	</style>
</head>
<body>
	<div class="container">
		<div class="col-md-12">
			<h1><?php echo $title; ?></h1>
			<hr>
<?php if (Session::get_flash('success')): ?>
			<div class="alert alert-success">
				<strong>Success</strong>
				<p>
				<?php echo implode('</p><p>', e((array) Session::get_flash('success'))); ?>
				</p>
			</div>
<?php endif; ?>
<?php if (Session::get_flash('error')): ?>
			<div class="alert alert-danger">
				<strong>Error</strong>
				<p>
				<?php echo implode('</p><p>', e((array) Session::get_flash('error'))); ?>
				</p>
			</div>
<?php endif; ?>
		</div>
		<div class="col-md-12">
<?php echo $content; ?>
		</div>
		<footer>
			
		</footer>
	</div>
	<div id="message"></div>
	<script type="text/javascript">
		<?php
		echo 'var uriBase = '.Format::forge(Uri::base())->to_json().';';
		?>
	</script>
	<?php echo Asset::js(array(
       'http://code.jquery.com/jquery-1.11.2.min.js',
       'http://code.jquery.com/ui/1.11.2/jquery-ui.min.js',
       'website.js'
	));
	?>
</body>
</html>
