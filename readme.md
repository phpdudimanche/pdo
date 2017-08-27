
# PDO by example #

Just to show how easily use PDO. Minimalist POC (Proof Of Concept).

## Just good pratice ##

This project goal is to implement best practice.  
If you refer to : https://github.com/phpdudimanche/incident, there are some progesss elements :

- No more var in methods, with params and connection : https://github.com/phpdudimanche/incident/blob/master/incident.php
- No more connection statement directly inside config file : https://github.com/phpdudimanche/incident/blob/master/_config.php
- Database fields and code in english

## Just few files ##

- index.php : bootstrap by default for demonstration
- Config/Connection.php : PDO parameters
- Model/class.php : query to dabase

## Just install ##

If you want to use, install this sql schema : install.sql.  

## Just URLs ##

To test if it is OK (becareful ID with autoincrement). Of course, in real word, Create and Delete will be in POST parameters type, from a form.

- **Create** with : index.php?act=c&title=title1&description=desccription1&severity=10&urgency=10
- **Retrieve** with : index.php?act=r&id=20
- **Update with** : index.php?act=u&id=20&title=new-title&description=new-description&severity=11&urgency=11&status=11       
- **Delete** with : index.php?act=d&id=20

## Just to be continued... ##

Of course, after you can implement **MVC Model**.   
See my other github repository

- View/ directory
- Controller/ directory
