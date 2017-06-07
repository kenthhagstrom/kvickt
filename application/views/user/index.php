<?php $this->render('template/header'); ?>

<?php $this->render('template/menu'); ?>

<h1><?php echo $this->title; ?></h1>

<?php if ( true !== $this->loggedin ) : ?>
	<?php $this->render('user/form/login'); ?>
<?php else: ?>
	<p>You are already logged in!</p>
<?php endif; ?>

<?php $this->render('template/footer'); ?>