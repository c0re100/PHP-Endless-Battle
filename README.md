# PHP-Endless-Battle
Ext4! Beta v2.6

# INSTALLATION
- Configure Server/Database settings(cfu.php/index.php)
- Import a MySQL Database(install.sql) using phpMyAdmin
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
- Jasonlhy for his help in dockerizing.
