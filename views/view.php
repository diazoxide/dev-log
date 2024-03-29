<?php
/** @var \DevLog\DevLogServe $instance */

?>
<div class="row">

    <div class="col-sm-3">

		<?php

		use DevLog\DevLogHelper;

		echo \DevLog\DevLogHelper::getMenu( [

			[ 'label' => 'Messages', 'url' => '?tab=messages' ],
			[ 'label' => 'Configuration', 'url' => '?tab=configuration' ],
			[ 'label' => 'Server', 'url' => '?tab=server' ],
			[ 'label' => 'GET', 'url' => '?tab=get' ],
			[ 'label' => 'POST', 'url' => '?tab=post' ],
			[ 'label' => 'Trace', 'url' => '?tab=trace' ],
			[ 'label' => 'Request', 'url' => '?tab=request' ],
			[ 'label' => 'Response', 'url' => '?tab=response' ],

		], [ 'items' => [ 'class' => 'list-group-item list-group-item-action' ] ] );


		$url = DevLogHelper::getActualUrlFromServer( $instance->log['statement']['server'] );

		?>

    </div>


    <div class="col-sm-9">

        <div class="alert alert-success" role="alert">

			<?php echo sprintf(
				'%1$s: <span class="font-weight-bold">%2$s</span> <a href="%3$s">%3$s</a> at <span class="font-weight-bold">%4$s</span> by <span class="font-weight-bold">%5$s</span>',
				$name,
				$instance->log['statement']['server']['REQUEST_METHOD'],
				$url,
				date( 'Y-m-d H:i:s', $instance->log['statement']['time'] ),
				DevLogHelper::getUserIpAddressFromServer( $instance->log['statement']['server'])
			); ?>

        </div>


		<?php
		$tab = isset( $_GET['tab'] ) ? $_GET['tab'] : "messages";

		switch ( $tab ) {
			case "messages":
				$this->render( '_messages', [
					'messages' => $instance->log['messages']
				] );
				break;
			case "server":
				$this->render( '_server', [
					'server' => $instance->log['statement']['server']
				] );
				break;
			case "request":
				$this->render( '_request', [
					'request' => $instance->log['statement']['request']
				] );
				break;
			case "response":
				$this->render( '_response', [
					'response' => $instance->log['statement']['response']
				] );
				break;
			case "get":
				$this->render( '_get', [
					'get' => $instance->log['statement']['get']
				] );
				break;
			case "post":
				$this->render( '_post', [
					'post' => $instance->log['statement']['post']
				] );
				break;
			case "trace":
				$this->render( '_trace', [
					'trace' => $instance->log['statement']['trace']
				] );
				break;
			case "configuration":
				$this->render( '_configuration', [
					'configuration' => $instance->log['statement']['php_info']
				] );
				break;
			default:
				$this->render( '_messages', [
					'messages' => $instance->log['messages']
				] );
				break;
		}


		?>

    </div>


</div>
