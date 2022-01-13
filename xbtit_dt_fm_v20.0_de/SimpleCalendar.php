<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
//    This file is part of xbtit DT FM.
//
// Redistribution and use in source and binary forms, with or without modification,
// are permitted provided that the following conditions are met:
//
//   1. Redistributions of source code must retain the above copyright notice,
//      this list of conditions and the following disclaimer.
//   2. Redistributions in binary form must reproduce the above copyright notice,
//      this list of conditions and the following disclaimer in the documentation
//      and/or other materials provided with the distribution.
//   3. The name of the author may not be used to endorse or promote products
//      derived from this software without specific prior written permission.
//
// THIS SOFTWARE IS PROVIDED BY THE AUTHOR ``AS IS'' AND ANY EXPRESS OR IMPLIED
// WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
// MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
// IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
// SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED
// TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR
// PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF
// LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
// NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE,
// EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
//
////////////////////////////////////////////////////////////////////////////////////

namespace donatj;

/**
 * Simple Calendar
 *
 * @author Jesse G. Donat <donatj@gmail.com>
 * @link http://donatstudios.com
 * @license http://opensource.org/licenses/mit-license.php
 *
 */
class SimpleCalendar {

	/**
	 * Array of Week Day Names
	 *
	 * @var array
	 */
	public $wday_names = false;

	private $now;
	private $daily_html = array();
	private $offset = 0;

	/**
	 * Constructor - Calls the setDate function
	 *
	 * @see setDate
	 * @param null|string $date_string
	 */
	function __construct( $date_string = null ) {
		$this->setDate($date_string);
	}

	/**
	 * Sets the date for the calendar
	 *
	 * @param null|string $date_string Date string parsed by strtotime for the calendar date. If null set to current timestamp.
	 */
	public function setDate( $date_string = null ) {
		if( $date_string ) {
			$this->now = getdate(strtotime($date_string));
		} else {
			$this->now = getdate();
		}
	}

	/**
	 * Add a daily event to the calendar
	 *
	 * @param string      $html The raw HTML to place on the calendar for this event
	 * @param string      $start_date_string Date string for when the event starts
	 * @param null|string $end_date_string Date string for when the event ends. Defaults to start date
	 */
	public function addDailyHtml( $html, $start_date_string, $end_date_string = null ) {
		static $htmlCount = 0;
		$start_date = strtotime($start_date_string);
		if( $end_date_string ) {
			$end_date = strtotime($end_date_string);
		} else {
			$end_date = $start_date;
		}

		$working_date = $start_date;
		do {
			$tDate = getdate($working_date);
			$working_date += 86400;
			$this->daily_html[$tDate['year']][$tDate['mon']][$tDate['mday']][$htmlCount] = $html;
		} while( $working_date < $end_date + 1 );

		$htmlCount++;

	}

	/**
	 * Clear all daily events for the calendar
	 */
	public function clearDailyHtml() { $this->daily_html = array(); }

	/**
	 * Sets the first day of the week
	 *
	 * @param int|string $offset Day to start on, ex: "Monday" or 0-6 where 0 is Sunday
	 */
	public function setStartOfWeek( $offset ) {
		if( is_int($offset) ) {
			$this->offset = $offset % 7;
		} else {
			$this->offset = date('N', strtotime($offset)) % 7;
		}
	}

	/**
	 * Returns/Outputs the Calendar
	 *
	 * @param bool $echo Whether to echo resulting calendar
	 * @return string HTML of the Calendar
	 */
	public function show( $echo = true ) {
		if( $this->wday_names ) {
			$wdays = $this->wday_names;
		} else {
			$today = (86400 * (date("N")));
			$wdays = array();
			for( $i = 0; $i < 7; $i++ ) {
				$wdays[] = strftime('%a', time() - $today + ($i * 86400));
			}
		}

		$this->array_rotate($wdays, $this->offset);
		$wday    = date('N', mktime(0, 0, 1, $this->now['mon'], 1, $this->now['year'])) - $this->offset;
		$no_days = cal_days_in_month(CAL_GREGORIAN, $this->now['mon'], $this->now['year']);

		$out = '<table cellpadding="0" cellspacing="0" class="SimpleCalendar"><thead><tr>';

		for( $i = 0; $i < 7; $i++ ) {
			$out .= '<th>' . $wdays[$i] . '</th>';
		}

		$out .= "</tr></thead>\n<tbody>\n<tr>";

		$wday = ($wday + 7) % 7;

		if( $wday == 7 ) {
			$wday = 0;
		} else {
			$out .= str_repeat('<td class="SCprefix">&nbsp;</td>', $wday);
		}

		$count = $wday + 1;
		for( $i = 1; $i <= $no_days; $i++ ) {
			$out .= '<td' . ($i == $this->now['mday'] && $this->now['mon'] == date('n') && $this->now['year'] == date('Y') ? ' class="today"' : '') . '>';

			$datetime = mktime(0, 0, 1, $this->now['mon'], $i, $this->now['year']);

			$out .= '<time datetime="' . date('Y-m-d', $datetime) . '">' . $i . '</time>';

			$dHtml_arr = false;
			if( isset($this->daily_html[$this->now['year']][$this->now['mon']][$i]) ) {
				$dHtml_arr = $this->daily_html[$this->now['year']][$this->now['mon']][$i];
			}

			if( is_array($dHtml_arr) ) {
				foreach( $dHtml_arr as $dHtml ) {
					$out .= '<div class="event">' . $dHtml . '</div>';
				}
			}

			$out .= "</td>";

			if( $count > 6 ) {
				$out .= "</tr>\n" . ($i != $count ? '<tr>' : '');
				$count = 0;
			}
			$count++;
		}
		$out .= ($count != 1 ? str_repeat('<td class="SCsuffix">&nbsp;</td>', 8 - $count) : '') . "</tr>\n</tbody></table>\n";
		if( $echo ) {
			echo $out;
		}

		return $out;
	}

	private function array_rotate( &$data, $steps ) {
		$count = count($data);
		if( $steps < 0 ) {
			$steps = $count + $steps;
		}
		$steps = $steps % $count;
		for( $i = 0; $i < $steps; $i++ ) {
			array_push($data, array_shift($data));
		}
	}

}
?>