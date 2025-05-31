<!DOCTYPE html>
<html>
<head>
    <title>Certificate Generator</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background-color: #f5f5f5; }
        .form-container { 
            max-width: 500px; 
            margin: 0 auto; 
            padding: 30px; 
            background: white; 
            border: 1px solid #ddd; 
            border-radius: 8px; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h2 { color: #2c3e50; text-align: center; margin-bottom: 25px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; color: #34495e; }
        input[type="text"], input[type="date"], textarea { 
            width: 100%; 
            padding: 10px; 
            box-sizing: border-box; 
            border: 1px solid #ddd; 
            border-radius: 4px; 
            font-size: 16px;
        }
        button { 
            background: #3498db; 
            color: white; 
            padding: 12px 20px; 
            border: none; 
            border-radius: 4px; 
            cursor: pointer; 
            font-size: 16px; 
            width: 100%;
            transition: background 0.3s;
        }
        button:hover { background: #2980b9; }
        .preview { 
            margin-top: 20px; 
            padding: 15px; 
            background: #f9f9f9; 
            border: 1px dashed #ccc; 
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Professional Certificate Generator</h2>
        <form method="post" action="generate.php">
            <div class="form-group">
                <label for="name">Recipient Name:</label>
                <input type="text" id="name" name="name" required placeholder="Enter recipient's full name">
            </div>
            <div class="form-group">
                <label for="course">Course/Program Name:</label>
                <input type="text" id="course" name="course" required placeholder="Enter course or program name">
            </div>
            <div class="form-group">
                <label for="date">Completion Date:</label>
                <input type="date" id="date" name="date" required>
            </div>
            <div class="form-group">
                <label for="description">Achievement Description:</label>
                <textarea id="description" name="description" rows="3" placeholder="Optional description of achievement"></textarea>
            </div>
            <button type="submit">Generate Certificate</button>
        </form>
        
        <div class="preview">
            <h3>Certificate Preview</h3>
            <p>After submission, your certificate will be generated and automatically downloaded.</p>
        </div>
    </div>
</body>
</html>