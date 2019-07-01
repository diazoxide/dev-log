<div class="row">

    <div class="col-sm-3">

        <div class="list-group">
            <a href="?tab=configuration" class="list-group-item list-group-item-action active">Configuration</a>
            <a href="?tab=server" class="list-group-item list-group-item-action">Server</a>
            <a href="?tab=get" class="list-group-item list-group-item-action">GET</a>
            <a href="?tab=post" class="list-group-item list-group-item-action">POST</a>
            <a href="?tab=messages" class="list-group-item list-group-item-action">Messages</a>
            <a href="?tab=trace" class="list-group-item list-group-item-action">Trace</a>
            <a href="?tab=request" class="list-group-item list-group-item-action">Request</a>
        </div>


    </div>


    <div class="col-sm-9">

		<?php
		$tab = isset( $_GET['tab'] ) ? $_GET['tab'] : "configuration";

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
			default:
				$this->render( '_configuration', [
					'configuration' => $log->statement->php_info
				] );
				break;
		}


		?>

    </div>


</div>
