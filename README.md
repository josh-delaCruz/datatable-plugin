# Frontend-and-Backend-REST-Service
Frontend and Backend REST service with Docker

<h2>Frontend and Backend</h2>

<p>Procedura</p>

<ol>
<li>Creare una cartella dump</li>
<li>mettere il database dentro la cartella</li>
<li>poi eseguire i comandi</li>
<li>docker run --name my-mysql-server --rm -v "percorso della cartella":/var/lib/mysql -v "percorso alla cartella dump":/dump -e       MYSQL_ROOT_PASSWORD=my-secret-pw -p 3306:3306 -d mysql:latest
</li>
<li>Poi avviamo il apache con</li>
<li>docker run -d -p 8080:80 --name my-apache-php-app --rm -v "percorso cartella serverphp":/var/www/html zener79/php:7.4-apache</li>
<li>Infine poi colleghiamo il database con:
    docker exec -it my-mysql-server bash;
    mysql -u root -p < /dump/create_employee.sql;
    exit;
</li>
</ol>     
