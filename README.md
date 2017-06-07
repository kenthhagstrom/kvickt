Kvickt PHP Framework
====================
(C) Kenth Hagström 2016

Kvickt is a PHP framework, it's also a Swedish word for something being fast. As the name suggests it's built with speed in mind. It's basically a website engine for developers, built with the principles of the MVC (Model View Controller) design pattern.

### TODOs

* Reset account password.
* Edit user account profile.
* List user on frontend by ID; **url/user/view/id**
* Better mail functionality.
* HTML helpers, secure forms, valid html5 etc.
* Add a dynamic menu system.
* Error handler with logging.
* User settings. Separate database table from user (use join).
* RBAC (Role Based Access Control).
* Always track and kill bugs!

### Requirements

To get Kvickt up and running you need a web server supporting mod_rewrite and PHP7. You also need a database to store data, MySQL or MariaDB. Test data available in the `install.sql` file.

## phpMyAdmin

If you have phpMyAdmin installed in the default subdirectory `/phpmyadmin/` on the same server. Then you need to add it as an exception from the rewrite rules in the `.htaccess` file.

    RewriteCond %{THE_REQUEST} !/phpmyadmin [NC]

# Alpha Release

Kvickt is still an alpha, don't use it in any circumstances on a live site! I take no responsibilities what so ever if you do! Hopefully a stable release will exist before christmas.