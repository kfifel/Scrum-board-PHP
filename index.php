<?php
    include('scripts.php');
?>
<!DOCTYPE html>
<html lang="en" >
<head>
	<meta charset="utf-8" />
	<title>YouCode | Scrum Board</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="Scrum board, scrum, board, table " name="description" />
	<meta content="" name="author" />
	
	<!-- ================== BEGIN core-css ================== -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
	<link href="assets/css/vendor.min.css" rel="stylesheet" />
	<link href="assets/css/default/app.min.css" rel="stylesheet" />
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<link href="assets/css/style.css" rel="stylesheet" />

	<!-- ================== END core-css ================== -->
</head>
<body>
	<!-- BEGIN #app -->
	<div id="app" class="app-without-sidebar">
		<!-- BEGIN #content -->
		<div id="content" class="app-content main-style">
			<div class="d-flex justify-content-between">
				<div class="divTitle">
					<ol class="breadcrumb">
						<li class=" breadcrumb-item"><a href="javascript:;">Home</a></li>
						<li class=" breadcrumb-item active">Scrum Board </li>
					</ol>
					<!-- BEGIN page-header -->
					<h1 class="page-header">
						Scrum Board
					</h1>
					<!-- END page-header -->
				</div>

				<div>
					<button class="btn btn-muted rounded-4 fw-bold ourColorButton" onclick="resetForm()" id="ourColorButton" type="button" data-toggle="modal" data-target="#save-tasks" >
						<i class="bx bx-plus"></i>
						<span class="d-none d-md-inline">
							Add task
						</span>
					</button>

                </div>
			</div>
			
			<div class="row">
				<div class="col-lg-4 col-md-6 col-sm-12 ">
					<div class="card mb-5">
						<div class="card-header bg-teal-900 rounded-lg d-flex justify-content-between">
							<h4 >To do (<span id="to-do-tasks-count"><?php countToDo()?></span>)</h4>
                            <form action="" method="post">
                                <button type="submit" name="getTasks" class="btn  rounded-3 text-white" ><i class="fa fa-refresh fa-xl"></i></button>
                            </form>

						</div>
						<div class="card-body" id="to-do-tasks" ondragstart="onDragStart(event)"  ondragover="return onDragOver(event)" ondrop="return dropToDo(event)" ondragleave="onDragLeave()">
							<!-- TO DO TASKS HERE -->
                            <?php

                             for( $i= 0; $i <  count($GLOBALS['tasks']) ; $i++){
                                 if($GLOBALS['tasks'][$i]['status'] === 'to do'){
                                     ?>
                                     <button id="${userStory.id} " onclick="editUserStory(<?=$GLOBALS['tasks'][$i]['id']?>)" class="d-flex userStoryCard w-100 alert-black rounded-1 mt-1 pb-2" draggable="true">
                                         <div class="col-1">
                                             <i class="bi bi-exclamation-octagon bx-xs text-red-700"></i>
                                         </div>
                                         <div class="col-11 text-start">
                                             <div ><?=$GLOBALS['tasks'][$i]['title']?></div>
                                             <div >
                                                 <div class="text-black-100">#<?=$GLOBALS['tasks'][$i]['id']?> created in <?=$GLOBALS['tasks'][$i]['date']?>.</div>
                                                 <div  title="<?=$GLOBALS['tasks'][$i]['description']?>">
                                                     <?php echo (strlen($GLOBALS['tasks'][$i]['description']) > 80)? substr($GLOBALS['tasks'][$i]['description'], 0, 70)."..." : $GLOBALS['tasks'][$i]['description'];   ?>
                                                 </div>
                                             </div>
                                             <div class="mt-1">
                                                 <span class="bg-gradient-blue-purple rounded-2 p-1 text-white"><?=$GLOBALS['tasks'][$i]['priority']?></span>
                                                 <span class="bg-black-100 rounded-2 p-1 text-white"><?=$GLOBALS['tasks'][$i]['type']?></span>
                                             </div>
                                         </div>
                                     </button>
                                     <?php
                                 }
                             }

                            ?>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 col-sm-12 ">
					<div class="card mb-5">
						<div class="card-header">
							<h4 >In Progress (<span id="in-progress-tasks-count"><?php countInProgres()?></span>)</h4>

						</div>
						<div class="card-body" id="in-progress-tasks" ondragstart="onDragStart(event)"  ondragover="return onDragOver(event)" ondrop="return dropInProgress(event)" ondragleave="onDragLeave()">
							<!-- IN PROGRESS TASKS HERE -->

                            <?php
                            for( $i= 0; $i <  count($GLOBALS['tasks']) ; $i++){
                                if($GLOBALS['tasks'][$i]['status'] === 'in progress'){
                                ?>
                                    <button id=" " onclick="editUserStory(<?=$GLOBALS['tasks'][$i]['id']?>)" class="d-flex userStoryCard w-100 alert-blue rounded-1 pb-2 mt-1" draggable="true">
                                        <div class="col-1">
                                            <i class="fa fa-spinner fa-spin	 bx-xs text-primary mt-3 "></i>
                                        </div>
                                        <div class="col-11 text-start">
                                            <div ><?=$GLOBALS['tasks'][$i]['title']?></div>
                                            <div >
                                                <div class="text-muted">#<?=$GLOBALS['tasks'][$i]['id']?> created in <?=$GLOBALS['tasks'][$i]['date']?>.</div>
                                                <div  title="<?=$GLOBALS['tasks'][$i]['description']?>">
                                                    <?php echo (strlen($GLOBALS['tasks'][$i]['description']) > 80)? substr($GLOBALS['tasks'][$i]['description'], 0, 70)."..." : $GLOBALS['tasks'][$i]['description'];   ?>
                                                </div>
                                            </div>
                                            <div class="mt-1">
                                                <span class="bg-gradient-blue-purple rounded-2 p-1 text-white"><?=$GLOBALS['tasks'][$i]['priority']?></span>
                                                <span class="bg-black-100 rounded-2 p-1 text-white"><?=$GLOBALS['tasks'][$i]['type']?></span>
                                            </div>
                                        </div>
                                    </button>
                            <?php
                                }
                            }
                            ?>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 col-sm-12 ">
					<div class="card mb-5">
						<div class="card-header">
							<h4 >Done (<span id="done-tasks-count"><?php countDone()?></span>)</h4>
						</div>
						<div class="card-body " id="done-tasks" ondragstart="onDragStart(event)"  ondragover="return onDragOver(event)" ondrop="return dropDone(event)" ondragleave="onDragLeave()">
							<!-- DONE TASKS HERE -->
                            <?php
                                for( $i= 0; $i <  count($GLOBALS['tasks']) ; $i++){
                                    if($GLOBALS['tasks'][$i]['status'] === 'done'){
                                        ?>
                                        <button id="${userStory.id} " onclick="editUserStory(<?=$GLOBALS['tasks'][$i]['id']?>)" class="d-flex userStoryCard w-100 alert-green rounded-1 pb-2 mt-1" draggable="true">
                                            <div class="col-1">
                                                <i class="bx bx-check-circle bx-sm text-green mt-3"></i>
                                            </div>
                                            <div class="col-11 text-start">
                                                <div ><?=$GLOBALS['tasks'][$i]['title']?></div>
                                                <div >
                                                    <div class="text-black-100">#<?=$GLOBALS['tasks'][$i]['id']?> created in <?=$GLOBALS['tasks'][$i]['date']?>.</div>
                                                    <div  title="<?=$GLOBALS['tasks'][$i]['description']?>">
                                                        <?php echo (strlen($GLOBALS['tasks'][$i]['description']) > 80)? substr($GLOBALS['tasks'][$i]['description'], 0, 70)."..." : $GLOBALS['tasks'][$i]['description'];   ?>
                                                    </div>
                                                </div>
                                                <div class="mt-1">
                                                    <span class="bg-gradient-blue-purple rounded-2 p-1 text-white"><?=$GLOBALS['tasks'][$i]['priority']?></span>
                                                    <span class="bg-black-100 rounded-2 p-1 text-white"><?=$GLOBALS['tasks'][$i]['type']?></span>
                                                </div>
                                            </div>
                                        </button>
                                        <?php
                                    }
                                }
                            ?>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- END #content -->
		
		
		<!-- BEGIN scroll-top-btn -->
		<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top" data-toggle="scroll-to-top"><i class="fa fa-angle-up"></i></a>
		<!-- END scroll-top-btn -->
	</div>
	<!-- END #app -->
	
	<!-- TASK MODAL -->
	<div class="modal fade" id="save-tasks" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 id="headerH5">add task</h5>
					<button type="button" class="btn close" data-dismiss="modal" aria-label="Close" onclick="closePopup()" id="closePopup">
						<i class="bi bi-x-lg"></i>
					</button>
				</div>
				<div class="modal-body">
					<div id="alertAdd">

					</div>
					<form id="form" action="" method="post">
						<div class="form-group">
							<label for="title" class="col-form-label">Title:</label>
							<input type="text" class="form-control" name="title" id="title"  placeholder="title">
						</div>
						<div class="form-group">
							<div class="form-check mt-2">
								<input class="form-check-input" type="radio" name="type" id="typeFeature" value="1" checked>
								<label class="form-check-label" for="typeFeature">
									Feature
								</label>
							</div>
							<div class="form-check">
								<input class="form-check-input" type="radio" name="type" id="typeBug" value="2">
								<label class="form-check-label" for="typeBug">
									Bug
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="Priority" class="col-form-label">Priority:</label>
							<select class="form-select" name="priority" id="Priority">
								<option value="1">High</option>
								<option value="2">Medium</option>
								<option value="3">Low</option>
							</select>
						</div>
						<div class="form-group">
							<label for="Status" class="col-form-label">Status:</label>
							<select class="form-select" name="status" id="Status">
								<option value="1">to do</option>
								<option value="2">in progress</option>
								<option value="3">done</option>
							</select>
						</div>
						<div class="form-group">
							<label for="Date" class="col-form-label">Date:</label>
							<input type="datetime-local" id="Date" name="date" class="form-control">
 						</div>
						<div class="form-group">
							<label for="Description" class="col-form-label">Description:</label>
							<textarea class="form-control" name="description" id="Description"></textarea>
						</div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="close" onclick="closePopup()">Cancel</button>
                            <button type="submit" name="save" class="btn pink text-white" id="0"  >Save</button>
                        </div>
					</form>
				</div>
			</div>
		</div>
	</div>



	<!-- ================== BEGIN core-js ================== -->
	<script src="assets/js/vendor.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.2/dist/sweetalert2.all.min.js"></script>
	<script src="assets/data/data.js"></script>
	<script src="assets/js/app.min.js"></script>
    <script src="assets/js/main.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

	<!-- ================== END core-js ================== -->
</body>
</html>

<?php
if(isset($_GET['id'])){
    editTask();
   ?>
        <script>
            document.getElementById('ourColorButton').click();
            document.getElementById('headerH5').innerText= "Update task";
            document.getElementById("0").setAttribute("name", "update");
            document.getElementById("0").innerText= "Update";

            document.getElementById('title').value = "<?php echo $GLOBALS['task'][0]['title']?>";
            <?php
                if($GLOBALS['task'][0]['type'] == 1)
                {
            ?>
            document.getElementById('typeFeature').checked = true;
            <?php
                }else if($GLOBALS['task'][0]['type'] == 1){
            ?>
            document.getElementById('typeBug').checked = true;
            <?php
                }
            ?>

            document.getElementById('Status').value = "<?=$GLOBALS['task'][0]['status']?>";
            document.getElementById('Priority').value = "<?=$GLOBALS['task'][0]['priority']?>";
            document.getElementById('Date').value = "<?=$GLOBALS['task'][0]['date']?>";
            document.getElementById('Description').value = "<?php echo $GLOBALS['task'][0]['description']?>";
        </script>;
<?php
}