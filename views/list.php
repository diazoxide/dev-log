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

	<?php /** @var \DevLog\DevLogServe[] $instances */
	foreach ( $instances as $id => $instance ): ?>
		<?php
		$url = DevLogHelper::getActualUrlFromServer( $instance->log['statement']['server'] );
		?>
        <tr>
            <td>
                <a href="/<?php echo DEV_LOG_PATH; ?>/view/<?php echo $id; ?>"><?php echo DevLogHelper::trimString( $id, '12', '' ); ?></a>
            </td>
            <td><span title="<?php echo $url; ?>"><?php echo DevLogHelper::trimString( $url ); ?></span></td>
            <td><?php echo DevLogHelper::getUserIpAddressFromServer( $instance->log['statement']['server'] ); ?></td>
            <td><?php echo $instance->log['statement']['server']['REQUEST_METHOD']; ?></td>
            <td><?php echo DevLogHelper::getHttpStatusBadge( $instance->log['statement']['status'] ); ?></td>
            <td><?php echo DevLogHelper::isXHRFromServer( $instance->log['statement']['server'] ) ? "Yes" : "No"; ?></td>
            <td><?php echo date( 'Y-m-d H:i:s', $instance->log['statement']['time'] ); ?></td>
            <td><?php echo DevLogHelper::getMemUsageReadable( $instance->log['statement']['memory_usage'] ); ?></td>
            <td><?php echo round( $instance->log['statement']['load_time'], 5 ); ?></td>
            <td><?php echo count( $instance->log['messages'] ); ?></td>
        </tr>
	<?php endforeach; ?>
    </tbody>
</table>


