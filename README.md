# Project Technology Summary

This project utilizes the following technologies:

- **PHP 8.2.1**: The server-side scripting language used for developing dynamic web applications and services.
- **MySQL 8**: The relational database management system employed for storing and managing the project's data.
- **PDO driver for SQL Server**: This must be [installed](https://learn.microsoft.com/en-us/sql/connect/php/installation-tutorial-linux-mac?view=sql-server-ver16#testing-your-installation) and [enabled](https://learn.microsoft.com/en-us/sql/connect/php/loading-the-php-sql-driver?view=sql-server-ver16) on your PHP installation to connect to the database used in the scripts written to answer questions 4 and 15.
- **RabbitMQ**: The message queue system. [Installation instructions](https://gcore.com/learning/how-to-install-rabbitmq-ubuntu/).
- **PHP AMQP Library**: Run `composer require php-amqplib/php-amqplib` to install this library in order to interact with RabbitMQ.
