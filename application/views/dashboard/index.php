<?php $this->render('template/header'); ?>

<ul>
	<li><a href="../">Main Page</a></li>
	<li>Dashboard</li>
	<li><a href="<?php echo SITE_URL; ?>user/logout">Logout</a></li>
</ul>

<h1>Dashboard</h1>
<p>When logged in, this is where you can find all your personal stuff.</p>
<p>If you've registered as an author you can manage your uploaded work here. Or upload more. You will see notifications regarding your stuff uploaded, comments, likes and so on.</p>
<p>If you're an site administrator you will see other kind of things, such as user management.</p>

<p><strong>User Agent:</strong> <?php echo $_SERVER['HTTP_USER_AGENT']; ?></p>

<h3>Stored $_SESSION Data :</h3>
<pre><?php print_r($_SESSION); ?></pre>

<?php $this->render('template/footer'); ?>
