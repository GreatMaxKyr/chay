<!DOCTYPE html>
<html lang="ua">
<head>
    <link rel="stylesheet" href="css/style.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=yes , initial-scale=1.0 , minimum-scalable=1.0 , maximum-scale=2.0">
    <title>Чай</title>
</head>
<body>
    <div class="wrapper">
        <form method="POST" action="index.php">
            <div class="top">
                <h1 class="h1">Замовляйте чай</h1>
                <img class="leaf" src="img/tea_leaves.png" alt="tea-leaf">
            </div>
            <h3>Скільки вам потрібно чаю?</h3>
            <input name="ml" type="range" value="100" min="50" max="1000" step="50" oninput="this.nextElementSibling.value=this.value">
            <output>100</output>
            <span>мл.</span>
            <h3>Скільки вам потрібно цукру до чаю?</h3>
            <input name="sugar" type="range" value="1.5" min="0" max="10" step="0.5" oninput="this.nextElementSibling.value=this.value">
            <output>1.5</output>
            <span>ч. л.</span>
            <h3>В що налити чай?</h3>
            <select class='oldselect' name="bottle" id="">
                <option value="cup">Кружку (350 ml)</option>
                <option value="carton">Картонний стакан (200 ml)</option>
                <option value="termos">Термос (500 ml)</option>
            </select>
            <h3>Яку ви хочете міцність чаю?</h3>
            <select class='oldselect' name="strenght" id="">
                <option value="low">Слабку</option>
                <option value="middle">Середню</option>
                <option value="height">Міцну</option>
            </select>
        <?php
            session_start(); 
            if (!isset($_SESSION['cash'])) {
                $_SESSION['cash'] = 0;
                $_SESSION['cost'] = 0;
                $_SESSION['orders'] = 0;
            }
            echo " 
                    <div class='balance'>
                        <h2>У вас на балансі :</h2>
                        <p>".round($_SESSION['cash'], 2)." грн</p> 
                        <img src='img/privat.png' alt='privat'>                   
                    </div>
                    <input class='psub' type='submit' value='Замовити чай'>
                </form>
            ";
            if (isset($_POST['ml'])) {
                $strenghtcost;
                $tspend = 0;
                $celsius = 0;
                $bsize;
                $naluto = 50;
                $ubottle;
                $utext;
                $sugar = $_POST['sugar'];
                $ml = $_POST['ml'];
                $bottle = $_POST['bottle'];
                $strenght = $_POST['strenght'];
                $tsmlf = $sugar / $ml * 50;//tea sugar ml 50
                $howmsugar = 0;

                if ($strenght == "low") {
                    $utext = "низька";
                    $strenghtcost = 1;
                } elseif ($strenght == "middle") {
                    $utext = "середня";
                    $strenghtcost = 3;
                } else {
                    $utext = "сильна";
                    $strenghtcost = 5;
                }
                if ($bottle == "cup") {
                    $ubottle = "кружка";
                    $bsize = 350;
                } elseif ($bottle == "carton") {
                    $ubottle = "Картонний стакан";
                    $bsize = 200;
                } else {
                    $ubottle = "термос";
                    $bsize = 500;
                }
                $cost = ($ml / 50) + ($sugar / 10) + ($bsize / 100) + $strenghtcost;
                echo '
                    <p class="your_order">
                        <h2>Ваше замовлення № '.++$_SESSION['orders'].':</h2>
                        <p>'.$ml.' мілілітрів чаю;</p>
                        <p>'.$sugar.' чайних ложок цукру;</p>
                        <p>'.$utext.' сила заварки чаю;</p>
                        <p>ємність для чаю '.$ubottle.';
                        <p>Вартість замовлення '.$cost.'грн;
                    </p>
                ';
                if ($bottle == "cup") {
                    echo "<img src='img/cup.png' alt='your cup'>";
                } elseif ($bottle == "carton") {
                    echo "<img src='img/plastic.png' alt='your plastic cup'>";
            
                } else {
                    echo "<img src='img/termos.png' alt='your termos'>";
                }
                echo "
                        <div class='prepearing'>
                            <h2>Приготування напою</h2>
                            <h3>Кип'ятимо воду</h3>
                            <img src='img/waterpot.gif' alt='water pot'>
                ";
                while ($celsius < 100) {
                    $celsius += 10;
                    echo "<p>Вода нагріта на $celsius °</p>";
                    if ($celsius == 100) {
                        echo "<p class='ready'>Вода нагріта</p>";
                    }
                }
            
                echo "<h3>Створюємо чай</h3>";
                while ($naluto <= $ml) {
                    if ($naluto == 50) {
                        echo "<img src='img/bucket-heart.gif' alt='pour_water'>";
                    }
                    if ($naluto > $bsize ) {
                        echo "
                            <img class='omnomnom' src='img/coffee-sugar.gif' alt='put_sugar'>
                            <p>Кладемо ".$tsmlf * $howmsugar." ч.л. цукру</p>
                            <img src='img/tea_brewing.webp' alt='tea brewing'>
                        ";
                        if ($strenght == "low") {
                            echo "<p>Пройшла 1 хвилина</p>";
                            echo "<p class='ready'>Час пройшов</p>";
                        } elseif ($strenght == "middle") {
                            while ($tspend < 3) {
                                $tspend += 1;
                                echo "<p>Пройшло $tspend хвилин</p>";
                                if ($tspend == 3) {
                                    echo "<p class='ready'>Час пройшов</p>";
                                }
                            }
                        } else {
                            while ($tspend < 5) {
                                $tspend += 1;
                                echo "<p>Пройшло $tspend хвилин</p>";
                                if ($tspend == 5) {
                                    echo "<p class='ready'>Час пройшов</p>";
                                }
                            }
                        }
                        echo "
                            <p>Берем ще одну ємність</p>
                        ";
                        $ml -= $bsize;
                        $naluto = 0;
                        $howmsugar = 0;
                    }
                    if ($naluto != 0) {
                        echo "<p>Налито $naluto мл</p>";
                        $howmsugar++;
                    }
                    if ($naluto == $ml) {
                        echo "
                            <p class='ready'>Воду налито</p>
                            <img class='omnomnom' src='img/coffee-sugar.gif' alt='put_sugar'>
                            <p>Кладемо ".$tsmlf * $howmsugar." ч.л. цукру</p>
                            <img src='img/tea_brewing.webp' alt='tea brewing'>
                        ";
                        if ($strenght == "low"){
                            echo "<p>Пройшла 1 хвилина</p>";
                            echo "<p class='ready'>Час пройшов</p>";
                        }elseif ($strenght == "middle"){
                            while ($tspend < 3){
                                $tspend+=1;
                                echo "<p>Пройшло $tspend хвилин</p>";
                                if ($tspend == 3){
                                    echo "<p class='ready'>Час пройшов</p>";
                                }
                            }
                        }else {
                            while ($tspend < 5){
                                $tspend+=1;
                                echo "<p>Пройшло $tspend хвилин</p>";
                                if ($tspend == 5){
                                    echo "<p class='ready'>Час пройшов</p>";
                                }
                            }
                        }
                    };
                    $naluto += 50;
                };
                
                echo "
                    </div><!--div prepearing end-->
                    <div class='tea_time'>
                        <h2>Ваш чай готовий</h2>
                        <img src='img/tea_time.webp' alt='tea_time'>
                        <img src='img/bon_appetit.webp' alt='bon_appetit'>
                    </div>           
                    <div class='pay'>
                        <form method='POST' action='pay.php'>
                            <h2>Оплатіть ваше замовлення</h2>
                            <p class='payc'>$cost грн</p> 
                            <label><input name='payment' value='0' type='hidden'></label>
                            <label><input class='psub' type='submit' value='Оплатити'>
                        </form>
                    </div>
                ";
                $_SESSION['cost'] += $cost; //робить суму всіх замовлень
            }
        ?>
    </div>
</body>
</html>