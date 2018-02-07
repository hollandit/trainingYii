let count = {question: 1, answer: 4};
function addQuestion(count) {
    let qustion = count.question;
    let answer = count.answer;
    return `<div class="test-create-question_page">
        <label for="question-${qustion}">Вопрос ${qustion}</label>
        <input type="text" id="question-${qustion}" name="Question[${qustion}]">
    </div>
    <div>
        <label>Ответ 1</label>
        <input type="text" name="Answer[${answer - 3}]">
    </div>
    <div>
        <label">Ответ 2</label>
        <input type="text" name="Answer[${answer - 2}]">
    </div>
    <div>
        <label>Ответ 3</label>
        <input type="text" name="Answer[${answer - 1}]">
    </div>
    <div>
        <label>Ответ 4</label>
        <input type="text" name="Answer[${answer}]">
    </div>`;
}

$(document).ready(function () {
    $('.addQuestion').click(function(){
        count.question++;
        count.answer = count.answer + 4;
        $('.test-create_question').append(addQuestion(count))
    })
});