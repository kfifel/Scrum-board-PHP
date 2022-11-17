<?php
    //INCLUDE DATABASE FILE
    include('database.php');

    session_start();

    //ROUTING
    getTasks();

    if(isset($_POST['save']))        saveTask();
    if(isset($_POST['update']))      updateTask();
    if(isset($_GET['delete']))      deleteTask();
    if(isset($_GET['id']) && isset($_GET['status'])) onDrop();



function getTasks()
    {
        $req = "SELECT tasks.id ,  tasks.title, types.name as type, priorities.name as priority, status.name as status,
                tasks.task_datetime as date, tasks.description
                FROM tasks
                    join status on tasks.status_id = status.id
                    join types on tasks.type_id = 	types.id
                    join priorities	 on tasks.priority_id = priorities.id 
                    ORDER by id asc
                    ";
        $res =  mysqli_query($GLOBALS['conn'], $req);

        while( $tasks = mysqli_fetch_assoc( $res)){
            $GLOBALS['tasks'][] = $tasks;
        }
    }


    function saveTask()
    {
        if( !empty($_POST['title']) && !empty($_POST['date']) && !empty($_POST['description'])){

            $req = "INSERT INTO `tasks` (`title`, `type_id`, `priority_id`, `status_id`, `task_datetime`, `description` ) 
                    VALUES  ( ?, ?, ?, ?, ?, ?)";
            $nvTask = getFormData();
            $res = $GLOBALS['conn']->prepare($req);
            $res->bind_param( "ssssss",  ...$nvTask);

            if($res->execute()){
                $_SESSION['message'] = "Task has been added successfully !";
                header('location: index.php');
                echo '<script type="text/javascript"></script> ';
            }else{
                $_SESSION['error'] = "Task has not been added successfully error detected ";
            }
        }else{
            $_SESSION['formValidation'] = 'Please fill out the form completly';
        }
    }

    function updateTask()
    {
        if(isset($_GET['id'])){
            $id = (int) $_GET['id'];
            $task = getFormData();
            $task[1]=(int)$task[1];
            $task[2] = (int) $task[2];
            $task[3] = (int) $task[3];

            $req = " UPDATE tasks SET  `title`='".$task[0]."',`type_id`=".$task[1].",
                    `priority_id`=".$task[2].",`status_id`=".$task[3].",`task_datetime`='".$task[4]."',
                    `description`='".$task[5]."' WHERE `id` = $id";
            $res = mysqli_query($GLOBALS['conn'], $req);
            if($res){
                $_SESSION['message'] = "Task has been updated successfully !";
                header('location: index.php');
            }else{
                $_SESSION['error'] = "Error with updating your tasks Error is accurid  !";
                header('location: index.php');
            }
        }
    }

    function deleteTask()
    {
        $id = (int) $_GET['delete'];
        if(!preg_match('#[^0-9]#',$id)){
            $req = "DELETE FROM tasks WHERE  id = $id";
            mysqli_query($GLOBALS['conn'], $req);
            $_SESSION['message'] = "Task has been deleted successfully !";
            header('location: index.php');
        }else{
            $_SESSION['error'] = "Error has occurred!";
            header('location: index.php');
        }
    }

    function getFormData(){
        @$type = $_POST['type'];
        @$priority = $_POST['priority'];
        @$status = $_POST['status'];

        settype($type, 'integer');
        settype($priority, 'integer');
        settype($status, 'integer');

        return array(
            mysqli_real_escape_string($GLOBALS['conn'], $_POST['title'] ),
            $type,
            $priority,
            $status,
            mysqli_real_escape_string($GLOBALS['conn'], $_POST['date'] ),
            mysqli_real_escape_string($GLOBALS['conn'], $_POST['description'] )
        );
    }


    function getTasksById($id){
        $id = (int)$id;
        if(!empty($id)){
            $req = "SELECT tasks.id ,  tasks.title, type_id as type, priority_id as priority, status_id as status,
                    tasks.task_datetime as date, tasks.description
                    FROM tasks where tasks.id = $id";

            $res =  mysqli_query($GLOBALS['conn'], $req);
            return mysqli_fetch_assoc( $res);

        }else{
            $_SESSION['message'] = 'id not define';
            return null;
        }
    }

    function editTask(){
        $id = $_GET['id'];
        $GLOBALS['task'][] = getTasksById($id);
    }

    function countStatus($id){
        $req = "SELECT count(id) as numberOf FROM tasks WHERE status_id = $id";
        $res = mysqli_query($GLOBALS['conn'], $req);
        $data=mysqli_fetch_assoc($res);
        echo $data['numberOf'];
    }

    function onDrop(){
        $id = (int)$_GET['id'];
        $status = (int) $_GET['status'];
        $req = "UPDATE `tasks` SET `status_id` = $status where id = $id";
        mysqli_query($GLOBALS['conn'], $req);
        header("location: index.php");
    }
