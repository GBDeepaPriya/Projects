var questions = [{
        question: "What is the baby of a Moth Known as?",
        choices: ["baby", "infant", "kit", "larva"],
        correctAnswer: 3,
    },
    {
        question: "What is the adult of a kid called",
        choices: ["calf", "doe", "goat", "chick"],
        correctAnswer: 2,
    },
    {
        question: "What is the young of a buffalo called?",
        choices: ["calf", "baby", "pup", "cow"],
        correctAnswer: 0,
    },
    {
        question: "What a baby Alligator called?",
        choices: ["baby", "gator", "hatchling", "calf"],
        correctAnswer: 2,
    },
    {
        question: "What is a baby Goose called?",
        choices: ["gooser", "gosling", "gup", "pup"],
        correctAnswer: 1,
    },
];

var currentQuestion = 0;
var correctAnswers = 0;
var quizOver = false;

$(document).ready(function() {
    var $quizMessage = $(".quizMessage");
    var $nextButton = $(".nextButton");
    var $question = $(".quizContainer > .question");
    var $choiceList = $(".quizContainer > .choiceList");

    displayCurrentQuestion();

    $quizMessage.hide();

    $nextButton.on("click", function() {
        if (!quizOver) {
            var value = $("input[type='radio']:checked").val();
            if (value === undefined) {
                $quizMessage.text("Please select an answer").show();
            } else {
                $quizMessage.hide();
                if (value == questions[currentQuestion].correctAnswer) {
                    correctAnswers++;
                }
                currentQuestion++;
                if (currentQuestion < questions.length) {
                    displayCurrentQuestion();
                } else {
                    displayScore();
                    $nextButton.text("Play Again?");
                    quizOver = true;
                }
            }
        } else {
            quizOver = false;
            $nextButton.text("Next Question");
            resetQuiz();
            displayCurrentQuestion();
            hideScore();
        }
    });
});

function displayCurrentQuestion() {
    var question = questions[currentQuestion];
    var numChoices = question.choices.length;

    $(".quizContainer > .question").text(question.question);
    $(".quizContainer > .choiceList").empty();

    for (var i = 0; i < numChoices; i++) {
        var choice = question.choices[i];
        $(
            '<li><input type="radio" value=' +
            i +
            ' name="dynradio"/>' +
            choice +
            "</li>"
        ).appendTo(".quizContainer > .choiceList");
    }
}

function resetQuiz() {
    currentQuestion = 0;
    correctAnswers = 0;
    hideScore();
}

function displayScore() {
    $(".quizContainer > .result").text(
        "You scored: " + correctAnswers + " out of: " + questions.length
    );
    $(".quizContainer > .result").show();
}

function hideScore() {
    $(".result").hide();
}