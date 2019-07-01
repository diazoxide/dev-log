<?php

use DevLog\DevLogHelper;

function mem_usage( $mem_usage ) {

	if ( $mem_usage < 1024 ) {
		return $mem_usage . " b";
	} elseif ( $mem_usage < 1048576 ) {
		return round( $mem_usage / 1024, 2 ) . " kb";
	} else {
		return round( $mem_usage / 1048576, 2 ) . " mb";
	}
}

function limit( $string, $limit = 40, $end = '...' ) {
	return ( strlen( $string ) > $limit ) ? substr( $string, 0, $limit ) . $end : $string;
}

?>

<table class="table table-dark table-striped">
    <thead>
    <tr>
        <th>ID</th>
        <th>URI</th>
        <th>IP</th>
        <th>Method</th>
        <th>Time</th>
        <th>Memory</th>
        <th>Load time</th>
        <th>Messages</th>
    </tr>
    </thead>
    <tbody>

	<?php /** @var Object[] $logs */

	foreach ( $logs as $id => $log ): ?>
		<?php
		$url = DevLogHelper::getActualUrlFromServer( $log->statement->server );
		?>
        <tr>
            <td><a href="/dlog/view/<?php echo $id; ?>"><?php echo limit($id,'12',''); ?></a></td>
            <td><span title="<?php echo $url; ?>"><?php echo limit( $url ); ?></span></td>
            <td><?php echo DevLogHelper::getUserIpAddressFromServer( $log->statement->server ); ?></td>
            <td><?php echo $log->statement->server->REQUEST_METHOD; ?></td>
            <td><?php echo $log->statement->time; ?></td>
            <td><?php echo mem_usage( $log->statement->memory_usage ); ?></td>
            <td><?php echo round( $log->statement->load_time, 5 ); ?></td>
            <td><?php echo count( $log->messages ); ?></td>
        </tr>
	<?php endforeach; ?>
    </tbody>
</table>


