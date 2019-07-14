<h1><?php echo $name;?></h1>

<pre><?php echo DevLog\DevLogHelper::dump( $instance->log,'export' );?></pre>
