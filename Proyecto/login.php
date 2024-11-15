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

$username = $_POST['username'];
$password = $_POST['password'];

try {
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $user['password'] === $password) {
        echo "<div class='message success'>Bienvenido, " . htmlspecialchars($username) . "!</div>";
        echo '<script>
                document.body.classList.add("success-background");
                setTimeout(function() {
                    window.location.href = "main.php";
                }, 2500);
              </script>';
    } else {
        echo "<div class='message error'>Usuario o contraseña incorrectos.</div>";
        echo '<script>
                document.body.classList.add("error-background");
              </script>';
    }
} catch (PDOException $e) {
    echo "Error al realizar la consulta: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Resultado</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            color: #37474f; 
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            text-align: center;
            overflow: hidden;
            transition: background 3s ease;
        }

        .success-background {
            background: linear-gradient(45deg, #0288d1, #4caf50);
            background-size: 400% 400%;
            animation: gradient 6s ease infinite;
        }

        .error-background {
            background: linear-gradient(45deg, #0288d1, #f44336);
            background-size: 400% 400%;
            animation: gradient 6s ease infinite;
        }

        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .message {
            font-size: 3rem;
            font-weight: 600;
            padding: 30px;
            border-radius: 10px;
            width: 70%;
            max-width: 500px;
            margin-top: 20px;
            animation: fadeIn 2s ease-out forwards, pulse 1.5s ease-in-out infinite;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .success {
            background-color: #4caf50; 
            color: white;
        }

        .error {
            background-color: #f44336; 
            color: white;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(-30px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        @keyframes underline {
            0% { width: 0%; }
            50% { width: 100%; }
            100% { width: 0%; }
        }

    </style>
</head>
<body>
</body>
</html>
