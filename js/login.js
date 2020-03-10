function validateForm(){
    let valid = true;
    userInput.classList.remove("error");
    passInput.classList.remove("error");
    
    if(userInput.value == ""){
        valid = false;
        userInput.classList.add("error");
    }
    if(passInput.value == ""){
        valid = false;
        passInput.classList.add("error");
    }
    return valid;
}

function validateLogin(){
    // Placeholder to allow quick navigation to main page
    if(validateForm()){
        $.post("validateLogin.php",
        {
            user: userInput.value,
            pass: passInput.value
        },
        function(data){
            if(!data){
                userInput.classList.add("error");
                passInput.classList.add("error");
            }
        });
    }
}

function addUser(){
    if(validateForm()){
        $.post("addUser.php",
        {
            user: userInput.value,
            pass: passInput.value
        });
    }
}

var userInput = document.getElementById("username");
var passInput = document.getElementById("password");