php_hitcount
============

A simple one class php based hit counter. 
After 7 days it will simply allow another view per ip by a page.


## Usage
============
Include the file into where you wish to use it.

After you will need simply to create an instance of it to function.
```
$Counter = new Count($host,$user,$password,$database,$htmlpath);
```
You pass it the host for a mysql database, the user and password along with the database you wish to use. Then you pass it the public html base you wish. If you live it blank it will take the full script path all the way to the base dir/


To call a usable function you can do:
```
$Counter->getSuggestedName();
```
It will return a suggest name for the page. It is based off of the path to the script.
If your file is in /home/web/cow/html/script.php it would return "script" while /home/web/cow/html/otherfile/script.php would come back with "otherfile_script"

```
$Counter->getHits();
$Counter->getHits("CrazyPage);
```
This will return the number of hits per the page you select or by default it will use the suggested name.

```
$Counter->addHit();
$Counter->addHit("CrazyPage);
```
This will add a hit to the page you select or by default it will use the suggested name.
