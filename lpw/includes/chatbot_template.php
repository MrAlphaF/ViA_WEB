<!-- includes/chatbot_template.php -->
<div id="chatbot-toggler">
    Chat
</div>

<div id="chatbot-window">
    <div id="chatbot-header">
        <span>FAQ Chat</span>
        <button id="close-chatbot" aria-label="Close chat window">×</button>
    </div>
    <div id="chatbot-body">
        <div id="faq-questions">
            <!-- FAQ questions will be loaded here by JavaScript -->
        </div>
        <hr>
        <div id="faq-answer">
            <p>Hello! Click on a question above to see the answer.</p>
        </div>
    </div>
</div>

<script src="js/chatbot.js" defer></script>