<?php
$host = 'localhost:3306'; 
$db = 'login';
$user = 'root';      
$pass = 'rootroot';          

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en la conexión a la base de datos: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cancion = $_POST['cancion'];
    $album = $_POST['album'];
    $artista = $_POST['artista'];
    $duracion = $_POST['duracion'];
    $genero = $_POST['genero'];
    $contenido_explicito = isset($_POST['contenido_explicito']) ? 1 : 0;

    $duracion_24 = date("H:i", strtotime($duracion));

    if (!preg_match("/^([01]?[0-9]|2[0-3]):([0-5][0-9])$/", $duracion_24)) {
        echo "Formato de duración no válido. Por favor use HH:MM.";
        exit;
    }

    $stmt = $pdo->prepare("INSERT INTO musica (cancion, album, artista, duracion, genero, contenido_explicito) 
                           VALUES (:cancion, :album, :artista, :duracion, :genero, :contenido_explicito)");

    $stmt->execute([
        ':cancion' => $cancion,
        ':album' => $album,
        ':artista' => $artista,
        ':duracion' => $duracion_24,
        ':genero' => $genero,
        ':contenido_explicito' => $contenido_explicito
    ]);

    echo '<div class="success-message">
        Canción añadida con éxito!
        <br><a href="main.php">Volver a la lista de canciones</a>
      </div>';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Canción</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <style>
        body {
            background-color: #e3f2fd;
            font-family: 'Poppins', sans-serif;
            color: #37474f;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            flex-direction: column;
        }

        .background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: space-evenly;
            align-items: flex-end;
            z-index: -1;
        }

        .bar {
            width: 100px;
            height: 100%;
            background: linear-gradient(to top, #0288d1, #64b5f6);
            animation: bars 1s ease-in-out infinite;
        }

        .bar:nth-child(odd) {
            animation-delay: 0.2s;
        }

        .bar:nth-child(even) {
            animation-delay: 0.4s;
        }

        .success-message {
            background-color: #87D28A;
            color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            font-size: 1.2rem;
            margin-top: 30px;
            margin-bottom: 10px;
        }

        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }

        @keyframes bars {
            0% {
                height: 10%;
            }
            50% {
                height: 80%;
            }
            100% {
                height: 10%;
            }
        }

        h2 {
            color: #0288d1;
            margin-bottom: 30px;
            font-weight: 600;
            text-align: center;
        }

        .form-container {
            max-width: 500px;
            width: 100%;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
            max-height: 90vh;
            overflow-y: auto;
        }

        .input-field label {
            color: #0288d1;
        }

        .input-field input {
            border: 2px solid #0288d1;
            border-radius: 4px;
            padding: 10px;
            font-size: 1rem;
            margin-bottom: 20px;
            width: 100%;
        }

        .btn {
            background-color: #0277bd;
            color: white;
            border-radius: 30px;
            width: 100%;
            margin-top: 20px;
            text-align: center;
            font-size: 1.1rem;
        }
    </style>
</head>
<body>
    <div class="background">
        <div class="bar"></div>
        <div class="bar"></div>
        <div class="bar"></div>
        <div class="bar"></div>
        <div class="bar"></div>
        <div class="bar"></div>
    </div>

    <div class="form-container">
        <h2>Agregar Canción</h2>
        <form action="add.php" method="POST">
            <label for="cancion">Canción:</label>
            <input type="text" id="cancion" name="cancion" required><br><br>

            <label for="album">Álbum:</label>
            <input type="text" id="album" name="album"><br><br>

            <label for="artista">Artista:</label>
            <input type="text" id="artista" name="artista" required><br><br>

            <label for="duracion">Duración:</label>
            <input type="time" id="duracion" name="duracion" required><br><br>

            <label for="genero">Género:</label>
            <input type="text" id="genero" name="genero" required><br><br>

            <div class="switch">
                <label>
                    No
                    <input type="checkbox" id="contenido_explicito" name="contenido_explicito">
                    <span class="lever"></span>
                    Sí
                </label>
            </div><br><br>

            <button type="submit" class="btn">Agregar Canción</button>
        </form>
    </div>
</body>
</html>
