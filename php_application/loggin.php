<?php
  include 'includes/header.php';
?>
	<form action="includes/login-inc.php" method="post">
  <div class="container">
    <h1>Logowanie</h1>
    <hr>

    <label for="email"><b>Nazwa użytkownika</b></label>
    <input type="text" placeholder="Wprowadź nazwę użytkownika" name="username" id="email" required>

    <label for="psw"><b>Hasło</b></label>
    <input type="password" placeholder="Wprowadź hasło" name="psw" id="psw" required>

    <button type="submit" name="submit" class="registerbtn">Zaloguj</button>
  </div>
  
</form>

<?php
  require_once 'includes/footer.php';
?>