<?php

    if($checkUpdateTime) {
          try {
            telegram_post_notification("Отправляю данные в таблицу", $telegram_token, $telegram_chat_id);
            sleep(1);
            $url = 'https://sheets.serviceanalytics.ru/sheets.php';
            $headers = ['Content-Type: application/json'];
          //  $postvars = http_build_query(array_merge($_POST, $array_for_import));
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, count($_POST));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data_import);
            $result_curl_google_sheets = curl_exec($ch);

          } catch (Exception $e) {
            // exception is raised and it'll be handled here
            // $e->getMessage() contains the error message
            telegram_post_notification("Ошибка".$e, $telegram_token, $telegram_chat_id);
            echo "Ошибка".$e; 
          }    
          sleep(1);
    }
  
?>