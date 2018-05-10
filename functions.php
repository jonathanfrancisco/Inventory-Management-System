<?php


    // for fetching data from the database ex. select * from
    function fetchData($query) {
        return mysqli_query(getConnection(), $query);
    }

    // for inserting, updating, and removing data
    function manageData($query) {
        mysqli_query(getConnection(),$query);
    }

    function getConnection() {
        return mysqli_connect("localhost","admin","1234","inventory");
    }

    

?>