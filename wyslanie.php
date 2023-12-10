<?php
      /*Limit wysłanych wiadomości w przeciągu 5h (zapobieganie SPAMu)*/
      session_start();

      $ip_address = $_SERVER['REMOTE_ADDR'];
  
      if (!isset($_SESSION['form_submissions'][$ip_address])) {
          $_SESSION['form_submissions'][$ip_address] = array();
      }
  
      if (is_array($_SESSION['form_submissions'][$ip_address]) && count($_SESSION['form_submissions'][$ip_address]) >= 5) {
          $last_submission_time = end($_SESSION['form_submissions'][$ip_address]);
  
      }
      
      if (count($_SESSION['form_submissions'][$ip_address]) >= 6) {
          $last_submission_time = end($_SESSION['form_submissions'][$ip_address]);
          $time_difference = time() - $last_submission_time;
          $time_limit = 18000;/*Limit wysłanych wiadomości w przeciągu 5h (zapobieganie SPAMu)*/
      
          if ($time_difference < $time_limit) {
              echo "<script>
              alert('Zbyt często próbujesz wysłać formularz. Spróbuj ponownie za jakiś czas.');
              window.location.href = 'index.html';
              </script>";
              exit();
          }
      }
      
      $_SESSION['form_submissions'][$ip_address][] = time();


            /*Wysłanie widomości E-Mail*/
      
              $to = "sosenkaslup@gmail.com";
              if(filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
                  $from = $_POST["email"];
              }
              else{
                  echo "<script>
                  alert('Nieprawidłowy email');
                  window.location.href = 'index.html';
                </script>";
              }
              $subject = "Sosenka - Oferta";
              $message =  "Email - " . $from . " Dane osobowe: " . $_POST["name"] . " Wiadomosc: " . $_POST["message"];
              $headers = "From: igorrydy@gmail.com\r\n" .
                  "Reply-To: $from\r\n" .
                  "X-Mailer: PHP/" . phpversion();

              // Konfiguracja SMTP
              ini_set("SMTP", "smtp.office365.com");
              ini_set("smtp_port", "587");
              ini_set("sendmail_from", "igorrydy@gmail.pl");
              ini_set("sendmail_path", "\"C:\xampp\sendmail\sendmail.exe\" -t");

              // Wysyłanie wiadomości
              $mailSuccess = mail($to, $subject, $message, $headers);
              
              if ($mailSuccess) {
                  echo "<script>
                  alert('Wiadomość wysłana pomyślnie');
                  window.location.href = 'index.html';
                </script>";
              } else {
                  echo "<script>
                  alert('Błąd podczas wysyłania wiadomości');
                  window.location.href = 'index.html';
                </script>";
              }
            
?>