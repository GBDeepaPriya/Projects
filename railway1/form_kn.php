<?php
include("connection.php");
session_start();
if (isset($_POST['submit'])) {
    $from = $_POST['from'];
    $to = $_POST['to'];
    $class = $_POST['class'];
    $general = $_POST['general'];
    $da = $_POST['date'];


    $query = "SELECT * from train WHERE from_station = '$from' AND to_station = '$to' AND date='$da'";
    $data = mysqli_query($conn, $query);

    if (mysqli_num_rows($data) > 0) {
        // session_start();
        $_SESSION['query1'] = $query;
        header('Location: display_kn.php');
        exit;
    } else  {
        header('Location: display2_kn.php');
        exit;

    }
} elseif (isset($_POST['search'])) {
    $trainname = $_POST['trainname'];
    $query = "SELECT * FROM train WHERE trainname = '$trainname'";
    $data = mysqli_query($conn, $query);

    if (mysqli_num_rows($data) > 0) {
        // session_start();
        $_SESSION['query2'] = $query;
        header('Location: display1_kn.php');
        exit;
    } else {
        header('Location: display2_kn.php');
        exit;

    }
}
?>





<?php
include("connection.php"); ?>

<!DOCTYPE html>
<html lang="kn">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://code.responsivevoice.org/responsivevoice.js"></script>


</head>

<body>
    <script>
    let synth = window.speechSynthesis;
    let utterance;

    function speakChooseLanguage() {
        let text = `ದಯವಿಟ್ಟು ಭಾಷೆಯನ್ನು ಆಯ್ಕೆಮಾಡಿ`;
        speakText(text);
    }

    function speakFrom() {
        let text = `ನೀವು ನಿಮ್ಮ ಮೂಲ ಸ್ಟೇಶನ್‌ನ್ನು ಹೇಳಬಹುದೇ?`;
        speakText(text);
    }

    function speakTo() {
        let text = `ನೀವು ನಿಮ್ಮ ಗುರಿ ಸ್ಥಾನವನ್ನು ಹೇಳಬಹುದೇ?`;
        speakText(text);
    }

    function speakClass() {
        let text = `ದಯವಿಟ್ಟು ತರಗತಿಯನ್ನು ನಮೂದಿಸಿ`;
        speakText(text);
    }

    function speakQuota() {
        let text = `ದಯವಿಟ್ಟು ಕೋಟಾವನ್ನು ನಮೂದಿಸಿ`;
        speakText(text);
    }

    function speakDate() {
        let text = `ದಯವಿಟ್ಟು ದಿನಾಂಕವನ್ನು ನಮೂದಿಸಿ`;
        speakText(text);
    }

    function speakTrainName() {
        let text = `ದಯವಿಟ್ಟು ರೈಲು ಹೆಸರನ್ನು ನಮೂದಿಸಿ`;
        speakText(text);
    }

    function speakText(text) {
        utterance = new SpeechSynthesisUtterance(text);
        utterance.lang = 'kn-IN';
        utterance.pitch = 2;
        utterance.rate = 0.6;
        utterance.volume = 1;


        synth.cancel(); // Cancel any ongoing speech synthesis
        synth.speak(utterance); // Start the speech synthesis


    }

    function changeLanguage(language) {
        window.location.href = 'form_' + language + '.php';
    }

    function recordLanguage() {
        var recognition = new webkitSpeechRecognition();
        recognition.lang = "en-GB";
        recognition.onresult = function(event) {
            var recordedWord = event.results[0][0].transcript;
            var language = getLanguageCode(recordedWord);
            if (language) {
                changeLanguage(language);
            } else {
                alert("Invalid language. Please try again.");
            }
        }
        recognition.start();
    }

    function getLanguageCode(language) {
        var languageCode = '';
        switch (language.toLowerCase()) {
            case 'english':
                languageCode = 'en';
                break;
            case 'hindi':
                languageCode = 'hi';
                break;
            case 'kannada':
                languageCode = 'kn';
                break;

        }
        return languageCode;
    }
    </script>

    <div class="bg_body">

        <div class="forn_bg_left"></div>
        <div class="form_bg">

            <h1>ರೈಲ್ವೆ ಸೀಟ್ ಲಭ್ಯತೆ ವ್ಯವಸ್ಥೆ</h1>


            <form id="languageForm" action="" method="POST">
                <div class="w-100 d-flex mt-50">
                    <div class="w-30 from">
                        <label for="language">ಭಾಷೆಯನ್ನು ಆಯ್ಕೆಮಾಡಿ:</label>
                    </div>



                    <div class="w-70 d-flex">
                        <select name="language" id="language" onchange="changeLanguage(this.value)">
                            <option value="en">ಇಂಗ್ಲೀಷ್</option>
                            <option value="hi">ಹಿಂದಿ</option>
                            <option value="kn">ಕನ್ನಡ</option>
                        </select>
                        <button type="button" class="speech-button" onclick="record1('language')"><i
                                class="fas fa-microphone"></i></button>
                    </div>
            </form>
        </div>


        <script>
        function changeLanguage(language) {
            if (language === 'en') {
                window.location.href = 'form.php';
            } else if (language === 'hi') {
                window.location.href = 'form_hi.php';
            } else if (language === 'kn') {
                window.location.href = 'form_kn.php';
            }
        }

        // Set the default language selection based on the current page
        var currentPage = '<?php echo basename($_SERVER["PHP_SELF"]); ?>';
        if (currentPage === 'form.php') {
            document.getElementById("language").value = "en";
        } else if (currentPage === 'form_hi.php') {
            document.getElementById("language").value = "hi";
        } else if (currentPage === 'form_kn.php') {
            document.getElementById("language").value = "kn";
        }
        </script>




        <form action="" method="POST">

            <div class="w-100 d-flex mt-50">
                <div class="w-30 from">
                    <label>ಪ್ರಯಾಣದ ಮೂಲ ನಿಲ್ದಾಣ: </label>
                </div>

                <div class="w-70 d-flex">
                    <select id="stationsSelectBox" class="" name="from">
                        <option value="">--ಆಯ್ಕೆ--</option>
                    </select>
                    <button type="button" class="speech-button" onclick="record('stationsSelectBox')"><i
                            class="fas fa-microphone"></i></button>
                </div>
            </div>

            <div class="w-100 d-flex mt-50">
                <div class="w-30">
                    <label>ತಲುಪುವ ಸ್ಥಳ: </label>
                </div>

                <div class="w-70 d-flex">
                    <select id="stationsSelectBox2" class="" name="to">
                        <option value="">--ಆಯ್ಕೆ--</option>
                    </select>
                    <button type="button" class="speech-button" onclick="record('stationsSelectBox2')"><i
                            class="fas fa-microphone"></i></button>
                </div>
            </div>

            <div class="w-100 d-flex mt-50">
                <div class="w-30">
                    <label>ತರಗತಿ: </label>
                </div>

                <div class="w-70 d-flex ">
                    <select id="stationsSelectBox3" class="" name="class">
                        <option value="">--ಆಯ್ಕೆ--</option>
                    </select>
                    <button type="button" class="speech-button" onclick="record('stationsSelectBox3')"><i
                            class="fas fa-microphone"></i></button>
                </div>
            </div>

            <div class="w-100 d-flex mt-50">
                <div class="w-30">
                    <label>ಕೋಟಾ: </label>
                </div>
                <div class="w-70 d-flex">
                    <select id="stationsSelectBox4" class="" name="general">
                        <option value="">--ಆಯ್ಕೆ--</option>
                    </select>
                    <button type="button" class="speech-button" onclick="record('stationsSelectBox4')"><i
                            class="fas fa-microphone"></i></button>
                </div>
            </div>

            <div class="w-100 d-flex mt-50">
                <div class="w-30 to">
                    <label for="date">ದಿನಾಂಕ: </label>
                </div>
                <div class="w-70 d-flex">
                    <input type="date" id="dateInput" name="date">
                    <button type="button" class="speech-button" onclick="recordDate()"><i
                            class="fas fa-microphone"></i></button>
                </div>
            </div>

            <div class="txt-centre mt-50 ">
                <input type="submit" value="ಸಲ್ಲಿಸು" class="btn button_style" name="submit">
            </div>

            <div class="w-100 d-flex mt-50">
                <div class="w-30">
                    <label>ರೈಲಿನ ಹೆಸರು: </label>
                </div>
                <div class="w-70 d-flex">
                    <select id="trainname" class="custom_select" name="trainname">
                        <option value="">--ಆಯ್ಕೆ--</option>
                    </select>
                    <button type="button" class="speech-button" onclick="record('trainname')"><i
                            class="fas fa-microphone"></i></button>

                </div>
            </div>
            <div class="txt-centre mt-50 ">
                <button type="submit" name="search" class="btn btn-primary button_style">ಹುಡುಕಿ</button>
            </div>
        </form>
    </div>



    <script>
    $(document).ready(function() {
        $.getJSON("stations.json",
            function(data) {
                console.log(data);
                data.stations.forEach(element => {
                    console.log(element)
                    let o = document.createElement('option');
                    o.text = element.name;
                    $('#stationsSelectBox, #stationsSelectBox2').append(o);

                });
            })
    })
    </script>

    <script>
    $(document).ready(function() {
        $.getJSON("allclasses.json",
            function(data) {
                console.log(data);
                data.allclasses.forEach(element => {
                    console.log(element)
                    let o = document.createElement('option');
                    o.text = element.name;
                    $('#stationsSelectBox3').append(o);
                });

            })
    })
    </script>

    <script>
    $(document).ready(function() {
        $.getJSON("general.json",
            function(data) {
                console.log(data);
                data.general.forEach(element => {
                    console.log(element)
                    let o = document.createElement('option');
                    o.text = element.name;
                    $('#stationsSelectBox4').append(o);

                });

            })
    })
    </script>

    <script>
    $(document).ready(function() {
        $.getJSON("trains.json", function(data) {
            console.log(data);
            data.trains.forEach(element => {
                console.log(element);
                let o = document.createElement('option');
                o.text = element.name;
                $('#trainname').append(o);
            });
        });
    });
    </script>


    <script>
    function record(elementId) {
        var recognition = new webkitSpeechRecognition();
        recognition.lang = "kn-IN";
        recognition.onresult = function(event) {
            var recordedWord = event.results[0][0].transcript;
            var selectBox = document.getElementById(elementId);
            for (var i = 0; i < selectBox.options.length; i++) {
                if (selectBox.options[i].text.toLowerCase().includes(recordedWord.toLowerCase())) {
                    selectBox.selectedIndex = i;
                    break;
                }
            }
        }
        recognition.start();
    }
    </script>
    <script>
    function record1(elementId) {
        var selectBox = document.getElementById(elementId);
        selectBox.selectedIndex = 0; // Reset the selected option initially

        // Start speech recognition only if the browser supports it
        if ('webkitSpeechRecognition' in window) {
            var recognition = new webkitSpeechRecognition();
            recognition.lang = "en-GB";
            recognition.onresult = function(event) {
                var recordedWord = event.results[0][0].transcript.toLowerCase();

                var language = getLanguageCode(recordedWord);
                if (language === 'en') {
                    window.location.href = 'form_en.php';
                } else if (language === 'hi') {
                    window.location.href = 'form_hi.php';
                } else if (language === 'kn') {
                    window.location.href = 'form_kn.php';
                }
            };
            recognition.start();
        }
    }
    </script>
    <script>
    function recordDate() {
        var recognition = new webkitSpeechRecognition();
        recognition.lang = "kn-IN";
        recognition.onresult = function(event) {
            var recordedWord = event.results[0][0].transcript;
            var dateInput = document.getElementById('dateInput');
            var parsedDate = parseSpokenDate(recordedWord);
            if (parsedDate) {
                dateInput.value = parsedDate;
            } else {
                alert("Invalid date format. Please try again.");
            }
        }
        recognition.start();
    }

    function parseSpokenDate(dateStr) {
        // Convert the spoken date to a valid date format
        // Example: "May 7th, 2023" -> "2023-05-07"
        var date = new Date(dateStr);
        if (isNaN(date)) {
            return null;
        }
        var year = date.getFullYear();
        var month = ("0" + (date.getMonth() + 1)).slice(-2);
        var day = ("0" + date.getDate()).slice(-2);
        return year + "-" + month + "-" + day;
    }
    </script>


    </div>


</body>

</html>