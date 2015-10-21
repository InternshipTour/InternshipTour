<?php
//兼容SAE上的数据连接
define('UC_DB_DSN', 'mysql://'.SAE_MYSQL_USER.':'.SAE_MYSQL_PASS.'@'.SAE_MYSQL_HOST_S.':'.SAE_MYSQL_PORT.'/'.SAE_MYSQL_DB); // SAE数据库连接