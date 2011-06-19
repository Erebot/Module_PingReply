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

/**
 * \brief
 *      A basic module that sends replies to PING queries it receives.
 *
 * \note
 *      This module is required for the bot to run correctly
 *      (without being disconnected every few minutes with a
 *      "Ping timeout" quit message).
 */
class   Erebot_Module_PingReply
extends Erebot_Module_Base
{
    /// \copydoc Erebot_Module_Base::_reload()
    public function _reload($flags)
    {
        if ($flags & self::RELOAD_HANDLERS) {
            $handler = new Erebot_EventHandler(
                array($this, 'handlePing'),
                new Erebot_Event_Match_InstanceOf('Erebot_Interface_Event_Ping')
            );
            $this->_connection->addEventHandler($handler);
        }
    }

    /// \copydoc Erebot_Module_Base::_unload()
    protected function _unload()
    {
    }

    /**
     * Responds to PING requests.
     *
     * \param Erebot_Interface_Event_Ping $event
     *      PING request to respond to.
     */
    public function handlePing(Erebot_Interface_Event_Ping $event)
    {
        $this->sendCommand('PONG :'.$event->getText());
    }
}

