
document.addEventListener('submit',(e)=>{

    let emaiLinput = document.getElementById("regEmail");
    let emailVal = emaiLinput.value;
    const emailMatch =     /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

    if( !emailVal.match(emailMatch)){
        document.getElementById("emailErr").style.display = "block";
        emaiLinput.style.backgroundColor = "red";
        e.preventDefault();
        emaiLinput.addEventListener("click",()=>{
            document.getElementById("emailErr").style.display = "none";
            emaiLinput.style.backgroundColor = "white";
        })
    } else {
        document.getElementById("emailErr").style.display = "none";
        emaiLinput.style.backgroundColor = "white";
    }


})
let usrInput = document.getElementById("usrName")
let usrErr = document.getElementById("usrErr").style.display;
if(usrErr === "block"){
    console.log("asdf")
    usrInput.style.backgroundColor = "red";
    usrInput.addEventListener("click",()=>{
        usrInput.style.backgroundColor = "white";
        document.getElementById("usrErr").style.display = "none";
    })
} else {
    usrInput.style.backgroundColor = "white";
}
let year = new Date().getFullYear();
let yearsArr = [];
for(let i = 1930;i<= year;i++){
    yearsArr.push(i);
}
let swimDateInp = document.getElementById("swimDate")
let swimDatErr = document.getElementById("dateErr")
swimDatErr.style.display = "none";
swimDateInp.addEventListener("blur",()=>{
    console.log("Blur");
    if(yearsArr.includes(parseInt(swimDateInp.value)) || swimDateInp.value === ""){
        swimDatErr.style.display = "none";
    } else {
        swimDatErr.style.display = "block";
        swimDateInp.style.backgroundColor = "red";
    }

})
swimDateInp.addEventListener("focus",()=>{
    console.log("focus");
    swimDatErr.style.display = "none";
    swimDateInp.style.backgroundColor = "white";
})
