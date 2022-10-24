<?php
    require_once 'cfg.php';

    $output = json_decode(file_get_contents('php://input'), TRUE);
    $chat_id = $output['message']['chat']['id'];
    $username = $output['message']['chat']['username'];
    $message = $output['message']['text'];
    $first_name = $output['message']['chat']['first_name'];
    $number = $output['message']['contact']['phone_number'];

    $command = explode(" ", $message);
    $command = $command[0]; 


    $data = $output['callback_query']['data'];
    $data_chat_id = $output['callback_query']['message']['chat']['id'];
    $data_message_id = $output['callback_query']['message']['message_id'];
    $call_back_from = $output['callback_query']['id'] ;
    $data_first_name = $output['callback_query']['from']['first_name'] ;

    $info = $mysqli->query("SELECT * FROM users WHERE chat_id = '".$chat_id."' ");
    $arr = $info->fetch_array();

    if($arr['status'] == 1){
        $admin = $arr['chat_id'];
    }

    function getChatMember($chat_id, $user_id) {
        global $api;
        $result = json_decode(file_get_contents($api.'getChatMember?chat_id='.$chat_id.'&user_id='.$user_id));
        return $result->result->status;
    }

    function check($chat_id, $user_id){
        $stats = getChatMember($chat_id, $user_id);
        if ($stats=="creator" or $stats=="administrator" or $stats=="member") {
            return true;
        }
        return false;
    }
    
    function send_answerCallbackQuery($call_back_from, $text, $message){
        global $api;
        file_get_contents($api.'answerCallbackQuery?callback_query_id='.$call_back_from.'&text='.$text.'&show_alert='.urlencode($message));
    }

    function sendMessage($chat_id, $keyboard, $message) {
    	 global $api;
      	 file_get_contents($api.'sendMessage?chat_id='.$chat_id.'&reply_markup='.$keyboard.'&parse_mode=HTML&text='.urlencode($message));
    }

   function editMessageText($chat_id, $message_id, $text, $button) {
        global $api;
        file_get_contents($api.'editMessageText?chat_id='.$chat_id.'&message_id='.$message_id.'&text='.urlencode($text).'&reply_markup='.$button.'&parse_mode=HTML');
    }

    function editMessageCaption($chat_id, $message_id, $caption, $button) {
        global $api;
        file_get_contents($api.'editMessageCaption?chat_id='.$chat_id.'&message_id='.$message_id.'&caption='.urlencode($caption).'&reply_markup='.$button.'&parse_mode=HTML');
    }

    function deleteMessage($chat_id, $message_id) {
        global $api;
        file_get_contents($api.'deleteMessage?chat_id='.$chat_id.'&message_id='.$message_id);       
    }


    switch ($command) {
        case '/start':
        break;

    }

    switch ($message) {

     }

    if( $data ) 
    {
        $lang = $mysqli->query("SELECT * FROM users WHERE chat_id = '".$data_chat_id."' ");
        $arr = $lang->fetch_array();
    }

    switch ($data) {

    }

     switch ($page) {

        case 'main':
            
            break;

    	default:
    		$text = "Здравствуйте, <b>$first_name !</b>\n\nВыберите интересующий Вас пункт меню:";
    		sendMessage($chat_id, $keyboard, $text);
    	break;
    }
?>