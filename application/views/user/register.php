<?php $this->render('template/header'); ?>

<?php $this->render('template/menu'); ?>

<h1><?php echo $this->title; ?></h1>

<?php if ( true !== $this->loggedin ) : ?>
	<?php $this->render('user/form/register'); ?>
<?php else: ?>
	<p>You're already a registered user, because it seems like you're logged in. Somebody else forgot to logout?</p>
<?php endif; ?>

<?php $this->render('template/footer'); ?>