<?php

use DevLog\DevLogHelper;
?>

<table class="table table-dark table-striped">
    <thead>
    <tr>
        <th>ID</th>
        <th>URI</th>
        <th>IP</th>
        <th>Method</th>
        <th>Status</th>
        <th>XHR</th>
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
            <td>
                <a href="/<?php echo DEV_LOG_PATH; ?>/view/<?php echo $id; ?>"><?php echo DevLogHelper::trimString( $id, '12', '' ); ?></a>
            </td>
            <td><span title="<?php echo $url; ?>"><?php echo DevLogHelper::trimString( $url ); ?></span></td>
            <td><?php echo DevLogHelper::getUserIpAddressFromServer( $log->statement->server ); ?></td>
            <td><?php echo $log->statement->server->REQUEST_METHOD; ?></td>
            <td><?php echo DevLogHelper::getHttpStatusBadge($log->statement->status); ?></td>
            <td><?php echo DevLogHelper::isXHRFromServer( $log->statement->server ) ? "Yes" : "No"; ?></td>
            <td><?php echo date('Y-m-d H:i:s', $log->statement->time); ?></td>
            <td><?php echo DevLogHelper::getMemUsageReadable( $log->statement->memory_usage ); ?></td>
            <td><?php echo round( $log->statement->load_time, 5 ); ?></td>
            <td><?php echo count( $log->messages ); ?></td>
        </tr>
	<?php endforeach; ?>
    </tbody>
</table>


