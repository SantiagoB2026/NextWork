<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a Nextwork</title>
    <!-- Importación de tipografía -->
    <link href="https://googleapis.com" rel="stylesheet">
    
    <!-- ESTILOS INTERNOS (Para evitar problemas de rutas de carpetas) -->
    <style>
        :root {
            --bg-main: #F7F9F6;
            --bg-dark-panels: #1F2226;
            --text-dark: #1A1D20;
            --accent-green: #00B653;
            --btn-dark-bg: #1A1D20;
            --font-primary: 'Inter', sans-serif;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: var(--font-primary);
            background-color: var(--bg-main);
            color: var(--text-dark);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* HEADER */
        .main-header {
            width: 100%;
            background-color: var(--bg-dark-panels);
            position: relative;
        }

        .header-container {
            max-width: 1200px;
            height: 70px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand-logo {
            width: 15px;
            height: 15px;
        }

        .user-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: linear-gradient(to bottom, #8ED8F8 50%, #A2D06B 50%);
            box-shadow: inset 0 0 4px rgba(0,0,0,0.2);
        }

        .header-border {
            width: 100%;
            height: 6px;
            background-color: var(--accent-green);
        }

        /* BODY / CONTENIDO */
        .main-content {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }

        .welcome-container {
            text-align: center;
            max-width: 800px;
            width: 100%;
        }

        .title-welcome {
            font-size: clamp(2.5rem, 5vw, 4.2rem);
            font-weight: 400;
            color: var(--text-dark);
            line-height: 1.2;
            letter-spacing: -1px;
            margin-bottom: 40px;
        }

        .brand-name {
            display: block;
            font-weight: 700;
            margin-top: 10px;
        }

        /* BOTONES */
        .button-group {
            display: flex;
            gap: 30px;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-block;
            padding: 16px 42px;
            font-size: 1.25rem;
            font-weight: 700;
            text-decoration: none;
            border-radius: 50px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-dark {
            background-color: var(--btn-dark-bg);
            color: #FFFFFF;
        }

        .btn-dark:hover {
            box-shadow: 0 6px 20px rgba(26, 29, 32, 0.3);
        }

        .btn-green {
            background-color: var(--accent-green);
            color: #FFFFFF;
        }

        .btn-green:hover {
            box-shadow: 0 6px 20px rgba(0, 182, 83, 0.4);
        }

        /* FOOTER */
        .main-footer {
            width: 100%;
            background-color: var(--bg-dark-panels);
            margin-top: auto;
        }

        .footer-border {
            width: 100%;
            height: 6px;
            background-color: var(--accent-green);
        }

        .footer-container {
            height: 80px;
        }
    </style>
</head>
<body>

    <!-- 1. HEADER SEPARADO -->
    <header class="main-header">
        <div class="header-container">
            <div class="brand-logo">
            </div>
            <div class="user-avatar"></div>
        </div>
        <div class="header-border"></div>
    </header>