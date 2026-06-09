### Step 3.3: Paste the Bot Code
1. Tap inside the large, empty text box area below the filename.
2. Copy the entire block of PHP code below and paste it directly into that text box:

```php
<?php
// 1. Capture data from Telegram
$content = file_get_contents("php://input");
$update = json_decode($content, true);

if (!$update) {
    exit;
}

$message = $update['message']['text'] ?? '';
$chat_id = $update['message']['chat']['id'] ?? '';

// 2. Your specific Bot Token
$bot_token = "8721519751:AAFMVhPw92o5JvaRKqc-IfcyTpgnkxKGjf4"; 

// 3. Questions and Answers
$qa_pairs = [
    "hello" => "Hi there! I am your mobile Q&A bot. Ask me something!",
    "what is php?" => "PHP is a scripting language used to build web tools like this bot.",
    "help" => "Try typing 'hello' or 'what is php?'."
];

$clean_message = strtolower(trim($message));
$response = "I'm sorry, I don't know the answer to that question yet.";

if (array_key_exists($clean_message, $qa_pairs)) {
    $response = $qa_pairs[$clean_message];
}

// 4. Send response back
$url = "https://api.telegram.org/bot" . $bot_token . "/sendMessage";
$data = ['chat_id' => $chat_id, 'text' => $response];

$options = [
    'http' => [
        'method'  => 'POST',
        'header'  => "Content-Type: application/x-www-form-urlencoded\r\n",
        'content' => http_build_query($data),
    ],
];

$context  = stream_context_create($options);
file_get_contents($url, false, $context);
?>
