<?php

namespace Hyperreal\DmtBundle\TalkIntegration;

use Hyperreal\DmtBundle\Exception\DmtException;
use Symfony\Component\Security\Core\Encoder\BasePasswordEncoder;

class TalkPasswordEncoder extends BasePasswordEncoder
{
    const ITERATION_COUNT_LOG_2 = 6;

    private static $iToA64 = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

    public function encodePassword($raw, $salt)
    {
        throw new DmtException('Registration is currently not supported');
    }

    public function isPasswordValid($encoded, $raw, $salt)
    {
        if (strlen($raw) > 4096) {
            return false;
        }

        if (strlen($encoded) == 34) {
            $hashCryptPrivate = $this->hashCryptPrivate($raw, $encoded);
            return ($hashCryptPrivate === $encoded) ? true : false;
        }

        return (md5($raw) === $encoded) ? true : false;
    }

    private function hashCryptPrivate($password, $setting)
    {
        $output = '*';
        if (substr($setting, 0, 3) != '$H$' && substr($setting, 0, 3) != '$P$') {
            return $output;
        }

        $countLog2 = strpos(self::$iToA64, $setting[3]);

        if ($countLog2 < 7 || $countLog2 > 30) {
            return $output;
        }

        $count = 1 << $countLog2;
        $salt = substr($setting, 4, 8);

        if (strlen($salt) != 8) {
            return $output;
        }

        $hash = md5($salt . $password, true);
        do {
            $hash = md5($hash . $password, true);
        } while (--$count);

        $output = substr($setting, 0, 12);
        $output .= $this->hashEncode64($hash, 16);

        return $output;
    }

    private function hashEncode64($input, $count)
    {
        $output = '';
        $i = 0;

        do {
            $value = ord($input[$i++]);
            $output .= self::$iToA64[$value & 0x3f];

            if ($i < $count) {
                $value |= ord($input[$i]) << 8;
            }

            $output .= self::$iToA64[($value >> 6) & 0x3f];

            if ($i++ >= $count) {
                break;
            }

            if ($i < $count) {
                $value |= ord($input[$i]) << 16;
            }

            $output .= self::$iToA64[($value >> 12) & 0x3f];

            if ($i++ >= $count) {
                break;
            }

            $output .= self::$iToA64[($value >> 18) & 0x3f];
        } while ($i < $count);

        return $output;
    }
}