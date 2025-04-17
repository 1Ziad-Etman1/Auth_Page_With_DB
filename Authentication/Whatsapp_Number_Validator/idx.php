<?php
    require_once __DIR__ . '/validator.php'; // Include function file

    $result = null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get input from form
        $phoneNumbers = isset($_POST['phoneNumbers']) ? trim($_POST['phoneNumbers']) : '';

        if (!empty($phoneNumbers)) {
            // Convert input to an array
            $phoneArray = array_map('trim', explode(',', $phoneNumbers));

            // Call the validation function
            $result = validate_whatsapp_numbers($phoneArray);
        } else {
            $result = ['success' => false, 'message' => 'Please enter phone numbers.'];
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>WhatsApp Number Validator</title>
    </head>
    <body>
        <h2>WhatsApp Number Validator</h2>
        <form method="POST">
            <label for="phoneNumbers">Enter phone numbers (comma-separated):</label><br>
            <textarea name="phoneNumbers" rows="4" cols="50"><?php echo isset($_POST['phoneNumbers']) ? htmlspecialchars($_POST['phoneNumbers']) : ''; ?></textarea><br>
            <button type="submit">Validate</button>
        </form>

        <?php if ($result !== null): ?>
            <h3>Result:</h3>
            <pre><?php echo htmlspecialchars(json_encode($result, JSON_PRETTY_PRINT)); ?></pre>
        <?php endif; ?>
    </body>
</html>
