<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Popup</title>

    <style>
    .popup{
        position: relative;
        display: inline-block;
        cursor: pointer;
        -webkit-user-select:  none;
        -moz-user-select:  none;
        -ms-user-select:  none;
        -o-user-select:  none;
        user-select:  none;
    }

    .popup .popuptext{
        visibility: hidden;
        width: 160px;
        background-color: lime;
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 8px 0;
        position: absolute;
        z-index: 1;
        bottom: 125%;
        left: 50%;
        margin-left: -80px;
    }
    .popup .popuptext::after{
        /* content: "";
        position: absolute;
        top: 100%;
        left: 50%;
        margin-left: -5px;
        border-width: 5px;
        border-style: solid;
        border-color: #555 transparent; */
    }
    .popup .show{
        visibility: visible;
        -webkit-animation: fadeIn 1s;
        animation: fadeIn 1s;

    }
    @-webkit-keyframes fadeIn{
        from{opacity:0;}
        to{opacity:1}
    }
    @keyframes fadeIn{
        from{opacity:0;}
        to{opacity:1}
    }
    </style>
</head>
<body>
    <h2> popup example</h2>
    <div class="popup" onclick="my()">
    Click me to toggle the popup !

    <span class="popuptext" id="mypopup">popup example</span>
    </div>
    <script>
    // function my(){
    // var popup = document.getElementById("mypopup");
    // popup.classList.toggle("show");
    // }
    </script>

<script src="layout/js/jquery-2.2.4.min.js"></script>
    <script>
    $(function(){
        $('.popup').on('click',function(){
    var popup =$("#mypopup");
    popup.toggleClass("show");
    });
    });
    
    </script>
</body>
</html>