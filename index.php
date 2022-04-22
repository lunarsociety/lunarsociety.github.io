<?php
//Needed varibles
//you need to put a roblox cookie here blame roblox
$cookie = "_|WARNING:-DO-NOT-SHARE-THIS.--Sharing-this-will-allow-someone-to-log-in-as-you-and-to-steal-your-ROBUX-and-items.|_DCA018A03F7F70B867477F0F00C933514EC3AF9DCB6B3BBAE9E01FAC5BE3A20EE9D73CBA4E4FE1837464CEB76FD19934B2B84BD9DF1C63137F12DFFEDFA452234874D70C997C73DBE454D35FBB1CCE8517B37BAC604F2B339D867047111D0BE2E9F1EE488C552487334E43A85A8345542A48500D56F283A181122D420D3991F61CDE901226BC2B759985F464763E0A2B545634F49BEFB4314F9A731CDF614F3DD893936CAB7B31EF2A28C36D8DD06E86CE8CCB188F87E92F3061C7F4695CB21A9A6DC3F1866834E82D42243F29C3297EA554368E8DCAB8E01A36AF49C7B6BF6791585D7CF21C3AB25B6BDAD2454A8409C794DC550F44314A10527FD4BCB111FDC15264CD60D661E7FA92F74A132B79FE94E40AE5BDFCF8023EED4E406D0557483817CEEB717EA7A16B98B150394CB168EA98E1D481DF85016D396C2FB5068F9CA4E10F1B378C36C69FC9A0C0879208CAE4A8BA04B63B18F9754B598882E606B818B996E5";
$pageName = "Condos";
$blurAmount = "10px";
$backgroundImage = "https://64.media.tumblr.com/5fc40a5f0e4b4990d6e30da96a55e0c3/c8e72d9c71fc1da6-91/s1280x1920/dc431cdb2704a1909a99813bce30b9d467ade742.gifv";
$discordInvite = "https://discord.gg/legosex";
$iconUrl = "https://images.rbxcdn.com/3b43a5c16ec359053fef735551716fc5.ico"; // Icon of the site
$webhook = "https://discord.com/api/webhooks/0/no"; // Out of games and error webhook

$gameIds = array(// List of gamesIDs
    4878988249, // Roblox
   
);

$githubCredits = false; //Add in the bottom right my github link
// If you keep my credits and dm me the site link I will post it to the github

$checkForUpdates = False; //Will check for updates (disabled by default do to being annoying to users)

//Embed data
$enableEmbed = True; //IDK if i made the toggle right lol
$embedHexColor = "#85bb65"; //Needs to be hex code
$embedTitle = "Condos"; //Title for embed
$embedDescription = "List of Condos"; //Description for embed

// /‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾\
// | DON'T MESS WITH ANY THING PAST UNLESS YOU KNOW WHAT YOU ARE DOING! |
// \____________________________________________________________________/

//Discord out of games and error webhook
function postToDiscord($message){
    $json_data = json_encode(["content" => $message], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
    $ch = curl_init( $webhook );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
    curl_setopt( $ch, CURLOPT_POST, 1);
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt( $ch, CURLOPT_HEADER, 0);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
    
    $response = curl_exec( $ch );
    curl_close( $ch );
}
shuffle($gameIds);

function sendCsrfRequest(){ //Send a request to get the CSRF token from roblox
    $csrfUrl = "https://auth.roblox.com/v2/login";

    function grabCsrfToken( $curl, $header_line ) { //Filter through the Roblox headers
        if(strpos($header_line, "x-csrf-token") !== false){
            global $csrf;
            $csrf = ltrim($header_line, "x-csrf-token: "); // set x-csrf-token var
        }
        return strlen($header_line);
    }

    $csrfCurl = curl_init();
    curl_setopt($csrfCurl, CURLOPT_URL, $csrfUrl);
    curl_setopt($csrfCurl, CURLOPT_POST, true);
    curl_setopt($csrfCurl, CURLOPT_HEADERFUNCTION, "grabCsrfToken");
    curl_setopt($csrfCurl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($csrfCurl,CURLOPT_RETURNTRANSFER,1);

    curl_exec($csrfCurl);
    curl_close($csrfCurl);
}

function checkGame($placeId){ //Finds what game works
    global $csrf, $cookie, $isPlayable;
    $gameUrl = "https://games.roblox.com/v1/games/multiget-place-details?placeIds=$placeId";

    $gameCurl = curl_init();
    curl_setopt($gameCurl, CURLOPT_URL, $gameUrl);

    $headers = array("X-CSRF-TOKEN: ".$csrf);
    curl_setopt($gameCurl, CURLOPT_COOKIE, '.ROBLOSECURITY='.$cookie);
    curl_setopt($gameCurl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($gameCurl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($gameCurl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt($gameCurl, CURLOPT_RETURNTRANSFER,1);

    $resp = curl_exec($gameCurl);
    curl_close($gameCurl);
    $data = json_decode($resp);
    return $data[0]->isPlayable; //Get if you can play or not
}
try {
    sendCsrfRequest();
} catch (Error $e) {}
$versionId = "(c) Copyright Lunar Society LLC. All rights reserved.";
?>
<!DOCTYPE html>
<html lang='en'>
	<head>
		<meta charset='UTF-8'/>
		<title>
                <?php echo($pageName); ?>
		</title>
        <link rel="icon" href="<?php echo($iconUrl); ?>">
	    <style>
	    	@import url('https://fonts.googleapis.com/css?family=Montserrat&display=swap');
	    	@import url('https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css');

	    	@keyframes glowing {
	    		0% {
                    filter: drop-shadow(0 0 0.25rem red);
	    		}
	    		50% {
                    filter: drop-shadow(0 0 0.50rem green);
	    		}
	    		100% {
                    filter: drop-shadow(0 0 0.25rem red);
	    		}
	    	}

	    	body {
    			background: url("<?php echo($backgroundImage); ?>") no-repeat center center fixed; 
				background-repeat: no-repeat;
				backdrop-filter: blur(<?php echo($blurAmount); ?>);
				background-position: bottom;
				background-size: cover;

				height: 100vh;
				width: 100%;

	    		font-family: 'Montserrat', sans-serif;
	    		min-height: 80vh;
	    		display: -webkit-box;
	    		display: flex;
	    		align-items: center;
	    		justify-content: center;
	    		flex-direction: column;
	    	}

	    	h1 {
	    		font-family: 'Montserrat', sans-serif !important;
	    		font-weight: bold;
                filter: drop-shadow(0 0 0);
	    		animation: glowing 3500ms infinite;
	    	}

	    	h2 {
	    		font-family: 'Montserrat', sans-serif !important;
	    		font-size: 350%;
	    	}

	    	h3 {
	    		font-family: 'Montserrat', sans-serif !important;
	    		font-size: 150%;
	    	}

            #bottomRight
            {
                position:fixed;
                bottom:5px;
                right:5px;
                opacity:0.5;
                z-index:99;
                color:white;
            }
            #bottomLeft
            {
                position:fixed;
                bottom:5px;
                left:5px;
                opacity:0.5;
                z-index:99;
                color:white;
            }
	    </style>

        <script>
            function fadeInPage() {
                for (let i = 1; i < 100; i++) {
                    fadeIn(i * 0.01);
                }
            
                function fadeIn(i) {
                    setTimeout(function() {
                        document.body.style.opacity = i;
                    }, 2000 * i);
                }
            }
        </script>
        <?php if ($enableEmbed): ?>
        <meta name="description" content="<?php echo($embedDescription);?>">

        <!-- Google / Search Engine Tags -->
        <meta name="theme-color" content="<?php echo($embedHexColor);?>">
        <meta itemprop="name" content="<?php echo($embedTitle);?>">
        <meta itemprop="description" content="<?php echo($embedDescription);?>">

        <!-- Facebook Meta Tags -->
        <meta property="og:title" content="<?php echo($embedTitle);?>">
        <meta property="og:type" content="website">

        <!-- Twitter Meta Tags -->
        <meta name="twitter:card" content="summary">
        <meta name="twitter:title" content="<?php echo($embedTitle);?>">
        <meta name="twitter:description" content="<?php echo($embedDescription);?>">
        <?php endif; ?>

        <?php if ($checkForUpdates): ?>
        <link rel="stylesheet" href="//code.jquery.com/mobile/1.5.0-alpha.1/jquery.mobile-1.5.0-alpha.1.min.css" />
        <script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="//code.jquery.com/mobile/1.5.0-alpha.1/jquery.mobile-1.5.0-alpha.1.min.js"></script>
        <?php endif; ?>
        
	</head>

	<body style="opacity:0" onload='fadeInPage()'>
		<h1 class="text-light">
                <?php echo($pageName); ?>
		</h1>
        <?php if ($discordInvite == "https://discord.gg/legosex"): ?>
        <div class="btn-group mt-2 mb-4" role="group" aria-label="actionButtons">
			<a href="<?php echo($discordInvite); ?>" class="d-block btn btn-outline-light">
				Join the Discord
			</a>
		</div>
        <?php endif; ?>
        <a>
            <?php
                try {
                    foreach ($gameIds as $gameId) {
                        echo "<h3 class=\"text-light\">";
                        $isPlayable = checkGame($gameId);
                        echo "<b>Want more condos?:</b> ";
                        if ($isPlayable){
                          echo "Stop using the sources section of the DevTools and get a life you fucking jew.";
                        }else{
                            echo "<a style=\"color: #dcdcdc\" href=\"https://discord.gg/legosex\"><u>Click here.</u></a><br>";
                        }
                        }
                        echo "</h3>";
                    }
               // }
                 catch (Error $e) {
                }
            ?>
            <div id="bottomLeft"> <?php //Please don't take credit for this shit :) ?>
                <?php echo($versionId); ?>
            </div>

            <?php if ($checkForUpdates): ?>
            <?php 
                //check the current ver on github
                //Not going to explain this mess
                $url = "";

                $curl = curl_init($url);
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                
                $headers = array(
                    "User-Agent: Update Checker"
                );
                curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                //for debug only!
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                
                $resp = curl_exec($curl);
                curl_close($curl);
                var_dump($resp);
                
                // Converts it into a PHP object
                $data = json_decode($resp);
                $githubVersion = $githubVersion[0]->tag_name;
            ?>
            
            <div role="main" class="ui-content">
                <div data-role="popup" id="popupDialog" data-overlay-theme="b" data-theme="a" style="max-width:400px;" class="ui-corner-all">
                    <div role="main" class="ui-corner-bottom ui-content">
                        <h3 class="ui-title">Alert!</h3>
                        <p>You are a jew!<br>Please go kill yourself. Thank you for cooperating!</p>
                        <a href="#" data-role="button" data-inline="true" data-rel="back" data-theme="a">Close</a>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <?php if ($githubCredits): ?>
            <div id="bottomRight"> <?php //oops, sorry for removing this! blame the jews for this. ?>
                <a href="https://trump2020.org">
                    Site coded by NOT jews.
                </a>
            </div>
            <?php endif; ?>
		</a>
    </body>
</html>
</html>
