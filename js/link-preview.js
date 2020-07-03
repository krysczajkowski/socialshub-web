
function previewURL(input_name, div_name, link) {
    var input = document.getElementById(input_name)
    var div = document.getElementById(div_name);
    var URL = link + input.value;
    div.innerHTML = 
    "<div class='py-3'><span class='text-muted font-weight-bold' style='font-size: 0.8rem;'>CURRENT LINK PREVIEW: </span><span class='font-weight-bold text-primary'>" + URL + "</span></div>";

}

function clearURL(div_name) {
    var div = document.getElementById(div_name);
    div.innerHTML = "";
}
