<!-- Floating Support Chat Widget -->
<style>
/* Floating Chat Icon */
.floating-chat-icon {
    position: fixed !important;
    bottom: 20px !important;
    right: 20px !important;
    left: auto !important;
    top: auto !important;
    width: 60px;
    height: 60px;
    background: #2196F3;
    border-radius: 50%;
    display: flex !important;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 4px 15px rgba(33, 150, 243, 0.4);
    z-index: 99999 !important;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.floating-chat-icon:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 20px rgba(33, 150, 243, 0.6);
}

.floating-chat-icon i {
    color: white;
    font-size: 28px;
}

.floating-chat-icon .chat-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #ff4757;
    color: white;
    font-size: 12px;
    font-weight: bold;
    padding: 2px 6px;
    border-radius: 10px;
    display: none;
}

/* Chat Window */
.chat-popup {
    position: fixed;
    bottom: 90px;
    right: 20px;
    width: 350px;
    height: 450px;
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 25px rgba(0, 0, 0, 0.2);
    z-index: 9998;
    display: none;
    flex-direction: column;
    overflow: hidden;
}

.chat-popup.active {
    display: flex;
}

.chat-header {
    background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
    color: white;
    padding: 15px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    
}


.chat-header-info {
    display: flex;
    align-items: center;
    gap: 10px;
}

.chat-header-info .avatar {
    width: 40px;
    height: 40px;
    background: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.chat-header-info .avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.chat-header-info .avatar i {
    color: #2196F3;
    font-size: 20px;
}

.chat-header-info h4 {
    margin: 0;
    font-size: 16px;
}

.chat-header-info span {
    font-size: 12px;
    opacity: 0.9;
}

.chat-close {
    background: none;
    border: none;
    color: white;
    font-size: 24px;
    cursor: pointer;
    padding: 0;
    line-height: 1;
}

.chat-close:hover {
    opacity: 0.8;
}

.chat-messages {
    flex: 1;
    padding: 15px;
    overflow-y: auto;
    background: #f8f9fa;
}

.message {
    margin-bottom: 15px;
    display: flex;
    flex-direction: column;
}

.message.support {
    align-items: flex-start;
}

.message.user {
    align-items: flex-end;
}

.message-bubble {
    max-width: 80%;
    padding: 10px 15px;
    border-radius: 15px;
    font-size: 14px;
    line-height: 1.4;
}

.message-sender {
    font-size: 11px;
    font-weight: bold;
    color: #2196F3;
    margin-bottom: 2px;
}

.message.support .message-bubble {
    background: #2196F3;
    color: white;
    border-bottom-left-radius: 3px;
}

.message.user .message-bubble {
    background: #e9ecef;
    color: #333;
    border-bottom-right-radius: 3px;
}

.message-time {
    font-size: 10px;
    color: #999;
    margin-top: 5px;
}

.message.user .message-time {
    text-align: right;
}


/* Chat Input Area */
.chat-input-area {
    padding: 15px;
    border-top: 1px solid #e9ecef;
    display: flex;
    gap: 10px;
    background: white;
}

.chat-input-area input {
    flex: 1;
    padding: 10px 15px;
    border: 1px solid #ddd;
    border-radius: 25px;
    outline: none;
    font-size: 14px;
}

.chat-input-area input:focus {
    border-color: #2196F3;
}

.chat-input-area button {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: none;
    background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.2s ease;
}

.chat-input-area button:hover {
    transform: scale(1.1);
}

.chat-input-area button i {
    font-size: 18px;
}

/* Typing indicator */
.typing-indicator {
    display: none;
    padding: 10px 15px;
    background: #e9ecef;
    border-radius: 15px;
    margin-bottom: 10px;
    width: fit-content;
}

.typing-indicator span {
    display: inline-block;
    width: 8px;
    height: 8px;
    background: #999;
    border-radius: 50%;
    margin: 0 2px;
    animation: typing 1.4s infinite;
}

.typing-indicator span:nth-child(2) {
    animation-delay: 0.2s;
}

.typing-indicator span:nth-child(3) {
    animation-delay: 0.4s;
}

@keyframes typing {
    0%, 60%, 100% { transform: translateY(0); }
    30% { transform: translateY(-5px); }
}

/* Welcome message in chat */
.welcome-message {
    text-align: center;
    padding: 20px;
    background: transparent !important;
    border: none !important;
}

.welcome-message i {
    font-size: 40px;
    color: #2196F3;
    margin-bottom: 10px;
}

.welcome-message h5 {
    margin: 0 0 10px 0;
    color: #333;
    background: transparent !important;
}

.welcome-message p {
    margin: 0;
    color: #666;
    font-size: 13px;
    background: transparent !important;
}

/* Quick Commands Section */
.quick-commands {
    margin-top: 15px;
    padding-top: 12px;
    border-top: 1px dashed #ddd;
    text-align: center;
}

.quick-commands small {
    display: block;
    color: #666;
    margin-bottom: 8px;
}

.command-chips {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 6px;
}

.command-chip {
    background: #f1f3f5;
    color: #495057;
    font-size: 11px;
    padding: 5px 10px;
    border-radius: 20px;
    cursor: pointer;
    transition: all 0.2s ease;
    border: 1px solid #e9ecef;
    user-select: none;
}

.command-chip:hover {
    background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
    color: white;
    border-color: transparent;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(33, 150, 243, 0.3);
}

.command-chip:active {
    transform: scale(0.98);
}

/* Scrollbar styling */
.chat-messages::-webkit-scrollbar {
    width: 5px;
}

.chat-messages::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.chat-messages::-webkit-scrollbar-thumb {
    background: #ccc;
    border-radius: 3px;
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    .chat-popup,
    .chat-input-area,
    .welcome-message,
    .welcome-message h5,
    .welcome-message p {
        background: #2d2d2d;
        color: #e0e0e0;
        border: none !important;
    }
    
    .chat-messages {
        background: #2d2d2d;
    }
    
    .message.user .message-bubble {
        background: #444;
        color: #fff;
    }
    
    .quick-commands {
        border-top-color: #444;
    }
    
    .quick-commands small {
        color: #aaa;
    }
    
    .command-chip {
        background: #2d2d2d;
        color: #e0e0e0;
        border-color: #444;
    }
    
    .command-chip:hover {
        background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
        color: white;
    }
    
    .chat-input-area input {
        background: #333;
        border-color: #555;
        color: #fff;
    }
}

/* Hide in print */
@media print {
    .floating-chat-icon, .chat-popup {
        display: none !important;
    }
}
</style>

<!-- Floating Chat Icon -->
<div class="floating-chat-icon" id="floatingChatIcon" title="Chat with Support">
    <i class="mdi mdi-chat"></i>
    <span class="chat-badge" id="chatBadge">0</span>
</div>

<!-- Chat Popup Window -->
<div class="chat-popup" id="chatPopup">
    <div class="chat-header" id="chatHeader">
        <div class="chat-header-info">
            <div class="avatar">
                <img src="<?php echo base_url(); ?>assets/images/logo_portal.png" alt="Support Team" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
            </div>
            <div>
                <h4>Support Team</h4>
                <span>Online | Usually replies instantly</span>
            </div>
        </div>
        <button class="chat-close" id="chatClose">&times;</button>
    </div>
    
    <div class="chat-messages" id="chatMessages">
        <div class="welcome-message">
            <i class="mdi mdi-hand-wave"></i>
            <?php $logged_in = $this->session->userdata('logged_in'); ?>
            <?php if($logged_in == 1 || $logged_in === '1'): ?>
                <h5>Welcome, <?php echo $this->session->userdata('current_firstname'); ?>!</h5>
                <p>How can we help you today? Send us a message and we'll respond as soon as possible.</p>
            <?php else: ?>
                <h5>Welcome to Support!</h5>
                <p>How can we help you today? Send us a message and we'll respond as soon as possible.</p>
            <?php endif; ?>
            
            <!-- Quick Commands / Suggested Topics -->
            <div class="quick-commands">
                <small><strong>💡 Try asking about:</strong></small>
                <div class="command-chips">
                    <span class="command-chip" data-query="admission">Admission</span>
                    <span class="command-chip" data-query="password reset">Password Reset</span>
                    <span class="command-chip" data-query="payment">Billing & Fees</span>
                    <span class="command-chip" data-query="class schedule">Class Schedule</span>
                    <span class="command-chip" data-query="grades">View Grades</span>
                    <span class="command-chip" data-query="contact info">Contact Us</span>
                </div>
            </div>
        </div>
        <div class="typing-indicator" id="typingIndicator">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    
    <div class="chat-input-area">
        <input type="text" id="chatInput" placeholder="Type your message..." autocomplete="off">
        <button id="sendMessage">
            <i class="mdi mdi-send"></i>
        </button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatIcon = document.getElementById('floatingChatIcon');
    const chatPopup = document.getElementById('chatPopup');
    const chatClose = document.getElementById('chatClose');
    const chatInput = document.getElementById('chatInput');
    const sendMessageBtn = document.getElementById('sendMessage');
    const chatMessages = document.getElementById('chatMessages');
    const typingIndicator = document.getElementById('typingIndicator');
    
    // User info from session
    <?php $logged_in = $this->session->userdata('logged_in'); ?>
    const isLoggedIn = <?php echo ($logged_in == 1 || $logged_in === '1') ? 'true' : 'false'; ?>;
    const userName = '<?php echo addslashes($this->session->userdata('current_firstname') ?: ''); ?>';
    
    // Load saved messages from localStorage
    loadMessagesFromStorage();
    
    // Open/close chat on icon click
    chatIcon.addEventListener('click', function() {
        chatPopup.classList.toggle('active');
        if (chatPopup.classList.contains('active')) {
            chatInput.focus();
        }
    });
    
    chatClose.addEventListener('click', function() {
        chatPopup.classList.remove('active');
    });
    
    // Command chip click handler - inserts query into input and sends
    document.querySelectorAll('.command-chip').forEach(chip => {
        chip.addEventListener('click', function() {
            const query = this.getAttribute('data-query');
            chatInput.value = query;
            chatInput.focus();
            sendMessage(); // Auto-send the message
        });
    });
    
    // Send message functionality
    function sendMessage() {
        const message = chatInput.value.trim();
        if (message) {
            // Add user message
            const senderName = isLoggedIn && userName ? userName : 'Guest';
            addMessage(message, 'user', senderName);
            chatInput.value = '';
            
            // Show typing indicator
            typingIndicator.style.display = 'block';
            chatMessages.scrollTop = chatMessages.scrollHeight;
            
            // Simulate support response after delay
            setTimeout(function() {
                typingIndicator.style.display = 'none';
                
                // Auto response based on common queries
                let response = getAutoResponse(message);
                addMessage(response, 'support');
            }, 1500);
        }
    }
    
    function addMessage(text, sender, senderName) {
        // Remove welcome message if exists
        const welcomeMsg = document.querySelector('.welcome-message');
        if (welcomeMsg) {
            welcomeMsg.remove();
        }
        
        const messageDiv = document.createElement('div');
        messageDiv.className = 'message ' + sender;
        
        const now = new Date();
        const timeString = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        
        let nameHtml = '';
        if (sender === 'user' && senderName) {
            nameHtml = `<div class="message-sender">${escapeHtml(senderName)}</div>`;
        }
        
        messageDiv.innerHTML = `
            ${nameHtml}
            <div class="message-bubble">${escapeHtml(text)}</div>
            <div class="message-time">${timeString}</div>
        `;
        
        // Insert before typing indicator
        chatMessages.insertBefore(messageDiv, typingIndicator);
        chatMessages.scrollTop = chatMessages.scrollHeight;
        
        // Save to localStorage
        saveMessagesToStorage();
    }
    
    // Save messages to localStorage
    function saveMessagesToStorage() {
        const messages = [];
        const messageElements = chatMessages.querySelectorAll('.message');
        messageElements.forEach(msg => {
            messages.push({
                text: msg.querySelector('.message-bubble').textContent,
                sender: msg.classList.contains('support') ? 'support' : 'user',
                senderName: msg.querySelector('.message-sender') ? msg.querySelector('.message-sender').textContent : null,
                time: msg.querySelector('.message-time').textContent
            });
        });
        localStorage.setItem('chatMessages', JSON.stringify(messages));
    }
    
    // Load messages from localStorage
    function loadMessagesFromStorage() {
        const savedMessages = localStorage.getItem('chatMessages');
        if (savedMessages) {
            const messages = JSON.parse(savedMessages);
            // Remove welcome message first
            const welcomeMsg = document.querySelector('.welcome-message');
            if (welcomeMsg) {
                welcomeMsg.remove();
            }
            
            messages.forEach(msg => {
                const messageDiv = document.createElement('div');
                messageDiv.className = 'message ' + msg.sender;
                
                let nameHtml = '';
                if (msg.sender === 'user' && msg.senderName) {
                    nameHtml = `<div class="message-sender">${escapeHtml(msg.senderName)}</div>`;
                }
                
                messageDiv.innerHTML = `
                    ${nameHtml}
                    <div class="message-bubble">${escapeHtml(msg.text)}</div>
                    <div class="message-time">${msg.time}</div>
                `;
                
                chatMessages.insertBefore(messageDiv, typingIndicator);
            });
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
    }
    
    // Clear chat history
    function clearChatHistory() {
        localStorage.removeItem('chatMessages');
        location.reload();
    }
    
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    function getAutoResponse(message) {
        message = message.toLowerCase();
        
        if (message.includes('hello') || message.includes('hi') || message.includes('hey')) {
            return "Hello! Thank you for reaching out to BHCA Support. How can I assist you today?";
        }
        else if (message.includes('admission') || message.includes('enroll')) {
            return "For admission and enrollment inquiries, please visit our enrollment page or contact our registrar's office at (02) 123-4567. You can also visit us Monday to Friday, 8:00 AM to 5:00 PM.";
        }
        else if (message.includes('password') || message.includes('forgot') || message.includes('reset')) {
            return "To reset your password, click on 'Forgot Password' on the login page and follow the steps. You'll receive a verification code via email and SMS.";
        }
        else if (message.includes('payment') || message.includes('billing') || message.includes('fee')) {
            return "For payment and billing inquiries, please contact our accounting department at accounting@bobhughes.edu.ph or visit the accounting office during office hours.";
        }
        else if (message.includes('schedule') || message.includes('class')) {
            return "Class schedules are available in your dashboard. If you're a new student, schedules are provided after enrollment. For specific inquiries, please contact your department head.";
        }
        else if (message.includes('grade') || message.includes('report card') || message.includes('grades')) {
            return "You can view your grades in the dashboard under the 'Grades' or 'academics' section. If you have concerns about your grades, please contact your teacher or the registrar's office.";
        }
        else if (message.includes('contact') || message.includes('phone') || message.includes('email') || message.includes('address')) {
            return "You can reach us at:\n- Phone: (02) 123-4567\n- Email: support@bobhughes.edu.ph\n- Address: 123 Education Street, City";
        }
        else if (message.includes('thank you')) {
            return "You're welcome! Is there anything else I can help you with?";
        }
        else if (message.includes('bye') || message.includes('goodbye')) {
            return "Thank you for contacting BHCA Support! Have a great day! Feel free to message us again if you need assistance.";
        }
        else {
            return "Thank you for your message! Our support team will get back to you shortly. For urgent matters, please contact us directly at (02) 123-4567 during office hours.";
        }
    }
    
    sendMessageBtn.addEventListener('click', sendMessage);
    
    chatInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            sendMessage();
        }
    });
    
    // Close chat when clicking outside
    document.addEventListener('click', function(e) {
        // Don't close if the click was on the chat icon or inside the chat popup
        if (!chatPopup.contains(e.target) && !chatIcon.contains(e.target)) {
            chatPopup.classList.remove('active');
        }
    });
});
</script>