<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="CSS/registrarse.css">
<title>Registrarse</title>
</head>
<body>

<form method="POST" action="regis_procesa.php">

<div class="card-register">
  <h1>Crear nueva cuenta</h1>

  <div class="field">
    <input type="text" name="nom" placeholder="Nombre">
  </div>

  <div class="field">
    <input type="date" name="cumple" placeholder="Fecha de nacimiento">
  </div>

  <div class="group">
    <label><input type="radio" name="genero" value="Mujer"> Mujer</label>
    <label><input type="radio" name="genero" value="Hombre"> Hombre</label>
    <label><input type="radio" name="genero" value="No"> Prefiero no contestar</label>
  </div>

  <div class="field">
    <input type="email" name="mail" placeholder="Correo electrónico">
  </div>

  <div class="field">
    <input type="password" name="contraseña" placeholder="Contraseña">
  </div>

  <button class="btn" type="submit">Registrarse</button>

    <p class="login-link"> <a href="login.php">¿Ya tienes una cuenta? </a></p>
</div>
</div>

</body>
</html>