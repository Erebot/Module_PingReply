<?php
/*
    This file is part of Erebot.

    Erebot is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Erebot is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Erebot.  If not, see <http://www.gnu.org/licenses/>.
*/

class   Erebot_Module_PingReply
extends Erebot_Module_Base
{
    public function reload($flags)
    {
        if ($flags & self::RELOAD_HANDLERS) {
            $handler = new Erebot_EventHandler(
                            array($this, 'handlePing'),
                            'Erebot_Event_Ping');
            $this->_connection->addEventHandler($handler);
        }
    }

    public function handlePing(Erebot_Interface_Event_Generic &$event)
    {
    var_dump('!!!');
        $this->sendCommand('PONG '.$event->getText());
    }
}

?>
