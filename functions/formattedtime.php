<?php

function formatdate(string $date) : string {
    switch(date("F", strtotime($date))) {
        case "January":
            $month = "\\J\\a\\n\\u\\a\\r\\i";
            break;
        case "February":
            $month = "\\F\\e\\b\\r\\u\\a\\r\\i";
            break;
        case "March":
            $month = "\\M\\a\\a\\r\\t";
            break;
        case "May":
            $month = "\\M\\e\\i";
            break;
        case "June":
            $month = "\\J\\u\\n\\i";
            break;
        case "July":
            $month = "\\J\\u\\l\\i";
            break;
        case "August":
            $month = "\\A\\u\\g\\u\\s\\t\\u\\s";
            break;
        case "October":
            $month = "\\O\\k\\t\\o\\b\\e\\r";
            break;
        default:
            break;
    }

    return (isset($month)) ? date("d $month Y", strtotime($date)) : date("d F Y", strtotime($date));
}