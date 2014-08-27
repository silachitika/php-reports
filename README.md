Php Reports
===========

A reporting framework for managing and displaying nice looking, exportable reports from any data source, including SQL and MongoDB.

Major features include:

*   Display a report from any data source that can output tabular data (SQL, MongoDB, PHP, etc.)
*   Output reports in HTML, XML, CSV, JSON, or your own custom format
*   Add customizable parameters to a report (e.g. start date and end date)
*   Add graphs and charts with the Google Data Visualization API
*   Supports multiple database environments (e.g. Production, Staging, and Dev)
*   Fully extendable and customizable

For installation instructions and documentation, check out http://jdorn.github.io/php-reports/

If you have a question, post on the official forum - http://ost.io/@jdorn/php-reports


Basic Introduction
============

Reports are organized and grouped in directories.  Each report is it's own file.

A report consists of headers containing meta-data (e.g. name and description) 
and the actual report (SQL queries, javascript, or PHP code).

All reports return rows of data which are then displayed in a sortable/searchable HTML table.

Reports can be exported to a number of formats including CSV, XLS, JSON, and XML.

The Php Reports framework ties together all these different report types, output formats, and meta-data into
a consistent interface.

Example Reports
==============

Here's an example SQL report:

```sql
-- Products That Cost At Least $X
-- VARIABLE: {"name": "min_price"}

SELECT Name, Price FROM Products WHERE Price > "{{min_price}}"
```

The set of SQL comments at the top are the report headers.  The first row is always the report name.

The `VARIABLE` header tells the report framework to prompt the user for a value before running the report.  Once provided
it will be passed into the report body ("{{min_price}}" in this example) and executed.


Here's a MongoDB report:

```js
// List of All Foods
// MONGODATABASE: MyDatabase
// VARIABLE: {
//   "name": "include_inactive", 
//   "display": "Include Inactive?", 
//   "type": "select",
//   "options": ["yes","no"]
// }

var query = {'type': 'food'};

if(include_inactive == 'no') {
    query.status = 'active';
}

var result = db.Products.find(query);

printjson(result);
```

As you can see, the structure is very similar.  MongoDB reports use javascript style comments for the headers, but everything else remains the same.

The MONGODATABASE header, if specified, will populate the 'db' variable.


Here's a PHP Report:

```php
<?php
//List of Payment Charges
//This connects to the Stripe Payments api and shows a list of charges
//INCLUDE: /stripe.php
//VARIABLE: {"name": "count", "display": "Number to Display"}

if($count > 100 || $count < 1) throw new Exception("Count must be between 1 and 100");

$charges = Stripe_Charge::all(array("count" => $count));

$rows = array();
foreach($charges as $charge) {
    $rows[] = array(
        'Charge Id'=>$charge->id,
        'Amount'=>number_format($charge->amount/100,2),
        'Date'=>date('Y-m-d',$charge->created)
    );
}

echo json_encode($rows);
?>
```
Again, the header format is very similar.  

The INCLUDE header includes another report within the running one.  Below is example content of /stripe.php:

```php
<?php
//Stripe PHP Included Report
//You can have headers here too; even nested INCLUDE headers!
//Some headers will even bubble up to the parent, such as the VARIABLE header

//include the Stripe API client
require_once('lib/Stripe/Stripe.php');

//set the Stripe api key
Stripe::setApiKey("123456");
?>
```

Hopefully, you can begin to see the power of Php Reports.

For full documentation and information on getting started, check out http://jdorn.github.io/php-reports/




Manual

Installation Procedure:
=======================

1. Git Clone https://github.com/silachitika/php-reports.git

```
git clone https://github.com/silachitika/php-reports.git
```


2. The next step is to install dependencies with Composer. If you don't already have composer installed, run the following:
```
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```


3. Once Composer is installed, run the following from within the php-reports folder
```
composer install​
```

4. Finally, you need to create a configuration file. A sample one is included in config/config.php.sample. It's easiest to just use this as a base.
```
cp config/config.php.sample config/config.php
```
5. You should now be able to view the report list in your browser

If you use nginx, place the following in your server declaration - try_files $uri $uri/ /index.php?$query_string;

If you use Apache, make sure .htaccess files are allowed and mod_rewrite is enabled
The basic Apache configuration (Optional)
```
 sudo vi /etc/apache2/sites-available/default                
 ```
 
 ```
 <Directory /var/www/php-reports>
                Options Indexes FollowSymLinks MultiViews
                AllowOverride All
                Order allow,deny
                allow from all
        </Directory>
```
New Features and Usage:
======================

A. User Authentication:
======================

1. Enable the login system in config/config.php

```
vi config/config.php//Confugure whether to use Login System or not for PHPReports
//Assign 1 to enable, assign 0 for disable.Default it is Disable
'loginEnable' => 1,
```

2. Create the mysql database called php_reports and run the php_reports.sql file for the login database table structure and default data.

```
Default Login Details:                                              User Name: admin@example.com                                     Password: password* Change the email and password once logged in as admin.
```

3. Also you can update the login_configuration table for your custom website_url and to enable registration feature for users and enable email login etc.
```
SELECT * FROM `login_configuration` 
```
id	name 	value
1 	website_name	PHP Reports Login
2	website_url	localhost/php-reports/login/
3	email	admin@example.com
4	activation	1
5	resend_activation_threshold 	0
6	language	models/languages/en.php
7	template	models/site-templates/default.css
8	can_register 	0
9	new_user_title	Admin
11	email_login	1
12	token_timeout 	10800


B) Uploading Custom Reports and Edit Reports:
============================================


1. Add the link to the reports folder in the config.php
```
//the root directory of all your reports
//reports can be organized in subdirectories
'reportDir' => 'reports',
```

NOTE: For Security reasons, suggested by Anugrah better to keep the reports directory outside of the repo (Also To avoid the permission issues) and link to that location in config.php.
```
'reportDir' => '/home/sreekanth/reports',
```

2. Make sure the permissions to the reports folder is writable from other users.


3. With in each reports sub directories create the custom directory for uploading custom user reports.


4. You can see the edit report option after selecting any report from report list right side of the report name.


5. You can see the Add custom report in the report list only if you create the custom directory within the report directories.


C) Email Scheduler 
==================

1. You can see the email scheduler after you select any report, and you can scheduler email after you run the report.

2. You can select the time to fire the email, and it creates the cron job under the www-data user.


D) Bug Fixes and Other Extensions
=================================

1)Date Range Issue Fix.(https://github.com/jdorn/php-reports/issues/139)

2)Fixed the email send error due to it is taking high memory while executing program to create the email.
3)Fixed the ado oci8 variables issue https://github.com/jdorn/php-reports/issues/128

4)Pipeline Charts.(https://github.com/jdorn/php-reports/issues/137)



