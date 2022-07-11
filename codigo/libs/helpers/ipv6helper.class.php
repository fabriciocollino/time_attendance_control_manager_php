<?php

class ipv6Helper {

	public static function is_ipv6($ip = "") {
		if ($ip == "") {
			$ip = self::get_ip();
		}
		if (substr_count($ip, ":") > 0 && substr_count($ip, ".") == 0) {
			return true;
		} else {
			return false;
		}
	}

	/*
	 * Detect if an IP is IPv4
	 *
	 * @param ip adresse ip ? tester
	 * @return true / false
	 */

	public static function is_ipv4($ip = "") {
		return!self::is_ipv6($ip);
	}

	/*
	 * return user IP
	 *
	 * @return IP
	 */

	public static function get_ip() {
		return getenv("REMOTE_ADDR");
	}

	/*
	 * Uncompress an IPv6 address
	 *
	 * @param ip adresse IP IPv6 ? d?compresser
	 * @return ip adresse IP IPv6 d?compress?
	 */

	public static function uncompress_ipv6($ip ="") {
		if ($ip == "") {
			$ip = self::get_ip();
		}
		if (strstr($ip, "::")) {
			$e = explode(":", $ip);
			$s = 8 - sizeof($e) + 1;
			foreach ($e as $key => $val) {
				if ($val == "") {
					for ($i == 0; $i <= $s; $i++)
						$newip[] = 0;
				} else {
					$newip[] = $val;
				}
			}
			$ip = implode(":", $newip);
		}
		return $ip;
	}

	/*
	 * Compress an IPv6 address
	 *
	 * @param ip adresse IP IPv6 ? compresser
	 * @return ip adresse IP IPv6 compress?
	 */

	public static function compress_ipv6($ip ="") {
		if ($ip == "") {
			$ip = self::get_ip();
		}
		if (!strstr($ip, "::")) {
			$e = explode(":", $ip);
			$zeros = array(0);
			$result = array_intersect($e, $zeros);
			if (sizeof($result) >= 6) {
				if ($e[0] == 0) {
					$newip[] = "";
				}
				foreach ($e as $key => $val) {
					if ($val !== "0") {
						$newip[] = $val;
					}
				}
				$ip = implode("::", $newip);
			}
		}
		return $ip;
	}

}

/*
 *  IPv6 Compression
 */
//echo " IPv6 compression : " . ipv6Helper::compress_ipv6() . "<br />". PHP_EOL;

/*
 * IPv6 Uncompression
 */
//echo "IPv6 Uncompression : " . ipv6Helper::uncompress_ipv6() . "<br />". PHP_EOL;

/*
 * Tester IPv6
 */
//echo "Your IP is " . ipv6Helper::get_ip() . " et You're using : ";
//echo (ipv6Helper::is_ipv6()) ? "IPv6" : "IPv4";

