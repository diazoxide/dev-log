<?php

use DevLog\DevLogHelper;

?>

<table class="table table-dark table-striped">
	<thead>
	<tr>
		<th>ID</th>

	</tr>
	</thead>
	<tbody>

	<?php /** @var \DevLog\DevLogServe[] $instances */
	foreach ( $instances as $id => $instance ): ?>
		<tr>
			<td>
				<a href="/<?php echo DEV_LOG_PATH; ?>/track/view/<?php echo $id; ?>"><?php echo DevLogHelper::trimString( $id, '12', '' ); ?></a>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>


