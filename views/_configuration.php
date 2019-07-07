<div id="phpinfo" class="table-responsive">
	<?php /** @var string $configuration */
	echo DevLog\DevLogHelper::phpInfoCleaner( $configuration );
	?>
</div>

<style>
	#phpinfo table tr td.v{
		word-break: break-word;
	}
</style>