<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Strip line breaks to prevent email header injection
    $name = trim(str_replace(["\r", "\n"], ' ', $_POST['name'] ?? ''));
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
    $comments = trim($_POST['comments'] ?? '');

    if ($email === false || $name === '' || $comments === '') {
        echo "Please provide a valid name, email address, and message.";
        exit;
    }

    // Email settings — From must be a fixed address on this domain;
    // the visitor's address goes in Reply-To only.
    $to = "contact@hare.org";
    $subject = "Feedback and Suggestions";
    $headers = "From: noreply@hare.org" . "\r\n" .
               "Reply-To: $email" . "\r\n" .
               "Content-Type: text/plain; charset=UTF-8";

    $message = "You have received feedback from:\n\n";
    $message .= "Name: $name\n";
    $message .= "Email: $email\n";
    $message .= "Comments:\n$comments\n";

    // Send email
    if (mail($to, $subject, $message, $headers)) {
        echo "Thank you for your feedback!";
    } else {
        echo "There was an error sending your feedback. Please try again later.";
    }
}
?>
