function opacityChange(){
    let register = document.getElementById('register-container-id');
    let login = document.getElementById('login-container-id');

    let x = event.clientX;
    let y = event.clientY;

    let el=document.elementFromPoint(x,y);
    if(el==register){
        login.style.opacity="0.7";
        register.style.opacity="1";
    }
    if(el==login){
        register.style.opacity="0.7";
        login.style.opacity="1";
    }
}

function LogOut(){
    location.replace("/SickRiffs/logout_handler.php");
}


function GoAdmin(){
    location.replace("/SickRiffs/admin_page.php");
}
