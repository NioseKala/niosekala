<?php
include_once "../logger/Logger.php";

class YoutubeVideos
{
  private $videos;
  public function YoutubeVideos() {
    $this->videos = array();
  }

  public function loadAll() {
    $mysqli = $_SESSION['dbconnect'];
   	$getYoutubeVideo = "SELECT * FROM YoutubeVideo";
  	$stmt = $mysqli->prepare($getYoutubeVideo);
  	$stmt->execute();
  	$results = $stmt->get_result();

   	while ($row = $results->fetch_assoc()) {
  		$title = $row['title'];
  		$url = $row['url'];
      $videoKey = $row['videoKey'];

      $videos[] = new YoutubeVideo($title, $url, $videoKey);
    }
  }

  public function getYoutubeVideos() {
    return $videos;
  }

  public function getYoutubeVideoByVideoKey($videoKey) {
    foreach ($videos as $video) {
      if ($video->getVideoKey() == $videoKey) {
        return $video;
      }
    }
  }

  public function insert($title, $url, $videoKey) {
    $newVideo = new YoutubeVideo($title, $url, $videoKey);
    $success = $newVideo->insert();
    if ($success) {
      Logger::info("Inserted a YoutubeVideo record with title: '".$title."', url: '".$url."', and videoKey: '".$videoKey."'");
      $videos[] = $newVideo;
    } else {
      Logger::warn("Wasn't able to insert the YoutubeVideo record with title: '".$title."', url: '".$url."', and videoKey: '".$videoKey."'");
    }
    return $success;
  }
}

?>
