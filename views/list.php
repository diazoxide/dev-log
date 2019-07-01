<?php

function mem_usage( $mem_usage ) {

	if ( $mem_usage < 1024 ) {
		return $mem_usage . " b";
	} elseif ( $mem_usage < 1048576 ) {
		return round( $mem_usage / 1024, 2 ) . " kb";
	} else {
		return round( $mem_usage / 1048576, 2 ) . " mb";
	}
}

?>

<table class="table table-dark table-striped">
    <thead>
    <tr>
        <th>ID</th>
        <th>URI</th>
        <th>Time</th>
        <th>Memory</th>
        <th>Messages</th>
    </tr>
    </thead>
    <tbody>

	<?php /** @var Object[] $logs */
	foreach ( $logs as $id => $log ): ?>
        <tr>
            <td><?php echo $id; ?></td>
            <td><a href="/dev-log/view/<?php echo $id; ?>"><?php echo $log->statement->server->REQUEST_URI; ?></td>
            <td><?php echo $log->statement->time; ?></td>
            <td><?php echo mem_usage( $log->statement->memory_usage ); ?></td>
            <td><?php echo count( $log->messages ); ?></td>
        </tr>
	<?php endforeach; ?>
    </tbody>
</table>


