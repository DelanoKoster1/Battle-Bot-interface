//change the innerhtml depended on which value is given in the select tag
function differentTypes(event) {
    if (this.value == "multiChoice") {

        let pollTypes = document.getElementById("pollTypes");

        pollTypes.innerHTML = "";

        pollTypes.innerHTML += '<span>verschillende poll types (multiple choice...)</span>';
        pollTypes.innerHTML += '<input type="text" name="answer1" class="form-control mt-3" placeholder="antwoord van poll..." />';
        pollTypes.innerHTML += '<input type="text" name="answer2" class="form-control mt-3" placeholder="antwoord van poll..." />';
        pollTypes.innerHTML += '<input type="text" name="answer3" class="form-control mt-3" placeholder="antwoord van poll..." />';
        pollTypes.innerHTML += '<input type="text" name="answer4" class="form-control mt-3" placeholder="antwoord van poll..." />';

    } else if (this.value == "yesOrNo") {

        let pollTypes = document.getElementById("pollTypes");

        pollTypes.innerHTML = "";

        pollTypes.innerHTML += '<span>verschillende poll types (yes or no...)</span>';
        pollTypes.innerHTML += '<input type="text" name="answer1" class="form-control mt-3" placeholder="antwoord van poll..." />';
        pollTypes.innerHTML += '<input type="text" name="answer2" class="form-control mt-3" placeholder="antwoord van poll..." />';
        
    } else if (this.value == "voteForBot") {
        let pollTypes = document.getElementById("pollTypes");

        pollTypes.innerHTML = "";
    
        pollTypes.innerHTML += '<span>verschillende poll types (vote for a bot...)</span>';
        pollTypes.innerHTML += '<input type="text" name="answer1" class="form-control mt-3" placeholder="antwoord van poll..." />';
        pollTypes.innerHTML += '<input type="text" name="answer2" class="form-control mt-3" placeholder="antwoord van poll..." />';
        pollTypes.innerHTML += '<input type="text" name="answer3" class="form-control mt-3" placeholder="antwoord van poll..." />';
        pollTypes.innerHTML += '<input type="text" name="answer4" class="form-control mt-3" placeholder="antwoord van poll..." />';
        pollTypes.innerHTML += '<input type="text" name="answer5" class="form-control mt-3" placeholder="antwoord van poll..." />';
    }
}


