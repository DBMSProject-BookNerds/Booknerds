<?php
    function create_database(){
        //boolean for whether or not to create data.
        $create_data = false;
        
        $string_result = "";
        
        // establish the database
        // change permissions as needed
        try
        {
        $conn = @mysqli_connect("localhost", "root", "default","");
        $string_result .= " connected successfully";
		}
		catch (exception $e) {
            $string_result .= $e->getmessage();
            return $string_result;
        }
        
        
        //$drop_db = "DROP DATABASE BookNerds"; /////// delete these after
        //mysqli_query($conn, $drop_db); /////     delete these after*/
        if (!$conn)
        {	
            $string_result .= "| Cannot connect" . mysqli_error($conn);
        }
        else
        {
            $string_result .= "| Connection created";
        }

        $sql="CREATE DATABASE if not exists BookNerds";
        try 
        {
            //create the database if it does not exist
            if (mysqli_query($conn, $sql))
            {
            $string_result .= "| Database created\n";
            mysqli_select_db($conn, 'BookNerds');

            // create the tables
            $table = array("CREATE TABLE bookstore
                            (bookstoreID int NOT NULL AUTO_INCREMENT,
                            bookstoreName varchar(50),
                            city varchar(50),
                            stateName varchar(50),
                            postalCode int,
                            addressName varchar(50),
                            phone varchar(20),
                            PRIMARY KEY(bookstoreID))",

                            "CREATE TABLE customer
                            (customerID int NOT NULL AUTO_INCREMENT,
                            firstName varchar(20),
                            lastName varchar(20),
                            email varchar(50),
                            phone varchar(20),
                            addressName varchar(50),
                            city varchar(50),
                            stateName varchar(50),
                            postalCode int,
                            PRIMARY KEY (customerID))",
                            
                            "CREATE TABLE orders
                            (orderID int NOT NULL AUTO_INCREMENT,
                            customerID int,
                            FOREIGN KEY (customerID) REFERENCES customer(customerID),
                            orderDate varchar(10),
                            totalPrice decimal(10, 2),
                            PRIMARY KEY(orderID))",

                            "CREATE TABLE author
                            (authorID int NOT NULL AUTO_INCREMENT,
                            firstName varchar(50),
                            lastName varchar(50),
                            descr varchar(500),
                            PRIMARY KEY (authorID))",

                            "CREATE TABLE genre
                            (genreID int NOT NULL AUTO_INCREMENT,
                            genreName varchar(20),
                            PRIMARY KEY (genreID))",

                            "CREATE TABLE book
                            (bookID int NOT NULL AUTO_INCREMENT,
                            title varchar(250),
                            descr varchar(500),
                            price decimal(10, 2),
                            authorID int,
                            FOREIGN KEY (authorID) REFERENCES author(authorID),
                            bookstoreID int,
                            FOREIGN KEY (bookstoreID) REFERENCES bookstore(bookstoreID),
                            publicationDate varchar(10),
                            genreID int,
                            FOREIGN KEY (genreID) REFERENCES genre(genreID),
                            isbn varchar(30),
                            stock int,
                            PRIMARY KEY (bookID))",

                            "CREATE TABLE orderDetails
                            (orderDetailsID int NOT NULL AUTO_INCREMENT,
                            orderID int,
                            FOREIGN KEY (orderID) REFERENCES orders(orderID),
                            bookstoreID int,
                            FOREIGN KEY (bookstoreID) REFERENCES bookstore(bookstoreID),
                            quantity int,
                            orderType varchar(30),
                            bookID int,
                            FOREIGN KEY (bookID) REFERENCES book(bookID),
                            PRIMARY KEY (orderDetailsID))"
                            );
            
                foreach ($table as &$value){
                    try{
                        if (mysqli_query($conn, $value))
                            {
                            $string_result .= "| Table created\n";
                            $create_data = true;
                            }
                    }
                    //catch the exception of creating a table
                    catch (exception $e){
                        $string_result .= "| " . $e->getmessage();
                        return $string_result;
                    }
                }
            }
        }
        //catch the exception of creating the database
        catch (exception $e)
        {
            $string_result .= "| " . $e->getmessage();
            return $string_result;
        }

        //create test data as needed.
        if($create_data){
			$string_result .= insert_dummy_data($conn, $string_result);
        }
        mysqli_close($conn);

		return $string_result;
    }

    function insert_dummy_data($conn, $string_result){
      
        // insert dummy customers
        $sql_insert_customer = "insert into customer VALUES
        (1,\"Garrett\", \"King\", \"gking@outlook.com\",\"832-190-7631\",\"760 Street Road\",\"Nacogdoches\",\"Texas\",75961),
        (2,\"Tim\", \"Kaufman\", \"tkaufman@gmail.com\",\"713-782-0912\",\"8989 Pearl Street\",\"Nacogdoches\",\"Texas\",75961),
        (3,\"Emily\", \"Morgan\", \"memily@outlook.com\",\"832-098-6580\",\"5642 North Street\",\"Nacogdoches\",\"Texas\",75961),
        (4,\"Clifford\", \"Amomo\", \"aclifford@yahoo.com\",\"670-987-5675\",\"8794 Austin Road\",\"Nacogdoches\",\"Texas\",75961)";

        try{
            mysqli_query($conn, $sql_insert_customer);
        }
        catch (exception $e){
            $string_result .= "| " . $e->getmessage();
            return $string_result;
        }

        // insert into bookstore
        $sql_insert_bookstore = "insert into bookstore VALUES
        (1,\"Books!\",\"Jasper\",\"Texas\",98729,\"937 Main Street\",\"732-019-7593\"),
        (2,\"Barnes & Noble\",\"Nacogdoches\",\"Texas\",75961,\"4792 Austin Road\",\"920-812-4712\"),
        (3,\"Library Tings\",\"Austin\",\"Texas\",56892,\"5692 6th Street\",\"689-868-5805\")";

        try{
            mysqli_query($conn, $sql_insert_bookstore);
        }
        catch (exception $e){
            $string_result .= "| " . $e->getmessage();
            return $string_result;
        }

        // insert into orders
        $sql_insert_orders = "insert into orders VALUES
        (1,1,\"2023-09-15\",39.98),
        (2,1,\"2023-08-23\",59.98),
        (3,2,\"2023-09-01\",29.99),
        (4,3,\"2023-05-05\",16.99),
        (5,3,\"2023-09-18\",19.99),
        (6,3,\"2023-09-26\",77.97)";

        try{
            mysqli_query($conn, $sql_insert_orders);         
        }
        catch (exception $e){
            $string_result .= "| " . $e->getmessage();
            return $string_result;
        }

        // insert into author
        $sql_insert_author = "insert into author VALUES
        (1,\"Agatha\",\"Christie\",\"Dame Agatha Mary Clarissa Christie, Lady Mallowan, DBE was an English writer known for her 66 detective novels and 14 short story collections, particularly those revolving around fictional detectives Hercule Poirot and Miss Marple.\"),
        (2,\"Raymond\",\"Chandler\",\"Raymond Thornton Chandler was an American-British novelist and screenwriter. In 1932, at the age of forty-four, Chandler became a detective fiction writer after losing his job as an oil company executive during the Great Depression.\"),
        (3,\"Daphne\",\"du Maurier\",\"Dame Daphne du Maurier, Lady Browning, DBE was an English novelist, biographer and playwright. Her parents were actor-manager Sir Gerald du Maurier and his wife, actress Muriel Beaumont. Her grandfather was George du Maurier, a writer and cartoonist.\"),
        (4,\"Josephine\",\"Tey\",\"Josephine Tey was a pseudonym used by Elizabeth MacKintosh (25 July 1896 - 13 February 1952), a Scottish author. Her novel The Daughter of Time, a detective work investigating the role of Richard III of England in the death of the Princes in the Tower, was chosen by the British Crime Writers' Association in 1990 as the greatest crime novel of all time.\"),
        (5,\"Stella\",\"Gibbons\",\"The goat comedy author frfr.\"),
        (6,\"Sophie\",\"Kinsella\",\"Shmeep shmop :yawn: :yawn: I sleep.\"),
        (7,\"Bram\",\"Stroker\",\"This guy got that zaza fr, on some dracula shizz.\"),
        (8,\"Stephen\",\"King\",\"This guy got movies out the wazoo on his books. Pretty successful!\"),
        (9,\"Jane\",\"Austen\",\"I think we had to read this for school I'm not sure idr.\"),
        (10,\"Margaret\",\"Mitchell\",\"Margaret Mitchell more like Margaret Sheeshell SHEEE\"),
        (11,\"Frank\",\"Herbert\",\"Franklin Patrick Herbert Jr. (October 8, 1920 – February 11, 1986) was an American science fiction author best known for the 1965 novel Dune and its five sequels. Though he became famous for his novels, he also wrote short stories and worked as a newspaper journalist, photographer, book reviewer, ecological consultant, and lecturer.\")";

        try{
            mysqli_query($conn, $sql_insert_author);
        }
        catch (exception $e){
            $string_result .= "| " . $e->getmessage();
            return $string_result;
        }

        // insert into genre
        $sql_insert_genre = "insert into genre VALUES
        (1,\"Mystery\"),
        (2,\"Comedy\"),
        (3,\"Horror\"),
        (4,\"Romance\"),
        (5,\"Science Fiction\")";

        try{
            mysqli_query($conn, $sql_insert_genre);
        }
        catch (exception $e){
            $string_result .= "| " . $e->getmessage();
            return $string_result;
        }
        
        // insert into book
        $sql_insert_book = "insert into book VALUES
        (1,\"Murder on the Orient Express\",\"Murder on the Orient Express is a work of detective fiction by English writer Agatha Christie featuring the Belgian detective Hercule Poirot. It was first published in the United Kingdom by the Collins Crime Club on 1 January 1934.\",
        19.99,1,1,\"1934-01-01\",1,9780062073495,20),
        (2,\"The Mysterious Affair at Styles\",\"The Mysterious Affair at Styles is the first detective novel by British writer Agatha Christie, introducing her fictional detective Hercule Poirot.\",
        29.99,1,1,\"1921-01-21\",1,9786585208062,16),
        (3,\"The Big Sleep\",\"The Big Sleep is a hardboiled crime novel by American-British writer Raymond Chandler, the first to feature the detective Philip Marlowe. It has been adapted for film twice, in 1946 and again in 1978. The story is set in Los Angeles.\",
        25.99,2,2,\"1935-06-05\",1,9786585208065,7),
        (4,\"The Murder of Roger Ackroyd\",\"The Murder of Roger Ackroyd is a detective novel by the British writer Agatha Christie, her third to feature Hercule Poirot as the lead detective. The novel was published in the UK in June 1926 by William Collins, Sons, having previously been serialised as Who Killed Ackroyd?\",
        15.99,1,2,\"1926-06-30\",1,9786860108023,35),
        (5,\"Rebecca\",\"Rebecca is a 1938 Gothic novel written by English author Daphne du Maurier. The novel depicts an unnamed young woman who impetuously marries a wealthy widower, before discovering that both he and his household are haunted by the memory of his late first wife, the title character.\",
        16.99,3,1,\"1938-11-04\",1,978686010444,18),
        (6,\"The Daughter of Time\",\"The Daughter of Time is a 1951 detective novel by Josephine Tey, concerning a modern police officer's investigation into the alleged crimes of King Richard III of England. It was the last book Tey published in her lifetime, shortly before her death.\",
        9.99,4,1,\"1951-12-20\",1,978686098401,4),
        (7,\"Cold Comfort Farm\",\"The humour of talented female authors was often underplayed in the 20th century but one book was acknowledged by contemporaries as a comedy classic - Stella Gibbons’s Cold Comfort Farm. It is a subversive, witty story about teenage orphan Flora Poste and her stay in Sussex with the doomed Starkadders.\",
        15.99,5,3,\"1932-07-09\",2,9786585202456,36),
        (8,\"The Burnout\",\"Sophie Kinsella has long been a trailblazer in the romantic comedy genre. Across all her work, you can’t help but laugh with (and sometimes at) her flawed, funny and relatable female protagonists. Her latest work, The Burnout, is no exception. It follows Sasha, a woman who is exhausted by her life and signs up for a wellness retreat.\",
        19.99,6,3,\"2023-12-25\",2,9786585659843,1),
        (9,\"Dracula\",\"Dracula is a novel by Bram Stoker, published in 1897. An epistolary novel, the narrative is related through letters, diary entries, and newspaper articles. It has no single protagonist and opens with solicitor Jonathan Harker taking a business trip to stay at the castle of a Transylvanian nobleman, Count Dracula.\",
        10.99,7,3,\"1897-01-01\",3,9786456859843,42),
        (10,\"The Shining\",\"The Shining is a 1977 horror novel by American author Stephen King. It is King's third published novel and first hardcover bestseller; its success firmly established King as a preeminent author in the horror genre.\",
        19.99,8,3,\"1977-03-27\",3,6597426859843,12),
        (11,\"Pride and Prejudice\",\"Since its immediate success in 1813, Pride and Prejudice has remained one of the most popular novels in the English language.\",
        9.99,9,3,\"1813-01-28\",4,9786371859843,5),
        (12,\"Gone with the Wind\",\"Scarlett O'Hara, the beautiful, spoiled daughter of a well-to-do Georgia plantation owner, must use every means at her disposal to claw her way out of the poverty she finds herself in after Sherman's March to the Sea.\",
        15.99,10,3,\"1936-06-30\",4,1286371859834,23),
        (13,\"Dune\",\"Dune is a 1965 epic science fiction novel book by American author Frank Herbert, originally published as two separate serials (1963-64 novel 'Dune World' and 1965 novel 'Prophet of Dune') in Analog magazine. It tied with Roger Zelazny's This Immortal for the Hugo Award in 1966 and it won the inaugural Nebula Award for Best Novel. It is the first installment of the Dune Chronicles. It is one of the world's best-selling science fiction novels.[2]\",
        8.99,11,3,\"1965-08-12\",5,9786345612843,4),
        (14,\"Dune Messiah\",\"Dune Messiah is a science fiction novel by American writer Frank Herbert, the second in his Dune series of six novels. A sequel to Dune (1965), it was originally serialized in Galaxy magazine in 1969, and then published by Putnam the same year. Dune Messiah and its own sequel Children of Dune (1976) were collectively adapted by the Sci-Fi Channel in 2003 into a miniseries entitled Frank Herbert's Children of Dune.\",
        8.99,11,3,\"1969-05-13\",5,9786345612844,13)";

        try{
            mysqli_query($conn, $sql_insert_book);
        }
        catch (exception $e){
            $string_result .= "| " . $e->getmessage();
            return $string_result;
        }
        
        // insert into order details
        $sql_insert_orderDetails = "insert into orderDetails VALUES
        (1,1,1,1,\"Physical\",6),
        (2,2,1,2,\"Physical\",2),
        (3,3,1,1,\"Physical\",2),
        (4,4,1,1,\"Physical\",5),
        (5,5,1,1,\"Physical\",1),
        (6,6,2,2,\"Physical\",3)";

        
        try{
            mysqli_query($conn, $sql_insert_orderDetails);
        }
        catch (exception $e){
            $string_result .= "| " . $e->getmessage();
            return $string_result;
        }
        return $string_result;
    }

?>