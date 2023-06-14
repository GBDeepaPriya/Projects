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

        let text = `No trains available for the given station. `;

        utterance = new SpeechSynthesisUtterance(text);
        utterance.lang = 'en-US';
        utterance.pitch = 2;
        utterance.rate = 0.6;
        utterance.volume = 1;

        synth.cancel(); // Cancel any ongoing speech synthesis
        synth.speak(utterance); // Start the speech synthesis
    }
    </script>
    <div>
        <h3>No Records Available</h3>

    </div>
    <button onclick="speakTable()">Speak Results</button>
</body>
</html>