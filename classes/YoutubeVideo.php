<?php
class YoutubeVideo {
  include_once "../logger/Logger.php";

  public function YoutubeVideo($title, $url, $videoKey) {
    $this->title = $title;
    $this->url = $url;
    $this->videoKey = $videoKey;
  }

  private $title;
  public function setTitle($title) { $this->title = $title; }
  public function getTitle() { return $this->title; }

  private $url;
  public function setUrl($url) { $this->url = $url; }
  public function getUrl() { return $this->url; }

  // Primary Key
  private $videoKey;
  public function setVideoKey($videoKey) { $this->videoKey = $videoKey; }
  public function getVideoKey() { return $this->videoKey; }

  protected function insert() {
    $mysqli = $_SESSION['dbconnect'];
    $insertVideoSql = "INSERT INTO `YoutubeVideo`(`title`, `url`, `videoKey`) VALUES (?,?,?)";
    $stmt = $mysqli->prepare($insertVideoSql);
    $stmt->bind_param("sss", getTitle(), getUrl(), getVideoKey());
    return $stmt->execute();
  }

  protected function createTableIfMissing() {
    mysqli = $_SESSION['dbconnect'];
    $selectQuery = "SELECT count(*) as exists FROM information_schema.TABLES WHERE (TABLE_NAME = 'YoutubeVideo')";
		$results = $mysqli->query($selectQuery);
		$row = $results->fetch_assoc();

		if($row['exist'] == '0') {
      $createTableQuery = "CREATE TABLE YoutubeVideo( title varchar(150) NOT NULL, url varchar(150) NOT NULL, videoKey varchar(40) NOT NULL PRIMARY KEY)";
      $mysqli->execute($createTableQuery);
      Logger::info("YoutubeVideo table was created");
    }
  }
}
?>
