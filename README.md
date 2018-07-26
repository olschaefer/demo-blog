Demo blog application
====

Installation:
____

    mkdir blog && cd blog
    git clone git@github.com:olschaefer/demo-blog.git .
    docker run -d --name postgres postgres
    docker build . -t blog_app
    docker run -idt -p 8080:8000 --link postgres:postgres --name blog_app blog_app
    docker exec blog_app /www/bin/console doctrine:database:create
    docker exec blog_app /www/bin/console doctrine:schema:create

Now navigate your browser to http://IP_address_of_blog_app_container:8080

Admin area 
------
**URL:** /admin/

**Login:** admin

**Password:** admin

API: 
------

**GET** /api/blog_posts/ — a list of blog posts

**GET** /api/blog_posts/{id} — detailed page 

**POST** /api/blog_posts/{id}/views/ — increment view counter (since GET requests are not allowed to modify state)