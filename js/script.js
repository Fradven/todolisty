function openPopup(statusId) {
    document.getElementById('task-popup').style.display = 'block';
    document.getElementById('popup-status-id').value = statusId;
}

function closePopup() {
    document.getElementById('task-popup').style.display = 'none';
}


function openDetailsPopup(taskId) {
    var task = document.getElementById('task-' + taskId);
    var title = task.querySelector('.task-title').innerText;
    var body = task.querySelector('.task-body').innerText;
    var priority = task.querySelector('.task-priority').innerText;

    document.getElementById('popup-title').innerText = title;
    document.getElementById('popup-body').innerText = body;
    document.getElementById('priority-value').innerText = priority;

    // Stockez l'ID de la tâche pour les opérations de modification et de suppression
    window.currentTaskId = taskId;

    document.getElementById('details-popup').style.display = 'block';
}

function closeDetailsPopup() {
    document.getElementById('details-popup').style.display = 'none';
    location.reload();
}

function editTask() {
    // Assurez-vous que les éléments du formulaire d'édition existent dans votre pop-up
    document.getElementById('edit-task-id').value = window.currentTaskId;
    document.getElementById('edit-task-title').value = document.getElementById('popup-title').innerText;
    document.getElementById('edit-task-body').value = document.getElementById('popup-body').innerText;

    // Afficher le formulaire de modification (à condition qu'il soit dans le même pop-up)
    document.getElementById('edit-task-form').style.display = 'block';
}

function deleteTask() {
    // Supprimez la tâche actuelle
    if (confirm("Êtes-vous sûr de vouloir supprimer cette tâche ?")) {
        window.location.href = "./gestionTask/supprimer.php?task_id=" + window.currentTaskId;
    }
}


function openEditPopup(taskId) {
    var task = document.getElementById('task-' + taskId);
    var title = task.querySelector('.task-title').innerText;
    var body = task.querySelector('.task-body').innerText;

    document.getElementById('edit-task-id').value = taskId;
    document.getElementById('edit-task-title').value = title;
    document.getElementById('edit-task-body').value = body;

    document.getElementById('edit-task-popup').style.display = 'block';
}

function closeEditPopup() {
    document.getElementById('edit-task-popup').style.display = 'none';
}



function prepareEditTask(taskId) {
    // Vous pouvez récupérer les détails de la tâche à partir de l'ID si nécessaire
    var task = document.getElementById('task-' + taskId);
    var title = task.querySelector('.task-title').innerText;
    var body = task.querySelector('.task-body').innerText;

    // Préparez le formulaire de modification
    document.getElementById('edit-task-id').value = taskId;
    document.getElementById('edit-task-title').value = title;
    document.getElementById('edit-task-body').value = body;

    // Fermez le pop-up de détails et ouvrez le pop-up de modification
    closeDetailsPopup();
    openEditPopup();
}

function openEditPopup() {
    document.getElementById('edit-task-popup').style.display = 'block';
}

function closeEditPopup() {
    document.getElementById('edit-task-popup').style.display = 'none';
}





function assignTaskToUser(taskId) {
    var assigneeId = document.getElementById('assign-user').value;

    if (!assigneeId) {
        alert("Veuillez sélectionner un utilisateur à qui assigner la tâche.");
        return;
    }

    var formData = new FormData();
    formData.append('task_id', taskId);
    formData.append('assignee_id', assigneeId);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', './gestionTask/assignTask.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        if (this.status == 200) {
            alert("Tâche assignée avec succès !");
            closeDetailsPopup();
            // Ici, ajoutez le code pour rafraîchir l'affichage des tâches
        } else {
            alert("Erreur lors de l'assignation de la tâche.");
        }
    };

    xhr.onerror = function() {
        alert("Erreur de requête.");
    };

    xhr.send('task_id=' + encodeURIComponent(taskId) + '&assignee_id=' + encodeURIComponent(assigneeId));
}


function updateTaskList() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '../gestionTask/getUserTasks.php', true); // Chemin vers le script PHP qui renvoie les tâches de l'utilisateur

    xhr.onload = function() {
        if (this.status == 200) {
            var tasks = JSON.parse(this.responseText);
            var taskListContainer = document.getElementById('task-list-container'); // L'élément contenant la liste des tâches
            taskListContainer.innerHTML = ''; // Effacer les tâches actuelles

            tasks.forEach(function(task) {
                // Ajoutez ici la logique pour créer et afficher les éléments de la tâche
            });
        } else {
            alert("Erreur lors de la récupération des tâches.");
        }
    };

    xhr.onerror = function() {
        alert("Erreur de requête.");
    };

    xhr.send();
}






function moveTask(taskId, direction) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', './gestionTask/moveTask.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        if (this.status == 200) {
            // Recharger la liste des tâches ou mettre à jour l'affichage
            alert("Tâche déplacée avec succès !");
        } else {
            alert("Erreur lors du déplacement de la tâche.");
        }
    };

    xhr.send('task_id=' + encodeURIComponent(taskId) + '&direction=' + encodeURIComponent(direction));
}
