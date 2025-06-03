// js/chatbot.js

const faqs = [
    {
        question: "What services do you offer?",
        answer: "We offer PC and laptop repairs, custom PC builds, hardware/software upgrades, and IT support."
    },
    {
        question: "What are your business hours?",
        answer: "Our business hours are Monday to Friday, 9 AM to 6 PM, and Saturday, 10 AM to 4 PM."
    },
    {
        question: "How can I request a custom PC build?",
        answer: "You can contact us through our contact page or visit us in-store to discuss your custom PC build requirements."
    },
    {
        question: "Do you offer on-site repairs?",
        answer: "Currently, we primarily offer in-store repairs. Please contact us for special arrangements."
    },
    {
        question: "What is your average repair turnaround time?",
        answer: "Turnaround time can vary depending on the issue and parts availability, but we aim for 2-3 business days for most common repairs."
    },
    {
        question: "Do you provide warranty for your services?",
        answer: "Yes, we provide a 90-day warranty on all our repair services and a 1-year warranty on custom PC builds."
    }
    // Add more FAQs here
];

document.addEventListener('DOMContentLoaded', () => {
    const chatbotToggler = document.getElementById('chatbot-toggler');
    const chatbotWindow = document.getElementById('chatbot-window');
    const closeChatbot = document.getElementById('close-chatbot');
    const faqQuestionsContainer = document.getElementById('faq-questions');
    const faqAnswerContainer = document.getElementById('faq-answer');

    if (!chatbotToggler || !chatbotWindow || !closeChatbot || !faqQuestionsContainer || !faqAnswerContainer) {
        console.error("Chatbot elements not found. Ensure HTML structure is correct.");
        return;
    }

    // Toggle chatbot window
    chatbotToggler.addEventListener('click', () => {
        chatbotWindow.style.display = chatbotWindow.style.display === 'block' ? 'none' : 'block';
        if (chatbotWindow.style.display === 'block') {
            loadFaqQuestions();
            faqAnswerContainer.innerHTML = '<p>Hello! Click on a question above to see the answer.</p>';
        }
    });

    closeChatbot.addEventListener('click', () => {
        chatbotWindow.style.display = 'none';
    });

    // Load FAQ questions into the chat window
    function loadFaqQuestions() {
        faqQuestionsContainer.innerHTML = '';
        faqs.forEach((faq, index) => {
            const questionButton = document.createElement('button');
            questionButton.classList.add('faq-question-button');
            questionButton.textContent = faq.question;
            questionButton.dataset.index = index;
            questionButton.addEventListener('click', displayAnswer);
            faqQuestionsContainer.appendChild(questionButton);
        });
    }

    // Display the answer for the clicked question
    function displayAnswer(event) {
        const questionIndex = event.target.dataset.index;
        if (faqs[questionIndex]) {
            faqAnswerContainer.innerHTML = `<p><strong>Q:</strong> ${faqs[questionIndex].question}</p>
                                        <p><strong>A:</strong> ${faqs[questionIndex].answer}</p>`;
        }
    }
});