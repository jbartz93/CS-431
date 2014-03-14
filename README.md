##Live Site Info

Everything pushed to this repo is automagically deployed on our Heroku instance. It should be live within 30 seconds of pushing to Github.

You can find the live site at: http://cs431jjs.herokuapp.com/

##Shared MySQL instance

There is a shared MySQL instance on ClearDB. Here is the info:

+ host: `us-cdbr-east-05.cleardb.net`
+ username: `bc05f276159d04`
+ password: `cab4ffa7`
+ database: `heroku_ad3d13b38fcc39e`

So from the command line you can access it with:
```bash
mysql --host=us-cdbr-east-05.cleardb.net --user=bc05f276159d04 --password=cab4ffa7 heroku_ad3d13b38fcc39e
