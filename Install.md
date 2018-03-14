# Installation Notes
You need to get latest version of Phalcon Framework. Phalcon is delivered as a php's extension so it can't be installed via composer. For Debian-based systems:

`curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.deb.sh | sudo bash`
`apt-get update && apt-get install php7.1-phalcon`
`service php7.1-fpm restart`

In case of any problems you could open installation instructions: https://olddocs.phalconphp.com/en/3.0.0/reference/install.html

I am using php7.1 at the moment and only for this version of PHP work is guaranteed and tested.
* Nginx's config file can be found in project root (quiz.local)
* Don't forget to import **snapshot.sql.bz2** to your MySQL database. I wanted to write a migrations but didn't have enough time for this. 
* Adjust variables in your app/config/config.php file (minimum is password for db connection)

After finishing you should be able to open your local URL with project.
Demo version: http://quiz.local. Please be sure that in /etc/hosts you have a record `188.165.226.139	quiz.local`


# Known Issues
* No UnitTests for insufficient time.
* No Docker
* No migrations. Yeah, it will be much cooler when you just start migration and all data is already in database, but my own time limits doesn't allowed me to use them.
* No validation. Due to MVP of this project, didn't waste time to correct data validation.
* JS part is awful. As a dedicated backend developer for many years, I didn't practice in something else a lot. So I guess there are a lot of performance issues, lack of optimization and maybe even security. But it's working!
* Randomizer is very bad. There are a lot of questions with only 2 possible answers in it. But for MVP is ok, I guess.
* Code is not structured enough. And this Quiz\Quiz\Quiz... well, time for early refactoing :D

I set a goal to solve this task in 7 hours – and I did it. Unfourtinately main devourer of time was JS/canvas part (didn't work with canvas ever). ~4,5 hours for this. ~2 hours for backend development, setting database and webserver. ~0,5h for testing and some adjustments.

I would like to give thanks for this task – I dropped out of my routine RESTful services and opened something new. Also this task is big enough to show all possible art of programming and you are not limitting developer. Despite to thing that task is big, it's absolutely useless to use it in production so developers can trust that it's for testing purposes only. 

P.s after finishing project I found that I missed this part: 
`There must be some solution which will sync clicks if this screen opened in multiple tabs (or browsers) for this same quiz. So, basically, if you have same quiz opened in two different tabs (or browsers) - click on answer 1 for question 1 in one tab must redraw other tab and indicate that answer 1 selected for question 1. Finishing quiz in one tab must redirect all other opened tabs for this same quiz to quizes list (screen #2).`

Well, first decision for this is WS. When user clicks server automatically sync answer position with all other connections bound to this user. Second possibility – just an AJAX call every second to server with the same reason – to check what changed. I guess this part is more complicated on frontend part, so I still couldn't do it fast enough.