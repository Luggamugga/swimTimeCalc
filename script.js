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
let distVal;

function timeLimiter() {
    console.log("yes");
    let distanceSelector = document.getElementById("distSelect");
    let distVal = distanceSelector.options[distanceSelector.selectedIndex].value;
    let highestPossibleTimePerDistanceM = (distVal / 1.3) / 60;
    let lowestPossibleTimePerDistanceM = (distVal / 1.7) / 60;
    let highestPossibleTimePerDistanceF = (distVal / 1.1) / 60;
    let lowestPossibleTimePerDistanceF = (distVal / 1.5) / 60;
    let gender = document.getElementById("genderSelector")
    let genderVal = gender.options[gender.selectedIndex].value;
    if (genderVal === "m") {
        if (Math.round(lowestPossibleTimePerDistanceM) % 5 === 0) {
            minTime = Math.round(lowestPossibleTimePerDistanceM);
        } else if (Math.round(lowestPossibleTimePerDistanceM) >= 5) {
            minTime = Math.round(lowestPossibleTimePerDistanceM) - Math.round(lowestPossibleTimePerDistanceM) % 5;
        } else {
            minTime = Math.round(lowestPossibleTimePerDistanceM);
        }
        if (Math.round(highestPossibleTimePerDistanceM) % 5 === 0) {
            maxTime = Math.round(highestPossibleTimePerDistanceM);
        } else if (Math.round(highestPossibleTimePerDistanceM) >= 5) {
            maxTime = Math.round(highestPossibleTimePerDistanceM) - Math.round(highestPossibleTimePerDistanceM) % 5;
        } else {
            maxTime = Math.round(highestPossibleTimePerDistanceM);
        }
    } else {
        //minTime = Math.round(lowestPossibleTimePerDistanceF);
        // maxTime = Math.round(highestPossibleTimePerDistanceF);
        if (Math.round(lowestPossibleTimePerDistanceF) % 5 === 0) {
            minTime = Math.round(lowestPossibleTimePerDistanceF);
        } else if (Math.round(lowestPossibleTimePerDistanceF) >= 5) {
            minTime = Math.round(lowestPossibleTimePerDistanceF) - Math.round(lowestPossibleTimePerDistanceF) % 5;
        } else {
            minTime = Math.round(lowestPossibleTimePerDistanceF);
        }
        if (Math.round(highestPossibleTimePerDistanceF) % 5 === 0) {
            maxTime = Math.round(highestPossibleTimePerDistanceF);
        } else if (Math.round(highestPossibleTimePerDistanceF) >= 5) {
            maxTime = Math.round(highestPossibleTimePerDistanceF) - Math.round(highestPossibleTimePerDistanceF) % 5;
        } else {
            maxTime = Math.round(highestPossibleTimePerDistanceF);
        }
    }
    let diffTimeArray  =[];
    diffTimeArray["Pull_Boy"] = distVal / (50 / 5);
    diffTimeArray["kickboard"] = distVal / (50 / 20);
    diffTimeArray["fins"] = -distVal / (50 / 5);
    diffTimeArray["paddles"] = distVal / (50 / 5);

    let checkEquDiv = document.getElementById("equMultChoice");
    let equArray = [];
    let selEquDiffArray = [];
    let checkEquArray = document.getElementsByClassName("equCheck");
    for (let i = 0; i < checkEquArray.length; i++) {
        if (checkEquArray[i].checked) {
            console.log(checkEquArray[i].value)
            equArray[i] = checkEquArray[i].value;
            selEquDiffArray[i] = diffTimeArray[checkEquArray[i].value] / 60;
            console.log(selEquDiffArray[i]);
        } else {
            equArray[i] = null;
            selEquDiffArray[i] = 0;
        }
    }
    minTime += Math.round(Math.min(...selEquDiffArray));
    maxTime += Math.round(Math.max(...selEquDiffArray));
    while (parentTime.firstChild) {
        parentTime.removeChild(parentTime.firstChild);
    }
    for (let i = minTime; i <= maxTime; i += 5) {
        let newOpt = document.createElement("option");
        newOpt.setAttribute("class", "selectOpts");
        newOpt.setAttribute("value", i);
        newOpt.setAttribute("id", "i" + i);
        newOpt.textContent = i + ' mins';
        parentTime.appendChild(newOpt);

    }
}