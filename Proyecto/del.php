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

if (isset($_POST['canciones']) && !empty($_POST['canciones'])) {
    $canciones_seleccionadas = $_POST['canciones'];
    $placeholders = implode(',', array_fill(0, count($canciones_seleccionadas), '?'));
    $stmt = $pdo->prepare("DELETE FROM musica WHERE id IN ($placeholders)");
    $stmt->execute($canciones_seleccionadas);

    echo '<div class="success-message">
            ¡Canciones eliminadas con éxito!
            <br><a href="main.php">Volver a la lista de canciones</a>
          </div>';
}

$stmt = $pdo->query("SELECT * FROM musica");
$canciones = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Canciones</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <style>
        body {
            background-color: #FDE3E3;
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
            background: linear-gradient(to top, #D10202, #F66464);
            animation: bars 1s ease-in-out infinite;
        }

        .bar:nth-child(odd) {
            animation-delay: 0.2s;
        }

        .bar:nth-child(even) {
            animation-delay: 0.4s;
        }

        @keyframes growShrink {
            0%, 100% { height: 50px; }
            50% { height: 150px; }
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

        .success-message {
            background-color: #D28787;
            color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            font-size: 1.2rem;
            margin-top: 30px;
            margin-bottom: 10px;
        }

        h2 {
            color: #D10202;
            font-weight: 600;
            text-align: center;
        }

        .form-container {
            max-width: 600px;
            width: 100%;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
            max-height: 90vh;
            overflow-y: auto;
        }

        table {
            width: 100%;
            margin-top: 20px;
        }

        table th, table td {
            padding: 15px;
            text-align: center;
            color: #37474f;
        }

        table th {
            color: #D10202;
            font-weight: bold;
        }

        .btn {
            background-color: #BD0202;
            color: white;
            border-radius: 30px;
            width: 100%;
            margin-top: 20px;
            text-align: center;
            font-size: 1.1rem;
        }

        .btn:hover {
            background-color: #9B0101;
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
        <h2>Lista de Canciones</h2>
        <form action="del.php" method="POST">
            <table class="striped">
                <thead>
                    <tr>
                        <th>Seleccionar</th>
                        <th>Canción</th>
                        <th>Álbum</th>
                        <th>Artista</th>
                        <th>Duración</th>
                        <th>Género</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($canciones as $cancion): ?>
                        <tr>
                            <td><label><input type="checkbox" name="canciones[]" value="<?php echo $cancion['id']; ?>"><span></span></label></td>
                            <td><?php echo htmlspecialchars($cancion['cancion']); ?></td>
                            <td><?php echo htmlspecialchars($cancion['album']); ?></td>
                            <td><?php echo htmlspecialchars($cancion['artista']); ?></td>
                            <td><?php echo htmlspecialchars($cancion['duracion']); ?></td>
                            <td><?php echo htmlspecialchars($cancion['genero']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <button type="submit" class="btn">Eliminar Seleccionadas</button>
        </form>
    </div>
</body>
</html>
