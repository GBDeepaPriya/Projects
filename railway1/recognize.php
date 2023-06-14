<?php
if (isset($_POST['recordedWord'])) {
  $recordedWord = $_POST['recordedWord'];
  $file = fopen('recordedWord.txt', 'a');
  fwrite($file, $recordedWord . "\n");
  fclose($file);
}
?>
<?php
if (isset($_POST['recordedWord'])) {
  $recordedWord = strtoupper(trim($_POST['recordedWord']));
  $file = file_get_contents('wordList.txt');
  $keywords = explode("\n", $file);
  $result = findBestMatch($recordedWord, $keywords);
  $bestMatch = $result['match'];
  $similarity = $result['similarity'];
  if ($bestMatch != 'NO MATCH') {
    echo('Recorded word saved successfully, Matched keyword: ' . $bestMatch . ' (similarity: ' . ($similarity + 1) . '%)');
  } else {
    echo('Recorded word saved successfully, but no matching keyword found.');
  }
}

function findBestMatch($recordedWord, $wordList) {
  $maxSimilarity = 0;
  $bestMatch = '';
  foreach ($wordList as $word) {
    $similarity = similar_text($recordedWord, $word);
    if ($similarity > $maxSimilarity) {
      $maxSimilarity = $similarity;
      $bestMatch = $word;
    }
  }
  if ($maxSimilarity > 0) {
    return array('match' => $bestMatch, 'similarity' => $maxSimilarity);
  } else {
    return array('match' => 'NO MATCH', 'similarity' => 0);
  }
}
?>