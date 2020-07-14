# Spouse program

Spouse program website using Composer, Docker, Stonehenge and deployed to Wodby.

## Environments

Env | Branch | URL
--- | ------ | ---
development | * | https://spouse.docker.sh/
testing | development | http://spouse-test.druid.fi
production | master | http://spouseprogram.fi

## Requirements

You need to have these applications installed to operate on all environments:

- [Docker](https://github.com/druidfi/guidelines/blob/master/docs/docker.md)
- [Stonehenge](https://github.com/druidfi/stonehenge)

## Create and start the environment

For the first time:

```
$ make fresh
```

## Import / export database
Docker container has [wp-cli](https://developer.wordpress.org/cli/commands/) installed.

To export or import database after the environment has been set up:
1. Get latest version of the database and set it in the same folder with the wordpress installation. You can get a database dump from Wodby
2. Go inside docker container: **make shell**.
3. Inside the container, go to the root of wordpress installation
4. Use the wp-cli to import or export database: **wp db import db-dump.sql**

Login page: https://spouse.docker.sh/wp-admin

Ready! Now go to https://spouse.docker.sh to see your site.
