<?php

function fail(?string $code = NULL, ?string $info = NULL) {
    switch ($code) {
        // Database Fail: Common
            case 'DB00':
                echo "Statement Preparation Error! $info";
                break;
            case 'DB01':
                echo "Statement Execution Error! $info";
                break;
            case 'DB02':
                echo "Cannot bind the result to the variables. $info";
                break;
            case 'DB03':
                echo "Could not connect to the database. $info";
                break;
            case 'DB04':
                echo "Could not connect to MySQL. $info";
                break;
        // Database Fail: With Binding
            case 'DB10':
                echo "No information variables are given while this is needed!";
                break;
            case 'DB11':
                echo "You have to give more information variables for this statement! You need to have $info variables.";
                break;
            case 'DB12':
                echo "You have to set chars for each bind parameter to execute this statement! \nChoose between 's' (string), 'i' (integer), 'd' (double) or 'b' (blob).";
                break;
            case 'DB13':
                echo "You have to give more / less chars for this statement! You need to have $info chars.";
                break;
            case 'DB14':
                echo "Cannot bind the parameters for this statement. $info";
                break;
            case 'DB15':
                echo "You have given invalid chars as bind chars! You only can choose between: 's' (string), 'i' (integer), 'd' (double) or 'b' (blob).";
                break;
        default:
            echo "Something went wrong";
            break;
    }
}


//////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                                                                                      //
// @Param $failCode: Use a code for fail messages, You can easily create 1 above                            //
// @Param $Paramchars: Use this when need to use WHERE conditions -> Use given type: s, i, d or b       //
// @Param $BindParamVars: Use this when need to use WHERE conditions -> Use known DB variables          //
// @Param $sql: Give the sql query to execute                                                           //
//                                                                                                      //
// By:          Joris Hummel                                                                            //
//                                                                                                      //
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function stmtExec(string $sql, int $failCode = 0, ?string $ParamChars = NULL, ...$BindParamVars) : array| bool {

    $host = "localhost";
    $user = "root";
    $pwd = "";
    $db = "battlebot";

    if($conn = mysqli_connect($host, $user, $pwd)) {
        if(mysqli_select_db($conn, $db)) {
            // Check if the statement can be prepared
            if($stmt = mysqli_prepare($conn, $sql)) {

                // If true
                // Check if the statement needs to bind
                if(substr_count($sql, "?")) {
                    
                    // If true
                    // Check if the bind param chars are set
                    if(!empty($ParamChars)) {

                        // Check if the given chars are valid
                        for ($i=0; $i<strlen($ParamChars); $i++) {
                            switch($ParamChars[$i]) {
                                case 's':
                                case 'i':
                                case 'd':
                                case 'b':
                                    // Valid, set $continue to true
                                    // Break the inner loop and continue the loop
                                    $continue = 1;
                                    break 1;
                                default:
                                    // Not valid, set $continue to false
                                    // Break the outer loop
                                    $continue = 0;
                                    break 2;
                            }
                        }
                        
                        if($continue) {
                            // If true
                            // Check if the length of the chars is the same as the total bind requests in the statement
                            if(strlen($ParamChars) == substr_count($sql, "?")) {

                                // If true
                                // Check if there are variable names given in the parameters
                                if(!empty($BindParamVars)) {

                                    // If true
                                    // Check if the amount of variables is the same as the bind request in the statement
                                    if(count($BindParamVars) == substr_count($sql, "?")) {
                                        
                                        // If true
                                        // Check if it's possible to bind and continue the function
                                        if(!mysqli_stmt_bind_param($stmt, $ParamChars, ...$BindParamVars)) {
                                            fail("DB".$failCode."4", mysqli_error($conn));
                                            return false;
                                        } 
                                    } else {
                                        fail("DB".$failCode."1", substr_count($sql, "?"));
                                        return false;
                                    }
                                } else {
                                    fail("DB".$failCode."0");
                                    return false;
                                }
                            } else {
                                fail("DB".$failCode."3", substr_count($sql, "?"));
                                return false;
                            }
                        } else {
                            fail("DB".$failCode."5");
                            return false;
                        }
                    } else {
                        fail("DB".$failCode."2");
                        return false;
                    }
                }  

                if(mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_store_result($stmt);
                    if(mysqli_stmt_num_rows($stmt) > 0) {

                        $sql = str_replace("DISTINCT ", "", $sql);
                        $totalFROMKey = substr_count($sql, "FROM");
                        $totalENDKey = substr_count($sql, ")");
                        $totalOPENKey = substr_count($sql, "(");
                        
                        // Check FROM
                        for($i = 0; $i < $totalFROMKey; $i++) {
                            if($i === 0) {
                                $posFROMKey[$i] = strpos($sql, "FROM");
                            } else {
                                $posFROMKey[$i] = strpos($sql, "FROM", $posFROMKey[$i - 1] + 1);
                                if($i - 1 >= 0 && $posFROMKey[$i] == $posFROMKey[$i - 1]) {
                                    $posFROMKey[$i] = strpos($sql, "FROM", $posFROMKey[$i - 1] + 1);
                                }
                            }
                        }

                        // Check nested query open sign
                        for($i = 0; $i < $totalOPENKey; $i++) {
                            if($i === 0) {
                                $posOPENKey[$i] = strpos($sql, "(");
                            } else {
                                $posOPENKey[$i] = strpos($sql, "(", $posOPENKey[$i - 1] + 1);
                                if($i - 1 >= 0 && $posOPENKey[$i] == $posOPENKey[$i - 1]) {
                                    $posOPENKey[$i] = strpos($sql, "(", $posOPENKey[$i - 1] + 1);
                                }
                            }
                        }

                        // Check nested query end sign
                        for($i = 0; $i < $totalENDKey; $i++) {
                            if($i === 0) {
                                $posENDKey[$i] = strpos($sql, ")");
                            } else {
                                $posENDKey[$i] = strpos($sql, ")", $posENDKey[$i - 1] + 1);
                                if($i - 1 >= 0 && $posENDKey[$i] == $posENDKey[$i - 1]) {
                                    $posENDKey[$i] = strpos($sql, ")", $posENDKey[$i - 1] + 1);
                                }
                            }
                        }
                        
                        // Get Right positions in nested queries and form for array values
                        for($k = 0; $k < count($posFROMKey); $k++) {
                            $posFrom = $posFROMKey[$k];
                            if(!empty($posENDKey) && !empty($posOPENKey)) {

                                if($posOPENKey[0] > $posFROMKey[0]) {
                                    goto finish;
                                }
                            
                                for($i = 0; $i < count($posOPENKey); $i++) {
                                    $posOpen = $posOPENKey[$i];
                                    $posEnd = $posENDKey[$i];
                                    
                                    if($posFrom > $posEnd && $posEnd > $posOpen) {
                                        if($i + 1 < $totalOPENKey && $posOPENKey[$i + 1] > $posFrom && $posENDKey[$i + 1] > $posOPENKey[$i + 1]) {
                                            goto finish;
                                        } else if($i + 1 == $totalOPENKey) {
                                            goto finish;
                                        }
                                    } else {
                                        $posFrom = 0;
                                    }
                                }
                            } 
                        }
                        finish:
                        if($posFrom != 0) {
                            $SelectResults = substr($sql, 7, $posFrom - 8);
                        } else {
                            $SelectResults = substr($sql, 7);
                        }
                        
                        $SelectResults = explode(",", $SelectResults);

                        for($i = 0; $i < count($SelectResults); $i++) {
                            if(str_contains($SelectResults[$i], " AS ")) {
                                $SelectResults[$i] = substr($SelectResults[$i], strpos($SelectResults[$i], " AS ") + 4);
                            }
                            $SelectResults[$i] = str_replace('\s', '', $SelectResults[$i]);
                            $SelectResults[$i] = trim($SelectResults[$i]);
                            $BindResults[] = $SelectResults[$i];
                        }

                        if(mysqli_stmt_bind_result($stmt, ...$BindResults)) {
                            $i = 0;
                            while(mysqli_stmt_fetch($stmt)) {
                                $j = 0;
                                foreach($BindResults as $Result) {
                                    $results[$SelectResults[$j]][] = $Result;
                                    $j++;
                                }
                                $i++;
                            }
                            mysqli_stmt_close($stmt);
                            return $results;
                        } else {
                            fail("DB".$failCode."2", mysqli_error($conn));
                            return false;
                        }
                    } else {
                        return true;
                    }
                } else {
                    fail("DB".$failCode."1", mysqli_error($conn));
                    return false;
                }

            } else {
                fail("DB00", mysqli_error($conn));
                echo $sql;
                return false;
            }
            mysqli_close($conn);
        } else if(str_contains($sql, "DATABASE")) {
            // Check if the statement can be prepared
            if($stmt = mysqli_prepare($conn, $sql)) {

                if(mysqli_stmt_execute($stmt)) {
                    return true;
                } else {
                    fail("DB".$failCode."1", mysqli_error($conn));
                    return false;
                }

            } else {
                fail("DB00", mysqli_error($conn));
                echo $sql;
                return false;
            }
            mysqli_close($conn);
        } else {
            fail("DB03", mysqli_error($conn));
            return false;
        }
    } else {
        fail("DB04", mysqli_error($conn));
        return false;
    }
}

// $type:   1 for print_r(), 0 or empty for var_dump()
function debug($var, int $type = 0) {
    echo "<pre>";
    if($type) {
        print_r($var);
    } else {
        var_dump($var);
    }
    echo "</pre>";
}