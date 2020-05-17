## Remove database, migrations and rebuild new database

bin/console doctrine:shema:drop -n -q --force --full-database && rm src/Migrations/*.php && bin/console make:migrations && bin/console doctrine:migrations:migrate -n -q

## Get all logs in elastic search

http://symfony.loc:9200/logstash-2020.05.16-000001/_search?pretty=true