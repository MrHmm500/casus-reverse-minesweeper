<?php
$jsonTestCases = file_get_contents('testcases.json');
$testCases = json_decode($jsonTestCases);
foreach($testCases as $caseName => $caseData) {
    echo "-----------------------------------<br />";
    echo $caseName . ' wordt getest<br />';
    echo 'expected output: <br />';
    echo str_replace("\n", '<br />', str_replace(' ', '&nbsp;', $caseData->expectedOutput)) . '<br /><br />';

    $input = explode("\n", $caseData->input);

    echo "-----------------------------------<br />";
    echo "actual output:<br />";

    extractOutputFromInput($input);

    echo "<br />";
}

function extractOutputFromInput($blockArray) {
    $bombs = [];
    foreach ($blockArray as $y => $block) {
        foreach (str_split($block) as $x => $letter) {
            if ($letter == 'x') {
                $bombs[] = $y . ' ' . $x;
            }
        }
    }

    $output = [];
    foreach ($blockArray as $x => $row) {
        foreach (str_split($row) as $y => $row2) {
            $output[$x][$y] = '.';
            foreach([
                        ($x+1 . ' ' . $y),
                        (($x+1) . ' ' . ($y+1)),
                        (($x) . ' ' . ($y+1)),
                        (($x-1) . ' ' . ($y)),
                        (($x-1) . ' ' . ($y-1)),
                        (($x) . ' ' . ($y-1)),
                        (($x+1) . ' ' . ($y-1)),
                        (($x-1) . ' ' . ($y+1)),

                    ] as $try) {
                if(
                    in_array($try, $bombs) && in_array($x . ' ' . $y, $bombs) == false
                ) {
                    $output[$x][$y] = ($output[$x][$y] == '.') ? 1 : $output[$x][$y] + 1;
                }
            }
        }
    }

    $outputFormatted = [];
    foreach($output as $x => $row) {
        $outputFormatted[$x] = '';
        foreach($row as $y) {
            $outputFormatted[$x] .= $y;
        }
    }
    foreach($outputFormatted as $outputLine) {
        echo ("$outputLine<br />");
    }
}