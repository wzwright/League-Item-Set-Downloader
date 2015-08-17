<html>
<head>
	<title></title>
	<script type="text/javascript" src="/js/jquery.js"></script>
</head>
<body>
	<script>
	var leagueIDLookup=[];
	window.onload=function(){
        xmlhttpLoad.open("GET", "http://ddragon.leagueoflegends.com/cdn/5.2.1/data/en_US/item.json", true);
        xmlhttpLoad.send();

        xmlhttp.open("GET","./curlPage.php?u=http://www.mobafire.com/league-of-legends/items",true);
        xmlhttp.send();
    }

	var xmlhttpLoad=new XMLHttpRequest();
    xmlhttpLoad.onreadystatechange = function() {
        if (xmlhttpLoad.readyState == 4 && xmlhttpLoad.status == 200) {
            var itemJson=JSON.parse(xmlhttpLoad.responseText);
            for(var key in itemJson.data){
                leagueIDLookup[itemJson.data[key].name.toLowerCase().replace("'","")]=key;
            }
        }
    }

    var xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            var curl = $(xmlhttp.responseText);
            var result="";
            var failed="";
            $.each(curl.find(".champ-box"),function(i,val){
            	var id=/-\d+/.exec($(val).attr('href'))[0].replace("-","");
            	var itemName=/\/item\/[a-zA-Z-]+/.exec($(val).attr('href'))[0].replace("/item/","").replace(/-/g," ");
            	itemName=itemName.substring(0,itemName.length-1);
            	if(itemName in leagueIDLookup)
            		result+=id+"|"+leagueIDLookup[itemName]+",";
            	else
            		failed+=itemName+", "+id+" | ";
            });
            console.log(result);
            console.log(failed);
        }
    }
	</script>
</body>
</html>