// --------------------------- Main code ------------------------------------


function resetForm(){
    $("#form").trigger( "reset");
    document.getElementById("0").setAttribute("name", "save");
    document.getElementById("headerH5").innerText = "Add task"
    document.getElementById("0").innerText= "save"
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
        denyButtonText: "Edit",
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
                    window.location.href="index.php?delete="+id;
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
            window.location.href="index.php?id="+id;
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
