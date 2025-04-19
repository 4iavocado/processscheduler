<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CS222 Operating System</title>
    <style>
        /* Reset some basic styling */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            height: 100vh;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
        }

        .container {
            text-align: center;
            background-color: rgba(255, 255, 255, 0.05);
            padding: 50px 60px;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
        }

        .container h1 {
            font-size: 36px;
            margin-bottom: 40px;
            letter-spacing: 1px;
        }

        .button {
            display: inline-block;
            margin: 15px;
            padding: 15px 40px;
            font-size: 18px;
            color: white;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid white;
            border-radius: 50px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .button:hover {
            background-color: white;
            color: #1e3c72;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Operating System</h1>
        <a href="cpuscheduling.php" class="button">CPU Scheduling</a>
        <a href="virtualmemory.php" class="button">Virtual Management</a>
    </div>
</body>
</html>
