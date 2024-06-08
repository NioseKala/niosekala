<?
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
}

?>
