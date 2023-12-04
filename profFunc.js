let count = 0;
let butt = document.getElementById("showButt")
butt.addEventListener("click",()=>{
    let tablesDiv = document.getElementById("tables");
    if(count % 2 === 0){
        tablesDiv.style.display = "grid";
        count--
    } else {
        tablesDiv.style.display = "none";
        count++

    }


})
