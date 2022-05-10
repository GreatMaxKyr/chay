<!DOCTYPE html>
<html lang="ua">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Оплата</title>
</head>
<body>
    <div class="wrapper">
        <div class="c">
            <h1 class="h1">Оплатіть ваше замовлення</h1>
        </div>
        <?php 
            
            session_start(); 
            if ($_POST) {
                $cost = $_SESSION['cost'];
                $cash = $_SESSION['cash'];
                $payment = $_POST['payment'];
                
                $cash += $payment;
                $_SESSION['cash'] = $cash;
                echo "
                    <form action='pay.php' method='POST'>
                        <div class='inf'>
                            <p>У вас ".$_SESSION['orders']." неоплачених замовлень на суму $cost грн</p>
                            <p>Вкладіть потрібну суму</p>
                            <p>(Автомат здачі не видає)</p>
                        </div>
                        
                        <button class='g' type='submit' name='payment' value='1'>
                            <img src='img/1.jpg' alt='money'>
                        </button>
                        <button class='g' type='submit' name='payment' value='2'>
                            <img src='img/2.jpg' alt='money'>
                        </button>
                        <button class='g' type='submit' name='payment' value='10'>
                            <img src='img/10.jpg' alt='money'>
                        </button>                   
                        <button class='g' type='submit' name='payment' value='1000'>
                            <img src='img/1000.jpg' alt='money'>
                        </button>
                        <div class='inf'><p>Ви ввели $payment гривень</p></div>
                    </form>
                ";
                
                echo "
                    <div class='balance'>
                        <h2>У вас на балансі :</h2>
                        <p>".round($cash, 2)." грн</p> 
                        <img src='img/privat.png' alt='privat'>                 
                    </div>
                ";
                if ($cash < $cost) {
                    echo "
                    <p class='nenough'>Ви ввели замалу суму, вложіть іще гроші!</p>
                    ";
                }elseif ($cash >= $cost) {
                    $_SESSION['cash'] -= $cost;
                    $_SESSION['cost'] = 0;
                    $_SESSION['orders'] = 0;
                    echo "
                    <form method='POST' class='c' action='index.php'> 
                    <label><input class='psub' type='submit' value='Оплатити'>
                    </form>
                    ";
                }
                
            }
        ?>
        
    </div>
</body>
</html>