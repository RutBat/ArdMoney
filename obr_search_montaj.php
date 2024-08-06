<?php
include "inc/db.php"; // Подключение к базе данных

if (isset($_GET['query'])) {
    $searchTerm = $_GET['query'];

    $searchTerm = '%' . $_GET['query'] . '%';

    // Подготовка запроса для предотвращения SQL-инъекций
    $stmt = $connect->prepare("SELECT * FROM montaj WHERE adress LIKE ?");
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {
            $str = $row['id'];
            $encodedStr = base64_encode($str);
            echo '
                <a id="search_view" class="search_view" style="color: black;" href="result.php?vid_id='.$encodedStr.'">
                <li class="hui list-group-item d-flex justify-content-between align-items-center" style="background-color: #fff; padding: 7px 10px 5px 10px;">
                        <label style="color: black; font-family: inherit;">
                            <small class="form-text">'.$row['date'].'</small>'.$row['adress'].'<br>
                        </label>';
                        echo "<br><small class='form-text '>";
                        echo $row['technik1'] . $row['technik2'] . $row['technik3'] . $row['technik4'] . $row['technik5'];
                        echo ":";
                        echo $row['text'];
                        echo '</small>';
                  echo' </a>

                </li>
                <hr style = "margin:0;color: #474747c7;" >
            ';
           
                    }
    } else {
        echo "<div>Ничего не найдено</div>";
    }

    $stmt->close();
    $connect->close();
}
?>

