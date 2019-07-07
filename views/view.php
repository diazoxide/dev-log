<div class="row">

    <div class="col-sm-3">

		<?php
		echo \DevLog\DevLogHelper::getMenu( [

			[ 'label' => 'Messages', 'url' => '?tab=messages' ],
			[ 'label' => 'Configuration', 'url' => '?tab=configuration' ],
			[ 'label' => 'Server', 'url' => '?tab=server' ],
			[ 'label' => 'GET', 'url' => '?tab=get' ],
			[ 'label' => 'POST', 'url' => '?tab=post' ],
			[ 'label' => 'Trace', 'url' => '?tab=trace' ],
			[ 'label' => 'Request', 'url' => '?tab=request' ],
			[ 'label' => 'Response', 'url' => '?tab=response' ],

		], [ 'items' => [ 'class' => 'list-group-item list-group-item-action' ] ] )
		?>

    </div>


    <div class="col-sm-9">

		<?php
		$tab = isset( $_GET['tab'] ) ? $_GET['tab'] : "messages";

		switch ( $tab ) {
			case "messages":
				$this->render( '_messages', [
					'messages' => $log->messages
				] );
				break;
			case "server":
				$this->render( '_server', [
					'server' => $log->statement->server
				] );
				break;
			case "request":
				$this->render( '_request', [
					'request' => $log->statement->request
				] );
				break;
			case "response":
				$this->render( '_response', [
					'response' => $log->statement->response
				] );
				break;
			case "get":
				$this->render( '_get', [
					'get' => $log->statement->get
				] );
				break;
			case "post":
				$this->render( '_post', [
					'post' => $log->statement->post
				] );
				break;
			case "trace":
				$this->render( '_trace', [
					'trace' => $log->statement->trace
				] );
				break;
			case "configuration":
				$this->render( '_configuration', [
					'configuration' => $log->statement->php_info
				] );
				break;
			default:
				$this->render( '_messages', [
					'messages' => $log->messages
				] );
				break;
		}


		?>

    </div>


</div>
