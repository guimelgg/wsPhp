<?php

  // Set default timezone
  date_default_timezone_set('UTC');

  try {
    /**************************************
    * Create databases and                *
    * open connections                    *
    **************************************/

    // Create (connect to) SQLite database in file
    $strPath = "patris.db";
    echo "sqlite:" . $strPath . ";Version=3";
    $file_db = new PDO("sqlite:" . $strPath );
    //$file_db = new PDO('sqlite:messaging.sqlite3');
    // Set errormode to exceptions
    $file_db->setAttribute(PDO::ATTR_ERRMODE,
                            PDO::ERRMODE_EXCEPTION);




    // Quote new title


    // Select all data from memory db messages table
    $result = $file_db->query('SELECT * FROM IngProducto');

    foreach($result as $row) {
      echo "Id: " . $row['PROD_PRODID'] . "\n";
      echo "Title: " . $row['PROD_CLAVE'] . "\n";
      echo "Message: " . $row['PROD_DESC'] . "\n";
      echo "Time: " . $row['PROD_UsuaDate'] . "\n";
      echo "\n";
    }



    /**************************************
    * Close db connections                *
    **************************************/

    // Close file db connection
    $file_db = null;
    // Close memory db connection
    $memory_db = null;
  }
  catch(PDOException $e) {
    // Print PDOException message
    echo $e->getMessage();
  }
?>
