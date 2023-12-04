let minDist = 500;
let maxDist = 10000;
let minTime = 15;
let maxTime = 180;
let parentTime = document.getElementById("swimTime")
//create distance elements
for (let i = 500; i <= 10000; i += 100) {
    let newOpt = document.createElement("option");
    newOpt.setAttribute("class", "selectOpts");
    newOpt.setAttribute("value", i);
    newOpt.textContent = i + 'm';
    let parentDist = document.getElementById("distSelect");
    parentDist.appendChild(newOpt);

}
for (let i = 15; i <= 180; i += 15) {
    let newOpt = document.createElement("option");
    newOpt.setAttribute("class", "selectOpts");
    newOpt.setAttribute("value", i);
    newOpt.setAttribute("id", "i" + i);
    newOpt.textContent = i + ' mins';
    let parentTime = document.getElementById("swimTime")
    parentTime.appendChild(newOpt);
}
//TODO: split function in three (timeLimiterFromDistance, timeLimiterfromEqu, timeLimiterfromStr)
let distVal = 0;
let genderVal;

function timeLimiter() {
    let distanceSelector = document.getElementById("distSelect");
    distVal = distanceSelector.options[distanceSelector.selectedIndex].value;
    if (distVal === 0) {
        return;
    }
    let highestPossibleTimePerDistanceM = (distVal / 1.3) / 60;
    let lowestPossibleTimePerDistanceM = (distVal / 1.7) / 60;
    let highestPossibleTimePerDistanceF = (distVal / 1.1) / 60;
    let lowestPossibleTimePerDistanceF = (distVal / 1.5) / 60;
    let gender = document.getElementById("genderSelector")
    genderVal = gender.options[gender.selectedIndex].value;
    if (genderVal === "m") {
        if (Math.round(lowestPossibleTimePerDistanceM) % 2 === 0) {
            minTime = Math.round(lowestPossibleTimePerDistanceM);
        } else if (Math.round(lowestPossibleTimePerDistanceM) >= 2) {
            minTime = Math.round(lowestPossibleTimePerDistanceM) - Math.round(lowestPossibleTimePerDistanceM) % 2;
        } else {
            minTime = Math.round(lowestPossibleTimePerDistanceM);
        }
        if (Math.round(highestPossibleTimePerDistanceM) % 2 === 0) {
            maxTime = Math.round(highestPossibleTimePerDistanceM);
        } else if (Math.round(highestPossibleTimePerDistanceM) >= 2) {
            maxTime = Math.round(highestPossibleTimePerDistanceM) - Math.round(highestPossibleTimePerDistanceM) % 2;
        } else {
            maxTime = Math.round(highestPossibleTimePerDistanceM);
        }
    } else {
        //minTime = Math.round(lowestPossibleTimePerDistanceF);
        // maxTime = Math.round(highestPossibleTimePerDistanceF);
        if (Math.round(lowestPossibleTimePerDistanceF) % 2 === 0) {
            minTime = Math.round(lowestPossibleTimePerDistanceF);
        } else if (Math.round(lowestPossibleTimePerDistanceF) >= 2) {
            minTime = Math.round(lowestPossibleTimePerDistanceF) - Math.round(lowestPossibleTimePerDistanceF) % 2;
        } else {
            minTime = Math.round(lowestPossibleTimePerDistanceF);
        }
        if (Math.round(highestPossibleTimePerDistanceF) % 2 === 0) {
            maxTime = Math.round(highestPossibleTimePerDistanceF);
        } else if (Math.round(highestPossibleTimePerDistanceF) >= 2) {
            maxTime = Math.round(highestPossibleTimePerDistanceF) - Math.round(highestPossibleTimePerDistanceF) % 2;
        } else {
            maxTime = Math.round(highestPossibleTimePerDistanceF);
        }
    }
    let diffTimeArray = [];
    diffTimeArray["Pull_Boy"] = 100 / (50 / 5);
    diffTimeArray["kickboard"] = 100 / (50 / 20);
    diffTimeArray["fins"] = -(100 / (50 / 5));
    diffTimeArray["paddles"] = 100 / (50 / 5);

    let checkEquDiv = document.getElementById("equMultChoice");
    let equArray = [];
    let selEquDiffArray = [0, 0, 0, 0];
    let checkEquArray = document.getElementsByClassName("equCheck");
    let checked = checkEquDiv.querySelectorAll("[type='checkbox']:checked");
   let i = 0;
    checked.forEach((el)=>{
        equArray.push(checkEquArray[i].value);
        selEquDiffArray.push(diffTimeArray[checkEquArray[i].value]/60);
        i++;
    })

    let strDiffTimeM = [];
    strDiffTimeM["freestyle"] = (distVal / 1.6) / 60;
    strDiffTimeM["butterfly"] = (distVal / 1.5) / 60;
    strDiffTimeM["backstroke"] = (distVal / 1.45) / 60;
    strDiffTimeM["breaststroke"] = (distVal / 1.35) / 60;
    strDiffTimeM["im"] = (distVal / 1.48) / 60;
    let strDiffTimeF = [];
    strDiffTimeF["freestyle"] = (distVal / 1.5) / 60;
    strDiffTimeF["butterfly"] = (distVal / 1.35) / 60;
    strDiffTimeF["backstroke"] = (distVal / 1.25) / 60;
    strDiffTimeF["breaststroke"] = (distVal / 1.15) / 60;
    strDiffTimeF["im"] = (distVal / 1.33);


    //TODO: Calculate the highestPossibleTimePerDistance for an array of selected strokes taking the fastest and slowest of those strokes to calculate it then update the values at the start of the function

    if (selEquDiffArray.length !== 0) {
        minTime += Math.round(Math.min(...selEquDiffArray));
        maxTime += Math.round(Math.max(...selEquDiffArray));
    }


    while (parentTime.firstChild) {
        parentTime.removeChild(parentTime.firstChild);
    }
    for (let i = minTime; i <= maxTime; i += 2) {
        let newOpt = document.createElement("option");
        newOpt.setAttribute("class", "selectOpts");
        newOpt.setAttribute("value", i);
        newOpt.setAttribute("id", "i" + i);
        newOpt.textContent = i + ' mins';
        parentTime.appendChild(newOpt);

    }
}

function timeLimiterStr() {
    if (distVal === 0) {
        return;
    }
    let gender = document.getElementById("genderSelector")
    genderVal = gender.options[gender.selectedIndex].value;
    let strDiffTimeM = [];
    strDiffTimeM["freestyle"] = (distVal / 1.6) / 60;
    strDiffTimeM["butterfly"] = (distVal / 1.5) / 60;
    strDiffTimeM["backstroke"] = (distVal / 1.45) / 60;
    strDiffTimeM["breaststroke"] = (distVal / 1.35) / 60;
    strDiffTimeM["im"] = (distVal / 1.48) / 60;
    let strDiffTimeF = [];
    strDiffTimeF["freestyle"] = (distVal / 1.5) / 60;
    strDiffTimeF["butterfly"] = (distVal / 1.35) / 60;
    strDiffTimeF["backstroke"] = (distVal / 1.25) / 60;
    strDiffTimeF["breaststroke"] = (distVal / 1.15) / 60;
    strDiffTimeF["im"] = (distVal / 1.33);


    function emptyCheck(arr) {
        return arr !== undefined;
    }

    let strArray = [];
    let selStrArray = [];
    let strCheckboxArray = document.getElementsByClassName("strCheck");
    let strDiffTimeArray = [];
    checkedStrArray = []
    checkedParent = document.getElementById("strChoice");
    let checked = checkedParent.querySelectorAll("[type='checkbox']:checked");
    checked.forEach((el) => {
        checkedStrArray.push(el.value);
        if (genderVal === "m") {
            strDiffTimeArray.push(strDiffTimeM[el.value]);
        } else {
            strDiffTimeArray.push(strDiffTimeF[el.value]);
        }
    })


    if (strDiffTimeArray.length !== 0) {
        if (strDiffTimeArray.length === 1) {
            minTime = Math.round(strDiffTimeArray[0]);
            maxTime = Math.round(strDiffTimeArray[0]);
        } else {
            minTime = Math.round(Math.min(...strDiffTimeArray));
            maxTime = Math.round(Math.max(...strDiffTimeArray));
        }
    }
    while (parentTime.firstChild) {
        parentTime.removeChild(parentTime.firstChild);
    }
    for (let i = minTime; i <= maxTime; i += 2) {
        let newOpt = document.createElement("option");
        newOpt.setAttribute("class", "selectOpts");
        newOpt.setAttribute("value", i);
        newOpt.setAttribute("id", "i" + i);
        newOpt.textContent = i + ' mins';
        parentTime.appendChild(newOpt);

    }
}

let indexForm = document.getElementById("indexForm");
indexForm.addEventListener("submit", (e) => {
    let strParent = document.getElementById("strChoice");
    let strErr = "Pick at least one Stroke";
    let checked = strParent.querySelectorAll("[type='checkbox']:checked")
    if (checked.length === 0) {
        alert(strErr);
        e.preventDefault();
    }
})
