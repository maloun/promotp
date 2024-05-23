<?phpglobal $conn;include 'database.php';// Запрос к базе данных$sql = "SELECT issues.name, issues.name AS issue_name, issues.id_client, issues.description, issues.id_issue, status.status_name, clients.first_name, clients.middle_name, clients.last_name, issues.completion_time, issues.id_status, marks.name AS mark_nameFROM issuesLEFT JOIN status ON issues.id_status = status.id_statusLEFT JOIN clients ON issues.id_client = clients.id_clientLEFT JOIN marks ON issues.id_mark = marks.id_markWHERE issues.deleted = 0";$result = $conn->query($sql);$sqlcomment = "SELECT c.id_comment, i.name, c.comment, c.creation_date FROM comments c JOIN issues i ON c.id_issue = i.id_issue;";$resultComment = $conn->query($sqlcomment);?><!DOCTYPE html><html lang="en"><head>    <meta charset="UTF-8">    <meta name="viewport" content="width=device-width, initial-scale=1.0">    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap">    <link rel="stylesheet" href="CSS/Issue_Styl.css">    <link rel="stylesheet" href="CSS/tasksStyle.css">    <link rel="stylesheet" href="CSS/completerstylee.css">    <title>Задачи</title></head><style>  .modal {  display: none;  position: fixed;  z-index: 1;  left: 0;  top: 0;  width: 100%;  height: 100%;  overflow: auto;  background-color: rgba(0,0,0,0.4);}</style><body>    <header>        <div class="header-container">            <div class="nav-item active">                <div class="rectangle-9">                    <img src="IMG/image-70active.svg" alt="Задачи" width="30" height="30" />                    <span class="nav-text">Задачи</span>                </div>            </div>            <div class="nav-item">              <a href="Clients.php" class="rectangle-9 client" style="text-decoration: none;">                    <img src="IMG/image-80.svg" alt="Клиенты" width="21" height="21" />                    <span class="nav-text">Клиенты</span>              </a>            </div>            <div class="nav-item">              <a href="Chats.php" class="rectangle-9 chat" style="text-decoration: none;">                    <img src="IMG/image-90.svg" alt="Чаты" width="28" height="24" />                    <span class="nav-text">Чаты</span>              </a>            </div>            <div class="nav-item">                <a href="product/products.php" class="rectangle-9 chat" style="text-decoration: none;">                    <img src="IMG/image30.png" alt="Чаты" width="28" height="24" />                    <span class="nav-text">Продукты</span>                </a>            </div>        </div>        <div class="login-avatar-container">            <div class="login-text">Логин</div>            <div class="avatar">                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26" fill="none">                    <circle cx="13" cy="13" r="13" fill="#C7A5A5" />                </svg>            </div>        </div>    </header>    <div class="header-content">        <div class="second-panel">            <div class="panel-item">                <span>Список</span>            </div>            <div class="panel-item" id="kanban">                <span>Канбан</span>            </div>            <div class="panel-item" id="calendar">                <span>Календарь</span>            </div>            <div class="panel-item" id="gant">                <span>Гант</span>            </div>        </div>        <div class="spacer"></div>        <div class="search-panel">    <div class="custom-select-wrapper">        <img src="IMG/Polygon2.svg" alt="Select" id="customSelect">        <select id="statusFilter">            <option value="all">Все статусы</option>            <?php                // Вывод статусов из базы данных                $statusSql = "SELECT * FROM status";                $statusResult = $conn->query($statusSql);                if ($statusResult->num_rows > 0) {                    while($statusRow = $statusResult->fetch_assoc()) {                        echo "<option value='" . $statusRow['id_status'] . "'>" . $statusRow['status_name'] . "</option>";                    }                }            ?>        </select>    </div>    <div class="divider-main"></div>    <img src="IMG/Search.svg" alt="Search" />    <input type="text" id="keywordInput"/></div><div id="TaskAddIssueWindow" class="modalIssue">  <div class="container_c">    <div class="icons_c">      <img class="cross-icon-third_c" src="IMG/cross.svg" alt="Cross Icon" onclick="closeTaskAddIssueWindow()">    </div>    <div class="content_c">      <img class="logo_c" src="IMG/task.svg" alt="Logo">      <div class="chat-info_c"></div>    </div>    <div class="contact-info_c">      <form method="post" action="add_issue.php" id="addIssueForm_c">        <div class="input-group_c">          <label for="name_c">Имя задачи</label>          <input type="text" id="name_c" name="name" required>        </div>        <div class="input-group_c">          <label for="client_c">Клиент</label>          <select id="client_c" name="id_client" required></select>        </div>        <div class="input-group_c">          <label for="descriptionName_c">Описание</label>          <input type="text" id="Description_c" name="description_issue" required>        </div>        <button type="submit" class="save-button_c">Добавить</button>      </form>    </div>  </div></div><script>document.addEventListener('DOMContentLoaded', function() {  // Select the "Добавить" button  var addButton = document.querySelector('.add-button');  // Add click event listener to the "Добавить" button  addButton.addEventListener('click', function() {    openTaskAddIssueWindow();    fetchClientNames(); // Call the function to fetch client names  });  function openTaskAddIssueWindow() {    // Открываем модальное окно    document.getElementById('TaskAddIssueWindow').style.display = 'block';  }  function fetchClientNames() {    var selectClient = document.getElementById('client_c');    selectClient.innerHTML = ''; // Clear existing options    // Use AJAX to fetch client names from the server    var xhr = new XMLHttpRequest();    xhr.onreadystatechange = function() {      if (xhr.readyState == 4 && xhr.status == 200) {        // Parse the JSON response        var clients = JSON.parse(xhr.responseText);        // Populate the client names in the select element        clients.forEach(function(client) {          var option = document.createElement('option');          option.value = client.id_client;          option.textContent = client.first_name + ' ' + client.middle_name + ' ' + client.last_name;          selectClient.appendChild(option);        });      }    };    xhr.open('GET', 'output_user.php', true);    xhr.send();  }});function closeTaskAddIssueWindow() {    // Закрываем модальное окно    document.getElementById('TaskAddIssueWindow').style.display = 'none';  }  // Add submit event listener to the form  var addIssueForm = document.getElementById('addIssueForm_c');  addIssueForm.addEventListener('submit', function(event) {    event.preventDefault(); // Prevent the default form submission    // Get the selected client ID from the <select> element    var selectedClientId = document.getElementById('client_c').value;    // You can include additional form data as needed    var formData = new FormData(addIssueForm);    formData.append('id_client', selectedClientId);    // Use AJAX to submit the form data to add_issue.php    var xhr = new XMLHttpRequest();    xhr.onreadystatechange = function() {      if (xhr.readyState == 4 && xhr.status == 200) {        // Handle the response from the server        console.log(xhr.responseText);        // Optionally, close the modal or perform other actions        closeTaskAddIssueWindow();      }    };    xhr.open('POST', 'add_issue.php', true);    xhr.send(formData);  });</script><div id="TaskCompleterWindow" class="modal"><div class="container">    <div class="icons">      <img class="cross-icon" src="IMG/cross.svg" alt="Cross Icon" onclick="CloseTaskCompleterWindow()">    </div>    <div class="content">      <img class="logo" src="IMG/image-wind-user.svg" alt="Logo">      <div class="company-info">      <h3></span></span></h3>        <!--<img class="pencil-icon" src="IMG/pencil.svg" alt="Pencil Icon">-->        <p>Компания</p>      </div>      <div class="chat-info">        <img class="chat-icon" src="IMG/image-chat.svg" alt="Chat Icon">        <h2 class="header">Открыть чат</h2>      </div>    </div>    <div class="divider-second"></div>    <div class="contact-info-wrapper">      <table class="contact-info">        <tr>        <td><label for="performer">Исполнитель:</label></td>        <td>            <div class="EditorMarks" id="EditorMarks" onclick="toggleDropdown(this.nextElementSibling)">Изменить</div>            <span class="login-text-window" id="assigned">Логин</span>        </td>        </tr>        <tr>          <td><label for="completion-date">Дата завершения:</label></td>          <td id="completionTime"></td>        </tr>        <tr>          <td><label for="status">Статус</label></td>          <td id="statusInfo"></td>        </tr>        <tr>          <td><label for="tags">Метки:</label></td>          <td id="marksInfo"></td>        </tr>      </table>    </div>      <!--<img class="cross-icon-sec" src="IMG/cross.svg" onclick="deleteTask()">-->    <div class="Tasks" id="taskTitle"></div>    <div class="Description">      <?php $taskName; ?>    </div>    <div class = "History" >      История по договору    </div>    <div class = "CommentsHistory" style="overflow-y: scroll;marign-top:-70px;height:130px;width:325px">                пример коментария    </div>    <div class="email-editor">    <input type="text" id="commentInput" class="email-text" placeholder="Напишите комментарий...">    <div class="editor-buttons">    </div>    <button class="send-button" id="saveComment">Комментировать</button></div><div id="commentList"></div><span class= "taskNameOutput" id="taskName"></span><div class="EditorMarks" id="EditorMarks" onclick="toggleDropdownStatus()">Изменить</div><div id="myDropdown" class="dropdown-content"></div></div>   </div><script>function toggleDropdown(obj) {    alert();    //alert(obj.id)}function toggleDropdownStatus() {    var taskId = document.getElementById('taskTitle').textContent.replace('Задача: ', '').trim();    var formData = new FormData();    formData.append('id_issue', taskId);    var dropdown = document.getElementById("myDropdown");    dropdown.onkeypress = (e) => {if (e.keyCode == 27) dropdown.style.visibility = "hidden"; }    if (dropdown.innerHTML.trim() === "") {        // Загрузка данных из output_marks.php и добавление в dropdown        var xmlhttp = new XMLHttpRequest();        xmlhttp.onreadystatechange = function() {            if (this.readyState == 4 && this.status == 200) {                dropdown.innerHTML = this.responseText;                // Добавление обработчика события для элемента select                var select = document.getElementById("marksDropdown");                select.addEventListener("change", function() {                    // Скрытие dropdown после выбора                    dropdown.style.visibility = "hidden";                    // Вызов функции для обновления статуса                    updateStatus();                });            }        };        xmlhttp.open("GET", "output_marks.php", true);        xmlhttp.send();    } else {        // Переключение видимости dropdown        dropdown.style.visibility = (dropdown.style.visibility === "visible") ? "hidden" : "visible";    }}// Закрытие dropdown при выборе элемента внутри негоdocument.addEventListener("change", function(event) {    var dropdown = document.getElementById("myDropdown");    if (!event.target.matches('.EditorMarks') && !event.target.matches('.dropdown-content') && !event.target.matches('#marksDropdown')) {        dropdown.style.visibility = "hidden";    }});function updateStatus() {    // Получение выбранного значения статуса    var select = document.getElementById("marksDropdown");    var selectedValue = select.value;    // Получение id_issue из атрибута data-task-id    var taskId = document.getElementById('taskTitle').textContent.replace('Задача: ', '').trim();    // Отправка запроса на изменение статуса    var xmlhttpChangeStatus = new XMLHttpRequest();    xmlhttpChangeStatus.onreadystatechange = function() {        if (this.readyState == 4 && this.status == 200) {            // Возможно, добавить обработку успешного изменения статуса            console.log("Статус успешно изменен");            statusInfo.innerText = document.getElementById("myDropdown").firstChild.options [selectedValue-1].innerText;        }    };    // Используйте метод POST и отправьте данные в формате x-www-form-urlencoded    xmlhttpChangeStatus.open("POST", "change_status.php", true);    xmlhttpChangeStatus.setRequestHeader("Content-type", "application/x-www-form-urlencoded");    xmlhttpChangeStatus.send("id_issue=" + taskId + "&id_status=" + selectedValue);}</script><script>document.addEventListener('DOMContentLoaded', function () {    // Получаем элемент .CommentsHistory    var commentsHistoryElement = document.querySelector('.CommentsHistory');    // Находим все элементы с классом 'open-task-modal'    var taskCells = document.querySelectorAll('.open-task-modal');    // Перебираем все элементы    taskCells.forEach(function(taskElement) {        // Добавляем обработчик события клика для каждой задачи        taskElement.addEventListener('click', function() {            // Получаем значение taskId из data-атрибута            var taskId = taskElement.dataset.taskId;            // Отправляем AJAX-запрос для получения комментариев и обновления .CommentsHistory            var xhr = new XMLHttpRequest();            xhr.onreadystatechange = function () {                if (xhr.readyState == 4 && xhr.status == 200) {                    commentsHistoryElement.innerHTML = xhr.responseText;                }            };            var formData = new FormData();            formData.append('id_issue', taskId);            xhr.open("POST", "getcomments.php", true); // Укажите путь к вашему PHP-файлу            xhr.send(formData);        });    });});</script><style>    /* Скрываем стандартный селект */    #statusFilter {        display: none;    }</style><script>    //СКРИПТЫ ДЛЯ КОМПЛИТЕРА document.addEventListener('DOMContentLoaded', function() {  var taskCells = document.querySelectorAll('.open-task-modal');    taskCells.forEach(function(cell) {    cell.addEventListener('click', function() {            var taskId = cell.dataset.taskId;      var taskDescription = cell.dataset.taskDescription;      var clientID = cell.dataset.clientId; // Добавляем строку для получения id_client      var completionTime = cell.dataset.taskCompletion; // Add this line to retrieve completion time      var statusID = cell.dataset.statusId; // Add this line to retrieve status ID      var marksID = cell.dataset.marksId; // Add this line to retrieve marks ID      var comment = cell.dataset.comment; // Получаем комментарий      var taskName = cell.dataset.taskName;      openTaskCompleterWindow(taskId, taskDescription, clientID,completionTime,statusID,marksID,comment,taskName); // Передаем clientID в функцию    });  });  function openTaskCompleterWindow(taskId, taskDescription, clientID,completionTime, statusID,marksID,comment,taskName) {    // Здесь вы можете выполнить дополнительные действия перед открытием окна, если это необходимо    var fioElement = document.querySelector('.company-info h3'); // Получаем элемент <h3></span>ФИО</span></h3>    fioElement.textContent = clientID; // Устанавливаем текст элемента       // Получаем элемент с идентификатором "taskTitle"    var taskTitleElement = document.getElementById('taskTitle');    // Устанавливаем текст элемента с идентификатором "taskTitle" в значение идентификатора задачи    taskTitleElement.textContent = 'Задача: ' + taskId;     taskTitleElement.style.display = 'none'; // Скрываем элемент    // Добавляем taskName в конец вывода    var taskNameElement = document.getElementById('taskName');    taskNameElement.textContent = 'Задача: ' + taskName;        // Сдвигаем элемент на 50 пикселей вправо    taskTitleElement.style.left = '395px';    taskTitleElement.style.whiteSpace = 'nowrap';    var descriptionElement = document.querySelector('.Description');        // Разбиваем текст на строки по каждым 50 символам        var formattedDescription = taskDescription.replace(/(.{70})/g, '$1\n');        // Устанавливаем отформатированный текст в элемент        descriptionElement.textContent = 'Описание: ' + formattedDescription;        descriptionElement.style.left = '395px';        descriptionElement.style.whiteSpace = 'pre-line'; // Используем 'pre-line' для сохранения переносов строк        descriptionElement.style.maxWidth = '400px'; // Установка максимальной ширины       var completionTimeElement = document.getElementById('completionTime');    completionTimeElement.textContent = completionTime;    var statusElement = document.getElementById('statusInfo');    statusElement.textContent = statusID;    var marksElement = document.getElementById('marksInfo');    marksElement.textContent = marksID;        // Открываем модальное окно    document.getElementById('TaskCompleterWindow').style.display = 'block';    // Здесь вы можете загрузить информацию о задаче с использованием AJAX или другим способом      }});function CloseTaskCompleterWindow() {    document.getElementById('TaskCompleterWindow').style.display = 'none';  }  document.getElementById('saveComment').addEventListener('click', function() {    // Получаем значение комментария из поля ввода    var commentValue = document.getElementById('commentInput').value;    var taskId = document.getElementById('taskTitle').textContent.replace('Задача: ', '').trim();    // Создаем новый объект FormData для отправки данных    var formData = new FormData();    formData.append('id_issue', taskId);    formData.append('comment', commentValue);    // Создаем новый объект XMLHttpRequest    var xhr = new XMLHttpRequest();    xhr.onreadystatechange = function() {        if (xhr.readyState == 4) {            if (xhr.status == 200) {                // Обработка ответа сервера                var response = JSON.parse(xhr.responseText);                if (response.status === "success") {                    console.log('Комментарий успешно сохранен');                } else {                    console.error('Ошибка: ' + response.message);                }            } else {                console.error('Ошибка HTTP: ' + xhr.status);            }        }    };    // Отправка POST-запроса на сервер    xhr.open("POST", "update_comment.php", true);    xhr.send(formData);});</script><script>    // Получаем ссылки на элементы    const customSelect = document.getElementById('customSelect');    const statusFilter = document.getElementById('statusFilter');    // Добавляем обработчик события при клике на изображение    customSelect.addEventListener('click', function() {        // Открываем или закрываем выпадающий список при клике на изображение        statusFilter.style.display = statusFilter.style.display === 'none' ? 'block' : 'none';    });</script><div class="add-button"><span>Добавить</span></div>    </div>    <div class="task-list-container">        <table class="task-table">          <thead>            <tr>              <th>Имя задачи</th>              <th>Статус</th>              <th>Клиент</th>              <th>Метки</th>              <th></th>            </tr>          </thead>          <tbody>            <?php            if ($result->num_rows > 0) {                // Вывод данных каждой строки в таблицу                while ($row = $result->fetch_assoc()) {                    echo "<tr>";                    echo "<td data-task-name='" . $row['name'] . "'  data-task-id='" . $row['id_issue'] .  "' data-task-description='" . $row['description'] . "' data-client-id='" . $row['first_name'] . $row['middle_name'] . $row['last_name'] . "' data-task-completion='" . $row['completion_time'] . "' data-status-id='" . $row['status_name'] . "' data-marks-id='" . $row['mark_name'] . "' data-comment='";                                    // Search for comments related to the current issue                    $comments = [];                    while ($commentRow = $resultComment->fetch_assoc()) {                        if ($commentRow['name'] === $row['name']) {                            $comments[] = $commentRow['comment'];                        }                    }                    echo implode(', ', $comments) . "' class='open-task-modal'>" . $row['issue_name'] . "</td>";                    echo "<td data-status-id='" . $row['id_status'] . "'>" . $row['status_name'] . "</td>";                    echo "<td>" . $row['first_name'] . "</td>";                    echo "<td>" . $row['mark_name'] . "</td>";                    echo "<td> <a href='#' onclick='deleteTask(" . $row['id_issue'] . ")'>Удалить</a></td>";                    echo "</tr>";                                    // Reset the internal data pointer of $resultComment                    $resultComment->data_seek(0);                }            }                            $conn->close();            ?>          </tbody>        </table>      </div></body><script>        function deleteTask(taskId) {            var confirmation = confirm("Вы точно хотите удалить эту задачу?");            if (confirmation) {                // Если пользователь подтвердил удаление, отправьте запрос на сервер для удаления задачи                // Можете использовать AJAX или другие методы отправки запросов                // Пример использования fetch:                fetch('delete_task.php?id=' + taskId, {                    method: 'DELETE',                })                .then(response => {                    // Обработка ответа от сервера, например, обновление страницы или скрытие удаленной задачи                    location.reload();                })                .catch(error => console.error('Ошибка при удалении задачи:', error));            }        }    </script><script>  document.addEventListener("DOMContentLoaded", function() {    // Получаем ссылки на все панели    var kanbanPanel = document.getElementById("kanban");    var calendarPanel = document.getElementById("calendar");    var ganttPanel = document.getElementById("gant");    // Добавляем обработчики событий клика для каждой панели    kanbanPanel.addEventListener("click", function() {        window.location.href = "TasksKanban.php";    });    calendarPanel.addEventListener("click", function() {        window.location.href = "TasksCalendar.php";    });    ganttPanel.addEventListener("click", function() {        window.location.href = "TasksGant.php";    });});</script><script>  document.addEventListener('DOMContentLoaded', function() {    var loginContainer = document.querySelector('.login-avatar-container');    var loginText = loginContainer.querySelector('.login-text');    // Получаем значение куки с логином пользователя    var loginCookie = document.cookie.replace(/(?:(?:^|.*;\s*)login\s*\=\s*([^;]*).*$)|^.*$/, "$1");    // Проверяем, есть ли значение куки с логином    if (loginCookie) {        loginText.textContent = loginCookie; // Отображаем логин пользователя        // Добавляем код для установки логина в другой элемент        var loginTextWindow = document.querySelector('.login-text-window');        loginTextWindow.textContent = loginCookie; // Устанавливаем логин в другой элемент    }});  </script>  <script>    document.addEventListener('DOMContentLoaded', function() {    var statusFilter = document.getElementById('statusFilter');    var taskRows = document.querySelectorAll('.task-table tbody tr');    statusFilter.addEventListener('change', function() {        var selectedStatusId = statusFilter.value;        // Показываем или скрываем строки таблицы в зависимости от выбранного статуса        taskRows.forEach(function(row) {            var statusCell = row.querySelector('td:nth-child(2)');            var statusId = statusCell.dataset.statusId;            if (selectedStatusId === 'all' || statusId === selectedStatusId) {                row.style.display = '';            } else {                row.style.display = 'none';            }        });    });});  </script><script>document.addEventListener('DOMContentLoaded', function() {    var statusFilter = document.getElementById('statusFilter');    var keywordInput = document.getElementById('keywordInput');    var taskRows = document.querySelectorAll('.task-table tbody tr');    // Функция для фильтрации строк таблицы по статусу и ключевому слову    function filterRows() {        var selectedStatusId = statusFilter.value;        var keyword = keywordInput.value.trim().toLowerCase();        taskRows.forEach(function(row) {            var cells = row.querySelectorAll('td');            var isVisible = false;            // Проверяем каждую ячейку в строке на соответствие ключевому слову            cells.forEach(function(cell) {                var cellText = cell.textContent.toLowerCase();                // Если хотя бы одно поле содержит ключевое слово и статус соответствует, делаем строку видимой                if ((cellText.includes(keyword) || keyword === '') && (selectedStatusId === 'all' || cell.dataset.statusId === selectedStatusId)) {                    isVisible = true;                }            });            // Устанавливаем свойство отображения строки в соответствии с результатом фильтрации            if (isVisible) {                row.style.display = '';            } else {                row.style.display = 'none';            }        });    }    // Обработчики событий для изменения статуса фильтра и ввода ключевого слова    statusFilter.addEventListener('change', filterRows);    keywordInput.addEventListener('input', filterRows);});</script></html>