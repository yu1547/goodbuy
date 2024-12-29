<?php
include 'db.php';
    try{
        $stmt = $db->prepare($query); //$query為要使用的SQL指令
        $result = $stmt->execute();//執行SQL語法
        echo "Success";
    }
    catch(PDOException $e){ //若上述程式碼出現錯誤，便會執行以下動作
        Print "getMessage(): " . $e->getMessage();
    }
?>