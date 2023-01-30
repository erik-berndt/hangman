<?php

//: check input - '#' start new game!
if (isset($_POST['guess'])) {	
	$guess = strtoupper($_POST['guess']);
	if ($guess == '#') {
		session_destroy();
		header("Refresh:0");
	}

  //: check letter match
  if (in_array($guess, $letters) && !in_array($guess,     $_SESSION['right'])) {
    array_push($_SESSION['right'], $guess);
  } else if (!in_array($guess, $letters) && !in_array($guess, $_SESSION['wrong']) && $guess != '') {
    array_push($_SESSION['wrong'], $guess);
  }
}

//: full solution given
if (isset($_POST['solution'])) {
  $res = strtoupper(trim($_POST['solution']));
  if ($res == $_SESSION['randPhrase']) {
    $_SESSION['right'] = str_split($res);
  } else if (sizeof(str_split($res)) > 1 && $res != $_SESSION['randPhrase']){
    array_push($_SESSION['wrong'], 'x');
  }
}

//: update score variables
$right   = sizeof($_SESSION['right']);
$wrong   = sizeof($_SESSION['wrong']);
$total   = $right + $wrong;


//: check letters  - create $result for final comparison
echo "<div class='phrase'>";
foreach($letters as $letter) {
if ($letter == ' ' || $letter == '-') {
  echo "<div class='letter space'>$letter</div>";
  $result = $result . $letter;
  continue;
} else if (in_array($letter, $_SESSION['right'])) {
  $letter = $letter;
} else {
  if ($wrong > 4) {
    $letter = $letter;
  } else {
  $letter = ' ';
  }
}
echo "<div class='letter'>$letter</div>";
$result = $result . $letter;
}
echo "</div>";

echo "<div class='letterblock'>";
if ($wrong > 4) {
  //: you lose
  echo "<div class='lose'>
          game over
        </div>
        <div class='newGame'>
          <span>
            neues Spiel? # eingeben!
          <span>
        </div>";
session_destroy();
  //: you win
} else if ($result == $_SESSION['randPhrase']) {
  echo "<div class='win'>
          Yeeehaw!
        </div>
        <div class='newGame'>
          <span>
            neues Spiel? # eingeben!
          <span>
        </div>";
  session_destroy();
} else {
//: create letterblock
$i = 0;
foreach($alpha as $abc) {
  if ($i % 7 == 0) {
    echo "<div class='blockline'>";
    $abc = ' ' . $abc;
  }
  if (in_array(trim($abc), $_SESSION['wrong']) || in_array(trim($abc), $_SESSION['right'])) {
    if ($i % 7 == 0) {
      $abc = ' 📌';
    } else {
    $abc = '📌';
    }
  } else {
    $abc = $abc . ' ';
  }
  echo "<div class='blockletter'><pre>$abc</pre></div>";
  if ($i % 7 == 6) {
    echo "</div>";
  }
  $i++;
}
echo "</div>";
}

?>