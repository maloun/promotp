const outputToDbEdit = document.querySelector(".form-edit"),
    continueBtnSaveEdit = outputToDbEdit.querySelector(".edit-equipments");

outputToDbEdit.onsubmit = (e) => {
    e.preventDefault()
}

continueBtnSaveEdit.onclick = () => {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "requests/edit/equipment.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let response = JSON.parse(xhr.responseText);
                if (response.success === true) {
                    alert(response.message);
                    closeTaskAddIssueWindow()
                } else {
                    alert(response.message);
                }
            }
        }
    }
    let formDataEdit = new FormData(outputToDbEdit);
    xhr.send(formDataEdit);
}
