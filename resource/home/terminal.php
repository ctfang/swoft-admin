<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title>Terminal</title>
    <meta name="author" content="Jakub Jankiewicz - jcubic&#64;onet.pl"/>
    <meta name="Description" content="Demonstration for JQuery Terminal Emulator using call automaticly JSON-RPC service (in php) with authentication."/>
    <script src="<?php admin_src(); ?>terminal/js/jquery-1.7.1.min.js"></script>
    <script src="<?php admin_src(); ?>terminal/js/jquery.mousewheel-min.js"></script>
    <script src="<?php admin_src(); ?>terminal/js/jquery.terminal.min.js"></script>
    <link href="<?php admin_src(); ?>terminal/css/jquery.terminal.min.css" rel="stylesheet"/>
    <script src="https://unpkg.com/js-polyfills/keyboard.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>
<body>

<script>
    var term;
    jQuery(function($) {
        var id = 1;
        term = $('body').terminal(function(command, term) {
            if (command == 'help') {
                term.echo("log,quit");
            } else if (command == 'log'){
                term.push(function(command, term) {
                    if (command == 'quit') {
                        term.pop()
                    } else {
                        term.echo('unknown command ' + command);
                    }
                }, {
                    prompt: 'log> ',
                    name: 'log'
                });
            }  else {
                term.echo("unknow command " + command);
            }
        }, {
            greetings: "命令行执行辅助,help or bin/swoft *",
            prompt: 'bin/swoft> ',
            onBlur: function() {
                // prevent loosing focus
                return false;
            }
        });
    });

</script>
</body>
</html>
