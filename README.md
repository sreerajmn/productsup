productsup
==========

Purpose
-------
To fetch XML file from different sources and convert it to different formats. 

Syntax
------

````php
php artisan import:coffee_feed source filename export_format
````
Currently supported sources: ftp and local
Currently supported export formats: csv and json

Usage
-----

Let's say you have a XML file in local storage that needs to be converted to CSV:

````php
php artisan import:coffee_feed local coffee_feed_trimmed.xml csv
````

The converted file will be stored in the `storage\app` folder