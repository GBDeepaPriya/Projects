<?php
session_start();
include("connection.php");

$query = $_SESSION['query1'];
$result = mysqli_query($conn, $query);
$totalRows = mysqli_num_rows($result);

function convertToHindi($stationName) {
    // Map English station names to Hindi equivalents
    $stationMap = array(
        'YESVANTPUR JN - YPR' => 'यशवंतपुर जंक्शन',
        'KOLKATA - KOAA' => 'कोलकाता',
        'LOKMANYATILAK T - LTT' => 'लोकमान्य तिलक',
        'RAJENDRANAGAR T - RJPB' => 'राजेन्द्रनगर',
        'BANDRA TERMINUS - BDT' => 'बांद्रा टर्मिनस',
        'VISAKHAPATNAM - VSKP' => 'विशाखापत्तनम',
        'ANAND VIHAR TRM - ANVT' => 'आनंद विहार टर्मिनस',
        'MUMBAI CENTRAL - MMCT' => 'मुंबई सेंट्रल',
        'C SHIVAJI MAH T - CSMT' => 'छत्रपति शिवाजी महाराज टर्मिनस',
        'GUWAHATI - GHY' => 'गुवाहाटी',
        'KACHEGUDA - KCG' => 'काचिगुडा',
        'CHANDIGARH - CDG' => 'चंडीगढ़',
        'GORAKHPUR JN - GKP' => 'गोरखपुर',
        'BHUBANESWAR - BBS' => 'भुवनेश्वर',
        'GUNTUR JN - GNT' => 'गुंटूर',
        'KHARAGPUR JN - KGP' => 'खड़गपुर',
        'BAREILLY - BE' => 'बरेली',
        'KRISHNARAJAPURM - KJM' => 'कृष्णराजापुरम',
        'KOZHIKKODE - CLT' => 'कोझिकोड',
        'KANPUR CENTRAL - CNB' => 'कानपुर सेंट्रल',
        'GWALIOR - GWL' => 'ग्वालियर',
        'GHAZIABAD - GZB' => 'गाज़ियाबाद',
        'RANI KAMALAPATI - RKMP' => 'रानी कमलापति',
        'KOTA JN - KOTA' => 'कोटा',
        'KATPADI JN - KPD' => 'कटपदी',
        'BIKANER JN - BKN' => 'बीकानेर',
        'DELHI S ROHILLA - DEE' => 'दिल्ली एस रोहिल्ला',
        'HARIDWAR JN - HW' => 'हरिद्वार',
        'HOWRAH JN - HWH' => 'हावड़ा',
        'HYDERABAD DECAN - HYB' => 'हैदराबाद दक्षिण',
        'INDORE JN BG - INDB' => 'इंदौर',
        'DELHI - DLI' => 'दिल्ली',
        'JAMMU TAWI - JAT' => 'जम्मू तवी',
        'JABALPUR - JBP' => 'जबलपुर',
        'AHMEDABAD JN - ADI' => 'अहमदाबाद',
        'BHOPAL JN - BPL' => 'भोपाल',
        'VADODARA JN - BRC' => 'वडोदरा',
        'V LAKSHMIBAI - VGLB' => 'वीरांगना लक्ष्मीबाई',
        'AGRA CANTT - AGC' => 'आगरा कैंट',
        'AJMER JN - AII' => 'अजमेर',
        'VARANASI JN - BSB' => 'वाराणसी',
        'DADAR - DR' => 'दादर',
        'PRAYAGRAJ JN. - PRYJ' => 'प्रयागराज',
        'BILASPUR JN - BSP' => 'बिलासपुर',
        'JAIPUR - JP' => 'जयपुर',
        'BORIVALI - BVI' => 'बोरिवली',
        'ERODE JN - ED' => 'इरोड',
        'ERNAKULAM TOWN - ERN' => 'एर्नाकुलम टाउन',
        'ERNAKULAM JN - ERS' => 'एर्नाकुलम',
        'JODHPUR JN - JU' => 'जोधपुर',
        'AMRITSAR JN - ASR' => 'अमृतसर',
        'AURANGABAD - AWB' => 'औरंगाबाद',
        'VIJAYAWADA JN - BZA' => 'विजयवाड़ा',
        'KANNUR - CAN' => 'कन्नूर',
        'COIMBATORE JN - CBE' => 'कोयंबटूर',
        'PUNE JN - PUNE' => 'पुणे',
        'PURI - PURI' => 'पुरी',
        'KALYAN JN - KYN' => 'कल्याण',
        'MYSURU JN - MYS' => 'मैसूर',
        'RAIPUR JN - R' => 'रायपुर',
    'LUDHIANA JN - LDH' => 'लुधियाना',
    'NEW DELHI - NDLS' => 'नई दिल्ली',
    'RAJAHMUNDRY - RJY' => 'राजमंद्री',
    'LUCKNOW NE - LJN' => 'लखनऊ नॉर्थ',
    'LUCKNOW NR - LKO' => 'लखनऊ जंक्शन',
    'H SAHIB NANDED - NED' => 'हजूर साहिब नांदेड़',
    'NAGPUR - NGP' => 'नागपुर',
    'NEW JALPAIGURI - NJP' => 'न्यू जलपाईगुड़ी',
    'NASHIK ROAD - NK' => 'नासिक रोड',
    'SURAT - ST' => 'सूरत',
    'RANCHI - RNC' => 'रांची',
    'MADGAON - MAO' => 'मडगांव',
    'MGR CHENNAI CTL - MAS' => 'चेन्नई सेंट्रल',
    'SOLAPUR JN - SUR' => 'सोलापुर',
    'MADURAI JN - MDU' => 'मदुरै',
    'SALEM JN - SA' => 'सलेम',
    'MUZAFFARPUR JN - MFP' => 'मुजफ्फरपुर',
    'H NIZAMUDDIN - NZM' => 'हजरत निजामुद्दीन',
    'TATANAGAR JN - TATA' => 'ततानगर',
    'TAMBARAM - TBM' => 'तम्बरम',
    'THRISUR - TCR' => 'त्रिशूर',
    'KSR BENGALURU - SBC' => 'कृष्णराजपुरम',
    'SECUNDERABAD JN - SC' => 'सिकंदराबाद',
    'SEALDAH - SDAH' => 'सीआलडाह',
    'DD UPADHYAYA JN - DDU' => 'दीनदयाल उपाध्याय',
    'TIRUNELVELI - TEN' => 'तिरुनेलवेली',
    'THANE - TNA' => 'ठाणे',
    'TIRUCHCHIRAPALI - TPJ' => 'तिरुचिरापल्ली',
    'TIRUPATI - TPTY' => 'तिरुपति',
    'CHENNAI EGMORE - MS' => 'चेन्नई एग्मोर',
    'PATNA JN - PNBE' => 'पटना',
    'PANVEL - PNVL' => 'पनवेल',
    'TRIVANDRUM CNTL - TVC' => 'त्रिवेंद्रम सेंट्रल',
    'SSS HUBBALLI JN - UBL' => 'हुब्बली',
    'MATHURA JN - MTJ' => 'मथुरा',
    'UDAIPUR CITY - UDZ' => 'उदयपुर सिटी',
    'UJJAIN JN - UJN' => 'उज्जैन',
    'AMBALA CANT JN - UMB' => 'अंबाला कैंट',
    'BANARAS - BSBS' => 'वाराणसी',
    'VAPI - VAPI' => 'वापी',
    'SORATH VANTHIL' => 'सौराष्ट्र वांटिल',

    'Anubhuti Class (EA)' => 'अनुभूति क्लास (ईए)',
    'AC First Class (1A)' => 'एसी पहली क्लास (1ए)',
    'Vistadome AC (EV)' => 'विस्ताडोम एसी (ईवी)',
    'Exec. Chair Car (EC)' => 'एक्जीक्यूटिव चेयर कार (ईसी)',
    'AC 2 Tier(2A)' => 'एसी द्वितीय टियर (2ए)',
    'First Class (FC)' => 'पहली क्लास (एफसी)',
    'AC 3 Tier (3A)' => 'एसी तृतीय टियर (3ए)',
    'AC 3 Economy (3E))' => 'एसी तृतीय आर्थिक (3ई)',
    'Vistadome Chair Car (VC)' => 'विस्ताडोम चेयर कार (वीसी)',
    'AC Chair car (CC)' => 'एसी चेयर कार (सीसी)',
    'Sleeper (SL)' => 'स्लीपर (एसएल)',
    'Vistadome Non AC (VS)' => 'विस्ताडोम गैर-एसी (वीएस)',
    'Second Sitting (2S)' => 'द्वितीय बैठक (2एस)',

    'GENERAL' => 'सामान्य',
    'LADIES' => 'महिला',
    'LOWER BERTH/SR.CITIZEN' => 'निचली बर्थ/वरिष्ठ नागरिक',
    'PERSON WITH DISABILITY' => 'विकलांग व्यक्ति',
    'TATKAL' => 'तत्काल',
    'PREMIUM TATKAL' => 'प्रीमियम तत्काल',

    'KR Express' => 'केआर एक्सप्रेस',
    'Agra Jaipur Express' => 'आगरा जयपुर एक्सप्रेस',
    'Lokamanya Express' => 'लोकमान्य एक्सप्रेस',
    'Yeshwanthpur Express'=> 'यशवंतपुर एक्सप्रेस'
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
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo convertToHindi($row['from_station']); ?></td>
            <td><?php echo convertToHindi($row['to_station']); ?></td>
            <td><?php echo convertToHindi($row['allclasses']); ?></td>
            <td><?php echo convertToHindi($row['quota']); ?></td>
            <td><?php echo $row['date']; ?></td>
            <td><?php echo $row['seats_available']; ?></td>
            <td><?php echo $row['fare']; ?></td>
            <td><?php echo $row['trainid']; ?></td>
            <td><?php echo convertToHindi($row['trainname']); ?></td>
        </tr>
        <?php } ?>
    </table>

    <script>
    let synth = window.speechSynthesis;
    let utterance;

    function speakTable() {
        const table = document.getElementById('results-table');
        const totalRows = <?php echo $totalRows; ?>;
        let text = `यहाँ ${totalRows} ट्रेनें उपलब्ध हैं. `;
        let currentRow = 2;

        for (let i = 1; i < table.rows.length; i++) {
            text += `प्रशिक्षण ${currentRow} का विवरण निम्नानुसार है. `;
            const row = table.rows[i];
            for (let j = 0; j < row.cells.length; j++) {
                const columnHeader = table.rows[0].cells[j].innerText;
                const cellValue = row.cells[j].innerText;

                switch (columnHeader) {

                    case 'FROM':
                        text += `यात्रा का स्रोत है ${cellValue}. `;
                        break;
                    case 'TO':
                        text += `यात्रा का गंतव्य है ${cellValue}. `;
                        break;
                    case 'DATE':
                        text += `तारीख है ${cellValue}. `;
                        break;
                    case 'TRAINNAME':
                        text += `प्रशिक्षण का नाम है ${cellValue}. `;
                        break;
                    case 'CLASS':
                        text += `वर्ग है ${cellValue}. `;
                        break;
                    case 'QUOTA':
                        text += `कोटा है ${cellValue}. `;
                        break;
                    case 'SEATS AVAILABLE':
                        text += `कुल उपलब्ध सीटें हैं ${cellValue}. `;
                        break;
                    default:
                        break;
                }
            }

            text += '. ';
            currentRow++;
        }

        utterance = new SpeechSynthesisUtterance(text);
        utterance.lang = 'hi-IN'; // Set the language to Hindi
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