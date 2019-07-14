<?php

use DevLog\DevLog;
use DevLog\DevLogHelper;
?>

<?php
$url = DevLogHelper::getActualUrlFromServer( $instance->log['statement']['server'] );
?>

<div class="btn-toolbar justify-content-between" role="toolbar" aria-label="Toolbar with button groups">

    <div class="btn-group" role="group" aria-label="First group">
        <a role="button" target="_blank" href="/<?php echo DEV_LOG_PATH; ?>/view/<?php echo $name; ?>" class="btn btn-dark"><?php echo DevLog::$scriptName;?></a>
        <button type="button" class="btn btn-secondary"><span title="<?php echo $url; ?>"><?php echo DevLogHelper::trimString( $url ); ?></span></button>
        <button type="button" class="btn btn-primary">Method: <?php echo $instance->log['statement']['server']['REQUEST_METHOD']; ?></button>
        <button type="button" class="btn btn-default">Status: <?php echo DevLogHelper::getHttpStatusBadge($instance->log['statement']['status']); ?></button>
        <button type="button" class="btn btn-success">RAM: <?php echo DevLogHelper::getMemUsageReadable( $instance->log['statement']['memory_usage'] ); ?></button>
        <button type="button" class="btn btn-default">Time: <?php echo round( $instance->log['statement']['load_time'], 5 ); ?>s</button>
        <button type="button" class="btn btn-warning">Messages: <?php echo count( $instance->log['messages'] ); ?></button>
    </div>


</div>
