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

$stmt = $pdo->query("SELECT * FROM musica");

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registros de Música</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #e3f2fd; 
            color: #37474f;
            overflow: hidden;
            position: relative;
        }

        .circle {
            position: absolute;
            background-color: rgba(173, 216, 230, 0.6); 
            border-radius: 50%;
            animation: rise infinite linear;
            opacity: 0;
        }

        @keyframes rise {
            0% {
                top: 260%;
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            100% {
                top: -200%;
                opacity: 0;
            }
        }

        h2 {
            color: #0288d1; 
            margin-bottom: 30px;
            font-weight: 600;
        }

        .container {
            margin-top: 50px;
        }

        table {
            border-radius: 10px;
            overflow: hidden;
            animation: glow-in 1.5s ease-in-out;
            width: 100%;
        }

        th {
            background-color: #b0bec5;
            color: #263238; 
        }

        td {
            background-color: #ffffff;
        }

        .highlight:hover {
            background-color: #e1f5fe !important; 
            transition: background-color 0.3s ease, transform 0.3s ease;
            transform: scale(1.02); 
        }

        @keyframes glow-in {
            0% { opacity: 0; transform: scale(0.95); }
            100% { opacity: 1; transform: scale(1); }
        }

        .btn {
            border-radius: 30px;
            background-color: #0277bd; 
            margin-bottom: 10px;
        }

        .btn:hover {
            background-color: #ffffff; 
            color: #01579b; 
            border: 2px solid #0277bd; 
        }

        .fade-in {
            animation: fadeIn 1.2s ease-out forwards;
        }

        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }

        .btn.redd {
            margin-top: 10px;
            background-color: #d32; 
            color: white; 
            border-radius: 30px;
            margin-bottom: 10px;
        }

        .btn.redd:hover {
            background-color: #ffffff; 
            color: #d32f2f; 
            border: 2px solid #d32f2f; 
        }
    </style>
</head>
<body>

    <div id="circles-container"></div>

    <div class="container fade-in">
        <h2 class="center-align">Lista de Canciones</h2>
        
        <div class="right-align">
            <a href="add.php" class="waves-effect waves-light btn">Agregar Canción</a>
        </div>

        <table class="highlight centered responsive-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Canción</th>
                    <th>Álbum</th>
                    <th>Artista</th>
                    <th>Duración</th>
                    <th>Género</th>
                    <th>Contenido Explícito</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['cancion']); ?></td>
                        <td><?php echo htmlspecialchars($row['album']); ?></td>
                        <td><?php echo htmlspecialchars($row['artista']); ?></td>
                        <td><?php echo $row['duracion']; ?></td>
                        <td><?php echo htmlspecialchars($row['genero']); ?></td>
                        <td><?php echo $row['contenido_explicito'] ? 'Sí' : 'No'; ?></td>
                        <td><a href="edit.php?id=<?php echo $row['id']; ?>" class="waves-effect waves-light btn">Editar</a></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        
        <div class="center-align">
            <a href="del.php" class="waves-effect waves-light btn redd">Eliminar Canción</a>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const circlesContainer = document.getElementById('circles-container');
            const numberOfCircles = 100; 

            for (let i = 0; i < numberOfCircles; i++) {
                const circle = document.createElement('div');
                circle.classList.add('circle');

                const size = Math.random() * 60 + 20; 
                const leftPosition = Math.random() * 100; 
                const duration = Math.random() * 30 + 10; 

                circle.style.width = `${size}px`;
                circle.style.height = `${size}px`;
                circle.style.left = `${leftPosition}%`;
                circle.style.animationDuration = `${duration}s`;

                circlesContainer.appendChild(circle);
            }
        });
    </script>

</body>
</html>
