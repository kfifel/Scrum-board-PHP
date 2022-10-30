<?php
    //INCLUDE DATABASE FILE
    include('database.php');
    //SESSSION IS A WAY TO STORE DATA TO BE USED ACROSS MULTIPLE PAGES
    session_start();

    $tasks= array();
//ROUTING
getTasks();
if(isset($_POST['save']))        saveTask();
if(isset($_POST['update']))      updateTask();
if(isset($_GET['delete']))      deleteTask();




function getTasks()
    {
        //CODE HERE
        //SQL SELECT
        $req = "SELECT tasks.id ,  tasks.title, types.name as type, priorities.name as priority, status.name as status,
                tasks.task_datetime as date, tasks.description
                FROM tasks
                    join status on tasks.status_id = status.id
                    join types on tasks.type_id = 	types.id
                    join priorities	 on tasks.priority_id = priorities.id";
        $res =  mysqli_query($GLOBALS['conn'], $req);

        while( $tasks = mysqli_fetch_assoc( $res)){
            $GLOBALS['tasks'][] = $tasks;
        }
    }


    function saveTask()
    {
        //CODE HERE
        //SQL INSERT
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
            $_SESSION['message'] = "Task has not been added successfully error detected ";
        }
    }

    function updateTask()
    {
        //CODE HERE
        //SQL UPDATE
        if(isset($_GET['id'])){
            $id = (int) $_GET['id'];
            $task = getFormData();
            $task['type']=(int)$task['type'];
            $task['priority'] = (int) $task['priority'];
            $task['status'] = (int) $task['status'];
            var_dump($task);
            $req = " UPDATE tasks SET  `title`='".$task['title']."',`type_id`=".$task['type'].",
                    `priority_id`=".$task['priority'].",`status_id`=".$task['status'].",`task_datetime`='".$task['date']."',
                    `description`='".$task['description']."' WHERE `id` = $id";
            $res = mysqli_query($GLOBALS['conn'], $req);
            if($res){
                $_SESSION['message'] = "Task has been updated successfully !";
                header('location: index.php');
            }else{
                $_SESSION['message'] = "Error with updating your tasks Error is accurid  !";
                header('location: index.php');
            }
        }
    }

    function deleteTask()
    {
        //CODE HERE
        //SQL DELETE
        $id = (int) $_GET['delete'];
        if(!preg_match('#[^0-9]#',$id)){
            $req = "DELETE FROM tasks WHERE  id = $id";
            mysqli_query($GLOBALS['conn'], $req);
            $_SESSION['message'] = "Task has been deleted successfully !";
            header('location: index.php');
        }else{
            $_SESSION['message'] = "Error has occurred!";
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
            'title'=>mysqli_real_escape_string($GLOBALS['conn'], $_POST['title'] ),
            'type'=>$type,
            'priority'=>$priority,
            'status'=>$status,
            'date'=>mysqli_real_escape_string($GLOBALS['conn'], $_POST['date'] ),
            'description'=>mysqli_real_escape_string($GLOBALS['conn'], $_POST['description'] )
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
        return $data['numberOf'];
    }
    function countToDo(){
        echo countStatus(1);
    }
    function countInProgres(){
        echo countStatus(2);
    }
    function countDone(){
        echo countStatus(3);
    }

