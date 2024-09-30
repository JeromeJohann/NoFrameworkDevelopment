document.addEventListener('DOMContentLoaded', loadTasks);

function loadTasks() {
    fetch('/backend/tasks.php')
        .then(response => response.text())
        .then(data => {
            let parser = new DOMParser();
            let xmlDoc = parser.parseFromString(data, "application/xml");
            let tasks = xmlDoc.getElementsByTagName('task');
            let taskList = document.getElementById('taskList');
            taskList.innerHTML = '';

            for (let task of tasks) {
                let taskItem = document.createElement('li');
                taskItem.textContent = task.getElementsByTagName('title')[0].textContent;
                taskItem.dataset.id = task.getAttribute('id');
                taskItem.onclick = function () {
                    deleteTask(taskItem.dataset.id);
                };
                taskList.appendChild(taskItem);
            }
        });
}

function addTask() {
    let taskTitle = document.getElementById('newTaskTitle').value;
    if (taskTitle) {
        let formData = new FormData();
        formData.append('title', taskTitle);

        fetch('/backend/tasks.php', {
            method: 'POST',
            body: formData
        }).then(loadTasks);
    }
}

function deleteTask(id) {
    fetch('/backend/tasks.php', {
        method: 'DELETE',
        body: `id=${id}`,
        headers: { "Content-Type": "application/x-www-form-urlencoded" }
    }).then(loadTasks);
}
