<?php session_start(); ?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Узнай погоду в своем городе</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>

    <header>

        <?php 

            $city = "Брянск"; // город. Можно и по-русски написать, например: Брянск
            $country = "RU"; // страна
            $mode = "json"; // в каком виде мы получим данные json или xml
            $units = "metric"; // Единицы измерения. metric или imperial
            $lang = "ru"; // язык
            $appID = "52a3cff675e4e6a5d39d0fbc77bd465e"; // Ваш APPID
              
            // формируем урл для запроса
            $url = "http://api.openweathermap.org/data/2.5/forecast?q=$city,$country&lang=$lang&units=$units&appid=$appID";
            $data = @file_get_contents($url);
            // если получили данные
            if($data){
                // декодируем полученные данные
                $dataJson = json_decode($data);
                // получаем только нужные данные
                $arrayDays = $dataJson->list;
                // выводим данные
            }

          echo "<h2>Погода для города " . $city . "</h2>";

          if($_COOKIE['user'] == !''):

        ?>
         <form action="city.php">
            <input type="text" name="city" placeholder="Название города" required>
            <input class="comm_btn" type="submit" value="Отправить">
         </form>
         <a href="Kab.php">Меню модерации</a>
        <?php else: ?>
        <div class="header__reg">
          <a href="form_register.php">Регистрация</a>
          <a href="form_auth.php">Авторизация</a>
        </div>
        <?php endif;?>

    </header>

    <section>
        

         <table class="weather">
           <tr>
            <td><b>Минимальная температура</b></td>
            <td><b>Максимальная температура</b></td>
            <td><b>Скорость ветра</b></td>
            <td><b>Погода</b></td>
            <td><b>Дата и время</b></td>
          </tr>
             <?php 
                foreach($arrayDays as $oneDay){
                  echo '<tr>' .
                   "<td>{$oneDay->main->temp_min} °C</td>" . //выводим компоненты
                   "<td>{$oneDay->main->temp_max} °C</td>" .
                   "<td>{$oneDay->wind->speed}  м/с</td>" .
                   "<td>{$oneDay->weather[0]->description}</td>" .
                   "<td>{$oneDay->dt_txt}</td>" .
                  '</tr>';

                    //"Минимальная температура: " . $oneDay->main->temp_min . " °C". "<br/>"; 
                   //"Максимальная температура: " . $oneDay->main->temp_max . " °C"."<br/>";      
                    //"Скорость ветра: " . $oneDay->wind->speed . " м/с". "<br/>";
                    //"Погода: " . $oneDay->weather[0]->description . "<br/>";
                }
              ?>
         </table>


  <div class="сomments">

    <form name="comment" action="com.php" method="post"> <!-- взаимодействие с comment.php -->
    
        <h3>Оставьте ваш комментарий:</h3>
        <br>
        <input type="text" name="name" placeholder="Имя">
        <textarea name="com_text" cols="50" rows="10"></textarea>
        <input type="hidden" name="page_id" value="111" />
        <input class="comm_btn" type="submit" value="Отправить" />
    </form>


    <?php
      $page_id = 111;// Уникальный идентификатор страницы (статьи или поста)
      $mysqli = new mysqli("localhost", "root", "", "zd12");// Подключается к базе данных
      $result_set = $mysqli->query("SELECT * FROM `com` WHERE `page_id`='$page_id'"); //Вытаскиваем все комментарии для данной страницы
      while ($row = $result_set->fetch_assoc()) {
        echo "<div class='com'><b>".$row["name"]."</b>: <br> ".$row["com_text"]."</div>"; //выводим комменты в отдельный див
      }
    ?>
   
  </div> <!-- //комментарии -->


    </section>

    <footer>
        

    </footer>

</body>
</html>



