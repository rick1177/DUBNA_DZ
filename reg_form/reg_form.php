<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"-->
    <!--          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">-->
    <link href="../bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../header_styles.css">
    <link rel="stylesheet" href="../reg_form/reg_form.css">
    <link rel="stylesheet" href="../font-awesome-4.7.0/css/font-awesome.min.css">
    <title>Результаты</title>
    <style>
        body {
            min-width: 600px;
        }
    </style>
</head>
<body>
    <div id="header"></div>
    <br>
    <style>
        table {
            border-collapse: collapse;
            width: 50%;
            margin: auto;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>

    <script>


        // Загружаем шапку и контент при загрузке страницы
        window.onload = function() {
            loadHeader();

        };

        function loadHeader() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState === 4) {
                    if (this.status === 200) {
                        document.getElementById("header").innerHTML = this.responseText;
                        setActiveLink();
                        setRegistrationNavLink();
                    } else {
                        console.error("Ошибка 1 загрузки файла header.html:", this.status);
                        // Здесь можно выполнить дополнительные действия, например, загрузить альтернативный контент или отобразить сообщение об ошибке
                    }
                }
            };
            xhttp.onerror = function() {
                console.error("Ошибка при выполнении запроса на загрузку файла header.html");
                // Здесь можно выполнить дополнительные действия, связанные с обработкой ошибки
            };
            xhttp.open("GET", "../header.html", true);
            xhttp.send();
        }

        function setActiveLink() {
            var path = window.location.pathname;
            var links = document.querySelectorAll('#navbarNav .nav-link');
            for (var i = 0; i < links.length; i++) {
                var link = links[i];
                if (link.getAttribute('href') === 'index.html') {
                    link.classList.add('active');
                }
            }
        }

        // Функция для выбора элемента <a> с классом "nav-link active" и текстом "Регистрация"
        function findNavLinkByText(text) {
            console.log("findNavLinkByText была запущена.");
            var navLinks = document.querySelectorAll('a.nav-link');
            console.log("Найдено элементов с классом 'nav-link active': " + navLinks.length);
            for (var i = 0; i < navLinks.length; i++) {
                var navLink = navLinks[i];
                console.log("Текст найденного элемента: " + navLink.textContent.trim());
                if (navLink.textContent.trim() === text) {
                    console.log("findNavLinkByText нашла нужный элемент");
                    return navLink;
                }
            }
            console.log("findNavLinkByText выдала null");
            return null; // Если элемент не найден
        }



        // Функция для вычисления глубины пути
        function calculatePathDepth() {
            var currentPath = window.location.pathname;
            var count = (currentPath.match(/\//g) || []).length;
            return count - 1; // Отнимаем 1, потому что последний слеш перед именем файла
        }

        // Функция для построения пути к index.html с учетом количества подкаталогов
        function buildIndexPath(fileName) {
            var depth = calculatePathDepth();
            var indexPath = '';
            // Добавляем соответствующее количество "../" перед именем файла
            for (var i = 0; i < depth - 1; i++) {
                indexPath += '../';
            }
            console.log("buildIndexPath выдаёт: " + indexPath + fileName);
            return indexPath + fileName;
        }


        // Функция для установки ссылки на index.html в элементе <a> с классом "nav-link active" и текстом "Регистрация"
        function setRegistrationNavLink() {
            console.log("setRegistrationNavLink была запущена.");
            var navLink = findNavLinkByText("Регистрация");
            if (navLink) {
                navLink.setAttribute('href', buildIndexPath('index.html'));
            }
            var navLink = findNavLinkByText("Участники");
            if (navLink) {
                navLink.setAttribute('href', buildIndexPath('stat.php'));
            }

        }

    </script>


    <?php
    // создание подключения к БД
    $servername = "localhost";
    $username = "root";
    $password = "3143daDA@";
    $dbname = "dubna_dz";

    // Подключаемся к базе данных
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Проверяем соединение
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Проверяем, была ли отправлена форма методом POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Получаем значения из формы
        $name = $_POST["name"];
        $mname = $_POST["mname"];
        $sname = $_POST["sname"];
        $birthday = $_POST["birthday"];
        $phone = $_POST["phone"];
        $email = $_POST["email"];
        $section = $_POST["section"];
        // Проверяем, существует ли ключ "report" в массиве $_POST
        $report = $_POST["report"] ?? ""; // Если ключ "report" не существует, присваиваем пустую строку
        $report = $report == "on" ? "да" : "нет"; // Проверяем значение чекбокса
        $report_to_db = isset($_POST["report"]) ? 1 : 0;

        $topic = $_POST["topic"] ?? "Не объявлена";
        $topic = $topic == "" ? "Не объявлена" : $topic;

        // Преобразуем дату в нужный формат
        $formatted_birthday = date("d.m.Y", strtotime($birthday));

        // SQL запрос для вставки данных
        $sql = "INSERT INTO member (name, mname, sname, birthday, phone, email, section, report, topic)
            VALUES ('$name', '$mname', '$sname', '$birthday', '$phone', '$email', '$section', $report_to_db, '$topic')";

        // Выполняем запрос
        if ($conn->query($sql) === TRUE) {
            //echo "Запись успешно добавлена";
        } else {
            echo "Ошибка при добавлении записи: " . $conn->error;
        }

        // Закрываем соединение с базой данных
        $conn->close();

        // Выводим информацию в виде таблицы
        echo "<table>";
        echo "<tr><th>Параметр</th><th>Значение</th></tr>";
        echo "<tr><td>Имя</td><td>$name</td></tr>";
        echo "<tr><td>Отчество</td><td>$mname</td></tr>";
        echo "<tr><td>Фамилия</td><td>$sname</td></tr>";
        echo "<tr><td>Дата рождения</td><td>$formatted_birthday</td></tr>";
        echo "<tr><td>Телефон</td><td>$phone</td></tr>";
        echo "<tr><td>E-mail</td><td>$email</td></tr>";
        echo "<tr><td>Секция</td><td>$section</td></tr>";
        echo "<tr><td>Заявлен доклад</td><td>$report</td></tr>";
        echo "<tr><td>Тема доклада</td><td>$topic</td></tr>";
        echo "</table>";

        // Добавляем кнопку "OK" для возврата на страницу start.html
        echo "<div>";
        echo "<button onclick=\"window.location='../index.html';\">&lt;&lt;Назад</button>";
        echo "</div>";
    }
    ?>

    <script src="../bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
</body>
</html>
