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
            header('Location: display.php');
            exit;
        } //else if(mysqli_num_rows($data) < 0) {
            else{
            header('Location: display2.php');
            exit;
            }

    // }
    } elseif (isset($_POST['search'])) {
        $trainname = $_POST['trainname'];
        $query = "SELECT * FROM train WHERE trainname = '$trainname'";
        $data = mysqli_query($conn, $query);

        if (mysqli_num_rows($data) > 0) {
            // session_start();
            $_SESSION['query2'] = $query;
            header('Location: display1.php');
            exit;
        } else {
            header('Location: display2.php');
            exit;

        }
    }
    ?>





<?php
    include("connection.php"); ?>

<!DOCTYPE html>
<html lang="en">

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
        let text = `Please choose a language`;
        speakText(text);
    }

    function speakFrom() {
        let text = `Can you tell me your source station?`;
        speakText(text);
    }

    function speakTo() {
        let text = `Can you tell me your destination station?`;
        speakText(text);
    }

    function speakClass() {
        let text = `Please enter the class`;
        speakText(text);
    }

    function speakQuota() {
        let text = `Please enter the quota`;
        speakText(text);
    }

    function speakDate() {
        let text = `Please enter the date`;
        speakText(text);
    }

    function speakTrainName() {
        let text = `Please enter the train name`;
        speakText(text);
    }

    function speakText(text) {
        utterance = new SpeechSynthesisUtterance(text);
        utterance.lang = 'en-US';
        utterance.pitch = 2;
        utterance.rate = 0.6;
        utterance.volume = 1;

        synth.cancel();
        synth.speak(utterance);
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

            <h1>Railway Seat Availability System </h1>




            <form id="languageForm" action="" method="POST">
                <div class="w-100 d-flex mt-50">
                    <div class="w-30 from">
                        <label for="language">CHOOSE A LANGUAGE:</label>
                    </div>

                    <button type="button" onclick="speakChooseLanguage()">Language</button>

                    <div class="w-70 d-flex">
                        <select name="language" id="language" onchange="changeLanguage(this.value)">
                            <option value="en">English</option>
                            <option value="hi">Hindi</option>
                            <option value="kn">Kannada</option>
                        </select>
                        <button type="button" class="speech-button" onclick="recordLanguage()"><i
                                class="fas fa-microphone"></i></button>
                    </div>

            </form>
        </div>


        <script>
        function changeLanguage(language) {
            if (language === 'en') {
                window.location.href = 'form_en.php';
            } else if (language === 'hi') {
                window.location.href = 'form_hi.php';
            } else if (language === 'kn') {
                window.location.href = 'form_kn.php';
            }

        }

        // Set the default language selection based on the current page
        var currentPage = '<?php echo basename($_SERVER["PHP_SELF"]); ?>';
        if (currentPage === 'form_en.php') {
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
                    <label>FROM: </label>
                </div>


                <button type="button" onclick="speakFrom()">From</button>


                <div class="w-70 d-flex">
                    <select id="stationsSelectBox" class="" name="from">
                        <option value="">-- Select --</option>
                    </select>
                    <button type="button" class="speech-button" onclick="record('stationsSelectBox')"><i
                            class="fas fa-microphone"></i></button>
                </div>
            </div>

            <div class="w-100 d-flex mt-50">
                <div class="w-30">
                    <label>TO:</label>
                </div>


                <button type="button" onclick="speakTo() ">TO</button>


                <div class="w-70 d-flex">
                    <select id="stationsSelectBox2" class="" name="to">
                        <option value="">-- Select --</option>
                    </select>
                    <button type="button" class="speech-button" onclick="record('stationsSelectBox2')"><i
                            class="fas fa-microphone"></i></button>
                </div>
            </div>

            <div class="w-100 d-flex mt-50">
                <div class="w-30">
                    <label>CLASSES: </label>
                </div>


                <button type="button" onclick="speakClass()">Class</button>

                <div class="w-70 d-flex ">
                    <select id="stationsSelectBox3" class="" name="class">
                        <option value="">-- Select --</option>
                    </select>
                    <button type="button" class="speech-button" onclick="record('stationsSelectBox3')"><i
                            class="fas fa-microphone"></i></button>
                </div>
            </div>

            <div class="w-100 d-flex mt-50">
                <div class="w-30">
                    <label>QUOTA: </label>
                </div>


                <button type="button" onclick="speakQuota()">Quota</button>


                <div class="w-70 d-flex">
                    <select id="stationsSelectBox4" class="" name="general">
                        <option value="">-- Select --</option>
                    </select>
                    <button type="button" class="speech-button" onclick="record('stationsSelectBox4')"><i
                            class="fas fa-microphone"></i></button>
                </div>
            </div>

            <div class="w-100 d-flex mt-50">
                <div class="w-30 to">
                    <label for="date">DATE: </label>
                </div>


                <button type="button" onclick="speakDate()">Date</button>

                <div class="w-70 d-flex">
                    <input type="date" id="dateInput" name="date">
                    <button type="button" class="speech-button" onclick="recordDate()"><i
                            class="fas fa-microphone"></i></button>
                </div>
            </div>


            <div class="txt-centre mt-50 ">
                <input type="submit" value="submit" class="btn button_style" name="submit">
            </div>



            <div class="w-100 d-flex mt-50">
                <div class="w-30">
                    <label>TRAIN NAME: </label>
                </div>


                <button type="button" onclick="speakTrainName()">Train Name</button>

                <div class="w-70 d-flex">
                    <select id="trainname" class="custom_select" name="trainname">
                        <option value="">-- Select --</option>
                    </select>
                    <button type="button" class="speech-button" onclick="record('trainname')"><i
                            class="fas fa-microphone"></i></button>

                </div>
            </div>
            <div class="txt-centre mt-50 ">
                <button type="submit" name="search" class="btn btn-primary button_style">Search</button>
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
        var selectBox = document.getElementById(elementId);
        selectBox.selectedIndex = 0; // Reset the selected option initially

        // Start speech recognition only if the browser supports it
        if ('webkitSpeechRecognition' in window) {
            var recognition = new webkitSpeechRecognition();
            recognition.lang = "en-GB";
            recognition.onresult = function(event) {
                var recordedWord = event.results[0][0].transcript.toLowerCase();

                // Iterate through options and find a match for the recorded word
                for (var i = 0; i < selectBox.options.length; i++) {
                    var optionText = selectBox.options[i].text.toLowerCase();

                    if (optionText.includes(recordedWord)) {
                        selectBox.selectedIndex = i;
                        break;
                    }
                }
            };
            recognition.start();
        }
    }
    </script>

    <script>
    function recordDate() {
        var recognition = new webkitSpeechRecognition();
        recognition.lang = "en-GB";
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