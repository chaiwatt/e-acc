<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <style>
            #style{
                padding: 5px;
                margin: 0;
            }
            #customers td, #customers th {
                border: 1px solid #ddd;
                padding: 8px;
            }
            #customers th {
                padding-top: 12px;
                padding-bottom: 12px;
                text-align: left;
                background-color: #66ccff;
                color: #000000;
            }
            .indent-body {
                text-indent: 30px;
            }
        </style>
    </head>
    <body>
        <div id="style">
            <p>
                เรื่อง {{ $subject }}
            </p>
            <p class="indent-body">
                {{ $body }}
            </p>

        </div>
    </body>
</html>
