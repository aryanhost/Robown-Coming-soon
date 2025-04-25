<?php
$options = get_option('robown_cs_settings');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo esc_html($options['site_title']); ?> - Coming Soon</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #1a1a1a, #2c3e50);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 50%;
            animation: floatAround 20s infinite linear;
        }

        @keyframes floatAround {
            0% {
                transform: translate(0, 0) rotate(0deg);
                opacity: 0;
            }
            20% {
                opacity: 0.8;
            }
            80% {
                opacity: 0.8;
            }
            100% {
                transform: translate(var(--moveX), var(--moveY)) rotate(360deg);
                opacity: 0;
            }
        }

        .glow {
            position: absolute;
            width: 150px;
            height: 150px;
            background: radial-gradient(circle, rgba(52, 152, 219, 0.3) 0%, transparent 70%);
            border-radius: 50%;
            animation: glow 4s infinite ease-in-out;
        }

        @keyframes glow {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.5); opacity: 0.8; }
        }

        .container {
            max-width: 800px;
            padding: 40px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            backdrop-filter: blur(10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 2;
            transition: all 0.5s ease;
            animation: fadeIn 1.5s ease-out;
            overflow: hidden;
        }

        .container:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.3);
        }

        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255, 255, 255, 0.2),
                transparent
            );
            transition: 0.5s;
        }

        .container:hover::before {
            left: 100%;
            transition: 0.5s;
        }

        .logo {
            font-size: 3.5rem;
            font-weight: bold;
            margin-bottom: 20px;
            background: linear-gradient(45deg, #3498db, #2ecc71);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-transform: uppercase;
            letter-spacing: 2px;
            animation: colorShift 5s infinite, slideDown 1s ease-out;
        }

        @keyframes colorShift {
            0% { filter: hue-rotate(0deg); }
            25% { filter: hue-rotate(90deg); }
            50% { filter: hue-rotate(180deg); }
            75% { filter: hue-rotate(270deg); }
            100% { filter: hue-rotate(360deg); }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideDown {
            from { transform: translateY(-50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        @keyframes slideUp {
            from { transform: translateY(50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 3px;
            animation: slideDown 1s ease-out 0.3s both;
        }

        p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            line-height: 1.6;
            color: #cccccc;
            animation: fadeIn 1s ease-out 0.6s both;
        }

        .countdown-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 40px 0;
            animation: slideUp 1s ease-out 0.9s both;
        }

        .countdown-box {
            background: rgba(255, 255, 255, 0.1);
            padding: 15px 20px;
            border-radius: 8px;
            min-width: 100px;
            transition: all 0.3s ease;
        }

        .countdown-box:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .countdown-value {
            font-size: 2.2rem;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .countdown-label {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #cccccc;
        }

        .login-link {
            display: inline-block;
            margin-top: 20px;
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .login-link:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        .login-popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 10px;
            z-index: 1000;
            color: #333;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
        }

        .login-popup.active {
            display: block;
            animation: popupFadeIn 0.3s ease-out;
        }

        @keyframes popupFadeIn {
            from { opacity: 0; transform: translate(-50%, -48%); }
            to { opacity: 1; transform: translate(-50%, -50%); }
        }

        .popup-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 999;
            backdrop-filter: blur(5px);
        }

        .popup-overlay.active {
            display: block;
        }

        /* Login Form Styles */
        .login-popup form {
            max-width: 300px;
            margin: 0 auto;
        }

        .login-popup form p {
            margin-bottom: 15px;
            color: #333;
        }

        .login-popup form label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-size: 14px;
            font-weight: bold;
        }

        .login-popup form input[type="text"],
        .login-popup form input[type="password"] {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            margin-bottom: 10px;
            transition: border-color 0.3s ease;
        }

        .login-popup form input[type="text"]:focus,
        .login-popup form input[type="password"]:focus {
            border-color: #3498db;
            outline: none;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.3);
        }

        .login-popup form .login-submit {
            text-align: center;
        }

        .login-popup form .button-primary {
            background: linear-gradient(135deg, #3498db, #2ecc71);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .login-popup form .button-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .login-popup form .login-remember {
            display: flex;
            align-items: center;
            margin: 10px 0;
        }

        .login-popup form .login-remember label {
            margin: 0 0 0 5px;
            font-weight: normal;
        }

        .login-popup form .login-remember input[type="checkbox"] {
            margin: 0;
        }

        .login-popup button {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .login-popup button:hover {
            background: #c0392b;
        }

        /* Improve popup styling */
        .login-popup {
            min-width: 320px;
            background: white;
        }

        .login-popup h3 {
            margin: 0 0 20px;
            color: #333;
            font-size: 1.5rem;
            text-align: center;
        }

        @media (max-width: 768px) {
            .container {
                padding: 30px;
            }

            .logo {
                font-size: 2.5rem;
            }

            h1 {
                font-size: 1.8rem;
            }

            p {
                font-size: 1rem;
            }

            .countdown-container {
                gap: 10px;
            }

            .countdown-box {
                min-width: 70px;
                padding: 10px;
            }

            .countdown-value {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="particles"></div>
    <div class="glow"></div>
    <div class="container">
        <div class="logo"><?php echo esc_html($options['site_title']); ?></div>
        <h1><?php echo esc_html($options['heading']); ?></h1>
        <p><?php echo esc_html($options['description']); ?></p>
        <div class="countdown-container">
            <div class="countdown-box">
                <div class="countdown-value" id="days">00</div>
                <div class="countdown-label">Days</div>
            </div>
            <div class="countdown-box">
                <div class="countdown-value" id="hours">00</div>
                <div class="countdown-label">Hours</div>
            </div>
            <div class="countdown-box">
                <div class="countdown-value" id="minutes">00</div>
                <div class="countdown-label">Minutes</div>
            </div>
            <div class="countdown-box">
                <div class="countdown-value" id="seconds">00</div>
                <div class="countdown-label">Seconds</div>
            </div>
        </div>
        <a href="#" class="login-link" onclick="showLoginPopup(event)">Login</a>
    </div>

    <!-- Login Popup -->
    <div class="popup-overlay" id="popupOverlay"></div>
    <div class="login-popup" id="loginPopup">
        <h3>Login to Website</h3>
        <?php wp_login_form(array(
            'remember' => true,
            'redirect' => home_url(),
        )); ?>
        <button onclick="hideLoginPopup()" style="margin-top: 10px;">Close</button>
    </div>

    <script>
        // Particles Creation
        const particlesContainer = document.querySelector('.particles');
        const particleCount = 150;

        for (let i = 0; i < particleCount; i++) {
            const particle = document.createElement('div');
            particle.className = 'particle';
            
            if (Math.random() < 0.1) {
                const size = 0.5 + Math.random();
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;
                particle.style.opacity = 0.05 + Math.random() * 0.15;
                particle.style.filter = `blur(${Math.random() * 4}px)`;
            } else {
                const size = 1 + Math.random() * 3;
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;
                particle.style.opacity = 0.1 + Math.random() * 0.4;
                particle.style.filter = `blur(${Math.random() * 3}px)`;
            }
            
            particle.style.left = `${Math.random() * 100}%`;
            particle.style.top = `${Math.random() * 100}%`;
            
            const moveX = (Math.random() - 0.5) * 500;
            const moveY = (Math.random() - 0.5) * 500;
            particle.style.setProperty('--moveX', `${moveX}px`);
            particle.style.setProperty('--moveY', `${moveY}px`);
            
            particle.style.animationDelay = `${Math.random() * 20}s`;
            particle.style.animationDuration = `${15 + Math.random() * 15}s`;
            
            particlesContainer.appendChild(particle);
        }

        // Countdown Logic
        const countDownDate = new Date('<?php echo esc_js($options['launch_date']); ?>').getTime();
        let countdownInterval;

        function updateCountdown() {
            const now = new Date().getTime();
            const distance = countDownDate - now;

            if (distance < 0) {
                clearInterval(countdownInterval);
                document.getElementById('days').textContent = '00';
                document.getElementById('hours').textContent = '00';
                document.getElementById('minutes').textContent = '00';
                document.getElementById('seconds').textContent = '00';
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById('days').textContent = String(days).padStart(2, '0');
            document.getElementById('hours').textContent = String(hours).padStart(2, '0');
            document.getElementById('minutes').textContent = String(minutes).padStart(2, '0');
            document.getElementById('seconds').textContent = String(seconds).padStart(2, '0');
        }

        updateCountdown();
        countdownInterval = setInterval(updateCountdown, 1000);

        // Login Popup Functions
        function showLoginPopup(e) {
            e.preventDefault();
            document.getElementById('popupOverlay').classList.add('active');
            document.getElementById('loginPopup').classList.add('active');
        }

        function hideLoginPopup() {
            document.getElementById('popupOverlay').classList.remove('active');
            document.getElementById('loginPopup').classList.remove('active');
        }

        // Close popup when clicking overlay
        document.getElementById('popupOverlay').addEventListener('click', hideLoginPopup);
    </script>
</body>
</html> 