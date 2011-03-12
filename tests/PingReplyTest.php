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

require_once(
    dirname(__FILE__) .
    DIRECTORY_SEPARATOR . 'testenv' .
    DIRECTORY_SEPARATOR . 'bootstrap.php'
);

class   PingReplyTest
extends ErebotModuleTestCase
{
    public function testPingReply()
    {
        $this->_module = new Erebot_Module_PingReply(NULL);
        $this->_module->reload(
            $this->_connection,
            Erebot_Module_Base::RELOAD_ALL
        );
        $event = new Erebot_Event_Ping($this->_connection, "foo");
        $this->_module->handlePing($event);
        $this->assertSame(1, count($this->_outputBuffer));
        $this->assertSame("PONG :foo", $this->_outputBuffer[0]);
    }
}

