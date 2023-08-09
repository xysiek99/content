<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Telefonia pakietowa</title>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> <!-- character encoding -->
        <!-- Required meta tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link rel="preconnect" href="https://firebasestorage.googleapis.com" />

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <link href="/css/style.css" rel="stylesheet" type="text/css">
    <link href="/css/aspect-elements.css" rel="stylesheet" type="text/css"/>
    <link href="/css/aspect-style.css" rel="stylesheet" type="text/css" />
    <!--><link rel="stylesheet" type="text/css" href="css/animate.css"></!-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
</head>
<body id="root-container" style="margin: 0;" onload="initAspectJS()">
    <div data-element-behavior="menu" id="nav-id-18-" data-element-type="section">
        <div id="container-id-19-" data-element-type="container">
            <a id="image-id-1-" data-element-type="button" href="/index.php"><span id="element-id-0-">Telefonia pakietowa</span></a>
            <?php if (isset($_SESSION['sessionUser'])){ ?>
                <p>Witaj <?php echo $_SESSION['sessionUser']; ?>. <a data-element-type="button" href="/logout.php">Wyloguj</a></p>
            <?php } else { ?>
                <a id="button-id-6-" data-element-type="button" href="/loggin.php"><span id="element-id-5-">Zaloguj</span></a>
            <?php } ?>
        </div>
    </div>
    <div id="button-id-0-popover" data-element-type="dropdown" data-popover-for="button-id-0-" class="dropdown" style="display: none;">
        <div id="element-id-2-">
            <a id="link-id-3-" data-element-type="link" data-item-of="button-id-0-popover" spellcheck="false" contenteditable="false" href="/labs/lab1.php">Rejestracja terminali w centrali Asterisk</a>
            <a id="link-id-4-" data-element-type="link" data-item-of="button-id-0-popover" spellcheck="false" contenteditable="false" href="/labs/lab2.php">Konfiguracja i wykonywanie połączeń lokalnych</a>
            <a id="link-id-56-" data-element-type="link" data-item-of="button-id-0-popover" spellcheck="false" contenteditable="false" href="/labs/lab3.php">Konfiguracja i wykonywanie połączeń między centralami</a>
            <a id="link-id-57-" data-element-type="link" data-item-of="button-id-0-popover" spellcheck="false" contenteditable="false" href="/labs/lab4.php">Auto Attendant, Interactive Voice Response, VoiceMail</a>
            <a id="link-id-58-" data-element-type="link" data-item-of="button-id-0-popover" spellcheck="false" contenteditable="false" href="/labs/lab5.php">Music on Hold, Attended Call Transfer, Blind Call Transfer, Call Pickup</a>
            <a id="link-id-59-" data-element-type="link" data-item-of="button-id-0-popover" spellcheck="false" contenteditable="false" href="/labs/lab6.php">Rekordy CDR</a>
            <a id="link-id-69-" data-element-type="link" data-item-of="button-id-0-popover" spellcheck="false" contenteditable="false" href="/labs/lab7.php">Diagnozowanie problemów</a>
        </div>
    </div>
</body>