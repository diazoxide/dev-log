<table class="table table-striped">
    <thead>
    <tr>
        <th>ID</th>
        <th>Type</th>
        <th>Category</th>
        <th>Message</th>
        <th>Time</th>
    </tr>

    </thead>
    <tbody>

	<?php /** @var Object[] $messages */
	foreach ( $messages as $id => $message ): ?>
		<?php
		$classes = [
			'info'    => "table-success",
			'warning' => "table-warning",
			'error'   => "table-danger",
		];
		?>
        <tr class="<?php echo isset( $classes[ $message->type ] ) ? $classes[ $message->type ] : 'table-primary'; ?>">
            <td><?php echo $id + 1; ?></td>
            <td><?php echo $message->type; ?></td>
            <td><?php echo $message->category; ?></td>
            <td><?php echo $message->message; ?></td>
            <td><?php echo $message->time; ?></td>
        </tr>

	<?php endforeach; ?>

    </tbody>
</table>