<h1>Wiam Test Task</h1>

<h3>Run</h3>

Build the container:
```
docker-compose build --no-cache php
```

Start the container:
```
docker-compose up -d
```

The project runs on `localhost`.

To have both the database and the application on localhost, I configured it so that it connects to the database via the 
host localhost, redirecting this host to the db container using extra_hosts and static IP addresses.





