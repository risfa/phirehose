<?php
require_once('../lib/Phirehose.php');
require_once('../lib/OauthPhirehose.php');

/**
 * Example of using Phirehose to display the 'sample' twitter stream.
 */
class SampleConsumer extends OauthPhirehose
{
  /**
   * Enqueue each status
   *
   * @param string $status
   */
  public function enqueueStatus($status)
  {
    /*
     * In this simple example, we will just display to STDOUT rather than enqueue.
     * NOTE: You should NOT be processing tweets at this point in a real application, instead they should be being
     *       enqueued and processed asyncronously from the collection process.
     */
    $data = json_decode($status, true);
    if (is_array($data) && isset($data['user']['screen_name'])) {
      print $data['user']['screen_name'] . ': ' . urldecode($data['text']) . "\n";
    }
  }
}

// The OAuth credentials you received when registering your app at Twitter
define('TWITTER_CONSUMER_KEY', '2Hr3pbuqo4GxSFR6zMdUhJZsm');
define('TWITTER_CONSUMER_SECRET', 'BYl5qn5jedbWBQU2rx6GCYmLVJNzfnHieLe0peaxiAqYeKov9a');

// The OAuth data for the twitter account
define('OAUTH_TOKEN', '1428145356-DwiEL7qdxQyscxVux0WE29YTY1Q3Vtf8CORmZVN');
define('OAUTH_SECRET', 'AexL66u9hZwmvSOR56B8nwgo8lGWZ4wDwrpj50WRMB0hS');

// Start streaming
$sc = new SampleConsumer(OAUTH_TOKEN, OAUTH_SECRET, Phirehose::METHOD_SAMPLE);
$sc->consume();
