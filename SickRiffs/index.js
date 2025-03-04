// javascript for header hamburger menu
const hamburger = document.querySelector(".hamburger-menu");
const navLeftMenu = document.querySelector(".nav-left");
const categoriesInNavMenu = document.querySelector(".categories-nav");
const whoAreWe = document.querySelector(".whoAreWe");
const dealOfTheDay = document.querySelector(".deal");

hamburger.addEventListener("click", () =>{
    hamburger.classList.toggle("active");
    navLeftMenu.classList.toggle("active");
})

categoriesInNavMenu.addEventListener("click", () =>{
    navLeftMenu.classList.toggle("active");
    hamburger.classList.toggle("active");
})

whoAreWe.addEventListener("click", () =>{
    navLeftMenu.classList.toggle("active");
    hamburger.classList.toggle("active");
})

dealOfTheDay.addEventListener("click", () =>{
    navLeftMenu.classList.toggle("active");
    hamburger.classList.toggle("active");
})

//javasript slider - HERO section

/*for auto slider*/
var counter = 1;
setInterval(function(){
    document.getElementById('radio' + counter).checked = true;
    counter++;
    if(counter>3){
        counter=1;
    }
},5000);

//javascript for categories


const six_string_open = document.getElementById('selected_cat_1');
const seven_string_open = document.getElementById('selected_cat_2');
const eight_string_open = document.getElementById('selected_cat_3');
const headless_open = document.getElementById('selected_cat_4');
const baritone_open = document.getElementById('selected_cat_5');
const signature_open = document.getElementById('selected_cat_6');
const hollowbody_open = document.getElementById('selected_cat_7');
const bass_open = document.getElementById('selected_cat_8');
const show_all_open = document.getElementById('showAllGuitarsButtonId');
const additional_filters = document.getElementById('additional_filters_button_id');
const filtration = document.getElementById('filtrationID');
const guitars_we_have_chosen = document.getElementById('guitarsWeHaveChosenId');


const show_all_guitars_container = document.getElementById('ShowAllGuitarsContainerID');
const categories = document.getElementById('categories');

document.getElementById('go_back_button_id').addEventListener('click',() =>{
    show_all_guitars_container.style.display="none";
})

// const form = document.getElementById('formID');
const submit_button = document.getElementById('submit_buttonID');

const six_string_radio = document.getElementById('Six_StringRadio');
const seven_string_radio = document.getElementById('Seven_StringRadio');
const eight_string_radio = document.getElementById('Eight_StringRadio');
const headless_radio = document.getElementById('HeadlessRadio');
const baritone_radio = document.getElementById('BaritoneRadio');
const signature_radio = document.getElementById('SignatureRadio');
const hollowbody_radio = document.getElementById('HollowbodyRadio');
const bass_radio = document.getElementById('BassRadio');

show_all_open.addEventListener('click', ()=>{
    show_all_guitars_container.style.display='flex';
    six_string_radio.checked = true;
    seven_string_radio.checked = true;
    eight_string_radio.checked = true;
    headless_radio.checked = true;
    baritone_radio.checked = true;
    signature_radio.checked = true;
    signature_radio.checked = true;
    hollowbody_radio.checked = true;
    bass_radio.checked = true;
    submit_button.click();
})

additional_filters.addEventListener('click', ()=>{
    if(filtration.style.display=="none"){
    filtration.style.display="flex";
    show_all_guitars_container.style.display='flex';
    guitars_we_have_chosen.style.gridTemplateColumns="1fr 1fr 1fr 1fr";
    }else{
        filtration.style.display="none";
        guitars_we_have_chosen.style.gridTemplateColumns="1fr 1fr 1fr 1fr 1fr"; 
    }
 })

six_string_open.addEventListener('click', ()=>{
    show_all_guitars_container.style.display='flex';
    // categories.style.display='none';
    six_string_radio.checked = true;
    submit_button.click();
})

seven_string_open.addEventListener('click', ()=>{
    show_all_guitars_container.style.display='flex';
    // categories.style.display='none';
    seven_string_radio.checked = true;
    submit_button.click();
})

eight_string_open.addEventListener('click', ()=>{
    show_all_guitars_container.style.display='flex';
    // categories.style.display='none';
    eight_string_radio.checked = true;
    submit_button.click();
})

headless_open.addEventListener('click', ()=>{
    show_all_guitars_container.style.display='flex';
    // categories.style.display='none';
    headless_radio.checked = true;
    submit_button.click();
})

baritone_open.addEventListener('click', ()=>{
    show_all_guitars_container.style.display='flex';
    // categories.style.display='none';
    baritone_radio.checked = true;
    submit_button.click();
})

signature_open.addEventListener('click', ()=>{
    show_all_guitars_container.style.display='flex';
    // categories.style.display='none';
    signature_radio.checked = true;
    submit_button.click();
})

hollowbody_open.addEventListener('click', ()=>{
    show_all_guitars_container.style.display='flex';
    // categories.style.display='none';
    hollowbody_radio.checked = true;
    submit_button.click();
})

bass_open.addEventListener('click', ()=>{
    show_all_guitars_container.style.display='flex';
    // categories.style.display='none';
    bass_radio.checked = true;
    submit_button.click();
})

document.getElementById('formID').addEventListener('submit', submitFormFun);

function submitFormFun(e){

    e.preventDefault();
    var categories_filter_form = document.forms["formID"].getElementsByTagName("input");

    categoriesToSend = new Array();
    
    for(var i=0;i<categories_filter_form.length;i++){
        if(categories_filter_form[i].type == 'radio' && categories_filter_form[i].checked){
            categoriesToSend.push(categories_filter_form[i].value);
            categories_filter_form[i].checked = false;
            
        }
    }
    if(categoriesToSend.length>0){
        var xhr = new XMLHttpRequest();
        xhr.open('POST','filtration_handler.php',true);
        xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');

        xhr.onload = function(){
            if(this.status == 200){
                guitars_we_have_chosen.innerHTML = this.responseText;
            }
        }
        xhr.send("checkbox_values="+JSON.stringify(categoriesToSend));

    }else{
        console.log("None checkboxes chosen.");
    }
    
}

document.getElementById('button-search-id').addEventListener('click',searchGuitar);

function searchGuitar(e){
    e.preventDefault();
    var guitarTofind = document.getElementById('searchbar-input-id').value;
    var message = "message="+guitarTofind;
    
    if(guitarTofind !== ""){
        var xhr = new XMLHttpRequest();
        xhr.open('POST','search_handler.php',true);
        xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');
        show_all_guitars_container.style.display='flex';

        xhr.onload = function(){
            if(this.status == 200){
                guitars_we_have_chosen.innerHTML = this.responseText;
            }
        }
        // xhr.send("checkbox_values="+JSON.stringify(categoriesToSend));
        xhr.send(message);

    }else{
        console.log("None checkboxes chosen.");
    }
    
}


function add_to_basket(){
    var value = document.getElementById('hidden_id').value;
    var xhr = new XMLHttpRequest();
    xhr.open('POST','add_to_basket_handler.php',true);
    xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');
    xhr.onload = function(){
        if(this.status == 200){
            document.getElementById('basket_items_number_id').innerHTML = this.responseText;
        }
    }
    xhr.send("guitar_to_basket="+JSON.stringify(value));
}

function add_to_basket_form(guitar_id){
    document.getElementById('hidden_id').value = guitar_id;
    add_to_basket();
}













