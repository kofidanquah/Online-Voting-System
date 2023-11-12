<?php 

function generateCandCode($prefix = 'CAN', $length=10) {
    $candCode =$prefix;
    for($i =strlen($prefix);$i<$length;$i++) {
        $randomCode = rand(1, 7);
        $candCode .= $randomCode;
    }
        return $candCode;
}


function generateVoterCode($prefix = 'VT', $length=7) {
    $voterCode =$prefix;
    for($i =strlen($prefix);$i<$length;$i++) {
        $randomCode = rand(1, 7);
        $voterCode .= $randomCode;
    }
        return $voterCode;
}

function generateVoterPassword($prefix = '', $length=4) {
    $voterPassword =$prefix;
    for($i =strlen($prefix);$i<$length;$i++) {
        $randomCode = rand(1, 9);
        $voterPassword .= $randomCode;
    }
        return $voterPassword;
}

?>