<?php
// Simula ng PHP script para sa grade calculator
// Pagsusuri kung may na-submit na form data
$result = '';
$error = '';
$quiz_score = '';
$assignment_score = '';
$exam_score = '';
$weighted_average = 0;
$letter_grade = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Kunin ang mga input values mula sa form
    $quiz_score = $_POST['quiz'] ?? '';
    $assignment_score = $_POST['assignment'] ?? '';
    $exam_score = $_POST['exam'] ?? '';
    
    // I-validate kung lahat ng fields ay filled
    if (empty($quiz_score) || empty($assignment_score) || empty($exam_score)) {
        $error = 'Lahat ng fields ay dapat na may laman.';
    }
    // I-validate kung numeric ang lahat ng inputs
    elseif (!is_numeric($quiz_score) || !is_numeric($assignment_score) || !is_numeric($exam_score)) {
        $error = 'Lahat ng scores ay dapat na numero.';
    }
    // I-validate kung nasa range ng 0-100 ang lahat ng scores
    elseif ($quiz_score < 0 || $quiz_score > 100 || 
            $assignment_score < 0 || $assignment_score > 100 || 
            $exam_score < 0 || $exam_score > 100) {
        $error = 'Lahat ng scores ay dapat nasa pagitan ng 0 at 100.';
    } else {
        // I-convert ang strings sa float para sa calculation
        $quiz_score = floatval($quiz_score);
        $assignment_score = floatval($assignment_score);
        $exam_score = floatval($exam_score);
        
        // I-calculate ang weighted average
        // Quiz: 30%, Assignment: 30%, Exam: 40%
        $weighted_average = ($quiz_score * 0.30) + ($assignment_score * 0.30) + ($exam_score * 0.40);
        
        // I-determine ang letter grade base sa grading scale
        if ($weighted_average >= 90) {
            $letter_grade = 'A';
        } elseif ($weighted_average >= 80) {
            $letter_grade = 'B';
        } elseif ($weighted_average >= 70) {
            $letter_grade = 'C';
        } elseif ($weighted_average >= 60) {
            $letter_grade = 'D';
        } else {
            $letter_grade = 'F';
        }
        
        // I-format ang result message
        $result = sprintf(
            'Weighted Average: %.2f<br>Letter Grade: %s',
            $weighted_average,
            $letter_grade
        );
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grade Calculator</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #000000 0%, #1a1a1a 100%);
            color: #ffffff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background: #ffffff;
            color: #000000;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            padding: 40px;
            max-width: 500px;
            width: 100%;
            border: 2px solid #000000;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 2.5em;
            font-weight: 700;
            color: #000000;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            font-size: 1.1em;
            color: #000000;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        input[type="number"] {
            width: 100%;
            padding: 15px;
            border: 2px solid #000000;
            border-radius: 8px;
            font-size: 1.1em;
            background: #ffffff;
            color: #000000;
            transition: all 0.3s ease;
        }

        input[type="number"]:focus {
            outline: none;
            border-color: #333333;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            background: #f9f9f9;
        }

        .weights-info {
            background: #f0f0f0;
            border: 2px solid #000000;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 25px;
            text-align: center;
        }

        .weights-info h3 {
            margin-bottom: 10px;
            color: #000000;
            font-size: 1.2em;
        }

        .weights-info p {
            margin: 5px 0;
            color: #333333;
            font-weight: 500;
        }

        .submit-btn {
            width: 100%;
            padding: 18px;
            background: #000000;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-size: 1.2em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .submit-btn:hover {
            background: #333333;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .result {
            margin-top: 25px;
            padding: 20px;
            background: #000000;
            color: #ffffff;
            border-radius: 8px;
            text-align: center;
            font-size: 1.3em;
            font-weight: 600;
            border: 2px solid #000000;
        }

        .error {
            margin-top: 25px;
            padding: 20px;
            background: #ffffff;
            color: #000000;
            border: 2px solid #000000;
            border-radius: 8px;
            text-align: center;
            font-size: 1.1em;
            font-weight: 600;
        }

        .grading-scale {
            background: #f9f9f9;
            border: 2px solid #000000;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 25px;
        }

        .grading-scale h3 {
            text-align: center;
            margin-bottom: 10px;
            color: #000000;
            font-size: 1.2em;
        }

        .grading-scale ul {
            list-style: none;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
            gap: 10px;
        }

        .grading-scale li {
            text-align: center;
            padding: 8px;
            background: #000000;
            color: #ffffff;
            border-radius: 5px;
            font-weight: 600;
        }

        @media (max-width: 600px) {
            .container {
                margin: 10px;
                padding: 30px 20px;
            }
            
            h1 {
                font-size: 2em;
            }
            
            .grading-scale ul {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Grade Calculator by Baltazar, Gabrielle Rae M. IT-204 WebSys</h1>
        
        <div class="weights-info">
            <h3>Grade Calculator</h3>
            <p>Quiz: 30%</p>
            <p>Assignment: 30%</p>
            <p>Exam: 40%</p>
        </div>

        <div class="grading-scale">
            <h3>Grading Scale</h3>
            <ul>
                <li>A: 90-100</li>
                <li>B: 80-89</li>
                <li>C: 70-79</li>
                <li>D: 60-69</li>
                <li>F: Below 60</li>
            </ul>
        </div>

        <form method="POST" action="">
            <div class="form-group">
                <label for="quiz">Quiz Score (0-100):</label>
                <input type="number" 
                       id="quiz" 
                       name="quiz" 
                       min="0" 
                       max="100" 
                       step="0.01" 
                       value="<?php echo htmlspecialchars($quiz_score); ?>"
                       required>
            </div>

            <div class="form-group">
                <label for="assignment">Assignment Score (0-100):</label>
                <input type="number" 
                       id="assignment" 
                       name="assignment" 
                       min="0" 
                       max="100" 
                       step="0.01" 
                       value="<?php echo htmlspecialchars($assignment_score); ?>"
                       required>
            </div>

            <div class="form-group">
                <label for="exam">Exam Score (0-100):</label>
                <input type="number" 
                       id="exam" 
                       name="exam" 
                       min="0" 
                       max="100" 
                       step="0.01" 
                       value="<?php echo htmlspecialchars($exam_score); ?>"
                       required>
            </div>

            <button type="submit" class="submit-btn">Calculate Grade</button>
        </form>

        <?php if (!empty($result)): ?>
            <div class="result">
                <?php echo $result; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="error">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
