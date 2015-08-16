<html>
<head>
    <title>League Item Set Downloader</title>

    <link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
    <link href="./bootstrap.min.css" rel="stylesheet">
    <link href="./itemSet.css" rel="stylesheet">
    <script type="text/javascript" src="/js/jquery.js"></script>
</head>
<body>
    <script>
    var itemLookup=[];
    window.onload = function(){
        xmlhttpLoad.open("GET", "./itemLookup.txt", true);
        xmlhttpLoad.send();
    }

    var xmlhttpLoad=new XMLHttpRequest();
    xmlhttpLoad.onreadystatechange = function() {
        if (xmlhttpLoad.readyState == 4 && xmlhttpLoad.status == 200) {
            var items=xmlhttpLoad.responseText.split(",");
            items.forEach(function(value){
                itemLookup[value.split("|")[0]]=value.split("|")[1];
            });
        }
    }

    var xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            var curl = $(xmlhttp.responseText);
            $("#champion").html(curl.find("h3").first().html().split(" ")[0]);
            var itemFile = new Object();
            if($("#title").val().length>0)
                itemFile.title=$("#title").val();
            else
                itemFile.title=curl.find(".guide-main-title").html().replace(/\s\s+/g, "");
            itemFile.type='custom';
            itemFile.map='any';
            itemFile.mode='any';
            itemFile.priority='true';
            var blocks = [];
            $.each(curl.find(".item-wrap"),function(i,val){
                var block = new Object();
                block.type=$(val).find(">:first-child").html().replace(/\s\s+/g, "").replace(/<span[\s\S]*<\/span>/g, "");
                var items=[];
                $.each($(val).children().eq(1).find(".main-items a"),function(index,value){
                    var item = new Object();
                    item.id= itemLookup[/-\d+/.exec($(value).attr('href'))[0].replace("-","")];
                    items.push(item);
                });
                block.items=items;
                blocks.push(block);
            });
            itemFile.blocks=blocks;
            post("./download.php",{json:JSON.stringify(itemFile), title:itemFile.title});
        }
    }

    function generate(){
        if($("#url").val().toLowerCase().indexOf('mobafire.com/league-of-legends/build/')!=-1)
        {
            xmlhttp.open("GET","./curlPage.php?u="+$("#url").val(),true);
            xmlhttp.send();
        }
        else
        {
            $("#url").val("");
            $("#url").attr("placeholder","Please use a mobafire guide")
        }
    }

    function post(path, params) {
    var method = "post"; // Set method to post by default if not specified.

    // The rest of this code assumes you are not using a library.
    // It can be made less wordy if you use one.
    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", path);

    for(var key in params) {
        if(params.hasOwnProperty(key)) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);

            form.appendChild(hiddenField);
         }
    }

    document.body.appendChild(form);
    form.submit();
}
    </script>
    <div class="container">
        <h2><p class="text-center text">Mobafire item set downloader</p></h2>
        <h4><p class="text-center text">Generate an item set from a Mobafire guide</p></h4>
        <h4><p class="text-center text">Place the downloaded file into C:\Riot Games\League of Legends\Config\Champions\<mark id="champion" style="background-color:#95a5a6;">ChampionName</mark>\Recommended\</p></h4>
        <br>
        <div id="innerDiv" class="text-center"><input size="40" id="url" placeholder="Guide URL"></input><br>
        <input size="23" id="title" placeholder="Custom title (optional)"></input><button style="width:119px; margin-top:3px;" onclick="generate()">Create Item Set</button></div>
        <br>
        <br>
    </div>
</body>
</html>