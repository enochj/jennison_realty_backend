Please contact Enoch Jennison at enochjennison@gmail.com or 316-617-0464 for additional questions.

Database migrations are found in database/migrations.
There are two tables in the database, one for listings, and one for photos.

For Scheduling the Task:
  -The Scheduler.bat file can be added as a scheduled task to Windows Task Scheduler.
  -Alternately on Linux, adding the following Cron entry will schedule the task:
  * * * * * php /path/to/artisan schedule:run >> /dev/null 2>&1

The scheduled task is found in app\Console\Kernel.php. It only runs if the time is 2AM PST.
This task will parse an XML file found in the root folder (realty) and insert it into the database.

The Listing and Photo models are found in /app.

The RESTful API endpoints are found in app/Http/routes.php.
