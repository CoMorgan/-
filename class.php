<?php

/**
 * Sirojov Mahmud (MoRGaN)
 * 01.04.2019
 * Telegram: @C_MoRGaN
 **/
namespace app;

class TelegramBot {


    public function go($method,$datas=[]){
        $botToken = "1120423625:AAFZi-pkXOwDKCjrT4Ys2e8Z4asSq2D2JHc";
        $url = "https://api.telegram.org/bot".$botToken."/".$method;
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
        $res = curl_exec($ch);
        if(curl_error($ch)){
            var_dump(curl_error($ch));
        }else{
            return json_decode($res);
        }
    }


    public function getData($data){
        return json_decode(file_get_contents($data), TRUE);
    }

    //Xabar yuborish uchun @String
    public function sendMessage($type){
        return $this->go('sendMessage', $type);
    }


    //Nima yuborayotganini ko'rsatish typing...
    public function sendChatAction($type){
        return $this->go('sendChatAction', $type);
    }

    //Rasm yuborish
    public function sendPhoto($type){
        return $this->go('sendPhoto', $type);
    }


    //mp3 va boshqa audio fayllarni yuborish
    public function sendAudio($type){
        return $this->go('sendAudio', $type);
    }

    //Video fayllarni yuborish
    public function sendVideo($type){
        return $this->go('sendVideo', $type);
    }

    //Voice faqat .ogg formatda yuboradi
    public function sendVoice($type){
        return $this->go('sendVoice', $type);
    }


    //Botga yuborilgan fayllarni qabul qilish
    public function getFile($type){
        return $this->go('getFile', $type);
    }
    //Xabarlarni forward qilish
    public function forwardMessage($type){
        return $this->go('forwardMessage', $type);
    }
    //Inline keyboard chiqarish
    public function InlineKeyboard($type){
        return json_encode(['inline_keyboard' => $type]);
    }

    //Notification chiqarish uchun ishlatiladigan function
    public function answerCallbackQuery($type){
        return $this->go('answerCallbackQuery', $type);
    }

    public function deleteMessage($type){
        return $this->go('deleteMessage', $type);
    }

    public function getChatMember($type){
        return $this->go('getChatMember', $type);
    }

    //Chatda odam sonini aniqlash
    public function getChatMembersCount($type){
        return $this->go('getChatMembersCount', $type);
    }

    //Message_id orqali messageni o'zgartirish
    public function editMessageMedia($type){
        return $this->go('editMessageMedia', $type);
    }


    //Inline Query uchun function
    public function answerInlineQuery($inline_id, $json){
        return $this->go('answerInlineQuery', [
            'inline_query_id'=>$inline_id,
            'results' => json_encode($json)
        ]);
    }


    public function keyboard($key) {
        return json_encode(['one_time_keyboard'=>false, 'resize_keyboard'=>true,
            'keyboard'=>$key]);

    }
    public function rg($met, $sid, $matn, $markup = false, $md = false) {

        return $this->go($met,[
            'chat_id' => $sid,
            'message_id'=>$md,
            'text' => $matn,
            'parse_mode'=>"markdown",
            'reply_markup'=>$markup,
            'disable_web_page_preview'=>true
        ]);
    }



    public function rulat($str)
    {
        $ru = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'Ў', 'Ҳ', 'Қ', 'Ғ', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я', 'ў', 'қ', 'ғ', 'ҳ', ' ');
        $en = array('A', 'B', 'V', 'G', 'D', 'E', 'Yo', 'J', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sh', '', 'I', '', 'E', 'Yu', 'Ya', 'O\'', 'X', 'Q', 'G\'', 'a', 'b', 'v', 'g', 'd', 'e', 'yo', 'j', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sh', '', 'i', '', 'e', 'yu', 'ya', 'o\'', 'q', 'g\'', 'x', ' ');
        $res = str_replace($ru, $en, $str);
        $simvol = array('\\', '/', '@', '$', '#', '.', '"', '-');
        $res = str_replace($simvol, '', $res);
        return $res; //kodlarizni shu yerga yozing
    }

    public function lng($lng, $select = false) {

        global $pdo;

        $update = json_decode(file_get_contents('php://input'));
        if ($update->callback_query == false) $cid = $update->message->chat->id; else $cid = $update->callback_query->message->chat->id;

        $stmt = $pdo->query("SELECT * FROM users WHERE chat_id = $cid");
        $til = $stmt->fetch();
        if ($select == true) {
            $tyl = $select;
        } else {
            $tyl = $til["lng"];
        }
        //define('TIL',$tyl);
        $lncmf = file_get_contents("lang/" . $tyl . ".cmf");
        preg_match_all('|' . $lng . ':(.*);|Uis', $lncmf, $language);

        return trim($language[1][0]);

    }
    public function dMessage($ch_id, $m_id) {

            return $this->deleteMessage(['chat_id' => $ch_id, 'message_id' => $m_id]);

    }


}//CLASS CLOSE


?>