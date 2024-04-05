<?php
ob_start();
$token = "5876587828:AAEJPu3dwgSnpIjx2LGpHNbxDHBY3s0J2Bg"; 
define("API_KEY", $token);

function bot($method, $datas = [])
{
    $sswwp = http_build_query($datas);
    $url = "https://api.telegram.org/bot" . API_KEY . "/" . $method . "?$sswwp";
    $sswwp = file_get_contents($url);
    return json_decode($sswwp);
}

$update = json_decode(file_get_contents('php://input'));

@$message = $update->message;
@$from_id = $message->from->id;
@$chat_id = $message->chat->id;
@$message_id = $message->message_id;
@$first_name = $message->from->first_name;
@$last_name = $message->from->last_name;
@$username = $message->from->username;
@$text = $message->text;
@$firstname = $update->callback_query->from->first_name;
@$usernames = $update->callback_query->from->username;
@$chatid = $update->callback_query->message->chat->id;
@$fromid = $update->callback_query->from->id;
$message = $update->message;
$from_id = $update->callback_query->from->id;
$from_id = $message->from->id;
$name = $message->from->first_name;

if (isset($update->callback_query)) {
    $up = $update->callback_query;
    $chat_id = $up->message->chat->id;
    $from_id = $up->from->id;
    $user = $up->from->username;
    $text = $up->message->text;
    $name = $up->from->first_name;
    $message_id = $up->message->message_id;
    $data = $up->data;
}

$BotDatabase = json_decode(file_get_contents("DataBaseBot.json"), 1);

if ($text == "/start") {
    bot('sendMessage', [
        'chat_id' => $chat_id,                              
        'text' => "اهلا بك عزيزي في بوت ميرو للتقيم  مطور البوت @GJEGG                                       قناه مطور البوت @AFTU2"   
        
        'parse_mode' => "markdown",
        'disable_web_page_preview' => true,
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => 'start / بدء', 'callback_data' => "start"]],
            ]
        ])
    ]);
}

if ($data == "start") {
    bot('editMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'text' => "ما تقيمك للبوت",
        'disable_web_page_preview' => true,
        'parse_mode' => "markdown",
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => 'سيء😡', 'callback_data' => "k1"]],
                [['text' => 'جيد😐', 'callback_data' => "k2"]],
                [['text' => 'جيد جدا 🙂', 'callback_data' => "k3"]],
                [['text' => 'رائع 😄', 'callback_data' => "k4"]],
                [['text' => 'رائع جدا 😀', 'callback_data' => "k5"]],
            ]
        ])
    ]);
}



if ($data == "k5" || $data == "k4" || $data == "k3" || $data == "k2" || $data == "k1") {
    $rating = "";
    switch ($data) {
        case "k5":
            $rating = "رائع جدا 😀";
            break;
        case "k4":
            $rating = "رائع 😄";
            break;
        case "k3":
            $rating = "جيد جدا 🙂";
            break;
        case "k2":
            $rating = "جيد😐";
            break;
        case "k1":
            $rating = "سيء😡";
            break;
    }

   
   
    $owner_chat_id = 7044392568;  
    $owner_message = "تقييم جديد:\nFrom: $name\nRating: $rating";

    bot('sendMessage', [
        'chat_id' => $owner_chat_id,
        'text' => $owner_message,
        'parse_mode' => "markdown",
    ]);

  
    bot('editMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'text' => "~شكرا لتقيمك 👾🤍",
        'disable_web_page_preview' => true,
        'parse_mode' => "markdown",
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => 'رجوع', 'callback_data' => "start"]],
            ]
        ])
    ]);
}