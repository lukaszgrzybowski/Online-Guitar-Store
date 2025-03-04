
// trigers to load content to scroll windows while the page is loading
window.onload = function(){
    document.getElementById('submit_filter_for_delete_id').click();
    document.getElementById('submit_filter_number_of_orders_id').click();

}

//trigers to load content while click on filter buttons
const scroll_guitars_delete=document.getElementById('scroll-guitars-container_id');
document.getElementById('submit_filter_for_delete_id').addEventListener('click',filterguitars);
document.getElementById('submit_filter_number_of_orders_id').addEventListener('click',filterorders);

//show guitars in guitars window
function filterguitars(e){
    e.preventDefault();
    filterToSend = new Array();

    var filter1 = document.getElementById("categoryformdeleteid").value;
    filterToSend.push(filter1);
    if(filter1 != "None"){
        document.getElementById("categoryformdeleteid").value = "None";
    }

    var filter2 = document.getElementById("brandformdeleteid").value;
    filterToSend.push(filter2);
    if(filter2 != "None"){
        document.getElementById("brandformdeleteid").value = "None";
    }

    var filter3 = document.getElementById("bodystyledeleteformid").value;
    filterToSend.push(filter3);
    if(filter3 != "None"){
        document.getElementById("bodystyledeleteformid").value = "None";
    }
   
    var filter4 = document.getElementById("productiondelformid").value;
    filterToSend.push(filter4);
    if(filter4 != "None"){
        document.getElementById("productiondelformid").value = "None";
    }

    // console.log(filterToSend);
    

    if(filterToSend.length>0){
        var xhr = new XMLHttpRequest();
        xhr.open('POST','filtration_delete_handler.php',true);
        xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');

        xhr.onload = function(){
            if(this.status == 200){
                scroll_guitars_delete.innerHTML = this.responseText;
            }
        }
        xhr.send("filter_values="+JSON.stringify(filterToSend));

    }else{
        console.log("None checkboxes chosen.");
    }
    
}
// end of show guitars

//show orders in orders window
function filterorders(e){
    e.preventDefault();
    filter_value = document.getElementById('number_of_orders_id').value;
    var xhr = new XMLHttpRequest();
    xhr.open('POST','scroll_orders_admin_handler.php',true);
    xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');

    xhr.onload = function(){
        if(this.status == 200){
           document.getElementById('scroll_orders_container_id').innerHTML = this.responseText;
        }
    }
    xhr.send("filter_value="+JSON.stringify(filter_value));
}
// end of dhwo orders

// delete guitar
document.getElementById('confirmation_delete_id').addEventListener('click',()=>{
    document.getElementById('confirmation_delete_id').style.display="none";
})


function confirmation_delete_guitar(clicked_id){
    var confirmation = document.getElementById('confirmation_delete_id');
    if(confirmation.style.display=="none"){
        confirmation.style.display="flex";
    }else{
        confirmation.style.display="none";
    }
    
    var yes_delete = document.querySelector(".delete_yes");
    yes_delete.id=clicked_id;
}

document.querySelector(".delete_yes").addEventListener('click',delete_guitar);
function delete_guitar(e){
    e.preventDefault();
    var xhr = new XMLHttpRequest();
        xhr.open('POST','delete_guitar_handler.php',true);
        xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');

        var send_id = document.querySelector(".delete_yes");
        xhr.onload = function(){
            if(this.status == 200){
                document.querySelector('.testtrack').innerHTML = this.responseText;
            }
        }
        xhr.send("id_to_delete="+JSON.stringify(send_id.id));
        setTimeout(() =>{
            document.getElementById('submit_filter_for_delete_id').click();
        },200);

}
// end of delete guitar

// delete order
document.getElementById('confirmation_delete_order_id').addEventListener('click',()=>{
    document.getElementById('confirmation_delete_order_id').style.display="none";
})

function confirmation_delete_order(clicked_id){
    var confirmation = document.getElementById('confirmation_delete_order_id');
    if(confirmation.style.display=="none"){
        confirmation.style.display="flex";
    }else{
        confirmation.style.display="none";
    }
    
    var yes_delete = document.querySelector(".delete_yes_order");
    yes_delete.id=clicked_id;
}

document.querySelector(".delete_yes_order").addEventListener('click',delete_order);
function delete_order(e){
    e.preventDefault();
    var xhr = new XMLHttpRequest();
        xhr.open('POST','delete_order_handler.php',true);
        xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');

        var send_id = document.querySelector(".delete_yes_order");
        xhr.onload = function(){
            if(this.status == 200){
            }
        }
        xhr.send("id_to_delete="+JSON.stringify(send_id.id));
        setTimeout(() =>{
            document.getElementById('submit_filter_number_of_orders_id').click();
        },100);
}
// end of delete order

// change status order
document.getElementById('confirmation_change_order_status_id').addEventListener('click',()=>{
    document.getElementById('confirmation_change_order_status_id').style.display="none";
})

function change_status(clicked_id){
    var confirmation = document.getElementById('confirmation_change_order_status_id');
    if(confirmation.style.display=="none"){
        confirmation.style.display="flex";
    }else{
        confirmation.style.display="none";
    }
    
    var yes_delete = document.querySelector(".change_yes_order");
    yes_delete.id=clicked_id;
}

document.querySelector(".change_yes_order").addEventListener('click',change_order_status);
function change_order_status(e){
    e.preventDefault();
    var xhr = new XMLHttpRequest();
        xhr.open('POST','order_status_handler.php',true);
        xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');

        var send_id = document.querySelector(".change_yes_order");
        xhr.onload = function(){
            if(this.status == 200){
            }
        }
        xhr.send("order_change="+JSON.stringify(send_id.id));
        setTimeout(() =>{
            document.getElementById('submit_filter_number_of_orders_id').click();
        },100);
}

// end change status order

//order view

document.getElementById('close_order_view').addEventListener('click',()=>{
    document.getElementById('view_orders_id').style.display="none";
})

function show_order(clicked_id){
    var confirmation = document.getElementById('view_orders_id');
    if(confirmation.style.display=="none"){
        confirmation.style.display="flex";
    }else{
        confirmation.style.display="none";
    }
    
    var yes_delete = document.querySelector(".view_order");
    yes_delete.id=clicked_id;
    document.querySelector(".view_order").click();
}

document.querySelector(".view_order").addEventListener('click',show_full_order);
function show_full_order(e){
    console.log('in');
    e.preventDefault();
    var xhr = new XMLHttpRequest();
        xhr.open('POST','show_order_handler.php',true);
        xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');

        var send_id = document.querySelector(".view_order");
        xhr.onload = function(){
            if(this.status == 200){
                document.getElementById('oreders_in_order_view_id').innerHTML = this.responseText;
            }
        }

        xhr.send("order_value="+JSON.stringify(send_id.id));
}

//end order view

// deal of the day

function confirmation_deal_of_the_day(clicked_id){
    var xhr = new XMLHttpRequest();
        xhr.open('POST','deal_of_the_day_handler.php',true);
        xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');

        xhr.onload = function(){
            if(this.status == 200){
            }
        }

        xhr.send("guitar_id="+JSON.stringify(clicked_id));
        setTimeout(() =>{
            document.getElementById('submit_filter_for_delete_id').click();
        },100);
}

// end of deal

// change price
function confirmation_change_price(clicked_id){
    console.log('in');
    var xhr = new XMLHttpRequest();
        xhr.open('POST','change_price_handler.php',true);
        xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');

        guitar = new Array();
        guitar.push(clicked_id);
        guitar.push(document.getElementById('new_price_for_dotd_id').value);

        xhr.onload = function(){
            if(this.status == 200){
            }
        }

        xhr.send("guitar="+JSON.stringify(guitar));
        setTimeout(() =>{
            document.getElementById('submit_filter_for_delete_id').click();
        },100);
}


// end change price


