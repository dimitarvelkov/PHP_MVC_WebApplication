<?php
renderMessages(INFO_MESSAGES_SESSION_KEY, 'info-messages');
renderMessages(ERROR_MESSAGES_SESSION_KEY, 'error-messages');

function renderMessages($messagesKey, $cssClass) {
    if (isset($_SESSION[$messagesKey]) && count($_SESSION[$messagesKey]) > 0) {
        echo  "<ul id='message' class='$cssClass'>";
        foreach ($_SESSION[$messagesKey] as $msg) {
            echo "<li>" . htmlspecialchars($msg) . '</li>';
        }
        echo '</ul>'."<script> $('#message').fadeOut(3500);</script>";
    }
    $_SESSION[$messagesKey] = [];
}
?>
