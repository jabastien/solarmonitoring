Server Requirements:
Mysql 5.x
PHP 5.3
php curl library installed
*email (for proper notifications) needs to be setup 

LAMP server with the following packages installed
openssh-server (or some other way to upload the application files)
apache2 
mysql-server
php5
php5-mysql
php5-curl
crontab
apache's mod rewrite needs to be enabled and .htaccess files allowed on the web app folder 
(see detailed instructions for help on how to do this)
phpmyadmin*

* = encouraged for ease of use, but not required

Basic Install instructions (for Sys Admins or if using an external web host)

1) Ensure your server meets all of the server requirements above:
2) Setup your Server:
	a) create mysql database for the application
	b) create mysql user and give that user full rights to db created in step a
	c) execute mysql timezone script
	d) edit then run default site script in /install directory
	e) edit then run the default device script in /install directory

3) setup your web directory and make sure you have permissions to upload files to it
4) configure permissions on 2 folders to allow the app to write to them
	a) /appfolder/csv  - this stores the downloaded raw data files
	b) /appfolder/logs/raw_json_files*

	*this is optional, and logging must be enabled programatticly in the m_export model

 
1) download application code from https://github.com/dexterinteractive/solarmonitoring
	a) upload to your web directory
	b) make sure .htaccess file is in root and in tact.


2) Upload all files to your web directory
3) Do
	a) execute database create script located in /install/solarmonitoring_create.sql
	b) EDIT FIRST, then execute the /install/sitesetup.sql script  (you MUST setup your default site and devices!)

4) Configure App:
	a) in /application/config/config.php
		1) set $config['base_url'] to the public URI  (e.g. http://mywebsite.com or http://mywebsite.com/thisapp)
		2) set $config['server_TZ'] to your appropriate server TZ
		3) set $config['system_golivedate'] to the appropriate system go live date.

	b) in /application/config/database.php
		1) set hostname, username, password and database to appropriate values for your environment


	
5) setup remote monitoring task
 	a) use this syntax to create a cron job
	0,15,30,45 * * * * wget -O - -q -t 1 --spider http://mywebsite.com/datalogger/collector/$PUBLICID
	
	*replace $PUBLICID with the public key for your monitoring site as well as the public URL of the app.  T
	his job polls every 15 	minutes, but you could (in theory) use a different interval and everything should still work 




