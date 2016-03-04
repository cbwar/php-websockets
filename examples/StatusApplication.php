<?php

/**
 * Shiny WSS Status Wrench_Application_Application
 * Provides live server infos/messages to client/browser.
 *
 * @author Simon Samtleben <web@lemmingzshadow.net>
 */
class Wrench_Application_StatusApplication extends Wrench_Application_Application
{
    private $_clients           = array();
    private $_serverClients     = array();
    private $_serverInfo        = array();
    private $_serverClientCount = 0;

    /**
     * @param Wrench_Connection $client
     */
    public function onConnect($client)
    {
        $id = $client->getId();
        $this->_clients[$id] = $client;
        $this->_sendServerinfo($client);
    }

    /**
     * @param Wrench_Connection $client
     */
    public function onDisconnect($client)
    {
        $id = $client->getId();
        unset($this->_clients[$id]);
    }

    public function onData($data, $client)
    {
        // currently not in use...
    }

    public function setServerInfo($serverInfo)
    {
        if (is_array($serverInfo)) {
            $this->_serverInfo = $serverInfo;
            return true;
        }

        return false;
    }


    public function clientConnected($ip, $port)
    {
        $this->_serverClients[$port] = $ip;
        $this->_serverClientCount++;
        $this->statusMsg('Client connected: ' . $ip . ':' . $port);

        $data = array(
            'ip' => $ip,
            'port' => $port,
            'clientCount' => $this->_serverClientCount,
        );

        $encodedData = $this->_encodeData('clientConnected', $data);

        $this->_sendAll($encodedData);
    }

    public function clientDisconnected($ip, $port)
    {
        if (!isset($this->_serverClients[$port])) {
            return false;
        }

        unset($this->_serverClients[$port]);

        $this->_serverClientCount--;
        $this->statusMsg('Client disconnected: ' . $ip . ':' . $port);

        $data = array(
            'port' => $port,
            'clientCount' => $this->_serverClientCount,
        );

        $encodedData = $this->_encodeData('clientDisconnected', $data);

        $this->_sendAll($encodedData);
    }

    public function clientActivity($port)
    {
        $encodedData = $this->_encodeData('clientActivity', $port);
        $this->_sendAll($encodedData);
    }

    /**
     * @param string $text
     */
    public function statusMsg($text, $type = 'info')
    {
        $data = array(
            'type' => $type,
            'text' => '[' . strftime('%m-%d %H:%M', time()) . '] ' . $text,
        );

        $encodedData = $this->_encodeData('statusMsg', $data);

        $this->_sendAll($encodedData);
    }

    /**
     * @param Wrench_Connection $client
     */
    private function _sendServerinfo($client)
    {
        if (count($this->_clients) < 1) {
            return false;
        }

        $currentServerInfo                = $this->_serverInfo;
        $currentServerInfo['clientCount'] = count($this->_serverClients);
        $currentServerInfo['clients']     = $this->_serverClients;
        $encodedData                      = $this->_encodeData('serverInfo', $currentServerInfo);

        $client->send($encodedData);
    }

    private function _sendAll($encodedData)
    {
        if (count($this->_clients) < 1) {
            return false;
        }

        foreach ($this->_clients as $sendto) {
            $sendto->send($encodedData);
        }
    }
}
