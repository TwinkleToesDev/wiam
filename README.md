<h1>Wiam Test Task</h1>

<h3>Run</h3>

Build the container:
```
docker-compose build
```

Start the container:
```
docker-compose up -d
```

Start migrations:
```
 docker-compose exec php bash   
 
 php yii migrate
```

The project runs on `localhost`.

To have both the database and the application on localhost, I configured it so that it connects to the database via the 
host localhost, redirecting this host to the db container using extra_hosts and static IP addresses.

<h3>Time spent</h3>

    •	Setting up the environment and Docker Compose: 1 hour
	•	Developing models and controllers: 2 hours
	•	Testing and debugging: 1 hour
	•	Preparing documentation: 30 minutes





