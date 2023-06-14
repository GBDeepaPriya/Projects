<?php
    session_start();
    include("connection.php");

?>
<!DOCTYPE html>
<html>

<head>
    <title>Railway Seat Availability System - Display</title>
    <link rel="stylesheet" href="style1.css">
</head>

<body>

    <div class="heading">
        <h1>Seat Availability System</h1>
    </div>
    <script>
    let synth = window.speechSynthesis;
    let utterance;

    function speakTable() {

        let text = `ಯಾವುದೇ ದಾಖಲೆಗಳು ಲಭ್ಯವಿಲ್ಲ `;


        utterance = new SpeechSynthesisUtterance(text);
        utterance.lang = 'kn-IN'; // Set the language to Hindi
        utterance.pitch = 1;
        utterance.rate = 0.6;
        utterance.volume = 1;


        synth.cancel(); // Cancel any ongoing speech synthesis
        synth.speak(utterance); // Start the speech synthesis
    }
    </script>
    <div>
        <h3>ಯಾವುದೇ ದಾಖಲೆಗಳು ಲಭ್ಯವಿಲ್ಲ</h3>

    </div>

</body>
</html>