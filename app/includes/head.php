<!-- includes/head.php -->
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $pageTitle ?? 'SudoMotors'; ?></title>

  <!-- PicoCSS principal -->
  <link rel="stylesheet" href="css/estilo_principal.css">

  <!-- Estilo para centrar todo -->
  <style>
    body {
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      text-align: center;
    }
    main {
      width: 100%;
      max-width: 500px;
    }
    footer {
      margin-top: 2rem;
      font-size: 0.9rem;
      color: var(--pico-muted-color);
    }
  </style>
    <link rel="icon" href="/media/favicon.png" type="image/png">
</head>
<body>
  <main>
