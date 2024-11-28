<?php
session_start();

if (!isset($_SESSION['random_number'])){
    $_SESSION['random_number'] = rand(1, 10);
    $_SESSION['attempts'] = 0;
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    if (isset($_POST['guess'])){
        $guess = (int)$_POST['guess'];
        $_SESSION['attempts']++;

        if ($guess < $_SESSION['random_number']){
            $message = "Too low! Try again.";
        }
        
        elseif ($guess > $_SESSION['random_number']){
            $message = "Too high! Try again.";
        }

        else{
            $message = "Congrats! You guess the number in {$_SESSION['attempts']} attempts.";
            session_destroy();
        }
    }

    elseif (isset($_POST['reset'])){
        session_destroy();
        header("Location: index.php");
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guessing Game</title>
</head>
<body>
    <h1>Guess the number</h1>
    <p>Guess the number between 1-10</p>

    <?php if ($message) : ?>
        <p><strong><?php echo htmlspecialchars($message); ?></strong></p>
    <?php endif; ?>

    <form method="post">
        <label for="guess">Enter your guess: </label>
        <input type="number" id="guess" name="guess" min="1" max="10" required>
        <button type="submit">Submit</button>
    </form>

    <form method="post" style="margin-top: 20px;">
        <button type="submit" name="reset">Reset Game</button>
    </form>
</body>
</html>