<?php
  include 'includes/header.php';
?>
	<form action="includes/register-inc.php" method="post">
  <div class="container">
    <h1>Rejestracja</h1>
    <p>Wypełnij formularz w celu założenia konta</p>
    <hr>

    <label for="email"><b>Login</b></label>
    <input type="text" placeholder="Wprowadź nazwę użytkwonika" name="username" id="email" required>

    <label for="psw"><b>Hasło</b></label>
    <input type="password" placeholder="Wprowadź hasło" name="psw" id="psw" required>

    <label for="psw-repeat"><b>Powtórz hasło</b></label>
    <input type="password" placeholder="Wprowadź ponownie hasło" name="psw-repeat" id="psw-repeat" required>

    <button type="submit" class="registerbtn" name="submit">Utwórz konto</button>
  </div>
  
  <div class="container signin">
    <p>Masz już konto? <a href="loggin.php">Zaloguj się</a>.</p>
  </div>
</form>

<?php
  require_once 'includes/footer.php';
?>