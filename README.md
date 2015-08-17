# League-Item-Set-Downloader
Downloads item sets from mobafire, made for Riot API challenge 2.0
Hosted at www.wzwright.com/ItemSetDownloader
(https://developer.riotgames.com/discussion/announcements/show/2lxEyIcE)

Made with PHP, JS, and jQuery with AJAX

curlPage.php gets the mobafire page and sends it to the client
download.php converts the JSON text to a file that is downloaded
itemLookup.txt maps Mobafire ids to league API ids, up to date as of 5.15
makeMapping.php is a script that helped create itemLookup.txt from the items static data in the Riot API and the Mobafire items page
