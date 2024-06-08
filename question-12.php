<!-- Task sender -->
<?php
require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$host = $_ENV['RABBITMQ_PORT'];
$port = $_ENV['RABBITMQ_HOST'];
$userName = $_ENV['RABBITMQ_USERNAME'];
$password = $_ENV['RABBITMQ_PASSWORD'];

const SENDER_QUEUE_NAME = 'email_queue';

$connection = new AMQPStreamConnection($host, $port, $userName, $password);
$channel = $connection->channel();

$channel->queue_declare(SENDER_QUEUE_NAME, false, false, false, false);

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
$userName = 'guest';
$password = 'guest';
const WORKER_QUEUE_NAME = 'email_queue';

$connection = new AMQPStreamConnectionWorker($host, $port, $userName, $password);
$channel = $connection->channel();

$channel->queue_declare(WORKER_QUEUE_NAME, false, false, false, false);

echo "Waiting for messages.\n";

$callback = function ($msg) {
    echo ' Email task received ', $msg->body, "\n";
};

$channel->basic_consume(WORKER_QUEUE_NAME, '', false, true, false, false, $callback);

try {
    $channel->consume();
} catch (\Throwable $exception) {
    echo $exception->getMessage();
}

$channel->close();
$connection->close();

?>