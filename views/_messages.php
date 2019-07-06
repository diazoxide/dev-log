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
			'message'    => "table-dark",
			'info'    => "table-success",
			'warning' => "table-warning",
			'error'   => "table-danger",
			'note'   => "table-info",
			'secondary'   => "table-secondary",
			'important'   => "table-primary",
		];
		?>
        <tr class="<?php echo isset( $classes[ $message->type ] ) ? $classes[ $message->type ] : 'table-primary'; ?>">
            <td><?php echo $id + 1; ?></td>
            <td><?php echo $message->type; ?></td>
            <td><?php echo $message->category; ?></td>
            <td><pre><?php echo $message->message; ?></pre></td>
            <td><?php echo $message->time; ?></td>
        </tr>

	<?php endforeach; ?>

    </tbody>
</table>