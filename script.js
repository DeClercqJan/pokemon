console.log("script.js has loaded");

// stolen from http://jsfiddle.net/j08691/XssCG/ as I've forgotten everything
function check(elem) {
    document.getElementById('type').disabled = !elem.selectedIndex;
}