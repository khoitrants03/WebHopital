<?php
class clsKetNoi{
    function ketNoiDB(){
        $conn = mysqli_connect("localhost", "root", "", "ql_bv");
        return $conn; 
    }

    function closeKetNoi($conn){
        mysqli_close($conn);
    }
}
?>