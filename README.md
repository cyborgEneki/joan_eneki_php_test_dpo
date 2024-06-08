# Technology Summary

This project utilizes the following technologies:

- **PHP 8.2.1**: The server-side scripting language used for developing dynamic web applications and services.
- **MySQL 8**: The relational database management system employed for storing and managing the project's data.
- **PDO driver for SQL Server**: This must be [installed](https://learn.microsoft.com/en-us/sql/connect/php/installation-tutorial-linux-mac?view=sql-server-ver16#testing-your-installation) and [enabled](https://learn.microsoft.com/en-us/sql/connect/php/loading-the-php-sql-driver?view=sql-server-ver16) on your PHP installation to connect to the database.
- **RabbitMQ**: The message queue system. [Installation instructions](https://www.rabbitmq.com/docs/install-debian).

To get started:
1. Rename `.env.example` to `.env`
2. Run `composer install`
