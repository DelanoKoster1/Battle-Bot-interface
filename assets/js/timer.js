document.addEventListener('DOMContentLoaded', function() {
    // Get the date of the set event
    let dateOfEvent = document.getElementById("dateOfEvent").innerHTML;

    // Set the date we're counting down to
    var countDownDate = new Date(dateOfEvent).getTime();

    // Update the count down every 1 second
    var interval = setInterval(function() {

        // Get today's date and time
        var now = new Date().getTime();
            
        // Find the distance between now and the count down date
        var distance = countDownDate - now;
            
        // Time calculations for days, hours, minutes and seconds
        
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        if (!Number.isNaN(seconds)) {   
            // Output the result in an element with id="timeUntilEvent"
            document.getElementById("timeUntilEvent").innerHTML = "Dagen tot evenement: " + days + "d " + hours + "h "
            + minutes + "m " + seconds + "s ";
        }else {
            clearInterval(interval);
            document.getElementById("timeUntilEvent").innerHTML = "Geen evenement ingepland.";
        }
            
        // If the count down is over, write some text 
        if (hours > -3 && hours < 0 && days >= 0) {
            clearInterval(interval);
            document.getElementById("timeUntilEvent").innerHTML = "Evenement is bezig";
            console.log(distance);
        }
    }, 1000);

        let timer = document.getElementById("eventTimeDisplay");
        timer.innerHTML += '<span class="material-icons align-middle timer">local_fire_department</span>';
        timer.innerHTML += '<span class="fw-bold" id="timeUntilEvent"></span>';
        timer.innerHTML += '<span class="material-icons align-middle timer">local_fire_department</span>';
    }, false);
