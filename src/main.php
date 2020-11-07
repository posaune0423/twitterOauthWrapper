<?php
ini_set('session.gc_maxlifetime', 60 * 60 * 24);
session_start();
$_SESSION['retweeted'] = [];


require_once('../config.php');
require_once('./tweet.php');
require '../vendor/autoload.php';


use Abraham\TwitterOAuth\TwitterOAuth;

// set required api key
$connection = new TwitterOAuth(
	CONSUMER_KEY,
	CONSUMER_SECRET,
	ACCESS_TOKEN,
	ACCESS_TOKEN_SECRET
);
$tweetmanager = new TweetManager($connection);


$keywords = ['リツイート', 'RT'];


$current_timeline = $tweetmanager->get_timeline();
$id_lists = $tweetmanager->fetch_tweet_id_containg_keywords($current_timeline, $keywords);


$result = $tweetmanager->retweet($id_lists);


if ($connection->getLastHttpCode() === 200) {
	echo 'Success! ' . $result . ' tweets has been retweeted' . "\n";
} else {
	echo 'Something went Wrong...' . "\n";
}
