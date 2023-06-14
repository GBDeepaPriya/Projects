<?php
session_start();
include("connection.php");

$query = $_SESSION['query1'];
$result = mysqli_query($conn, $query);
$totalRows = mysqli_num_rows($result);

function convertToKan($stationName) {
    // Map English station names to Hindi equivalents
    $stationMap = array(
'YESVANTPUR JN - YPR' => 'ಯಶವಂತಪುರ ಜಂಕ್ಷನ',
'KOLKATA - KOAA' => 'ಕಲಕತ್ತ',
'LOKMANYATILAK T - LTT' => 'ಲೋಕಮಾನ್ಯ ತಿಲಕ್',
'RAJENDRANAGAR T - RJPB' => 'ರಾಜೇಂದ್ರನಗರ',
'BANDRA TERMINUS - BDT' => 'ಬಂದ್ರ ಟರ್ಮಿನಸ್',
'VISAKHAPATNAM - VSKP' => 'ವಿಶಾಖಪಟ್ನಂ',
'ANAND VIHAR TRM - ANVT' => 'ಆನಂದ ವಿಹಾರ ಟರ್ಮಿನಸ್',
'MUMBAI CENTRAL - MMCT' => 'ಮುಂಬೈ ಸೆಂಟ್ರಲ್',
'C SHIVAJI MAH T - CSMT' => 'ಛತ್ರಪತಿ ಶಿವಾಜಿ ಮಹಾರಾಜ್ ಟರ್ಮಿನಸ್',
'GUWAHATI - GHY' => 'ಗುವಾಹಾಟಿ',
'KACHEGUDA - KCG' => 'ಕಚೇಗೂಡ',
'CHANDIGARH - CDG' => 'ಚಂಡೀಗಡ್ಡ',
'GORAKHPUR JN - GKP' => 'ಗೋರಖಪುರ',
'BHUBANESWAR - BBS' => 'ಭುವನೇಶ್ವರ',
'GUNTUR JN - GNT' => 'ಗುಂಟೂರು',
'KHARAGPUR JN - KGP' => 'ಖಡಗಪುರ',
'BAREILLY - BE' => 'ಬೆಯರೆಲಿ',
'KRISHNARAJAPURM - KJM' => 'ಕೃಷ್ಣರಾಜಪುರಂ',
'KOZHIKKODE - CLT' => 'ಕೊಳಿಕೋಡ್',
'KANPUR CENTRAL - CNB' => 'ಕಾನ್ಪೂರ್ ಸೆಂಟ್ರಲ್',
'GWALIOR - GWL' => 'ಗ್ವಾಲಿಯರ್',
'GHAZIABAD - continue from here' => 'ಗಾಜಿಯಾಬಾದ್',
'RANI KAMALAPATI - RKMP' => 'ರಾಣಿ ಕಾಮಲಾಪತಿ',
'KOTA JN - KOTA' => 'ಕೋಟಾ',
'KATPADI JN - KPD' => 'ಕಟ್ಪಾಡಿ',
'BIKANER JN - BKN' => 'ಬಿಕಾನೇರ್',
'DELHI S ROHILLA - DEE' => 'ದೆಹಲಿ ಆರೋಹಿಲ್ಲಾ',
'HARIDWAR JN - HW' => 'ಹರಿದ್ವಾರ್',
'HOWRAH JN - HWH' => 'ಹೊವ್ರಾ',
'HYDERABAD DECAN - HYB' => 'ಹೈದರಾಬಾದ್ ಡಿಕ್ಕನ್',
'INDORE JN BG - INDB' => 'ಇಂದೂರ್',
'DELHI - DLI' => 'ದೆಹಲಿ',
'JAMMU TAWI - JAT' => 'ಜಮ್ಮು ತವಿ',
'JABALPUR - JBP' => 'ಜಬಲ್ಪುರ್',
'AHMEDABAD JN - ADI' => 'ಅಮದಾವಾದ್',
'BHOPAL JN - BPL' => 'ಭೋಪಾಲ್',
'VADODARA JN - BRC' => 'ವಡೋದರ',
'V LAKSHMIBAI - VGLB' => 'ವೀರಂಗನ ಲಕ್ಷ್ಮೀಬಾಯಿ',
'AGRA CANTT - AGC' => 'ಆಗ್ರಾ ಕ್ಯಾಂಟ್',
'AJMER JN - AII' => 'ಅಜ್ಮೀರ್',
'VARANASI JN - BSB' => 'ವಾರಣಾಸಿ',
'DADAR - DR' => 'ದಾದರ್',
'PRAYAGRAJ JN. - PRYJ' => 'ಪ್ರಯಾಗ್ರಾಜ್',
'BILASPUR JN - BSP' => 'ಬಿಲಾಸ್ಪುರ್',
'JAIPUR - JP' => 'ಜೈಪೂರ್',
'BORIVALI - BVI' => 'ಬೊರಿವಲಿ',

'ERODE JN - ED' => 'ಇರೋಡ್',
'ERNAKULAM TOWN - ERN' => 'ಎರ್ಣಾಕುಲಂ ಟೌನ್',
'ERNAKULAM JN - ERS' => 'ಎರ್ಣಾಕುಲಂ',
'JODHPUR JN - JU' => 'ಜೊಧ್ಪುರ್',
'AMRITSAR JN - ASR' => 'ಅಮ್ರಿತಸರ್',
'AURANGABAD - AWB' => 'ಔರಂಗಾಬಾದ್',
'VIJAYAWADA JN - BZA' => 'ವಿಜಯವಾಡ ಜಂಕ್ಷನ್',
'KANNUR - CAN' => 'ಕಣ್ಣೂರು',
'COIMBATORE JN - CBE' => 'ಕೋಯಂಬತ್ತೂರು',
'PUNE JN - PUNE' => 'ಪೂನೆ',
'PURI - PURI' => 'ಪುರಿ',
'KALYAN JN - KYN' => 'ಕಲ್ಯಾಣ್',
'MYSURU JN - MYS' => 'ಮೈಸೂರು',
'RAIPUR JN - R' => 'ರಾಯಪುರ್',
'LUDHIANA JN - LDH' => 'ಲುಧಿಯಾನಾ',
'NEW DELHI - NDLS' => 'ನ್ಯೂ ದೆಹಲಿ',
'RAJAHMUNDRY - RJY' => 'ರಾಜಮಂಡ್ರಿ',
'LUCKNOW NE - LJN' => 'ಲಕ್ನೋ ಉತ್ತರ ಜಂಕ್ಷನ್',
'LUCKNOW NR - LKO' => 'ಲಕ್ನೋ ಜಂಕ್ಷನ್',
'H SAHIB NANDED - NED' => 'ಹುಜೂರ್ ಸಾಹಿಬ್ ನಾಂದೇಡ್',
'NAGPUR - NGP' => 'ನಾಗಪುರ',
'NEW JALPAIGURI - NJP' => 'ನ್ಯೂ ಜಲಪೈಗುಡ್ಡಿ',
'NASHIK ROAD - NK' => 'ನಾಶಿಕ್ ರಸ್ತೆ',
'SURAT - ST' => 'ಸುರತ್',
'RANCHI - RNC' => 'ರಾಂಚಿ',
'MADGAON - MAO' => 'ಮಡಗಾಂವ್',
'MGR CHENNAI CTL - MAS' => 'ಎಂಜಿಆರ್ ಚೆನ್ನೈ ಕೇಂದ್ರಿತ',
'SOLAPUR JN - SUR' => 'ಸೊಲಾಪುರ್',
'MADURAI JN - MDU' => 'ಮದುರೈ',
'SALEM JN - SA' => 'ಸೇಲೆಂ',
'MUZAFFARPUR JN - MFP' => 'ಮುಜಫ್ಫರ್‌ಪುರ್',
'H NIZAMUDDIN - NZM' => 'ಹೈದರಾಬಾದ್ ನಿಜಾಮುದ್ದೀನ್',
'TATANAGAR JN - TATA' => 'ಟಾಟಾನಗರ್',
'TAMBARAM - TBM' => 'ತಂಬರಾಮ್',
'THRISUR - TCR' => 'ತೃಶೂರ್',
'KSR BENGALURU - SBC' => 'ಕ್ರಿಷ್ಣರಾಜೇಂದ್ರ ಸಂಕೇತ',
'SECUNDERABAD JN - SC' => 'ಸೆಕೆಂಡರಾಬಾದ್',
'SEALDAH - SDAH' => 'ಶಿಯಾಲ್ದಾ',
'DD UPADHYAYA JN - DDU' => 'ದೀನದಯಾಲು ಉಪಾಧ್ಯಾಯ ಜಂಕ್ಷನ್',
'TIRUNELVELI - TEN' => 'ತಿರುನೆಲ್ವೇಲಿ',
'THANE - TNA' => 'ಥಾನೆ',
'TIRUCHCHIRAPALI - TPJ' => 'ತಿರುಚಿರಾಪಳ್ಳಿ',
'TIRUPATI - TPTY' => 'ತಿರುಪತಿ',
'CHENNAI EGMORE - MS' => 'ಚೆನ್ನೈ ಎಗ್ಮೋರ್',
'PATNA JN - PNBE' => 'ಪಟ್ನಾ',
'PANVEL - PNVL' => 'ಪಾನ್ವೆಲ',
    'TRIVANDRUM CNTL - TVC' => 'ತ್ರಿವೆಂಡ್ರಮ್ ಕೇಂದ್ರಿತ',
    'SSS HUBBALLI JN - UBL' => 'ಹುಬ್ಬಳ್ಳಿ',
    'MATHURA JN - MTJ' => 'ಮಥುರಾ',
    'UDAIPUR CITY - UDZ' => 'ಉದೈಪುರ್ ನಗರ',
    'UJJAIN JN - UJN' => 'ಉಜ್ಜೈನ್',
    'AMBALA CANT JN - UMB' => 'ಅಂಬಾಲಾ ಛಾವಣಿ ಜಂಕ್ಷನ್',
    'BANARAS - BSBS' => 'ವಾರಣಾಸಿ',
    'VAPI - VAPI' => 'ವಾಪಿ',
    'SORATH VANTHIL' => 'ಸೋರತ್ ವಂಥಿಲ್',

'Anubhuti Class (EA)' => 'ಅನುಭೂತಿ ಕ್ಲಾಸ್ (ಈಏ)',
'AC First Class (1A)' => 'ಎಸ್ಸಿ ಮೊದಲ ಕ್ಲಾಸ್ (1ಏ)',
'Vistadome AC (EV)' => 'ವಿಸ್ಟಾಡೋಮ್ ಎಸಿ (ಈವಿ)',
'Exec. Chair Car (EC)' => 'ಎಕ್ಸೆಕ್ಯೂಟಿವ್ ಚೇರ್ ಕಾರ್ (ಈಸಿ)',
'AC 2 Tier(2A)' => 'ಎಸ್ಸಿ 2 ಟಿಯರ್ (2ಏ)',
'First Class (FC)' => 'ಮೊದಲ ಕ್ಲಾಸ್ (ಎಫ್ಸಿ)',
'AC 3 Tier (3A)' => 'ಎಸ್ಸಿ 3 ಟಿಯರ್ (3ಏ)',
'AC 3 Economy (3E)' => 'ಎಸ್ಸಿ 3 ಆರ್ಥಿಕ (3ಈ)',
'Vistadome Chair Car (VC)' => 'ವಿಸ್ಟಾಡೋಮ್ ಚೇರ್ ಕಾರ್ (ವೀಸಿ)',
'AC Chair car (CC)' => 'ಎಸ್ಸಿ ಚೇರ್ ಕಾರ್ (ಸಿಸಿ)',
'Sleeper (SL)' => 'ಸ್ಲೀಪರ್ (ಎಸ್ಎಲ್)',
'Vistadome Non AC (VS)' => 'ವಿಸ್ಟಾಡೋಮ್ ಗೈರ್-ಎಸಿ (ವಿಎಸ್)',
'Second Sitting (2S)' => 'ದ್ವಿತೀಯ ಕುಳಿತುಕೊಳ್ಳುವ ಸ್ಥಳ (2ಎಸ್)',
'GENERAL' => 'ಸಾಮಾನ್ಯ',
'LADIES' => 'ಮಹಿಳೆಯರು',
'LOWER BERTH/SR.CITIZEN' => 'ಕೆಳಗಿನ ಬರ್ತ್',
'PERSON WITH DISABILITY' => 'ಅಂಗಸಾಧಕತೆ ಹೊಂದಿದ ವ್ಯಕ್ತಿ',
'TATKAL' => 'ತತ್ಕಾಲ',
'PREMIUM TATKAL' => 'ಪ್ರೀಮಿಯಂ ತತ್ಕಾಲ',
'KR Express' => 'ಕೆಆರ್ ಎಕ್ಸ್‌ಪ್ರೆಸ್',
'Agra Jaipur Express' => 'ಆಗ್ರಾ ಜೈಪುರ್ ಎಕ್ಸ್‌ಪ್ರೆಸ್',

'Lokamanya Express' =>'ಲೋಕಮಾನ್ಯ ಎಕ್ಸ್‌ಪ್ರೆಸ್',
'Yeshwanthpur Express' => 'ಯಶವಂತಪುರ ಎಕ್ಸ್‌ಪ್ರೆಸ್',
'Bombay Express' => 'ಬಾಂಬೆ ಎಕ್ಸ್‌ಪ್ರೆಸ್',
'Mumbai Express' => 'ಮುಂಬೈ ಎಕ್ಸ್‌ಪ್ರೆಸ್'

);
    

    // Check if the station name exists in the mapping
    if (array_key_exists($stationName, $stationMap)) {
        return $stationMap[$stationName];
    } else {
        return $stationName; // Return the original name if no mapping is found
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Railway Seat Availability System - Display</title>
    <link rel="stylesheet" href="style1.css">
</head>

<body>
    <div class="heading">
        <h1>ರೈಲ್ವೆ ಸೀಟ್ ಲಭ್ಯತೆ ವ್ಯವಸ್ಥೆ</h1>
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
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo convertToKan($row['from_station']); ?></td>
            <td><?php echo convertToKan($row['to_station']); ?></td>
            <td><?php echo convertToKan($row['allclasses']); ?></td>
            <td><?php echo convertToKan($row['quota']); ?></td>
            <td><?php echo $row['date']; ?></td>
            <td><?php echo $row['seats_available']; ?></td>
            <td><?php echo $row['fare']; ?></td>
            <td><?php echo $row['trainid']; ?></td>
            <td><?php echo convertToKan($row['trainname']); ?></td>
        </tr>
        <?php } ?>
    </table>

    <script>
    let synth = window.speechSynthesis;
    let utterance;

    function speakTable() {
        const table = document.getElementById('results-table');
        const totalRows = <?php echo $totalRows; ?>;
        let text = `ಲಭ್ಯವಿರುವ ರೈಲುಗಳು{totalRows} ಇವೆ. `;
        let currentRow = 2;

        for (let i = 1; i < table.rows.length; i++) {
            text += `ರೈಲು ${currentRow - 1} ವಿವರಗಳು ಹೀಗಿವೆ. `;

            const row = table.rows[i];
            for (let j = 0; j < row.cells.length; j++) {
                const columnHeader = table.rows[0].cells[j].innerText;
                const cellValue = row.cells[j].innerText;

                switch (columnHeader) {

                    case 'FROM':
                        text += `ಪ್ರಯಾಣದ ಮೂಲಸ್ಥಳ ${cellValue}. `;
                        break;

                    case 'TO':
                        text += `ಪ್ರಯಾಣದ ಗುರಿಸ್ಥಾನ ${cellValue}. `;

                        break;
                    case 'DATE':
                        text += `ದಿನಾಂಕ ${cellValue}. `;

                        break;
                    case 'TRAINNAME':
                        text += `ರೈಲು ಹೆಸರು ${cellValue}. `;

                        break;
                    case 'CLASS':
                        text += `ತರಗತಿ ${cellValue}. `;

                        break;
                    case 'QUOTA':
                        text += `ಕೋಟಾ ${cellValue}. `;

                        break;
                    case 'SEATS AVAILABLE':
                        text += `ಹೊಂದಿಕೆಯಲ್ಲಿರುವ ಒಟ್ಟು ಸೀಟುಗಳು ${cellValue}. `;

                        break;
                    default:
                        break;
                }
            }

            text += '. ';
            currentRow++;
        }

        utterance = new SpeechSynthesisUtterance(text);
        utterance.lang = 'kn-IN'; // Set the language to Hindi
        utterance.pitch = 1;
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