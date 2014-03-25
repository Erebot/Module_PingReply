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

class   PingReplyTest
extends Erebot_Testenv_Module_TestCase
{
    protected function _setConnectionExpectations()
    {
        parent::_setConnectionExpectations();
    }

    public function testPingReply()
    {
        $event = $this->getMock(
            '\\Erebot\\Interfaces\\Event\\Ping',
            array(), array(), '', FALSE, FALSE
        );

        $event
            ->expects($this->any())
            ->method('getConnection')
            ->will($this->returnValue($this->_connection));
        $event
            ->expects($this->any())
            ->method('getText')
            ->will($this->returnValue('foo'));

        $this->_module = new \Erebot\Module\PingReply(NULL);
        $this->_module->setFactory('!Callable', $this->_factory['!Callable']);
        $this->_module->moduleReload($this->_connection, 0);
        $this->_module->handlePing($this->_eventHandler, $event);
        $this->assertSame(1, count($this->_outputBuffer));
        $this->assertSame("PONG :foo", $this->_outputBuffer[0]);
        $this->_module->moduleUnload();
    }
}

