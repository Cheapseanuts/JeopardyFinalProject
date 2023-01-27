let answer = "";
let score = 0;
let numQuestions = 0;
let response = "";
let charSet = '';
let hintCount = 0;

function GetQuestion() {
    $.get(
            "GetQuestion.php",
            function (data) {
                $("#lblCategory").text(TitleCase(data[0].toString()));
                $("#lblClue").text(data[1]);
                answer = data[2];
                $("#lblValue").text(data[3]);
                $("#lblAirDate").text(data[4]);
                numQuestions++;
            },
            "json"
            );
    $("#txtResponse").focus();
    $("#lblHint").text("");
    hintCount = 0;
}

function CheckAnswer() {
    response = $("#txtResponse").val();
    if (answer.toLowerCase() === response.toLowerCase()) {
        window.alert("Correct!");
        score++;
    } else if (Similarity(answer, response) > 0.8) {
        window.alert("Close enough, the correct answer was " + answer);
        score++;
    } else {
        window.alert("Sorry, the correct answer is " + answer);
    }
    $("#lblScore").text(score + "/" + numQuestions + " - " + (score / numQuestions) * 100 + "%");
    GetQuestion();
    $("#txtResponse").val("");
}

function ResetScore() {
    score = 0;
    numQuestions = 0;
    $("#lblScore").text(score + "/" + numQuestions + " - " + (score / numQuestions) * 100 + "%");
}

function GetHint() {
    ++hintCount;
    for (let i = 0; i < hintCount; i++) {
        charSet = answer.substring(0, hintCount);
    }
    $("#lblHint").text(charSet);
}


//THE FOLLOWING CODE WAS COPIED FROM:
//https://www.tutorialspoint.com/how-to-title-case-a-sentence-in-javascript
function TitleCase(string) {
    var sentence = string.toLowerCase().split(" ");
    for (var i = 0; i < sentence.length; i++) {
        sentence[i] = sentence[i][0].toUpperCase() + sentence[i].slice(1);
    }
    return sentence.join(" ");
}

//THE FOLLOWING CODE WAS COPIED FROM STACk OVERFLOW:
//https://stackoverflow.com/questions/10473745/compare-strings-javascript-return-of-likely
function Similarity(s1, s2) {
    var longer = s1;
    var shorter = s2;
    if (s1.length < s2.length) {
        longer = s2;
        shorter = s1;
    }
    var longerLength = longer.length;
    if (longerLength === 0) {
        return 1.0;
    }
    return (longerLength - EditDistance(longer, shorter)) / parseFloat(longerLength);
}

function EditDistance(s1, s2) {
    s1 = s1.toLowerCase();
    s2 = s2.toLowerCase();

    var costs = new Array();
    for (var i = 0; i <= s1.length; i++) {
        var lastValue = i;
        for (var j = 0; j <= s2.length; j++) {
            if (i === 0)
                costs[j] = j;
            else {
                if (j > 0) {
                    var newValue = costs[j - 1];
                    if (s1.charAt(i - 1) !== s2.charAt(j - 1))
                        newValue = Math.min(Math.min(newValue, lastValue),
                                costs[j]) + 1;
                    costs[j - 1] = lastValue;
                    lastValue = newValue;
                }
            }
        }
        if (i > 0)
            costs[s2.length] = lastValue;
    }
    return costs[s2.length];
}