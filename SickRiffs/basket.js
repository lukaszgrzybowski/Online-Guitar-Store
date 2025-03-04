function delete_guitar_form(guitar_id){
    document.getElementById('hidden_id').value = guitar_id;
    delete_guitar_form_basket();
}

function delete_guitar_form_basket(){
    var value = document.getElementById('hidden_id').value;
    var xhr = new XMLHttpRequest();
    xhr.open('POST','delete_basket_handler.php',true);
    xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');
    xhr.onload = function(){
        if(this.status == 200){
        }
    }
    xhr.send("delete_from_basket="+JSON.stringify(value));
    setTimeout(() =>{
        window.location.reload();
    },50);
}





