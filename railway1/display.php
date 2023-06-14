<?php
session_start();
include("connection.php");

$query = $_SESSION['query1'];
$result = mysqli_query($conn, $query);
$totalRows = mysqli_num_rows($result);
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
    <table border="1" id="results-table">
        <tr>
            <th>FROM</th>
            <th>TO</th>
            <th>CLASS</th>
            <th>QUOTA</th>
            <th>DATE</th>
            <th>SEATS AVAILABLE</th>
            <th>FARE</th>
            <th>TRAINID</th>
            <th>TRAINNAME</th>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <tr>
            <td><?php echo $row['from_station']; ?></td>
            <td><?php echo $row['to_station']; ?></td>
            <td><?php echo $row['allclasses']; ?></td>
            <td><?php echo $row['quota']; ?></td>
            <td><?php echo $row['date']; ?></td>
            <td><?php echo $row['seats_available']; ?></td>
            <td><?php echo $row['fare']; ?></td>
            <td><?php echo $row['trainid']; ?></td>
            <td><?php echo $row['trainname']; ?></td>
        </tr>
        <?php
        }
        ?>
    </table>

    <script>
    let synth = window.speechSynthesis;
    let utterance;

    function speakTable() {
        const table = document.getElementById('results-table');
        const totalRows = <?php echo $totalRows; ?>;
        let text = `There are ${totalRows} trains available. `;
        let currentRow = 2;

        for (let i = 0; i < table.rows.length; i++) {
            if (i === 0) {
                continue;
            }

            text += `The details of train ${currentRow - 1} are as follows. `;
            const row = table.rows[i];
            for (let j = 0; j < row.cells.length; j++) {
                const columnHeader = table.rows[0].cells[j].innerText;
                const cellValue = row.cells[j].innerText;

                switch (columnHeader) {
                    case 'FROM':
                        text += `Source of Journey is ${cellValue}. `;
                        break;
                    case 'TO':
                        text += `Destination of Journey is ${cellValue}. `;
                        break;
                    case 'DATE':
                        text += `The Date is ${cellValue}. `;
                        break;
                    case 'TRAINNAME':
                        text += `The train name is ${cellValue}. `;
                        break;
                    case 'CLASS':
                        text += `The Class is ${cellValue}. `;
                        break;
                    case 'QUOTA':
                        text += `The quota is ${cellValue}. `;
                        break;
                    case 'SEATS AVAILABLE':
                        text += `The total seats available are ${cellValue}. `;
                        break;
                    default:
                        break;
                }
            }

            text += '. ';
            currentRow++;
        }

        utterance = new SpeechSynthesisUtterance(text);
        utterance.lang = 'en-US';
        utterance.pitch = 2;
        utterance.rate = 0.6;
        utterance.volume = 1;

        synth.cancel(); // Cancel any ongoing speech synthesis
        synth.speak(utterance); // Start the speech synthesis
    }

    function stopSpeaking() {
        synth.cancel(); // Stop the speech synthesis
    }
    </script>

    <button onclick="speakTable()">Speak Results</button>
    <button onclick="stopSpeaking()">Stop Speaking</button>
</body>

</html>