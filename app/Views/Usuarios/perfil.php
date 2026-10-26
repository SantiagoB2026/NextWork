
<?= view('templates/header') ?>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <style>
        :root {
            --bg-gradient: linear-gradient(135deg, #0f172a, #1e1b4b);
            --card-bg: rgba(255, 255, 255, 0.03);
            --card-border: rgba(255, 255, 255, 0.08);
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --accent: #6366f1;
            --accent-hover: #4f46e5;
            --success: #10b981;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }

        body {
            background: var(--bg-gradient);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .profile-container {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 24px;
            width: 100%;
            max-width: 450px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease;
        }

        .cover-photo {
            background: linear-gradient(45deg, #4338ca, #6366f1);
            height: 140px;
            width: 100%;
            position: relative;
        }

        .avatar-wrapper {
            position: relative;
            width: 110px;
            height: 110px;
            margin: -55px auto 0 auto;
        }

        .avatar {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #1e1b4b;
            background: #334155;
        }

        .status-badge {
            position: absolute;
            bottom: 5px;
            right: 5px;
            width: 16px;
            height: 16px;
            background-color: var(--success);
            border: 3px solid #1e1b4b;
            border-radius: 50%;
        }

        .profile-info {
            text-align: center;
            padding: 20px 24px;
        }

        .profile-name {
            font-size: 1.5rem;
            font-weight: 600;
            letter-spacing: -0.5px;
            margin-bottom: 4px;
        }

        .profile-username {
            color: var(--accent);
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 16px;
            display: inline-block;
        }

        .profile-bio {
            color: var(--text-muted);
            font-size: 0.95rem;
            line-height: 1.5;
            margin-bottom: 24px;
        }

        .stats-container {
            display: flex;
            justify-content: space-around;
            border-top: 1px solid var(--card-border);
            border-bottom: 1px solid var(--card-border);
            padding: 16px 0;
            margin-bottom: 24px;
        }

        .stat-box {
            text-align: center;
        }

        .stat-value {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--text-main);
        }

        .stat-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
            margin-top: 4px;
        }

        .action-buttons {
            display: flex;
            gap: 12px;
        }

        .btn {
            flex: 1;
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            text-align: center;
        }

        .btn-primary {
            background: var(--accent);
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background: var(--accent-hover);
        }

        .btn-secondary {
            background: transparent;
            color: var(--text-main);
            border: 1px solid var(--card-border);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: var(--text-muted);
        }
    </style>
<body>

    <div class="profile-container">
        <!-- Foto de Portada -->
        <div class="cover-photo"></div>

        <!-- Foto de Perfil / Avatar -->
        <div class="avatar-wrapper">
            <img class="avatar" src="https://unsplash.com" alt="Foto de perfil">
            <div class="status-badge" title="En línea"></div>
        </div>

        <!-- Detalles del Perfil -->
        <div class="profile-info">
            <h1 class="profile-name">Sofía Alarcón</h1>
            <span class="profile-username">@sofia.dev</span>
            
            <p class="profile-bio">
                Diseñadora UI/UX & Desarrolladora Frontend. Apasionada por crear interfaces digitales minimalistas, accesibles y centradas en el usuario. 🚀
            </p>

            <!-- Estadísticas -->
            <div class="stats-container">
                <div class="stat-box">
                    <div class="stat-value">14.2k</div>
                    <div class="stat-label">Seguidores</div>
                </div>
                <div class="stat-box">
                    <div class="stat-value">482</div>
                    <div class="stat-label">Siguiendo</div>
                </div>
                <div class="stat-box">
                    <div class="stat-value">94</div>
                    <div class="stat-label">Proyectos</div>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="action-buttons">
                <button class="btn btn-primary" onclick="alert('¡Siguiendo a Sofía!')">Seguir</button>
                <button class="btn btn-secondary" onclick="alert('Abriendo chat...')">Mensaje</button>
            </div>
        </div>
    </div>

</body>
</html>
