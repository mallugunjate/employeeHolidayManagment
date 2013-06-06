<?php
require_once (dirname(__FILE__) . '/pearlog/Log.php');

/**
 * Logger class for logging into files.
 * Uses PEAR Logger
 * Read this document for more details
 * http://www.indelible.org/php/Log/guide.html
 */
class logger {

    function logger($loglevel, $logname = '', $logdir, $logprefix) {
        if($loglevel === 'off') {
            $this->enabled = false;
            return;
        }
        $this->enabled = true;
        $loglevel = strtolower($loglevel);
        $logpath = $logdir . '/' . $logprefix .'_' . date('Y-m-d') . '.log';
        $logobj = new Log('file', $logpath, $logname);
        $conf = array('lineFormat' => '[%1$s] [%2$s] [%3$s] %4$s', 'timeFormat' => $this->get_formatted_date());
        switch($loglevel) {
            case 'debug':
                $this->file = $logobj->singleton('file', $logpath, $logname, $conf, PEAR_LOG_DEBUG);
                break;
            case 'info':
                $this->file = $logobj->singleton('file', $logpath, $logname, $conf, PEAR_LOG_INFO);
                break;
            case 'error':
                $this->file = $logobj->singleton('file', $logpath, $logname, $conf, PEAR_LOG_ERR);
                break;
            case 'fatal':
                $this->file = $logobj->singleton('file', $logpath, $logname, $conf, PEAR_LOG_EMERG);
                break;
            case 'warning':
                $this->file = $logobj->singleton('file', $logpath, $logname, $conf, PEAR_LOG_WARNING);
                break;
            default:
                $this->file = $logobj->singleton('file', $logpath, $logname, $conf, PEAR_LOG_INFO);
                break;
        }
    }

    function info($msg, $userid = null) {
        $this->log_message($msg, $userid, PEAR_LOG_INFO);
    }

    function error($msg, $userid = null) {
        $this->log_message($msg, $userid, PEAR_LOG_ERR);
    }

    function debug($msg, $userid = null) {
        $this->log_message($msg, $userid, PEAR_LOG_DEBUG);
    }

    function fatal($msg, $userid = null) {
        $this->log_message($msg, $userid, PEAR_LOG_EMERG);
    }

    function warning($msg, $userid = null) {
        $this->log_message($msg, $userid, PEAR_LOG_WARNING);
    }

    function log_message($msg, $userid, $loglevel) {
        if(!empty($msg) && $this->enabled) {
            $ip = (isset($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : '';
            $msg = "[$ip] [$userid] [$msg]";
        }
        $this->file->log($msg, $loglevel);
    }

    function get_formatted_date() {
        list($usec, $sec) = explode(" ", microtime());
        $date = date("d-m-Y H:i:s", (string)$sec) . substr($usec, 1, 4); 
        return $date;
    }
}
