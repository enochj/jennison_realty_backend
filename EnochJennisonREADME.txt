Please contact Enoch Jennison at enochjennison@gmail.com or 316-617-0464 for additional questions.

Database migrations are found in database/migrations.
There are two tables in the database, one for listings, and one for photos.

Database configuration is found in config/local/database.php. I can view my local database using phpMyAdmin and username Test and no password.

For Scheduling the Task:
  -listings_lookup.xml can be imported into Windows Task Scheduler. It calls scheduler.bat which will run the schedule.
  -Alternately on Linux, adding the following Cron entry will schedule the task:
  * * * * * php /path/to/artisan schedule:run >> /dev/null 2>&1

The scheduled task is found in app\Console\Kernel.php. It only runs if the time is 2AM PST.
This task will parse the XML file listings.xml found in the root folder (realty) and insert it into the database.

The Listing and Photo models are found in /app.

The RESTful API endpoints are found in app/Http/routes.php.
