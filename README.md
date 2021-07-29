# ClipboardPastingServiceAPI
* As there's no login module (as the part of assignment), only one table's been used for saving the contents.<br>
* The restriction of having one table is that one name/title can have only one post. <br>
* Acesskey authentication part has been commented as my localhost's not accepting custom/additinal headers in case of CORS even after altering the server configuration.<br>
* Create a database named 'clipboard_pasting_service'<br>
* Change the database connection details in Config/settings.php<br>
* The file SQLQueries/queries.php haas the required queries.<br>
* However the query '<b>create table posts(id int AUTO_INCREMENT, name varchar(50), password varchar(30), content text, expiration datetime, exposure varchar(10), created_on datetime, updated_on timestamp, PRIMARY KEY(id), UNIQUE KEY (`name`))</b>' should be enough to create the table required.
* Run the application on apache/nginx server
