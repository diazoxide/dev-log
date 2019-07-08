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

	use DevLog\DevLog;

	foreach ( $messages as $id => $message ): ?>
        <tr class="<?php echo isset( DevLog::$messageTypes[ $message->type ] ) ? DevLog::$messageTypes[ $message->type ] : 'table-primary'; ?>">
            <td><?php echo $id + 1; ?></td>
            <td><?php echo $message->type; ?></td>
            <td><?php echo $message->category; ?></td>
            <td>
                <pre><?php echo htmlspecialchars( $message->message ); ?></pre>
            </td>
            <td><?php echo $message->time; ?></td>
        </tr>

	<?php endforeach; ?>

    </tbody>
</table>