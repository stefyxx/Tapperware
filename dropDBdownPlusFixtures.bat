del migrations/V*
symfony console doctrine:database:drop --force --no-interaction 
symfony console doctrine:database:create --no-interaction
symfony console make:migration --no-interaction
symfony console doctrine:migration:migrate --no-interaction

symfony console doctrine:fixtures:load 
@Rem symfony console doctrine:fixtures:load --no-interaction 

@Rem per usare questo file é sufficiente scrivere nel terminale .\dropDBdownPlusFixtures.bat

@Rem --no-interaction: NON MI DOMANDA PIù SE SONO SICURO DI DISTRUGGERE TUTTO!!!!
@Rem fixtures:load cancella vecchi e mette nuovi
@Rem fixtures:load --append riaggiunge fakes alla fine, se non mi serve, cancello la linea
