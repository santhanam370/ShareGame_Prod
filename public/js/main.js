function makeSelection(obj){
    if(document.getElementById('context').value=='verifyanswer' 
        && (document.getElementById('selectedOption').value !=null 
            && document.getElementById('selectedOption').value !="")){
                return;
    }
    var optionCount = document.getElementById('optionCount').value;
    for(var i=0; i<optionCount; i++){
        document.getElementById("option"+(i+1)).className = "btn btn-block";
    }
    if(document.getElementById('context').value=='verifyanswer'){
        if(obj.value==document.getElementById('correctOption').value){
            obj.className = "btn btn-success btn-block";
            document.getElementById('scoreCard').innerHTML = parseInt(document.getElementById('scoreCard').innerHTML) + 1;
        }else{
            obj.className = "btn btn-danger btn-block";
        }
    }else{
        obj.className = "btn btn-success btn-block";
    }
    document.getElementById('selectedOption').value = obj.value;
    document.getElementById('submit').className = "btn btn-success btn-block";
}

function copytoclipboard(){
    var tempText = document.createElement('textarea');
    tempText.value = document.getElementById("urlref").value;
    document.body.appendChild(tempText);
    tempText.focus();
    tempText.select();
    document.execCommand("copy");
    document.body.removeChild(tempText);
    alert("URL : "+document.getElementById("urlref").value +" copied to clipboard.");
}

function shareinfacebook(){
    window.open("https://www.facebook.com/sharer/sharer.php?u=\""+document.getElementById("urlref").value+"\"","_blank");
}

function shareinwhatsapp(){
    window.open("whatsapp://send?text="+document.getElementById("urlref").value,"_blank");
}