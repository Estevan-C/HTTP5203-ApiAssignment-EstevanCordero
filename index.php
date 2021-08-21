<?php
// Files to call for API Curl Request
include_once 'curl_request/idgb_curl.php';
include_once 'curl_request/youtube_curl.php';

// Limit set for the For Loop
define("MAX_RESULTS", 10);

// Table For IDGB
$rows = '';
$rows  = '<table>';
    $rows .= '<tr>';
        $rows .= '<th>Link to IDGB Page</th>';
        $rows .= '<th>Rating</th>';
        $rows .= '<th>Followers on IDGB</th>';
        $rows .= '<th>Game Summary</th>';
    $rows .= '</tr>';
if(isset($_POST['submit']) ) {

    $keyword = $_POST['keyword'];

    // Test if keyword is empty
    if(empty($keyword)){
        $response = "Please Enter A Game/Character!" ;
    }

    // If Not Empty
    if (!empty($keyword)) {

        $data = idgb($keyword); // call to IDGB Curl

        // Output for IDGB Table
        foreach ($data as $game) {
            $rows .= '<tr>';
            $rows .= '<td>' . '<a href="' . $game->url . '">' . $game->name . '</a>' . '</td>';
            $rows .= '<td>' . $game->total_rating . '</td>';
            if ($game->follows == 0) {
                $rows .= '<td>No Followers</td>';
            } else {
                $rows .= '<td>' . $game->follows . '</td>';
            }
            $rows .= '<td>' . $game->summary . '</td>';
            $rows .= '</tr>';
        }
        $rows .= '</table>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="css/midnight-green.scss">
        <title>Search Function</title>
    </head>
    <body>
        <nav>
            <header>API Assignment</a></header>
        </nav>
        <section container>
            <h1>Search Through A Database on a Game/Character of Your Choice!</h1>
            <form method="post" action="">
                <div>
                  <label>Search A Game or Character :</label>
                    <input class="input-field" type="search" id="keyword" name="keyword"  placeholder="Enter A Game/Character"/>
                </div>
                <input type="submit" name="submit" value="Search">
            </form>
            <?php if(empty($keyword)) { ?>
                <div><h3><?php echo $response ?></h3></div>
            <?php }?>
        </section>
        <h2>Top 10 Video Games Base On Your Search</h2>
        <?php
          if (isset($_POST['submit'])) {
              $keyword = $_POST['keyword'];
              if(!empty($keyword)){
                print $rows;
              }
        }?>
        <h2>Top 10 Most Recent Youtube Videos Base On Your Search</h2>
        <?php

        // Out Put For Youtube Videos
        if (isset($_POST['submit'])) {
            $keyword = $_POST['keyword'];
            if(!empty($keyword)){
                for($i = 0; $i < MAX_RESULTS; $i++)
                {
                    $value = youtube($keyword); // Call to Youtube Curl

                    // Collects the id and snippets for a youtube video
                    $videoID = $value['items'][$i]['id']['videoId'];
                    $title = $value['items'][$i]['snippet']['title'];
                    $description = $value['items'][$i]['snippet']['description'];

        ?>
            <div class="video-tile">
                 <div  class="videoDiv">
                     <iframe id="iframe" style="width:100%;height:100%" src="//www.youtube.com/embed/<?php echo $videoID; ?>"
                             data-autoplay-src="//www.youtube.com/embed/<?php echo $videoID; ?>?autoplay=1">
                     </iframe>
                 </div>
                 <div class="videoInfo">
                    <div class="videoTitle"><b><?php echo $title; ?></b></div>
                    <div class="videoDesc"><?php echo $description; ?></div>
                 </div>
            </div>
             <?php
                }
              }
            }
             ?>
    </body>
</html>