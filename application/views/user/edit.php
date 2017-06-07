<?php $this->render('template/header'); ?>
<?php $this->render('template/menu'); ?>

<h1><?php echo $this->title; ?></h1>

<?php if ( true == Session::get('logged_in') ) : ?>

	<?php $this->render('user/form/edit'); ?>

<?php else: ?>

	<p>You're not logged in!</p>

<?php endif; ?>

<?php $this->render('template/footer'); ?>