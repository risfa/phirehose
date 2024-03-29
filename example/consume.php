<?php
/**
 * A simple example of how you could consume (ie: process) statuses collected by the ghetto-queue-collect.
 * 
 * This script in theory supports multi-processing assuming your filesystem supports flock() semantics. If you're not 
 * sure what that means, you probably don't need to worry about it :)
 * 
 * Caveat: I'm not sure if this works properly/at all on windows.
 * 
 * See: http://code.google.com/p/phirehose/wiki/Introduction
 */
class GhettoQueueConsumer
{
  
  /**
   * Member attribs
   */
  protected $queueDir;
  protected $filePattern;
  protected $checkInterval;
  
  /**
   * Construct the consumer and start processing
   */
  public function __construct($queueDir = 'limadigitid', $filePattern = 'limadigitid*.queue', $checkInterval = 10)
  {
    $this->queueDir = $queueDir;
    $this->filePattern = $filePattern;
    $this->checkInterval = $checkInterval;
    
    // Sanity checks
    if (!is_dir($queueDir)) {
      throw new ErrorException('Invalid directory: ' . $queueDir);
    }
    
  }
  
  /**
   * Method that actually starts the processing task (never returns).
   */
  public function process() {
    
    // Init some things
    $lastCheck = 0;
    //*******//
		//testing//
		//*******//
    // Loop infinitely
    // while (TRUE) {
    //*******//
		//testing//
		//*******//
      // Get a list of queue files
			//*******//
			//testing//
			//*******//
      // $queueFiles = glob($this->queueDir . '/' . $this->filePattern);
			//*******//
			//testing//
			//*******//
      $queueFiles = $this->queueDir . '/limadigitid.20151204-113625.queue';
      $lastCheck = time();
      
      $this->log('Found ' . count($queueFiles) . ' queue files to process...');
      
      // Iterate over each file (if any)
			//*******//
			//testing//
			//*******//
      // foreach ($queueFiles as $queueFile) {
			//*******//
			//testing//
			//*******//
        $this->processQueueFile($queueFiles);
			//*******//
			//testing//
			//*******//
      //*******//
      // }
			//testing//
			//*******//
      
      // Wait until ready for next check
      $this->log('Sleeping...');
      while (time() - $lastCheck < $this->checkInterval) {
        sleep(1);
      }
    //*******//
		//testing//
		//*******//
    // } // Infinite loop
    //*******//
		//testing//
		//*******//
  } // End process()
  
  /**
   * Processes a queue file and does something with it (example only)
   * @param string $queueFile The queue file
   */
  protected function processQueueFile($queueFile) {
    $this->log('Processing file: ' . $queueFile);
    
    // Open file
    $fp = fopen($queueFile, 'r');
    
    // Check if something has gone wrong, or perhaps the file is just locked by another process
    if (!is_resource($fp)) {
      $this->log('WARN: Unable to open file or file already open: ' . $queueFile . ' - Skipping.');
      return FALSE;
    }
    
    // Lock file
    flock($fp, LOCK_EX);
    
    // Loop over each line (1 line per status)
    $statusCounter = 0;
    while ($rawStatus = fgets($fp, 8192)) {
      $statusCounter ++;
      
      /** **************** NOTE ********************
       * This is the part where you would normally do your processing. If you're extracting/trending information 
       * about the tweets it should happen here, where it doesn't matter so much if things are slow (you will
       * catch up on the next loop).
       */
      $data = json_decode($rawStatus, true);
			echo "<pre>";
			print_r($data);
      // if (is_array($data) && isset($data['user']['screen_name'])) {
        // $this->log('Decoded tweet: ' . $data['user']['screen_name'] . ': ' . urldecode($data['text']));
      // }
      
    } // End while
    
    // Release lock and close
    flock($fp, LOCK_UN);
    fclose($fp);
    
    // All done with this file
    $this->log('Successfully processed ' . $statusCounter . ' tweets from ' . $queueFile . ' - deleting.');
		//*******//
		//testing//
		//*******//
    // unlink($queueFile);    
    //*******//
		//testing//
		//*******//
  }
  
  /**
   * Basic log function.
   *
   * @see error_log()
   * @param string $messages
   */
  protected function log($message)
  {
    @error_log($message, 0);
  }
    
}

// Construct consumer and start processing
$gqc = new GhettoQueueConsumer();
$gqc->process();