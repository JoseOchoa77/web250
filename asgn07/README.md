1.Why does this many-to-many design use three tables instead of putting one bird_id in
bird_images?
We need this design because we are going to utilize many items with different IDs. If we used a single table connection we wouldn't be able to put more than one item i believe. Also we are normalizing the data so it has better integrity.

2. What happens to the links, image records, and physical JPEG files when a species record is deleted?
Well the delete will cascade to the other tables that inherit the ID of the record because of the ON DELETE CASCADE line in the mysql. But will not affect images or JPEG files.

3. What does the PDO DSN contain, and why is Database::$connection static?
PDO DSN contains variables that make it possible to connect to a database. The variable include: 'mysql:host=localhost;dbname=testdb;charset=utf8mb4'. The connection is static so that there is only one shared connection throughout the whole request or else it would the connection would have to be restated all the time. 

4. What is the difference between query() and fetchColumn() in the count example?
query() submits a query into the database but will not fetch the output meanwhile fetchcolumn() cant query but can fetch the output. 
