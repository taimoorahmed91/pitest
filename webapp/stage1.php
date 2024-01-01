<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet"> <!-- Poppins Font -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #282828;
            margin: 0;
            padding: 0;
            color: #fff;
            font-family: 'Poppins', sans-serif; /* Using Poppins font */
        }
        .container {
            display: grid;
            grid-template-columns: 1fr 1fr; /* 2 columns on larger screens */
            grid-template-rows: 1fr; /* 1 row */
            height: 100vh;
            grid-gap: 10px;
            padding: 10px;
        }
        .box {
            display: flex;
            flex-direction: column;
            justify-content: start;
            align-items: center;
            border: 1px solid #3a3a3a;
            border-radius: 15px;
            font-size: 1.2em; /* Adjusted font size */
            padding: 20px;
            box-sizing: border-box;
            background-color: #1a1a1a;
            min-height: 200px; /* Ensures a minimum height for each box */
        }
        .heading {
            font-size: 2.5em; /* Larger font size for headings */
            margin-bottom: 20px;
            font-weight: 700; /* Bold font weight for headings */
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                grid-template-columns: 1fr; /* Single column on smaller screens */
            }
            .box {
                min-height: 100px; /* Smaller min-height for smaller screens */
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="box" id="box1">
            <h1 class="heading">Devices</h1>
            <!-- Content for Devices -->
        </div>
        <div class="box" id="box2">
            <h1 class="heading">Buttons</h1>
            <!-- Content for Buttons -->
        </div>
    </div>
</body>
</html>

