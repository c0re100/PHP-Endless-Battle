# PHP-Endless-Battle
Ext4! Beta v2.6

# INSTALLATION
- Configure Server/Database settings(cfu.php/index.php)
- Import a MySQL Database(INSTALL.SQL) using phpMyAdmin
- Done

# Why not to use?
- Discontinued
- Spegatti code, nearly impossible to maintain and debug
- Extremely vulnerable to SQL injection
  - `mysql_query`
  - Without `mysql_real_escape_string`
- Incomplete server side form checking
- Unknown exploits

# What to do if I insist?
- At least escape all the SQL queries
- Or better, refactor all the code
- Or even more better, rewrite in node.js or other modern server side language

# Original author
http://forum.v2alliance.net/viewthread.php?tid=164&extra=page%3D1

#Thanks
- PokeGuys (Gold Gundam......more)
- Saren (reCAPTCHA......more)

# Docker

## How to use

1. Install Docker & Docker Compose
2. Download the whole project
3. `cd` the project root
4. Run `docker-compose -p EL build`
5. Run `docker-compose -p EL up -d`
6. Go to the PHP_MY_ADMIN, create database called `ebs`
7. Import `src/INSTALL.SQL`

- DOCKER_MACHINE_IP:9999 is the front page, e.g. `http://192.168.99.100:9999`
- DOCKER_MACHINE_IP:8181 is PHPMYADMIN, e.g. `http://192.168.99.100:8181`
- MYSQL user = root
- MYSQL passwrod = 1234

## What is docker doing?
1. Download the image of mysql, myphpadmin, and php with MySQL extension
2. Link them all together according to **docker-compose.yml**
3. Copy everythings inside `src/` into the html directory

## Why it is so slow to load the front page?
When you type **wrong IP** in the PHP, it will take very longgggggg time to try to get the SQL connection, Up to 1 min

## Why you set the database connection to 172.17.0.1?

`172.17.0.1` is the gateway IP of all the docker image (Personally I don't know why)
In my docker machine, it looks like
- Apache: 172.17.0.4
- PHPMYADMIN: 172.17.0.3
- MySQL: 172.17.0.2

I have tried to use 127.0.0.1 or localhost or 0.0.0.0, it seems to be failed.

