# ATSAST
Auxiliary Teaching for SAST

## Installation

Here is detailed step about deploying ATSAST:

1. You need to have a server and installed the following:
    - [PHP ^7.1.3(recommend 7.3.4)](http://php.net/downloads.php)
    - [Composer ^1.8.5(recommend 1.8.5)](https://getcomposer.org)
    - [MySQL ^5.5.3(recommend 8.0)](https://www.mysql.com/)

2. Clone ATSAST to your website folder;

```
cd /path-to-ATSAST/
git clone https://github.com/ZsgsDesign/ATSAST ./
```

3. Change your website root to `public` folder and then, if there is a `open_basedir` restriction, remove it;

4. Now run the following commands at the root folder of ATSAST;

```
composer install
```

> Notice: you may find this step(or others) fails with message like "func() has been disabled for security reasons", it means you need to remove restrictions on those functions, basically Laravel and Composer require proc_open and proc_get_status to work properly.

5. Almost done, you still got to modify a few folders and give them permission to write;

```
chmod -R 775 storage/
chmod -R 775 bootstrap/
```

6. OK, right now we still need to configure environment, a typical `.env` just like the `.env.example`, you simply need to type the following codes;

```
cp .env.example .env
vim .env
```

7. Now, we need to configure the database, thankfully Laravel have migration already;

```
php artisan migrate
```

8. ATSAST's up-and-running, enjoy!
