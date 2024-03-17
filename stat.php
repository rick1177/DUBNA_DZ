<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"-->
    <!--          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">-->
    <link href="bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="header_styles.css">
    <link rel="stylesheet" href="reg_form/reg_form.css">
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <title>POST Form</title>
</head>
<body>
<div id="header"></div>
<br>
<div id="reg_form_include"></div>
<script>
    // Загружаем шапку и контент при загрузке страницы
    window.onload = function () {
        loadHeader();
    };

    function loadHeader() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                document.getElementById("header").innerHTML = this.responseText;
                setActiveLink();
            }
        };
        xhttp.open("GET", "header.html", true);
        xhttp.send();
    }


    function setActiveLink() {
        var path = window.location.pathname;
        var links = document.querySelectorAll('#navbarNav .nav-link');
        for (var i = 0; i < links.length; i++) {
            var link = links[i];
            if (link.getAttribute('href') === 'stat.html') {
                link.classList.add('active');
            }
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

// Выполняем запрос к базе данных для извлечения данных
$sql = "SELECT * FROM member";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Выводим данные в виде HTML таблицы
    echo "<table>";
    echo "<tr>
                <th>Имя</th>
                <th>отчество</th>
                <th>Фамилия</th>
                <th>Дата рождения</th>
                <th>Телефон</th>
                <th>E=mail</th>
                <th>Секция</th>
                <th>Доклад</th>
                <th>Тема</th>
              </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "
        <tr>
            <td>" . $row["name"] . "</td>
            <td>" . $row["mname"] . "</td>
            <td>" . $row["sname"] . "</td>
            <td>" . $row["birthday"] . "</td>
            <td>" . $row["phone"] . "</td>
            <td>" . $row["email"] . "</td>
            <td>" . $row["section"] . "</td>
            <td>" . $row["report"] . "</td>
            <td>" . $row["topic"] . "</td>                        
        </tr>
        ";
    }

        echo "</table>";
    } else {
    echo "0 результатов";
}

$conn->close();
?>

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

</body>
</html>