<?php
/**
 * Colin Morgan
 * 08.08.2021
 * Korona Virus
 * Telegram: @C_MoRGaN
 **/
require 'class.php';

use app\TelegramBot;

$pdo = new PDO('mysql:host=localhost;dbname=react3537_cmf', 'cmf', 'Morgan2000');

$video_qul = "BAACAgIAAxkBAAEEjNdetQoGCaFdDsA5o0S4bt3373SjkwACGgYAAnqqqEnoP3r3drPDbxkE";
$goopic = "AgACAgIAAxkBAAEEjN5etQvZs1FA2fYYoVIKHwVICTy_DwACoa0xG3qqqEn5Z3Dwt9x6FHb9bZEuAAMBAAMCAAN5AANT9gIAARkE";
date_default_timezone_set('Asia/Tashkent');

$bot = new TelegramBot;

$data = $bot->getData("php://input");

if ($data['message']) {
    $chat_id = $data['message']['chat']['id'];
    $userid = $data['message']['from']['id'];
    $username = $data['message']['from']['username'];
    $ism = $data['message']['from']['first_name'] . ' ' . $data['message']['from']['last_name'];
    $text = $data['message']['text'];
    $message_id = $data['message']['message_id'];
}

if ($data['callback_query']) {
//CALLBACK
    $callback = $data['callback_query'];
    $callid = $callback['id'];
    $i_m_id = $callback['inline_message_id'];
    $cdata = $callback['data'];
    $chat_id = $callback['message']['chat']['id'];
    $message_id = $callback['message']['message_id'];
    $text = $callback['message']['text'];
}
$admin = '266873587';//tasdiqlovchi admin
$adm = ['266873587', '389378714', '1115067337'];//

$cmx = $pdo->query("SELECT * FROM users WHERE chat_id = $chat_id");
$lng = $cmx->fetch()['lng'];
$menyu = $bot->keyboard([[['text' => $bot->lng(cat)], ['text' => $bot->lng(korzinka)]], [['text' => $bot->lng(order)], ['text' => $bot->lng(connect)]], [['text' => $bot->lng($lng)]]]);

if ($text == "/start") {
    $stmt = $pdo->prepare("SELECT count(*) FROM users WHERE chat_id = ?");
    $stmt->execute([$chat_id]);
    $count = $stmt->fetchColumn();
    if ($count == 0) {
        // users add to chat id
        $sql = "INSERT INTO users (chat_id, map) VALUES (?,?)";
        $pdo->prepare($sql)->execute([$chat_id, 0]);
        $lng_keyboard = $bot->keyboard([[['text' => "🇺🇿 O'zbek tili"], ['text' => "🇷🇺 Русский язык"]]]);
        $bot->rg('sendmessage', $chat_id, "Выберите язык:", $lng_keyboard);

    } else {
        if ($lng == false) {
            $lng_keyboard = $bot->keyboard([[['text' => "🇺🇿 O'zbek tili"], ['text' => "🇷🇺 Русский язык"]]]);
            $bot->rg('sendmessage', $chat_id, "Выберите язык:", $lng_keyboard);
            $array = array($message_id - 1);
            foreach ($array as $me_id) {
                $bot->dMessage($chat_id, $me_id);
            }

        } else {

            $bot->rg('sendmessage', $chat_id, str_replace('{name}', $ism, $bot->lng(happy)), $menyu);
            $sql = "UPDATE users SET map=? WHERE chat_id=?";
            $pdo->prepare($sql)->execute([0, $chat_id]);
            $array = array($message_id - 1);
            foreach ($array as $me_id) {
                $bot->dMessage($chat_id, $me_id);
            }
        }
    }

}


if ($text == "🇺🇿 O'zbek tili") {
    $uz_men = $bot->keyboard([[['text' => $bot->lng(cat, uz)], ['text' => $bot->lng(korzinka, uz)]], [['text' => $bot->lng(order, uz)], ['text' => $bot->lng(connect, uz)]], [['text' => $bot->lng(uz, uz)]]]);
    $bot->rg('sendmessage', $chat_id, "*Bosh menyu*", $uz_men);
    // Bazaga til yozadi
    $sql = "UPDATE users SET lng=? WHERE chat_id=?";
    $pdo->prepare($sql)->execute([uz, $chat_id]);
    $array = array($message_id - 1);
    foreach ($array as $me_id) {
        $bot->dMessage($chat_id, $me_id);
    }
}
if ($text == "🇷🇺 Русский язык") {
    $menyus = $bot->keyboard([[['text' => $bot->lng(cat, ru)], ['text' => $bot->lng(korzinka, ru)]], [['text' => $bot->lng(order, ru)], ['text' => $bot->lng(connect, ru)]], [['text' => $bot->lng(ru, ru)]]]);
    $bot->rg('sendmessage', $chat_id, "*Главное меню*", $menyus);
    // Bazaga til yozadi
    $sql = "UPDATE users SET lng=? WHERE chat_id=?";
    $pdo->prepare($sql)->execute([ru, $chat_id]);
    $array = array($message_id - 1);
    foreach ($array as $me_id) {
        $bot->dMessage($chat_id, $me_id);
    }
}
// Xaridlar menyu yozamiz
if ($text == $bot->lng(cat) || $text == $bot->lng(back)) {
    $mapping = $pdo->query("SELECT * FROM users WHERE chat_id = $chat_id")->fetch();
    if ($mapping['map'] == false || stripos($mapping['map'], '1-') !== false) {
        $a_cats = $pdo->query("SELECT * FROM katalog WHERE activ = '1' AND cat = '0'")->fetchAll();
        $a_array = [];
        for ($i = 0; $i < count($a_cats); $i++) {


            if ($i % 2 == 0) {
                if ($a_cats[$i + 1]['name_' . $lng] == true) {
                    $a_array[] = [['text' => $a_cats[$i]['name_' . $lng]], ['text' => $a_cats[$i + 1]['name_' . $lng]]];
                } else {
                    $a_array[] = [['text' => $a_cats[$i]['name_' . $lng]]];

                }
            }
        }

        $a_array[] = [['text' => $bot->lng(korzinka)], ['text' => $bot->lng(menu)]];
        $bot->rg('sendmessage', $chat_id, $bot->lng(select_cats), $bot->keyboard($a_array));
        // ortiqcha postlardan tozala
        $array = array($message_id, $message_id - 1);
        foreach ($array as $me_id) {
            $bot->dMessage($chat_id, $me_id);
        }
        $sql = "UPDATE users SET map=? WHERE chat_id=?";
        $pdo->prepare($sql)->execute([0, $chat_id]);

    }
}

if ($text == '/mid') {
    $bot->rg('sendmessage', $chat_id, '`' . json_encode($data['message']) . '`');
}
// Sub kategoriya ko'rsatamiz
$asosiy_cats = $pdo->query("SELECT * FROM katalog WHERE activ = '1' AND cat = '0'")->fetchAll();
$n_cats = [];
foreach ($asosiy_cats as $as_cats) {
    $n_cat[] = $as_cats['name_' . $lng];
}
if (in_array($text, $n_cat)) {
    $sub_cats = $pdo->query("SELECT * FROM katalog WHERE name_$lng = '$text' AND cat = '0'")->fetch();
    $a_cats = $pdo->query("SELECT * FROM katalog WHERE activ = '1' AND cat = '{$sub_cats['id']}'")->fetchAll();
    $a_array = [];
    $a_array[] = [['text' => $bot->lng(back)]];
    for ($i = 0; $i < count($a_cats); $i++) {


        if ($i % 2 == 0) {
            if ($a_cats[$i + 1]['name_' . $lng] == true) {
                $a_array[] = [['text' => $a_cats[$i]['name_' . $lng]], ['text' => $a_cats[$i + 1]['name_' . $lng]]];
            } else {
                $a_array[] = [['text' => $a_cats[$i]['name_' . $lng]]];

            }
        }
    }

    $a_array[] = [['text' => $bot->lng(korzinka)], ['text' => $bot->lng(menu)]];

    $bot->rg('sendmessage', $chat_id, $bot->lng(tovar_spis), $bot->keyboard($a_array));
    // delete post
    $array = array($message_id, $message_id - 1, $message_id - 2);
    foreach ($array as $me_id) {
        $bot->dMessage($chat_id, $me_id);
    }
    $sql = "UPDATE users SET map=? WHERE chat_id=?";
    $pdo->prepare($sql)->execute(['1-' . $sub_cats['id'], $chat_id]);

}
// Nachalo
if ($text == $bot->lng(menu)) {
    $bot->rg('sendmessage', $chat_id, '*' . $bot->lng(b_menu) . '*', $menyu);
    $array = array($message_id, $message_id - 1, $message_id - 2);
    foreach ($array as $me_id) {
        $bot->dMessage($chat_id, $me_id);
    }
    $sql = "UPDATE users SET map=? WHERE chat_id=?";
    $pdo->prepare($sql)->execute([0, $chat_id]);
}

// Tovarlar chiqish qism
$mapping = $pdo->query("SELECT * FROM users WHERE chat_id = $chat_id")->fetch();
$map = str_replace(array('1-', '2-', '3-'), '', $mapping['map']);
$su_cat = $pdo->query("SELECT * FROM katalog WHERE activ = '1' AND cat = '$map'")->fetchAll();
$s_name = [];
foreach ($su_cat as $sub_cat) {
    if ($text == $sub_cat['name_' . $lng]) {
        $tovar_id = $sub_cat['id'];

        $stmt = $pdo->prepare("SELECT count(*) FROM tovar WHERE cat = ?");
        $stmt->execute([$tovar_id]);
        $count_tovar = $stmt->fetchColumn();
        if ($count_tovar > 1) {
            $inline_tovar = $bot->InlineKeyboard([[['text' => $bot->lng(add_kor), 'callback_data' => "add_kor"]], [['text' => "◀️", 'callback_data' => "prev-" . $tovar_id . "-0"], ['text' => "1 / " . $count_tovar, 'callback_data' => "#"], ['text' => "▶️", 'callback_data' => "next-" . $tovar_id . "-0"]]]);
        } else {
            $inline_tovar = $bot->InlineKeyboard([[['text' => $bot->lng(add_kor), 'callback_data' => "add_kor"]], [['text' => "1 / 1", 'callback_data' => "#"]]]);
        }
        $file = $pdo->query("SELECT * FROM tovar WHERE cat = '$tovar_id'")->fetch();
        $caption = "{$file['name_'.$lng]}

*{$bot->lng('sena')}:* {$file['narx']} {$bot->lng(sum)}";
        if ($file['name_' . $lng] == true) {
            $keyboard = $bot->keyboard([[['text' => $bot->lng(back)]], [['text' => $bot->lng(korzinka)], ['text' => $bot->lng(menu)]]]);


            $bot->rg('sendmessage', $chat_id, $bot->lng('select_tovar'), $keyboard);
            $bot->sendPhoto(['chat_id' => $chat_id, 'photo' => $file['rasm'], 'caption' => $caption, 'reply_markup' => $inline_tovar, 'parse_mode' => markdown]);
            // delete post
            $array = array($message_id, $message_id - 1);
            foreach ($array as $me_id) {
                $bot->dMessage($chat_id, $me_id);
            }
            $sql = "UPDATE users SET map=? WHERE chat_id=?";
            $pdo->prepare($sql)->execute(['3-' . $tovar_id, $chat_id]);
        } else {
            $s_z_kat = $pdo->query("SELECT * FROM katalog WHERE cat = '$tovar_id'")->fetchAll();
            // if ($text == $zb_kat['name_' . $lng]) {
            $key_p = [];
            $key_p[] = [['text' => $bot->lng(back)]];
            for ($i = 0; $i < count($s_z_kat); $i++) {
                if ($i % 2 == 0) {
                    if ($a_cats[$i + 1]['name_' . $lng] == true) {
                        $key_p[] = [['text' => $s_z_kat[$i]['name_' . $lng]], ['text' => $s_z_kat[$i + 1]['name_' . $lng]]];
                    } else {
                        $key_p[] = [['text' => $s_z_kat[$i]['name_' . $lng]]];
                    }
                }
            }

            $key_p[] = [['text' => $bot->lng(korzinka)], ['text' => $bot->lng(menu)]];
            $keyboard = $bot->keyboard($key_p);
            //}
            $stmt = $pdo->prepare("SELECT count(*) FROM katalog WHERE cat = ?");
            $stmt->execute([$tovar_id]);
            $count_zb = $stmt->fetchColumn();
            if ($count_zb > 0) {
                $bot->rg('sendmessage', $chat_id, $bot->lng(tovar_spis), $keyboard);
                $sql = "UPDATE users SET map=? WHERE chat_id=?";
                $pdo->prepare($sql)->execute(['3-' . $tovar_id, $chat_id]);
            } else {
                // Pusto //Pusto //Pusto
                $a_cats = $pdo->query("SELECT * FROM katalog WHERE activ = '1' AND cat = '{$map}'")->fetchAll();
            $key_p = [];
            $key_p[] = [['text' => $bot->lng(back)]];
            for ($i = 0; $i < count($a_cats); $i++) {
                if ($i % 2 == 0) {
                    if ($a_cats[$i + 1]['name_' . $lng] == true) {
                        $key_p[] = [['text' => $a_cats[$i]['name_' . $lng]], ['text' => $a_cats[$i + 1]['name_' . $lng]]];
                    } else {
                        $key_p[] = [['text' => $a_cats[$i]['name_' . $lng]]];
                    }
                }
            }

            $key_p[] = [['text' => $bot->lng(korzinka)], ['text' => $bot->lng(menu)]];
            $keyboard = $bot->keyboard($key_p);
            $bot->rg('sendmessage', $chat_id, $bot->lng(pusta), $keyboard);
        }
            $array = array($message_id, $message_id - 1);
            foreach ($array as $me_id) {
                $bot->dMessage($chat_id, $me_id);
            }
        }//
    }
}

// Tovardan orqaga qaytish
$mapping = $pdo->query("SELECT * FROM users WHERE chat_id = $chat_id")->fetch();
$map_back = str_replace(array('2-', '3-'), '', $mapping['map']);
if (stripos($mapping['map'], '2-') !== false || stripos($mapping['map'], '3-') !== false) {
    if ($text == $bot->lng(back)) {
        $sub_cats = $pdo->query("SELECT * FROM katalog WHERE id = '$map_back'")->fetch();
        $a_cats = $pdo->query("SELECT * FROM katalog WHERE activ = '1' AND cat = '{$sub_cats['cat']}'")->fetchAll();

        $a_array = [];
       if ($a_cats[0]['cat'] == true) $a_array[] = [['text' => $bot->lng(back)]];
        for ($i = 0; $i < count($a_cats); $i++) {
            if ($i % 2 == 0) {
                if ($a_cats[$i + 1]['name_' . $lng] == true) {
                    $a_array[] = [['text' => $a_cats[$i]['name_' . $lng]], ['text' => $a_cats[$i + 1]['name_' . $lng]]];
                } else {
                    $a_array[] = [['text' => $a_cats[$i]['name_' . $lng]]];

                }
            }
        }

        $a_array[] = [['text' => $bot->lng(korzinka)], ['text' => $bot->lng(menu)]];
        $bot->rg('sendmessage', $chat_id, $bot->lng(tovar_spis), $bot->keyboard($a_array));
        // delete post
        $array = array($message_id, $message_id - 1, $message_id - 2);
        foreach ($array as $me_id) {
            $bot->dMessage($chat_id, $me_id);
        }
        $str = str_replace(explode('-', $mapping['map'])[1], '', $mapping['map']);
        $atr = $str - 1;
        $sql = "UPDATE users SET map=? WHERE chat_id=?";
        $pdo->prepare($sql)->execute([$atr.'-' . $sub_cats['cat'], $chat_id]);

    }
}
// Callback prev \ next
if (mb_stripos($cdata, 'next') !== false) {
    $tedi = explode('-', $cdata)[1];
    $keyins = explode('-', $cdata)[2];
    $stmt = $pdo->prepare("SELECT count(*) FROM tovar WHERE cat = ?");
    $stmt->execute([$tedi]);
    $count_tovar = $stmt->fetchColumn();
    // qayta boshidan chiqib kelsin
    if ($count_tovar > $keyins + 1) {
        $keyin = $keyins;
    } else {
        $keyin = -1;
    }
    $next_file = $pdo->query("SELECT * FROM tovar WHERE cat = '$tedi'")->fetchAll();
    $n_file_id = '';
    for ($i = 0; $i < count($next_file); $i++) {
        if ($i == $keyin + 1) {
            $n_file_id .= $next_file[$i]['id'];
        }
    }
    $next_file_n = $pdo->query("SELECT * FROM tovar WHERE id = '$n_file_id'")->fetch();
    $sh = $keyin + 2;
    $keyin_next = $keyin + 1;
    $inline_tovar = $bot->InlineKeyboard([[['text' => $bot->lng(add_kor), 'callback_data' => "add_kor"]], [['text' => "◀️", 'callback_data' => "prev-" . $tedi . "-" . $keyin_next], ['text' => "$sh / " . $count_tovar, 'callback_data' => "#"], ['text' => "▶️", 'callback_data' => "next-" . $tedi . "-" . $keyin_next]]]);
    $caption_next = "{$next_file_n['name_'.$lng]}

*{$bot->lng('sena')}:* {$next_file_n['narx']} {$bot->lng(sum)}";
    $inputMedia = json_encode(['type' => "photo", 'media' => $next_file_n['rasm'], 'caption' => $caption_next, 'parse_mode' => "markdown"]);
    $bot->editMessageMedia(['chat_id' => $chat_id, 'message_id' => $message_id, 'inline_message_id' => $i_m_id, 'media' => $inputMedia, 'reply_markup' => $inline_tovar]);
}

if (mb_stripos($cdata, 'prev') !== false) {
    $tedi = explode('-', $cdata)[1];
    $keyins = explode('-', $cdata)[2];
    $stmt = $pdo->prepare("SELECT count(*) FROM tovar WHERE cat = ?");
    $stmt->execute([$tedi]);
    $count_tovar = $stmt->fetchColumn();
    // oxiridan aylanib kelsin
    if ($keyins == 0) {
        $keyin = $count_tovar;
    } else {
        $keyin = $keyins;
    }
    $next_file = $pdo->query("SELECT * FROM tovar WHERE cat = '$tedi'")->fetchAll();
    $n_file_id = '';
    for ($i = 0; $i < count($next_file); $i++) {
        if ($i == $keyin - 1) {
            $n_file_id .= $next_file[$i]['id'];
        }
    }
    $next_file_n = $pdo->query("SELECT * FROM tovar WHERE id = '$n_file_id'")->fetch();
    $sh = $keyin;
    $keyin_next = $keyin - 1;
    $inline_tovar = $bot->InlineKeyboard([[['text' => $bot->lng(add_kor), 'callback_data' => "add_kor"]], [['text' => "◀️", 'callback_data' => "prev-" . $tedi . "-" . $keyin_next], ['text' => "$sh / " . $count_tovar, 'callback_data' => "#"], ['text' => "▶️", 'callback_data' => "next-" . $tedi . "-" . $keyin_next]]]);
    $caption_prev = "{$next_file_n['name_'.$lng]}

*{$bot->lng('sena')}:* {$next_file_n['narx']} {$bot->lng(sum)}";
    $inputMedia = json_encode(['type' => "photo", 'media' => $next_file_n['rasm'], 'caption' => $caption_prev, 'parse_mode' => "markdown"]);
    $bot->editMessageMedia(['chat_id' => $chat_id, 'message_id' => $message_id, 'inline_message_id' => $i_m_id, 'media' => $inputMedia, 'reply_markup' => $inline_tovar]);
}

// Admin panel cat add
if (in_array($chat_id, $adm)) {
    if (mb_stripos($text, '/add') !== false) {
        $nameuz = explode('=', $text)[1];
        $nameru = explode('=', $text)[2];
        $cat = explode('=', $text)[3];
        $cat_r = (true == $cat) ? $cat : '0';
        $sql = "INSERT INTO katalog (name_uz, name_ru, cat, activ) VALUES (?,?,?,?)";
        $pdo->prepare($sql)->execute([$nameuz, $nameru, $cat_r, 1]);
        $bot->rg('sendmessage', $chat_id, '*Katalog qo\'shildi*');

    }
// Tovar qo'shish panel
    if (mb_stripos($text, '/tovar') !== false) {
        $rasm = $data['message']['reply_to_message']['photo'][0]['file_id'];
        $cmf = explode('=', $text);
        $nameuz = $cmf[1];
        $nameru = $cmf[2];
        $narxi = $cmf[3];
        $cat = $cmf[4];
        $sql = "INSERT INTO tovar (name_uz, name_ru, rasm, narx, cat) VALUES (?,?,?,?,?)";
        $pdo->prepare($sql)->execute([$nameuz, $nameru, $rasm, $narxi, $cat]);
        $bot->rg('sendmessage', $chat_id, "Tovaringiz mufaqqiyatli qo'shildi");
    }
    if ($text == "/katalog") {
        $katalog = $pdo->query("SELECT * FROM katalog WHERE cat = '0'")->fetchAll();
        $catting = '';
        foreach ($katalog as $loop) {
            $subkat = $pdo->query("SELECT * FROM katalog WHERE cat = '{$loop['id']}' ")->fetchAll();
            $subcatr = '';
            foreach ($subkat as $subkatf) {
                $stmt = $pdo->prepare("SELECT count(*) FROM tovar WHERE cat = ?");
                $stmt->execute([$subkatf['id']]);
                $count_s = $stmt->fetchColumn();
                $zb_tovar = $pdo->query("SELECT * FROM katalog WHERE cat = '{$subkatf['id']}'")->fetchAll();
               $kat_3 = '';
                foreach ($zb_tovar as $zaeb_t) {
                    $stmt = $pdo->prepare("SELECT count(*) FROM tovar WHERE cat = ?");
                    $stmt->execute([$zaeb_t['id']]);
                    $count = $stmt->fetchColumn();
$kat_3 .= "       ├ ".$zaeb_t['name_'.$lng]." ($count) ❌ /X{$zaeb_t['id']} 🗒 /T{$zaeb_t['id']}
\n";
                }
                $subcatr .= " ├ " . $subkatf['name_' . $lng] . " ($count_s) ❌ /X{$subkatf['id']} 🗒 /T{$subkatf['id']}
$kat_3";
            }
            $catting .= "\n*Bo'lim ({$loop['id']}): " . $loop['name_' . $lng] . "*
$subcatr";
        }
        $bot->rg('sendmessage', $chat_id, $catting);
    }
    if (mb_stripos($text, '/X') !== false) {
        $bot->rg('sendmessage', $chat_id, " Kategoriya o'chirildi");
        $d_id = explode('/X', $text)[1];
        $count = $pdo->prepare("delete from katalog where id = $d_id ");
        $count->execute();
    }
    if (mb_stripos($text, '/T') !== false) {
        $s_id = explode('/T', $text)[1];
        $s_kat = $pdo->query("SELECT * FROM katalog WHERE id = '$s_id'")->fetch();
        $tavarlar = $pdo->query("SELECT * FROM tovar WHERE cat = '$s_id'")->fetchAll();
        $tvari = '';
        foreach ($tavarlar as $z_kat) {
            $tvari .= " ├ {$z_kat['name_'.$lng]} ❌ /D{$z_kat['id']}
";
        }
        $tovari = "*Bo'lim: " . $s_kat['name_' . $lng] . "*
" . $tvari;
        $bot->rg('sendmessage', $chat_id, $tovari);
    }
    if (mb_stripos($text, '/D') !== false) {
        $bot->rg('sendmessage', $chat_id, " Tovar o'chirildi");
        $d_id = explode('/D', $text)[1];
        $count = $pdo->prepare("delete from tovar where id = $d_id ");
        $count->execute();
    }
    if ($text == "/admin") {
        $admin = "Kategoriyalar bilan ishlash uchun:
        /katalog
        Asosiy kategoriya qo'shish:
        /add=Nomi uz=Номи ру
        Sub kategoriya qo'shish:
        /add=Nomi uz=Номи ру=2
        Tovar qo'shish uchun rasm tashlab rasmga reply qilgan holda:
        /tovar=Nomi uz=Номи ру=15000=9";
        $bot->rg('sendmessage', $chat_id, $admin);
    }
} else {// adminka
// Noto'g'ri buyruqlar tozalansin

    $clear = array($bot->lng(cat), $bot->lng(korzinka), $bot->lng(order), $bot->lng(connect), $bot->lng(uz), $bot->lng(ru), $bot->lng(menu), $bot->lng(back), '/start');
    if (in_array($text, $clear)) {
    } else {
        $bot->dMessage($chat_id, $message_id);
    }
}