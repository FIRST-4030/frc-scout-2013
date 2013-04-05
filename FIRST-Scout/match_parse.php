<?php

# Config -- this changes for each competition
$start_date = '2013-04-05';
$results_url = 'http://www2.usfirst.org/2013comp/Events/WACH/matchresults.html';

# PHP whines if you don't declare a timezone locally
date_default_timezone_set('America/Los_Angeles');

# Allow command-line override for debug use
if (isset($argv[1]) && strlen($argv[1])) {
	$results_url = $argv[1];
}
if (isset($argv[2]) && strlen($argv[2])) {
	$start_date = $argv[2];
}

# Read the file and split on >
$string = file_get_contents($results_url, FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
$results = explode('>', $string);
unset($string);

# Parse state
$inTable = false;
$inResults = false;
$inRow = false;
$inCell = false;
$cdata = '';
$row = array();
$inMatches = false;
$lastTime = 0;

# Loop through the data
foreach ($results as $line) {

	# Start of table
	if (!$inTable) {
		if (preg_match('/\<table(?:\s+.*)?$/i', $line)) {
			$inTable = true;
			continue;
		}


	# In a table
	} else {
	
		# End of table
		if (preg_match('/\<\/table\s*$/i', $line)) {
			endTable();
			continue;
		}
		
		# Start of row
		if (!$inRow) {
			if (preg_match('/\<tr(?:\s+.*)?$/i', $line)) {
				$inRow = true;
				continue;
			}

		# In a row
		} else {
			
			# End of row
			if (preg_match('/\<\/tr\s*$/i', $line)) {
				endRow();
				continue;
			}
			
			# Start of cell
			if (!$inCell) {
				if (preg_match('/\<td(?:\s+.*)?$/i', $line)) {
					$inCell = true;
					continue;
				}

			# In a cell
			} else {
				
				# End of cell
				if (preg_match('/(.*)\<\/td\s*$/i', $line, $matches)) {
					endCell($matches[1]);
					continue;
				}
				
				# Capture data
				$cdata .= $line . '>';
			}
		}
	}
}

function endCell($data = '') {
	global $cdata;
	global $inCell;
	if (isset($data) && strlen($data)) {
		$cdata .= $data;
	}
	gotCell($cdata);
	$cdata = '';
	$inCell = false;
}

function endRow($data = '') {
	global $inRow;
	endCell($data);
	gotRow();
	$inRow = false;
}

function endTable($data = '') {
	global $inTable;
	endRow($data);
	gotTable();
	$inTable = false;
}

function gotCell($data) {
	global $row;
	if (isset($data) && strlen($data)) {
		$row[] = $data;
	}
}

function gotRow() {
	global $row;
	global $inMatches;
	if (!$inMatches) {
		if (is_array($row) && count($row) > 2) {
			if (preg_match('/Time/', $row[0]) && preg_match('/(?:Match|Description)/', $row[1])) {
				$inMatches = true;
			}
		}
	} else {
		gotMatch($row);
	}
	$row = array();
}

function gotTable() {
	global $inMatches;
	$inMatches = false;
}

function gotMatch($row) {
	if (!isset($row) || !is_array($row)) {
		print "Invalid row (not an array)\n";
	}
	$count = count($row);
	if (!$count) {
		return;
	}
	if ($count != 8 && $count != 10 && $count != 11) {
		print 'Invalid row (' . count($row) . '): ' . join("\t", $row) . "\n";
		return;
	}
	
	# Deal with the silly time-only data
	global $lastTime;
	global $start_date;
	$time = strtotime($start_date . ' ' . $row[0]);
	if ($time < $lastTime) {
		$time += 86400;
	}
	$lastTime = $time;
	
	# Build a more useful array
	$data = array();
	$data['time'] = $time;
	# Store the time as an epoch-seconds date for each math
	# Use something like date('Y-m-d H:i:s T', $time) to get human-readable times

	# Finals have an extra column, so everything after time is offset
	$finals = 0;
	if ($count == 11) {
		$data['description'] = $row[1];
		$finals = 1;
	}

	# Basic data, including finals offset
	$data['match'] = $row[1 + $finals];
	$data['red']   = array($row[2 + $finals], $row[3 + $finals], $row[4 + $finals]);
	$data['blue']  = array($row[5 + $finals], $row[6 + $finals], $row[7 + $finals]);

	# Only some matches have scores
	if ($count >= 10) {
		$data['score'] = array('red' => $row[8 + $finals], 'blue' => $row[9 + $finals]);
	}
	dataReady($data);
}

# Do something useful here
function dataReady($data) {
	print_r($data);
}

?>
