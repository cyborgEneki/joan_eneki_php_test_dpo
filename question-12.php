<!-- Task sender -->
<?php
require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$host = 'localhost';
$port = 5672;
$user = 'guest';
$pwd = 'guest';

$queueName = 'email_queue';

$connection = new AMQPStreamConnection($host, $port, $user, $pwd);
$channel = $connection->channel();

$channel->queue_declare($queueName, false, false, false, false);

$msg = new AMQPMessage('Hello World!');
$channel->basic_publish($msg, '', 'hello');

echo "Email task sent.'\n";

$channel->close();
$connection->close();

?>


<!-- Task processer (worker) -->
<?php
require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection as AMQPStreamConnectionWorker;

$host = 'localhost';
$port = 5672;
$user = 'guest';
$pwd = 'guest';
$queueName = 'email_queue';

$connection = new AMQPStreamConnectionWorker($host, $port, $user, $pwd);
$channel = $connection->channel();

$channel->queue_declare($queueName, false, false, false, false);

echo "Waiting for messages.\n";

$callback = function ($msg) {
    echo ' Email task received ', $msg->body, "\n";
};

$channel->basic_consume($queueName, '', false, true, false, false, $callback);

try {
    $channel->consume();
} catch (\Throwable $exception) {
    echo $exception->getMessage();
}

$channel->close();
$connection->close();

?>