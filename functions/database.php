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


/*
 *                         
 * @param string $sql: Give the sql query to execute                                                                                    
 * @param int $failCode: Use a code for fail messages, You can easily create 1 above                        
 * @param ?string $paramchars: Use this when need to use WHERE conditions -> Use given type: s, i, d or b       
 * @param ...$BindParamVars: Use this when need to use WHERE conditions -> Use known DB variables                                                           
 *                                                                                                  
 * By:          Joris Hummel                                                                         
 *                                                                                                   
 */
function stmtExec(string $sql, int $failCode = 0, ?string $paramChars = NULL, ...$bindParamVars) : array| bool {


    //Require function.php
    require_once('function.php');

    if($conn = connectDB();) {
        if(mysqli_select_db($conn, $db)) {
            // Check if the statement can be prepared
            if($stmt = mysqli_prepare($conn, $sql)) {

                // If true
                // Check if the statement needs to bind
                if(substr_count($sql, "?")) {
                    
                    // If true
                    // Check if the bind param chars are set
                    if(!empty($paramChars)) {

                        // Check if the given chars are valid
                        for ($i=0; $i<strlen($paramChars); $i++) {
                            switch($paramChars[$i]) {
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
                            if(strlen($paramChars) == substr_count($sql, "?")) {

                                // If true
                                // Check if there are variable names given in the parameters
                                if(!empty($bindParamVars)) {

                                    // If true
                                    // Check if the amount of variables is the same as the bind request in the statement
                                    if(count($bindParamVars) == substr_count($sql, "?")) {
                                        
                                        // If true
                                        // Check if it's possible to bind and continue the function
                                        if(!mysqli_stmt_bind_param($stmt, $paramChars, ...$bindParamVars)) {
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
                        $totalFromKey = substr_count($sql, "FROM");
                        $totalEndKey = substr_count($sql, ")");
                        $totalOpenKey = substr_count($sql, "(");
                        
                        // Check FROM
                        for($i = 0; $i < $totalFromKey; $i++) {
                            if($i === 0) {
                                $posFromKey[$i] = strpos($sql, "FROM");
                            } else {
                                $posFromKey[$i] = strpos($sql, "FROM", $posFromKey[$i - 1] + 1);
                                if($i - 1 >= 0 && $posFromKey[$i] == $posFromKey[$i - 1]) {
                                    $posFromKey[$i] = strpos($sql, "FROM", $posFromKey[$i - 1] + 1);
                                }
                            }
                        }

                        // Check nested query open sign
                        for($i = 0; $i < $totalOpenKey; $i++) {
                            if($i === 0) {
                                $posOpenKey[$i] = strpos($sql, "(");
                            } else {
                                $posOpenKey[$i] = strpos($sql, "(", $posOpenKey[$i - 1] + 1);
                                if($i - 1 >= 0 && $posOpenKey[$i] == $posOpenKey[$i - 1]) {
                                    $posOpenKey[$i] = strpos($sql, "(", $posOpenKey[$i - 1] + 1);
                                }
                            }
                        }

                        // Check nested query end sign
                        for($i = 0; $i < $totalEndKey; $i++) {
                            if($i === 0) {
                                $posEndKey[$i] = strpos($sql, ")");
                            } else {
                                $posEndKey[$i] = strpos($sql, ")", $posEndKey[$i - 1] + 1);
                                if($i - 1 >= 0 && $posEndKey[$i] == $posEndKey[$i - 1]) {
                                    $posEndKey[$i] = strpos($sql, ")", $posEndKey[$i - 1] + 1);
                                }
                            }
                        }
                        
                        // Get Right positions in nested queries and form for array values
                        for($k = 0; $k < count($posFromKey); $k++) {
                            $posFrom = $posFromKey[$k];
                            if(!empty($posEndKey) && !empty($posOpenKey)) {

                                if($posOpenKey[0] > $posFromKey[0]) {
                                    goto finish;
                                }
                            
                                for($i = 0; $i < count($posOpenKey); $i++) {
                                    $posOpen = $posOpenKey[$i];
                                    $posEnd = $posEndKey[$i];
                                    
                                    if($posFrom > $posEnd && $posEnd > $posOpen) {
                                        if($i + 1 < $totalOpenKey && $posOpenKey[$i + 1] > $posFrom && $posEndKey[$i + 1] > $posOpenKey[$i + 1]) {
                                            goto finish;
                                        } else if($i + 1 == $totalOpenKey) {
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
                            $selectResults = substr($sql, 7, $posFrom - 8);
                        } else {
                            $selectResults = substr($sql, 7);
                        }
                        
                        $selectResults = explode(",", $selectResults);

                        for($i = 0; $i < count($selectResults); $i++) {
                            if(str_contains($selectResults[$i], " AS ")) {
                                $selectResults[$i] = substr($selectResults[$i], strpos($selectResults[$i], " AS ") + 4);
                            }
                            $selectResults[$i] = str_replace('\s', '', $selectResults[$i]);
                            $selectResults[$i] = trim($selectResults[$i]);
                            $bindResults[] = $selectResults[$i];
                        }

                        if(mysqli_stmt_bind_result($stmt, ...$bindResults)) {
                            $i = 0;
                            while(mysqli_stmt_fetch($stmt)) {
                                $j = 0;
                                foreach($bindResults as $result) {
                                    $results[$selectResults[$j]][] = $result;
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