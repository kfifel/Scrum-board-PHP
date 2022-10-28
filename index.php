<?php
    include('scripts.php');
?>
<!DOCTYPE html>
<html lang="en" >
<head>
	<meta charset="utf-8" />
	<title>YouCode | Scrum Board</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
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
                        <a href="index.php?id=2">clic ici</a>
					</ol>
					<!-- BEGIN page-header -->
					<h1 class="page-header">
						Scrum Board
					</h1>
					<!-- END page-header -->
				</div>

				<div class="">
					<button class="btn btn-muted rounded-4 fw-bold ourColorButton" type="button" data-toggle="modal" data-target="#save-tasks" >
						<i class="bx bx-plus"></i>
						<span class="d-none d-md-inline">
							Add task
						</span>
					</button>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#save-tasks" data-whatever="@mdo">Open modal for @mdo</button>

                </div>
			</div>
			
			<div class="row">
				<div class="col-lg-4 col-md-6 col-sm-12 ">
					<div class="card mb-5">
						<div class="card-header bg-teal-900 rounded-lg">
							<h4 class="">To do (<span id="to-do-tasks-count">0</span>)</h4>
                            <form action="" method="post">
                                <button type="submit" name="getTasks" class="btn pink text-white" id="0" >Refresh</button>

                            </form>

						</div>
						<div class="card-body" id="to-do-tasks" ondragstart="onDragStart(event)"  ondragover="return onDragOver(event)" ondrop="return dropToDo(event)" ondragleave="onDragLeave()">
							<!-- TO DO TASKS HERE -->
                            <?php

                            echo  "<pre>";
                               print_r(  array_values($GLOBALS['tasks']));
                            echo  "</pre>";


                            ?>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 col-sm-12 ">
					<div class="card mb-5">
						<div class="card-header">
							<h4 class="">In Progress (<span id="in-progress-tasks-count">0</span>)</h4>

						</div>
						<div class="card-body" id="in-progress-tasks" ondragstart="onDragStart(event)"  ondragover="return onDragOver(event)" ondrop="return dropInProgress(event)" ondragleave="onDragLeave()">
							<!-- IN PROGRESS TASKS HERE -->

                            <?php
                            echo  "<pre>";
                            foreach(  array_values($GLOBALS['tasks']) as $row)
                                print_r($row);
                            echo  "</pre>";
                            ?>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 col-sm-12 ">
					<div class="card mb-5">
						<div class="card-header">
							<h4 class="">Done (<span id="done-tasks-count">0</span>)</h4>
						</div>
						<div class="card-body " id="done-tasks" ondragstart="onDragStart(event)"  ondragover="return onDragOver(event)" ondrop="return dropDone(event)" ondragleave="onDragLeave()">
							<!-- DONE TASKS HERE -->

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
					<h5 id="headerH5">add task <?=$_SESSION['message']?></h5>
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
							<input type="text" class="form-control" name="title" id="title" placeholder="title">
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
							<input type="date" id="Date" name="date" class="form-control">
 						</div>
						<div class="form-group">
							<label for="Description" class="col-form-label">Description:</label>
							<textarea class="form-control" name="description" id="Description"></textarea>
						</div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="close" onclick="closePopup()">Cancel</button>
                            <button type="submit" name="save" class="btn pink text-white" id="0" >Save</button>
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
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

	<!-- ================== END core-js ================== -->
</body>
</html>