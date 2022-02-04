<?php

/*
=========================
PHPantom v1.0 
===== Features ==========
[*] Monitor dangerous functions
[*] You can pass custom functions array
[*] Outputs a nice table on the same page
[*] Check if the line has inputs or not
[*] Based on Xdebug extension  
========= TODO ==========
[+] Refactoring the code ( I wrote it without coffee :D)
[+] Read the whole function and find an input
[+] Add some regex for better results
======== ABOUT ==========
Written by HitmanAlharbi 
Twitter: @HitmanF15
=========================
*/

class PHPantom{

    // Array of dangerous functions
    public $dangerous = ['exec', 'passthru', 'shell_exec', 'system', 'proc_open', 'popen', 'curl_exec', 'curl_multi_exec',
    'parse_ini_file', 'show_source','extract', 'include', 'include_once', 'require', 'require_once', 'call_user_func',
    'eval', 'assert', 'file_get_contents', 'file_put_contents', 'unserialize'];

    // Array of user inputs
    public $inputs = ['$_GET', '$_POST', '$_FILE', 'php://input', '$_REQUEST', '$_COOKIE', '$_SERVER',
    'get_query_var', 'query_vars', 'Input::get', 'request->post()', 'request->post()'];


    // Starts when the class called
    function __construct($functions = null){
        // Maybe the user wants to pass specific functions
        if(!empty($functions) && is_array($functions)){
            // Set the dangerous functions passed by user
            $this->dangerous = $functions;
        }
        // Start functions monitor
        xdebug_start_function_monitor($this->dangerous);
    }


    // When it stopped print the output
    function __destruct(){
        // Stop functions monitor
        xdebug_stop_function_monitor();
        // Output the result
        $this->output();
    }

    // Output function *TODO some refactoring ...*
    function output(){
        // Open HTML tags
        echo "<div style='background-color: white; color: black;'><center></br><h1>PHPantom by HitmanAlharbi</h1></br><h2 style='color: red'>Monitored functions</h2></br><table style='width: 60%;'><tr><td style='width: 10%; font-weight: bold;'>Function</td><td style='width: 35%; font-weight: bold;'>File path</td><td style='width: 10%; font-weight: bold;'>Line number</td><td style='width: 15%; font-weight: bold;'>Input in the line</td><td style='font-weight: bold;'>PHP code</td></tr>";
        // Get the monitored functions
        $monitored = xdebug_get_monitored_functions();
        // Remove the duplicates (Multiple calls)
        $monitored = array_unique($monitored, SORT_REGULAR);
        // Loop for monitored functions 
        foreach($monitored as $func){
            // If the file's path is empty?
            if(!empty($func['filename'])){
                // Init a SplFileObject class with the file's path
                $file = new SplFileObject($func['filename']);
                // Go to a specific line
                $file->seek($func['lineno'] - 1);
                // Store the current line to a variable
                $line = trim($file->current());
                // Init a hasInput variable
                $hasInput = false;
                // Check if it has inputs? *It checks the current line only* 
                foreach ($this->inputs as $in) {
                    // If the line contains the input
                    if (strpos($line, $in) !== FALSE) { 
                        // Set the hasInput variable to true
                        $hasInput = true;
                    }
                }
                // Print the file's path + line number + code in a HTML table
                echo "<tr>
                <td style='color: brown' target='_blank'>".$func['function']."</td>
                <td><a style='color: purple' target='_blank' href='".$func['filename']."'>".$func['filename']."</a></td>
                <td style='color: black'>".$func['lineno']."</td>
                  <td>".($hasInput === true ? "<b style='color: green'>Maybe</b>" : "<b style='color: red'>No</b>")."</td>
                  <td style='color: blue'>$line</td>
                </tr>";
            }
        }
        // Close HTML tags
        echo "</table></br></br></center></div>";
    }

}
