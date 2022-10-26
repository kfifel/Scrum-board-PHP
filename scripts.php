<?php
    //INCLUDE DATABASE FILE
   include('database.php');

    //SESSSION IS A WAY TO STORE DATA TO BE USED ACROSS MULTIPLE PAGES
    session_start();

    //ROUTING
    if(isset($_POST['save']))        saveTask();
    if(isset($_POST['update']))      updateTask();
    if(isset($_POST['delete']))      deleteTask();
    

    function getTasks()
    {
        //CODE HERE
        //SQL SELECT
        $req = "";
        echo "Fetch all tasks";
    }


    function saveTask()
    {
        //CODE HERE
        //SQL INSERT
        $req = "INSERT INTO `tasks` (`title`, `type`, `priority`, `status`, `date`, `description` ) 
                VALUES  ( ?, ?, ?, ?, ?, ?)";
        $nvTask = getFormData();
        $res = $GLOBALS['conn']->prepare($req);
        $res->bind_param( "ssssss",  ...$nvTask);

        if($res->execute()){
            $_SESSION['message'] = "Task has been added successfully !";
            header('location: index.php');
        }else{
            $_SESSION['message'] = "Task has not been added successfully error detected ";
        }
    }

    function updateTask()
    {
        //CODE HERE
        //SQL UPDATE
        $_SESSION['message'] = "Task has been updated successfully !";
		header('location: index.php');
    }

    function deleteTask()
    {
        //CODE HERE
        //SQL DELETE
        $_SESSION['message'] = "Task has been deleted successfully !";
		header('location: index.php');
    }

    function getFormData(){
        @$type = $_POST['type'];
        @$priority = $_POST['priority'];
        @$status = $_POST['status'];

        settype($type, 'integer');
        settype($priority, 'integer');
        settype($status, 'integer');

        return array(
            "title"         => mysqli_real_escape_string($GLOBALS['conn'], $_POST['title'] ),
            "type"          => mysqli_real_escape_string($GLOBALS['conn'], $type ) ,
            "priority"      => mysqli_real_escape_string($GLOBALS['conn'], $priority ),
            "status"        => mysqli_real_escape_string($GLOBALS['conn'], $status ),
            "date"          => mysqli_real_escape_string($GLOBALS['conn'], $_POST['date'] ),
            "description"   => mysqli_real_escape_string($GLOBALS['conn'], $_POST['description'] )
        );
    }

    $GLOBALS['conn']= null;
?>