# LaravelCrudTasksAPI

### Access Nuxt Front repository 

[![Repository](https://img.shields.io/badge/Nuxt-Frontend-1daf2f?style=for-the-badge&logo=vue&logoColor=white)](https://github.com/wbilibio/nuxt-crud-tasks-front)


## Build Setup Docker


### Install Docker and Compose
<a href="https://docs.docker.com/engine/install/">Install Docker</a>.

<a href="https://docs.docker.com/compose/install/">Install Docker Compose</a>.

```bash
# ENV File
Duplicate env.example to .env
Database connections is right
Configure mail to send email

# If you are using your server or local environment as a user that is not root
$ export UID=$(id -u)
$ export GID=$(id -g)

# OBS:. If you are using your server or local environment as the root user
Replace php.dockerfile in the docker-compose.yml file for php.root.dockerfile

# run and up docker
$ docker-compose up -d --build laravelcrudtasksapi

# Composer Install
$ docker-compose run --rm composer update

# Generate JWT Secret
$ docker-compose run --rm artisan jwt:secret

# Generate Laravel Key
$ docker-compose run --rm artisan key:generate

# Create database
$ docker-compose run --rm artisan migrate

# Create first user admin
## email: admin@admin.com
## password: admin
$ docker-compose run --rm artisan db:seed 


# Artisan serve
http://localhost:8000

```

### Extras

```sh
# Down containers 
docker-compose down

#re-build
docker-compose build --no-cache
