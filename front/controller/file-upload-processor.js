window.fd = {logging: false};
var options = {iframe: {url: 'upload.php'}}
var zone = new FileDrop('my-dropzone', options)

zone.event('send', function (files) {
  files.each(function (file) {
  	file.readData(
      function (str) { processCSVFile(str); },
      function (e) { alert('Unable to read file content, please try again') },
      'text'
    )
  })
})

function hover(){
    $("#my-dropzone").attr("style", "transform: scale(1.03, 1.03) translate3d(0, 0, 0);z-index: 10;background: #32b5cb;color: #ffffff; border: 1px solid #ccc !important; height: 200px !important; padding-top: 80px;");
}

function dishover(){
    $("#my-dropzone").attr("style", "border: 1px solid #ccc !important; height: 200px !important; padding-top: 80px;");
}

zone.event("dragEnter", function(e){
    hover();
})

zone.event("dragOver", function(e){
    hover();
})

zone.event("dragLeave", function(e){
    dishover();
})

zone.event("upload", function(e){
    dishover();
})

zone.event('iframeDone', function (xhr) {
  alert(xhr.responseText)
})

var last_count = 0;
var deletedRecordRow = "";
$("#invalid-upload").hide();
function processCSVFile(str){
	var json = CSV2JSON(str);
	var string="";
	for (var i = 0; i < json.length; i++) {
		var reg_num = json[i].reg_num;
		var first_name = json[i].first_name;
		var last_name = json[i].last_name;
		var score = json[i].score;
		last_count = i+1;

		if (typeof reg_num == "undefined" || typeof first_name == "undefined" || typeof last_name == "undefined" || typeof score == "undefined"){
			continue;
		}

        string += "<tr class='uploaded-record' id='score-"+last_count+"'><td class='active'>"+last_count+"</td><td contenteditable onfocus='regnumFocus($(this))' onblur='regnumBlur($(this))'>"+
                  reg_num+"</td><td contenteditable onfocus='fnameFocus($(this))' onblur='fnameBlur($(this))'>"+
                  first_name+"</td><td contenteditable onfocus='lnameFocus($(this))' onblur='lnameBlur($(this))'>"+
                  last_name+"</td><td contenteditable onfocus='scoreFocus($(this))' onblur='scoreBlur($(this))'>"+
                  score+"</td><td> <a class='btn btn-danger btn-clean tip pull-left' title='delete' onclick='deleteRecord("+last_count+")'><i class='fa fa-user-times'></i></a></td></tr>";
	}
    if (string == ""){
        $("#invalid-upload").show();

        setTimeout(function(){
            $("#invalid-upload").fadeOut("slow").hide();
        }, 5000);
    } else {
        $("#uploaded-csv-file").html(string);
        $("#show-uploaded").modal({backdrop: 'static', keyboard: false});
    }
}

function CSVToArray(strData, strDelimiter) {
    strDelimiter = (strDelimiter || ",");
    // Create a regular expression to parse the CSV values.
    var objPattern = new RegExp((
    // Delimiters.
    "(\\" + strDelimiter + "|\\r?\\n|\\r|^)" +
    // Quoted fields.
    "(?:\"([^\"]*(?:\"\"[^\"]*)*)\"|" +
    // Standard fields.
    "([^\"\\" + strDelimiter + "\\r\\n]*))"), "gi");
    var arrData = [[]];
    var arrMatches = null;
    while (arrMatches = objPattern.exec(strData)) {
        var strMatchedDelimiter = arrMatches[1];
        if (strMatchedDelimiter.length && (strMatchedDelimiter != strDelimiter)) {
            arrData.push([]);
        }
        // Now that we have our delimiter out of the way,
        // let's check to see which kind of value we
        // captured (quoted or unquoted).
        if (arrMatches[2]) {
            var strMatchedValue = arrMatches[2].replace(
            new RegExp("\"\"", "g"), "\"");
        } else {
            // We found a non-quoted value.
            var strMatchedValue = arrMatches[3];
        }

        arrData[arrData.length - 1].push(strMatchedValue);
    }
    // Return the parsed data.
    return (arrData);
}

function CSV2JSON(csv) {
    var array = CSVToArray(csv);
    var objArray = [];
    for (var i = 1; i < array.length; i++) {
        objArray[i - 1] = {};
        for (var k = 0; k < array[0].length && k < array[i].length; k++) {
            var key = array[0][k];
            objArray[i - 1][key] = array[i][k]
        }
    }

    var json = JSON.stringify(objArray);
    var str = json.replace(/},/g, "},\r\n");

    return objArray;
}

var regnumstring = "Reg. No";
var fnamestring = "First Name";
var lnamestring = "Last Name";
var scorestring = "Score";
$("#add-new-record").on("click", function(){
    last_count += 1;
    var string = "<tr class='uploaded-record' id='score-"+last_count+"'><td class='active'>"+last_count+"</td><td contenteditable onfocus='regnumFocus($(this))' onblur='regnumBlur($(this))'>"+regnumstring+
                  "</td><td contenteditable onfocus='fnameFocus($(this))' onblur='fnameBlur($(this))'>"+fnamestring+
                  "</td><td contenteditable onfocus='lnameFocus($(this))' onblur='lnameBlur($(this))'>"+lnamestring+
                  "</td><td contenteditable onfocus='scoreFocus($(this))' onblur='scoreBlur($(this))'>"+scorestring+
                  "</td><td> <a class='btn btn-danger btn-clean tip pull-left' title='delete' onclick='deleteRecord("+last_count+")'><i class='fa fa-user-times'></i></a></td></tr>";
    $("#uploaded-csv-file").append(string);
    $("#uploaded-csv-file").scrollTop(100);
});

function deleteRecord(id){
    deletedRecordRow = "<tr class='uploaded-record' id='score-"+id+"'>"+$("#score-"+id).html()+"</tr>";
    $("#score-"+id).remove();
    $("#undo-last-action").show();
}

function undoDelete(){
    $("#uploaded-csv-file").append(deletedRecordRow);
    deletedRecordRow = "";
}

$("#undo-last-action").hide();

$("#undo-last-action").on("click", function(){
    undoDelete();
    $(this).hide();
});

function focus(type, e){
    switch(type){
        case "regnum":{
            if (e.text() == regnumstring){
                e.text("");
            }
            break;
        }
        case "fname":{
            if (e.text() == fnamestring){
                e.text("");
            }
            break;
        }
        case "lname":{
            if (e.text() == lnamestring){
                e.text("");
            }
            break;
        }
        case "score":{
            if (e.text() == scorestring){
                e.text("");
            }
            break;
        }
    }
}

function blur(type, e){
    switch(type){
        case "regnum":{
            if (e.text() == ""){
                e.text(regnumstring);
            }
            break;
        }
        case "fname":{
            if (e.text() == ""){
                e.text(fnamestring);
            }
            break;
        }
        case "lname":{
            if (e.text() == ""){
                e.text(lnamestring);
            }
            break;
        }
        case "score":{
            if (e.text() == ""){
                e.text(scorestring);
            }
            break;
        }
    }
}
function regnumFocus(e){
    focus("regnum", e);
}

function fnameFocus(e){
    focus("fname", e);
}

function lnameFocus(e){
    focus("lname", e);
}

function scoreFocus(e){
    focus("score", e);
}
function regnumBlur(e){
    blur("regnum", e);
}

function fnameBlur(e){
    blur("fname", e);
}

function lnameBlur(e){
    blur("lname", e);
}

function scoreBlur(e){
    blur("score", e);
}