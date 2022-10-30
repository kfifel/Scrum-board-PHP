// --------------------------- Main code ------------------------------------
const userStroys = new Map()
var id = 0;
let toDoCount = 0;
let inProgressCount = 0;
let doneCount = 0;

/*
    for(let task of tasks){
        userStroys.set(++id,task)
    }
*/
    updateDataInHtml();

function save(idAModifier){
    let newData = formData(idAModifier)
    if(typeof idAModifier  == "undefined") {
        if (userStroys.set(newData.id, newData)) {
            addUserStory(newData)
            document.getElementById('closePopup').click()
            onSuccess()
        }
    }else {
                if (userStroys.has(idAModifier)) {
                    userStroys.set(idAModifier, newData)
                    updateDataInHtml();
                    $('#exampleModal').modal('hide');
                }else{
                    onError();
                }
        }
}

function resetForm(){
    $("#form").trigger( "reset");
    document.getElementById("0").setAttribute("name", "save");
    document.getElementById("headerH5").innerText = "Add task"
    document.getElementById("0").innerText= "save"
}

function addUserStory(userStory) {
    document.getElementById('to-do-tasks-count').innerText = toDoCount;
    document.getElementById('in-progress-tasks-count').innerText = inProgressCount;
    document.getElementById('done-tasks-count').innerText = doneCount;
}

function updateDataInHtml(){

    toDoCount = 0;
    inProgressCount = 0;
    doneCount = 0;
    for(let [key ,userStory] of userStroys){
            addUserStory(userStory)
    }
}

function editUserStory(id){

    Swal.fire({
        title: 'Chose an action?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        showDenyButton: true,
        confirmButtonColor: '#d33',
        denyButtonColor: '#38c00b',
        cancelButtonColor: '#3085d6',
        denyButtonText: "<a href='../../index.php?id="+id+"'>Edit</a>",
        confirmButtonText: 'delete!'
    }).then(async (result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#38c00b',
                confirmButtonText: 'delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    userStroys.delete(id)
                    updateDataInHtml()
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                }
            })
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            swal.fire(
                'Cancelled',
                'Your imaginary file is safe :)',
                'error'
            )
        } else if (result.isDenied) {

                document.getElementById("headerH5").innerText = 'Update task'
                document.getElementById("0").innerText= "Update"

                //det date selected
                document.getElementById("title").value = userStorySelect.title
                if(userStorySelect.type === 'Bug')
                    document.getElementById('typeBug').checked = true;
                else
                document.getElementById('typeFeature').checked = true;
                document.getElementById("Priority").value = userStorySelect.priority
                document.getElementById("Status").value= userStorySelect.status
                document.getElementById("Date").value= userStorySelect.date
                document.getElementById("Description").value= userStorySelect.description


                document.getElementById("0").setAttribute("onclick", "save("+userStorySelect.id+")")
                $('#exampleModal').modal('show');

            }

    })
}

function findById(id){
    for(let [key ,userStory] of userStroys){
        if(key === id)
            return userStory;
    }
}

function onSuccess(){
    Swal.fire({
      position: 'center-center',
      icon: 'success',
      title: 'Your task has been saved',
      showConfirmButton: false,
      timer: 1500
    })
}

function onError(){
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Something went wrong!',
        footer: '<a href="">Why do I have this issue?</a>'
    })
}

function closePopup(){
    $('#exampleModal').modal('hide');
}


// drage and drop functions
function onDragStart(e){
    e.dataTransfer.effectAllowed = 'move'
    e.dataTransfer.setData('text', e.target.getAttribute("id"))
}
function onDragOver(e){
    return false
}
function dropToDo(e){
    ob = parseInt(e.dataTransfer.getData("text"))
    let data = findById(ob)
    data.status = "to do"
    userStroys.set(ob, data)
    updateDataInHtml()
    e.stopPropagation()
}
function dropInProgress(e){
    ob = parseInt(e.dataTransfer.getData("text"))
    let data = findById(ob)
    data.status = 'in progress'
    userStroys.set(ob, data)
    updateDataInHtml()
    e.stopPropagation()
}
function dropDone(e){
    ob = parseInt(e.dataTransfer.getData("text"))
    let data = findById(ob)
    data.status = "done"
    userStroys.set(ob, data)
    updateDataInHtml()
    e.stopPropagation()
}
function onDragLeave(e){

}
