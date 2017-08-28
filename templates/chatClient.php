<!--<!doctype html>
<html><head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0-beta1/jquery.min.js"></script>
<script src="./js/chatClientOld.js"></script>
<style type="text/css">
#send_message_form {
  position: fixed;
  z-index: 100; 
  bottom: 0; 
  left: 0;
  width: 100%;
  background-color: white;
}
#message_log{
  padding-bottom: 50px;
}
</style>
<meta charset="utf-8">
<title></title>
</head><body>
<div id="message_log"></div>
<form id="send_message_form" action="" method="post">
Sender: <input type="text" name="sender" value="sender"><br>
Message: <input type="text" name="message_text" autofocus="on" autocomplete="off">
<input type="submit" value="Submit"></form>
</body></html>-->

<!doctype html>
<html>
    <head>
        <style type="text/css">
            #send_message_form {
                position: fixed;
                z-index: 100; 
                bottom: 0; 
                left: 0;
                width: 100%;
                background-color: white;
            }
            #message_log{
                padding-bottom: 50px;
            }
        </style>
        <style>
            * {
                box-sizing: border-box;
            }

            body {
                background-color: #edeff2;
                font-family: "Calibri", "Roboto", sans-serif;
            }

            .chat_window {
                position: absolute;
                width: 100%;
                height: 100%;
                border-radius: 10px;
                background-color: #fff;
                left: 50%;
                top: 0px;
                transform: translateX(-50%) translateY(-50%);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
                background-color: #f8f8f8;
            }

            .top_menu {
                background-color: #fff;
                width: 100%;
                padding: 20px 0 15px;
                box-shadow: 0 1px 30px rgba(0, 0, 0, 0.1);
            }
            .top_menu .buttons {
                margin: 3px 0 0 20px;
                position: absolute;
            }
            .top_menu .buttons .button {
                width: 16px;
                height: 16px;
                border-radius: 50%;
                display: inline-block;
                margin-right: 10px;
                position: relative;
            }
            .top_menu .buttons .button.close {
                background-color: #f5886e;
            }
            .top_menu .buttons .button.minimize {
                background-color: #fdbf68;
            }
            .top_menu .buttons .button.maximize {
                background-color: #a3d063;
            }
            .top_menu .title {
                text-align: center;
                color: #bcbdc0;
                font-size: 20px;
            }

            .messages {
                position: relative;
                list-style: none;
                padding: 20px 10px 0 10px;
                margin: 0;
                height: 347px;
                overflow: scroll;
            }
            .messages .message {
                clear: both;
                overflow: hidden;
                margin-bottom: 20px;
                transition: all 0.5s linear;
                opacity: 0;
            }
            .messages .message.left .avatar {
                background-color: #f5886e;
                float: left;
            }
            .messages .message.left .text_wrapper {
                background-color: #ffe6cb;
                margin-left: 20px;
            }
            .messages .message.left .text_wrapper::after, .messages .message.left .text_wrapper::before {
                right: 100%;
                border-right-color: #ffe6cb;
            }
            .messages .message.left .text {
                color: #c48843;
            }
            .messages .message.right .avatar {
                background-color: #fdbf68;
                float: right;
            }
            .messages .message.right .text_wrapper {
                background-color: #c7eafc;
                margin-right: 20px;
                float: right;
            }
            .messages .message.right .text_wrapper::after, .messages .message.right .text_wrapper::before {
                left: 100%;
                border-left-color: #c7eafc;
            }
            .messages .message.right .text {
                color: #45829b;
            }
            .messages .message.appeared {
                opacity: 1;
            }
            .messages .message .avatar {
                width: 60px;
                height: 60px;
                border-radius: 50%;
                display: inline-block;
            }
            .messages .message .text_wrapper {
                display: inline-block;
                padding: 20px;
                border-radius: 6px;
                width: calc(100% - 85px);
                min-width: 100px;
                position: relative;
            }
            .messages .message .text_wrapper::after, .messages .message .text_wrapper:before {
                top: 18px;
                border: solid transparent;
                content: " ";
                height: 0;
                width: 0;
                position: absolute;
                pointer-events: none;
            }
            .messages .message .text_wrapper::after {
                border-width: 13px;
                margin-top: 0px;
            }
            .messages .message .text_wrapper::before {
                border-width: 15px;
                margin-top: -2px;
            }
            .messages .message .text_wrapper .text {
                font-size: 18px;
                font-weight: 300;
            }

            .bottom_wrapper {
                position: relative !important;
                width: 100%;
                background-color: #fff;
                padding: 20px 20px;
                position: absolute;
                bottom: 0;
            }
            .bottom_wrapper .message_input_wrapper {
                display: inline-block;
                height: 50px;
                border-radius: 25px;
                border: 1px solid #bcbdc0;
                width: calc(100% - 160px);
                position: relative;
                padding: 0 20px;
            }
            .bottom_wrapper .message_input_wrapper .message_input {
                border: none;
                height: 100%;
                box-sizing: border-box;
                width: calc(100% - 40px);
                position: absolute;
                outline-width: 0;
                color: gray;
            }
            .bottom_wrapper .send_message {
                width: 140px;
                height: 50px;
                display: inline-block;
                border-radius: 50px;
                background-color: #a3d063;
                border: 2px solid #a3d063;
                color: #fff;
                cursor: pointer;
                transition: all 0.2s linear;
                text-align: center;
                float: right;
            }
            .bottom_wrapper .send_message:hover {
                color: #a3d063;
                background-color: #fff;
            }
            .bottom_wrapper .send_message .text {
                font-size: 18px;
                font-weight: 300;
                display: inline-block;
                line-height: 48px;
            }

            .message_template {
                display: none;
            }

        </style>
        <meta charset="utf-8" />
    <link href="./css/bootstrap.min.css" rel="stylesheet" />
    <title></title>
</head>
<body>
<div class="col-md-9">
<?php /*  */ ?>

    <div class="chat_window" >
        <div class="top_menu">
            <div class="buttons">
                <div class="button close"></div>
                <div class="button minimize"></div>
                <div class="button maximize"></div>
            </div>
            <div class="title">Chat</div>
        </div>
        <ul class="messages" data-bind="foreach: chats, attr: { style: 'height : '+ windowHeight() + 'px;' }">
            <li class="message left appeared" data-bind="ifnot: $root.leftRightCheck(senderId)">
                <div class="avatar"><img data-bind="attr: {src : './img/avatars/'+image}" class="img-responsive"/></div>
                <div class="text_wrapper">
                    <div class="text"  data-bind="text: messageText"></div>
                </div>
                <span data-bind="text: name"></span>
            </li>

            <li class="message right appeared" data-bind="if: $root.leftRightCheck(senderId)">
                <div class="avatar"><img data-bind="attr: {src : './img/avatars/'+image}" class="img-responsive"/></div>
                <div class="text_wrapper">
                    <div class="text"  data-bind="text: messageText"></div>
                </div>
                <span data-bind="text: name"></span>
            </li>
        </ul>
        <form class="bottom_wrapper clearfix" data-bind="enable: hasSenderId, submit: addChat">
            <div class="message_input_wrapper">
                <input class="message_input" placeholder="Type your message here..." data-bind="enable: hasSenderId, value: newChatLine"/>
            </div>
            <button type="submit"  data-bind="enable: hasSenderId, submit: addChat" class="send_message">
                <div class="icon"></div>
                <div class="text">Send</div>
            </button>
        </form>
    </div>
</div>
<div class="col-md-3">
    <ul class="list-group" data-bind="foreach: activeUsers">
        <li class="list-group-item">
            <div class="row clearfix">
                <div class="col-md-3">
                    <img data-bind="attr: { src : './img/avatars/'+image }" class="img-responsive" />            
                </div>
                <div class="col-md-9">
                    <h6 data-bind="text: name"></h6>
                    <span data-bind="text: creationTimestamp"></span>
                </div>
            </div>
       </li>
    </ul>
</div>

<div class="modal fade" tabindex="-1" role="dialog" data-bind="modal:showDialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">title</h4>

            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input class="form-control" type="text" auto-complete="off" placeholder="Nick Name" data-bind="value: sender">
                </div>
                <ul class="row clearfix list-unstyled" data-bind="foreach: avatars">
                    <li class="col-md-3">
                        <input type="radio" data-bind="value: id, checked: $parent.avatarId" />
                        <img data-bind="attr: { src: image }, click: $root.checkRadioBox" class="img-responsive" />
                    </li>   
                    <!-- ko if: $index % 4 == 3 -->
                    <div class="clearfix"></div>
                    <!-- /ko -->
                </ul>
            </div>
            <div class="modal-footer">
                <?php //<button type="button" class="btn btn-primary btn-xs" data-bind="click : submit">Close</button> ?>
                <button type="button" class="btn btn-primary btn-xs" data-dismiss="modal" data-bind="click: setSenderAndAvatar">Close</button>
            </div>
        </div>
    </div>
    <script src="./js/jquery-3.2.1.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/knockout.js"></script>
    <script src="./js/cookieHelper.js"></script>
    <script src="./js/koBindingHandlerModal.js"></script>
    <script src="./js/chatClient.js"></script>
</body>
</html>