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

        let text = `दिए गए स्टेशन के लिए कोई ट्रेन उपलब्ध नहीं है। `;

        utterance = new SpeechSynthesisUtterance(text);
        utterance.lang = 'hi-IN'; // Set the language to Hindi
        utterance.pitch = 1;
        utterance.rate = 0.6;
        utterance.volume = 1;


        synth.cancel(); // Cancel any ongoing speech synthesis
        synth.speak(utterance); // Start the speech synthesis
    }
    </script>
    <div>
        <h3>कोई रिकॉर्ड उपलब्ध नहीं है</h3>

    </div>
    <button onclick="speakTable()">बोलो</button>
</body>
</html>