<?php
/**
 * example.php
 *
 * @author Bennett Stone
 * @link phpdevtips.com
 * @version 1.0
 * @date 19-May-2013
 * @package Flash Messages
 **/

require( 'function.php' );

//Set the first flash message with default class
flash( 'example_message', 'This content will show up on123 example2.php' );

//Set the second flash with an error class
flash( 'example_class', 'This content will show up on example2.php with the error class', 'error' );
?>
<html>
<head>
    <title>Example Session Based Flash Messages</title>
</head>
<body>
    <h1>Loading this page will set a session based flash message</h1>
    <p>
        <a href="example2.php">Click here to see the message</a>
    </p>
    
</body>
</html>