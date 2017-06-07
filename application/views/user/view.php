<table>
	<tr>
		<th>id</th>
		<th>username</th>
		<th>password</th>
		<th>email</th>
		<th>name</th>
		<th>active</th>
		<th>role</th>
	</tr>
<?php foreach( $this->userdata as $k => $v ) : ?>

	<tr>
	<?php foreach( $v as $data ): ?>
		<td><?php echo $data; ?></td>
	<?php endforeach; ?>
	</tr>

<?php endforeach; ?>

</table>